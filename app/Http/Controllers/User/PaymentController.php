<?php
// app/Http/Controllers/User/PaymentController.php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Transaksi;
use App\Services\MidtransService;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    use LogsActivity;

    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    public function create($id)
    {
        $transaksi = Transaksi::with(['detailTransaksis.produk', 'pengembalian'])
            ->where('user_id', Auth::id())
            ->whereIn('status', [Transaksi::STATUS_DIKEMBALIKAN, Transaksi::STATUS_SELESAI])
            ->findOrFail($id);

        if ($transaksi->status === Transaksi::STATUS_SELESAI) {
            return redirect()->route('transaksi.riwayat')
                ->with('info', 'Transaksi ini sudah selesai dan lunas.');
        }

        $subtotal = $transaksi->detailTransaksis->sum('subtotal');
        $deposit = $transaksi->jumlah_deposit;
        $sisaPembayaran = $subtotal - $deposit;
        $biayaTambahan = $transaksi->pengembalian?->total_biaya_tambahan ?? 0;
        $totalBayar = $sisaPembayaran + $biayaTambahan;

        if ($totalBayar <= 0) {
            $transaksi->complete();
            return redirect()->route('transaksi.riwayat')
                ->with('success', 'Transaksi telah selesai. Tidak ada sisa pembayaran.');
        }

        $existingPayment = Payment::where('transaksi_id', $transaksi->id)
            ->where('jenis_pembayaran', Payment::JENIS_PELUNASAN)
            ->whereIn('transaction_status', [Payment::STATUS_PENDING, Payment::STATUS_CAPTURE])
            ->first();

        $snapToken = null;

        if ($existingPayment) {
            $statusCheck = $this->midtransService->checkStatus($existingPayment->kode_pembayaran);

            if ($statusCheck['success'] && isset($statusCheck['status']->transaction_status)) {
                $transactionStatus = $statusCheck['status']->transaction_status;

                if (in_array($transactionStatus, ['settlement', 'capture'])) {
                    $this->processSuccessfulPayment($existingPayment, $statusCheck['status']);
                    return redirect()->route('transaksi.riwayat')
                        ->with('success', 'Pembayaran telah berhasil diproses.');
                } elseif ($transactionStatus === 'expire') {
                    $existingPayment->update(['transaction_status' => Payment::STATUS_EXPIRE]);
                    $existingPayment = null;
                }
            }
        }

        if (!$existingPayment) {
            $kodePembayaran = 'PAY-' . date('Ymd') . '-' . strtoupper(Str::random(8));

            $payment = Payment::create([
                'transaksi_id' => $transaksi->id,
                'pengembalian_id' => $transaksi->pengembalian?->id,
                'kode_pembayaran' => $kodePembayaran,
                'jenis_pembayaran' => Payment::JENIS_PELUNASAN,
                'jumlah_tagihan' => $totalBayar,
                'jumlah_dibayar' => 0,
                'sisa_tagihan' => $totalBayar,
                'transaction_status' => Payment::STATUS_PENDING
            ]);

            $customerDetails = [
                'nama_lengkap' => $transaksi->nama_lengkap,
                'email' => $transaksi->email,
                'no_telepon' => $transaksi->no_telepon
            ];

            $result = $this->midtransService->createPelunasanPayment($payment, $customerDetails);

            if ($result['success']) {
                $snapToken = $result['snap_token'];
            } else {
                return redirect()->back()->with('error', 'Gagal memproses pembayaran: ' . $result['message']);
            }
        } else {
            $snapToken = $existingPayment->snap_token;
            if (!$snapToken) {
                $customerDetails = [
                    'nama_lengkap' => $transaksi->nama_lengkap,
                    'email' => $transaksi->email,
                    'no_telepon' => $transaksi->no_telepon
                ];
                $result = $this->midtransService->createPelunasanPayment($existingPayment, $customerDetails);
                if ($result['success']) {
                    $snapToken = $result['snap_token'];
                }
            }
        }

        return view('user.payment.pelunasan', compact(
            'transaksi',
            'snapToken',
            'subtotal',
            'deposit',
            'sisaPembayaran',
            'biayaTambahan',
            'totalBayar'
        ));
    }

    private function processSuccessfulPayment(Payment $payment, $midtransResponse)
    {
        DB::beginTransaction();

        try {
            $payment->update([
                'transaction_status' => Payment::STATUS_SETTLEMENT,
                'jumlah_dibayar' => $payment->jumlah_tagihan,
                'sisa_tagihan' => 0,
                'transaction_id' => $midtransResponse->transaction_id ?? null,
                'payment_type' => $midtransResponse->payment_type ?? null,
                'bank' => $midtransResponse->va_numbers[0]->bank ?? $midtransResponse->bank ?? null,
                'va_number' => $midtransResponse->va_numbers[0]->va_number ?? null,
                'raw_response' => json_decode(json_encode($midtransResponse), true),
                'paid_at' => now()
            ]);

            $payment->transaksi->complete();

            $this->logActivity(
                'payment_success',
                'payment',
                $payment->id,
                $payment->kode_pembayaran,
                "User " . Auth::user()->name . " berhasil melakukan pelunasan"
            );

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Process payment error: ' . $e->getMessage());
            return false;
        }
    }

    public function success(Request $request)
    {
        $orderId = $request->query('order_id');
        $payment = Payment::where('kode_pembayaran', $orderId)->with('transaksi')->first();

        if (!$payment) {
            return redirect()->route('transaksi.riwayat')->with('error', 'Pembayaran tidak ditemukan.');
        }

        $statusCheck = $this->midtransService->checkStatus($orderId);

        if ($statusCheck['success'] && isset($statusCheck['status']->transaction_status)) {
            if (in_array($statusCheck['status']->transaction_status, ['settlement', 'capture'])) {
                $this->processSuccessfulPayment($payment, $statusCheck['status']);
                return redirect()->route('transaksi.riwayat')->with('success', 'Pembayaran berhasil!');
            } elseif ($statusCheck['status']->transaction_status === 'pending') {
                return redirect()->route('user.payment.create', $payment->transaksi_id)
                    ->with('info', 'Pembayaran masih pending.');
            }
        }

        return redirect()->route('transaksi.riwayat')->with('error', 'Gagal memverifikasi pembayaran.');
    }

    public function pending(Request $request)
    {
        return redirect()->route('transaksi.riwayat')
            ->with('info', 'Pembayaran Anda sedang diproses.');
    }

    public function error(Request $request)
    {
        $orderId = $request->query('order_id');
        if ($orderId) {
            Payment::where('kode_pembayaran', $orderId)
                ->where('transaction_status', Payment::STATUS_PENDING)
                ->update(['transaction_status' => Payment::STATUS_FAILURE]);
        }
        return redirect()->route('transaksi.riwayat')->with('error', 'Pembayaran gagal.');
    }

    public function notification(Request $request)
    {
        $notification = json_decode($request->getContent(), true);
        Log::info('Midtrans Notification:', $notification);

        $payment = Payment::where('kode_pembayaran', $notification['order_id'])->first();

        if (!$payment) {
            return response()->json(['message' => 'Payment not found'], 404);
        }

        DB::beginTransaction();

        try {
            $payment->update([
                'transaction_id' => $notification['transaction_id'] ?? null,
                'payment_type' => $notification['payment_type'] ?? null,
                'bank' => $notification['va_numbers'][0]['bank'] ?? $notification['bank'] ?? null,
                'va_number' => $notification['va_numbers'][0]['va_number'] ?? null,
                'raw_response' => $notification,
                'fraud_status' => $notification['fraud_status'] ?? null
            ]);

            $status = $notification['transaction_status'];
            if (in_array($status, ['settlement', 'capture'])) {
                $payment->update([
                    'transaction_status' => Payment::STATUS_SETTLEMENT,
                    'jumlah_dibayar' => $payment->jumlah_tagihan,
                    'sisa_tagihan' => 0,
                    'paid_at' => now()
                ]);
                $payment->transaksi->complete();
            } elseif ($status == 'pending') {
                $payment->update(['transaction_status' => Payment::STATUS_PENDING]);
            } elseif (in_array($status, ['deny', 'cancel'])) {
                $payment->update(['transaction_status' => $status]);
            } elseif ($status == 'expire') {
                $payment->update(['transaction_status' => Payment::STATUS_EXPIRE]);
            } elseif ($status == 'refund') {
                $payment->update(['transaction_status' => Payment::STATUS_REFUND]);
            }

            DB::commit();
            return response()->json(['message' => 'Notification processed']);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Notification Error: ' . $e->getMessage());
            return response()->json(['message' => 'Error'], 500);
        }
    }
}
