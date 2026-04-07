<?php
// app/Services/MidtransService.php

namespace App\Services;

use Midtrans\Snap;
use Midtrans\Transaction;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;

class MidtransService
{
    /**
     * Create payment for pelunasan
     */
    public function createPelunasanPayment(Payment $payment, array $customerDetails)
    {
        $transaksi = $payment->transaksi;

        $params = [
            'transaction_details' => [
                'order_id' => $payment->kode_pembayaran,
                'gross_amount' => (int) $payment->jumlah_tagihan,
            ],
            'customer_details' => [
                'first_name' => $customerDetails['nama_lengkap'] ?? $transaksi->nama_lengkap,
                'email' => $customerDetails['email'] ?? $transaksi->email,
                'phone' => $customerDetails['no_telepon'] ?? $transaksi->no_telepon,
                'billing_address' => [
                    'first_name' => $customerDetails['nama_lengkap'] ?? $transaksi->nama_lengkap,
                    'address' => $transaksi->alamat_lengkap,
                    'city' => $transaksi->kabupaten,
                    'postal_code' => '00000',
                    'country_code' => 'IDN'
                ]
            ],
            'item_details' => $this->getItemDetails($payment),
            'expiry' => [
                'start_time' => date('Y-m-d H:i:s O'),
                'unit' => 'hours',
                'duration' => 24
            ],
            'enabled_payments' => [
                'credit_card',
                'bank_transfer',
                'gopay',
                'shopeepay',
                'qris',
                'bca_klikpay',
                'echannel',
                'cimb_clicks',
                'danamon_online'
            ]
        ];

        try {
            $snapToken = Snap::getSnapToken($params);

            $payment->update([
                'snap_token' => $snapToken,
                'order_id_midtrans' => $payment->kode_pembayaran,
                'expiry_time' => now()->addHours(24)
            ]);

            Log::info('Midtrans Snap Token created', [
                'payment_id' => $payment->id,
                'order_id' => $payment->kode_pembayaran,
                'amount' => $payment->jumlah_tagihan
            ]);

            return [
                'success' => true,
                'snap_token' => $snapToken,
                'order_id' => $payment->kode_pembayaran
            ];

        } catch (\Exception $e) {
            Log::error('Midtrans Create Payment Error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    private function getItemDetails(Payment $payment)
    {
        $items = [];
        $transaksi = $payment->transaksi;

        if ($payment->jenis_pembayaran === Payment::JENIS_PELUNASAN) {
            foreach ($transaksi->detailTransaksis as $detail) {
                $items[] = [
                    'id' => (string) $detail->produk_id,
                    'price' => (int) $detail->subtotal,
                    'quantity' => 1,
                    'name' => substr($detail->nama_produk . ' (' . $detail->durasi_hari . ' hari)', 0, 50)
                ];
            }

            $pengembalian = $payment->pengembalian;
            if ($pengembalian && $pengembalian->total_biaya_tambahan > 0) {
                $items[] = [
                    'id' => 'FEE_001',
                    'price' => (int) $pengembalian->total_biaya_tambahan,
                    'quantity' => 1,
                    'name' => 'Biaya Tambahan (Denda/Kerusakan)'
                ];
            }
        }

        return $items;
    }

    public function checkStatus($orderId)
    {
        try {
            $status = Transaction::status($orderId);
            return [
                'success' => true,
                'status' => $status
            ];
        } catch (\Exception $e) {
            Log::error('Midtrans Check Status Error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function cancel($orderId)
    {
        try {
            $cancel = Transaction::cancel($orderId);
            return [
                'success' => true,
                'data' => $cancel
            ];
        } catch (\Exception $e) {
            Log::error('Midtrans Cancel Error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}
