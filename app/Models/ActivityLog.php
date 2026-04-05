<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $table = 'activity_logs';

    protected $fillable = [
        'user_id',
        'user_name',
        'user_email',
        'user_level',
        'action',
        'module',
        'item_id',
        'item_code',
        'description',
        'old_data',
        'new_data',
        'ip_address',
        'user_agent',
        'status',
        'error_message',
    ];

    protected $casts = [
        'old_data' => 'array',
        'new_data' => 'array',
    ];

    /**
     * Relasi ke user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope untuk filter berdasarkan modul
     */
    public function scopeModule($query, $module)
    {
        return $query->where('module', $module);
    }

    /**
     * Scope untuk filter berdasarkan action
     */
    public function scopeAction($query, $action)
    {
        return $query->where('action', $action);
    }

    /**
     * Scope untuk filter berdasarkan tanggal
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * Scope untuk filter berdasarkan status
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
