<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Club extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'category', 'logo', 
        'banner_color', 'meeting_schedule', 'faculty_advisor_id',
        'is_active', 'max_members', 'tags'
    ];

    protected $casts = [
        'tags' => 'array',
        'is_active' => 'boolean',
        'max_members' => 'integer',
    ];

    public function members(): HasMany
    {
        return $this->hasMany(ClubMember::class);
    }

    public function membershipRequests(): HasMany
    {
        return $this->hasMany(MembershipRequest::class);
    }

    public function facultyAdvisor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'faculty_advisor_id');
    }

    // In app/Models/Club.php

    public function activeMembers()
    {
        return $this->members()->where('status', 'active');
    }

    public function pendingMembers()
    {
        return $this->members()->where('status', 'pending');
    }

    public function isFull()
    {
        if (!$this->max_members) return false;
        return $this->current_members >= $this->max_members;
    }

    public function getMemberPercentageAttribute()
    {
        if (!$this->max_members) return 0;
        return ($this->current_members / $this->max_members) * 100;
    }

    public function hasMember($userId)
    {
        return $this->members()
            ->where('user_id', $userId)
            ->whereIn('status', ['active', 'pending'])
            ->exists();
    }
}