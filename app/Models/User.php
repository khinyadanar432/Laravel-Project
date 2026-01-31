<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'student_id',
        'phone',
        'profile_photo',
        'year_level',
        'department',
        'bio',
        'interests',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'interests' => 'array',
    ];

    // Relationship: User has many club memberships
    public function clubMembers()
    {
        return $this->hasMany(ClubMember::class);
    }

    // Alias for clubMembers (for compatibility)
    public function clubMemberships()
    {
        return $this->clubMembers();
    }

    // Alias for pending memberships (what membershipRequests() was trying to do)
    public function membershipRequests()
    {
        return $this->clubMembers()->where('status', 'pending');
    }

    // Relationship: User belongs to many clubs through club_members table
    public function clubs()
    {
        return $this->belongsToMany(Club::class, 'club_members')
                    ->withPivot('status', 'role', 'joined_at', 'applied_at')
                    ->withTimestamps();
    }

    // Convenience methods for different membership statuses
    public function activeClubs()
    {
        return $this->clubs()->wherePivot('status', 'active');
    }

    public function pendingClubs()
    {
        return $this->clubs()->wherePivot('status', 'pending');
    }

    public function archivedClubs()
    {
        return $this->clubs()->whereIn('club_members.status', ['alumni', 'suspended', 'rejected']);
    }
}