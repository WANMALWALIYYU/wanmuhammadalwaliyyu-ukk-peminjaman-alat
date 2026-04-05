<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of activity logs.
     */
    public function index(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        // Filter berdasarkan action
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // Filter berdasarkan module
        if ($request->filled('module')) {
            $query->where('module', $request->module);
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter tanggal
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('user_name', 'like', "%{$search}%")
                  ->orWhere('user_email', 'like', "%{$search}%")
                  ->orWhere('action', 'like', "%{$search}%")
                  ->orWhere('module', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $logs = $query->paginate(20)->withQueryString();

        // Data untuk filter dropdown
        $actions = ActivityLog::distinct()->pluck('action');
        $modules = ActivityLog::distinct()->pluck('module');
        $statuses = ['success', 'failed'];

        if ($request->ajax()) {
            return view('admin.activity-logs.table', compact('logs'))->render();
        }

        return view('admin.activity-logs.index', compact('logs', 'actions', 'modules', 'statuses'));
    }

    /**
     * Display the specified activity log.
     */
    public function show($id)
    {
        $log = ActivityLog::with('user')->findOrFail($id);
        return view('admin.activity-logs.show', compact('log'));
    }

    /**
     * Remove the specified activity log.
     */
    public function destroy($id)
    {
        $log = ActivityLog::findOrFail($id);
        $log->delete();

        toast('Log aktivitas berhasil dihapus', 'success')
            ->timerProgressBar()
            ->autoClose(2000);

        return redirect()->route('activity-logs.index');
    }

    /**
     * Clear all activity logs (older than specified days)
     */
    public function clear(Request $request)
    {
        $days = $request->input('days', 30);

        $deleted = ActivityLog::where('created_at', '<', now()->subDays($days))->delete();

        toast("Berhasil menghapus {$deleted} log aktivitas yang lebih dari {$days} hari", 'success')
            ->timerProgressBar()
            ->autoClose(2000);

        return redirect()->route('activity-logs.index');
    }
}
