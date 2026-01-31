<?php

namespace App\Http\Controllers\Student;

use App\Models\Club;
use App\Models\ClubMember;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Use direct queries to avoid relationship issues
        $stats = [
            'active_clubs' => ClubMember::where('user_id', $user->id)
                ->where('status', 'active')
                ->count(),
                
            'pending_clubs' => ClubMember::where('user_id', $user->id)
                ->where('status', 'pending')
                ->count(),
                
            'total_clubs' => Club::where('is_active', true)->count(),
            
            'recommended_clubs' => $this->getRecommendedClubs($user),
        ];

        // Get active memberships with club details
        $activeMemberships = ClubMember::where('user_id', $user->id)
            ->where('status', 'active')
            ->with(['club' => function($query) {
                $query->select('id', 'name', 'slug', 'category', 'logo', 'banner_color');
            }])
            ->get();

        // Get pending requests
        $pendingRequests = ClubMember::where('user_id', $user->id)
            ->where('status', 'pending')
            ->with(['club' => function($query) {
                $query->select('id', 'name', 'slug', 'category', 'logo');
            }])
            ->get();

        // Get recent active clubs
        $recentClubs = Club::where('is_active', true)
            ->latest()
            ->limit(6)
            ->get();

        // Calculate profile completion
        $profileCompletion = $this->calculateProfileCompletion($user);
        
        // Count clubs matching user interests
        $matchingClubs = $this->countMatchingClubs($user);

        return view('student.dashboard', compact(
            'stats', 
            'activeMemberships', 
            'pendingRequests',
            'recentClubs',
            'profileCompletion',
            'matchingClubs'
        ));
    }
    
    private function getRecommendedClubs($user)
    {
        // Get club IDs the user is already a member of
        $joinedClubIds = ClubMember::where('user_id', $user->id)
            ->pluck('club_id')
            ->toArray();
        
        // Recommend clubs based on user's interests if available
        $query = Club::where('is_active', true)
            ->whereNotIn('id', $joinedClubIds)
            ->limit(5);
        
        // If user has interests, try to match them
        if ($user->interests && is_array($user->interests)) {
            $interests = $user->interests;
            $query->where(function($q) use ($interests) {
                foreach ($interests as $interest) {
                    $q->orWhere('category', 'like', "%{$interest}%")
                      ->orWhere('name', 'like', "%{$interest}%")
                      ->orWhere('description', 'like', "%{$interest}%");
                }
            });
        }
        
        return $query->count();
    }
    
    /**
     * Calculate profile completion percentage.
     */
    private function calculateProfileCompletion($user)
    {
        $totalFields = 8;
        $completedFields = 0;
        
        // Basic info
        if (!empty($user->name)) $completedFields++;
        if (!empty($user->email)) $completedFields++;
        
        // Profile details
        if (!empty($user->profile_photo)) $completedFields++;
        if (!empty($user->student_id)) $completedFields++;
        if (!empty($user->phone)) $completedFields++;
        if (!empty($user->year_level)) $completedFields++;
        if (!empty($user->department)) $completedFields++;
        if (!empty($user->bio)) $completedFields++;
        
        return round(($completedFields / $totalFields) * 100);
    }
    
    /**
     * Count clubs matching user interests.
     */
    private function countMatchingClubs($user)
    {
        if (!$user->interests) {
            return 0;
        }
        
        $interests = json_decode($user->interests, true);
        if (empty($interests)) {
            return 0;
        }
        
        return Club::where('is_active', true)
            ->where(function($query) use ($interests) {
                foreach ($interests as $interest) {
                    $query->orWhere('name', 'like', "%{$interest}%")
                          ->orWhere('description', 'like', "%{$interest}%")
                          ->orWhere('category', 'like', "%{$interest}%");
                }
            })
            ->count();
    }
}