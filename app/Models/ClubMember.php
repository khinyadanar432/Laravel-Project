<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClubMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'club_id', 'role', 'status', 'joined_at',
        'left_at', 'left_reason', 'has_paid_events', 'outstanding_balance'
    ];

    protected $casts = [
        'joined_at' => 'date',
        'left_at' => 'date',
        'has_paid_events' => 'boolean',
        'outstanding_balance' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function club(): BelongsTo
    {
        return $this->belongsTo(Club::class);
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function canLeave(): bool
    {
        return !$this->has_paid_events || $this->outstanding_balance == 0;
    }
}