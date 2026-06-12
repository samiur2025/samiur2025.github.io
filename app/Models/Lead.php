<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'description',
        'status',
        'ip_address',
        'user_agent',
        'read_at'
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'new' => '#00f0ff',
            'contacted' => '#ff2a6d',
            'qualified' => '#a855f7',
            'proposal' => '#f59e0b',
            'closed' => '#22c55e',
            'archived' => '#606080',
            default => '#9090b0'
        };
    }

    public function getStatusGlowAttribute(): string
    {
        return match($this->status) {
            'new' => 'rgba(0, 240, 255, 0.3)',
            'contacted' => 'rgba(255, 42, 109, 0.3)',
            'qualified' => 'rgba(168, 85, 247, 0.3)',
            'proposal' => 'rgba(245, 158, 11, 0.3)',
            'closed' => 'rgba(34, 197, 94, 0.3)',
            'archived' => 'rgba(96, 96, 128, 0.3)',
            default => 'rgba(144, 144, 176, 0.3)'
        };
    }

    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    public function markAsRead(): void
    {
        if (!$this->read_at) {
            $this->update(['read_at' => now()]);
        }
    }
}
