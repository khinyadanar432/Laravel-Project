<?php

namespace App\Http\Controllers\Student;

use App\Models\Club;
use App\Models\ClubMember;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClubController extends Controller
{
    public function index(Request $request)
    {
        // Start with active clubs
        $query = Club::query()->where('is_active', true);
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }
        
        // Filter by category
        if ($request->filled('category') && $request->category != 'all') {
            $query->where('category', $request->category);
        }
        
        // Order clubs
        $query->orderBy('is_featured', 'desc')
              ->orderBy('created_at', 'desc');
        
        $clubs = $query->paginate(12);
        
        // Get categories for filter dropdown
        $categories = Club::where('is_active', true)
            ->distinct()
            ->orderBy('category')
            ->pluck('category');
        
        $user = Auth::user();
        
        // Check user's membership status for each club using direct query
        if ($user) {
            // Get all user memberships at once for efficiency
            $userMemberships = ClubMember::where('user_id', $user->id)
                ->get()
                ->keyBy('club_id');
            
            $clubs->each(function($club) use ($userMemberships) {
                if (isset($userMemberships[$club->id])) {
                    $club->membership_status = $userMemberships[$club->id]->status;
                    $club->membership_role = $userMemberships[$club->id]->role;
                } else {
                    $club->membership_status = null;
                }
                
                // Get current member count
                $club->current_members = ClubMember::where('club_id', $club->id)
                    ->where('status', 'active')
                    ->count();
                
                // Check if club is full
                $club->is_full = $club->max_members && 
                                $club->current_members >= $club->max_members;
            });
        }
        
        return view('student.clubs.index', compact('clubs', 'categories'));
    }
    
    public function show($slug)
    {
        $club = Club::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
        
        $user = Auth::user();
        
        // Check membership status using direct query
        $membership = ClubMember::where('user_id', $user->id)
            ->where('club_id', $club->id)
            ->first();
        
        // Check if there's a pending request
        $pendingRequest = $membership && $membership->status === 'pending';
        $isMember = $membership && $membership->status === 'active';
        
        // Get active members count
        $activeMembers = ClubMember::where('club_id', $club->id)
            ->where('status', 'active')
            ->count();
        
        // Check if user is at club limit (max 5 clubs)
        $userActiveClubCount = ClubMember::where('user_id', $user->id)
            ->where('status', 'active')
            ->count();
        $canJoinMoreClubs = $userActiveClubCount < 5;
        
        // Get club members for display
        $clubMembers = ClubMember::where('club_id', $club->id)
            ->where('status', 'active')
            ->with('user')
            ->limit(20)
            ->get();
        
        return view('student.clubs.show', compact(
            'club', 
            'membership',
            'pendingRequest',
            'isMember',
            'activeMembers',
            'clubMembers',
            'canJoinMoreClubs',
            'userActiveClubCount'
        ));
    }
    
    public function join(Request $request, $slug)
    {
        $user = Auth::user();
        $club = Club::where('slug', $slug)->firstOrFail();
        
        // Check if user is at club limit (max 5 clubs)
        $userActiveClubCount = ClubMember::where('user_id', $user->id)
            ->where('status', 'active')
            ->count();
            
        if ($userActiveClubCount >= 5) {
            return redirect()->back()
                ->with('error', 'You have reached the maximum limit of 5 clubs. Please leave a club before joining another.');
        }
        
        // Check if already a member or has pending request
        $existingMembership = ClubMember::where('user_id', $user->id)
            ->where('club_id', $club->id)
            //->whereIn('status', ['active', 'pending'])
            ->exists();
            
        if ($existingMembership) {
            return redirect()->back()
                ->with('error', 'You already have an active membership or pending request for this club.');
        }
        
        // Check if club is full
        $currentMembers = ClubMember::where('club_id', $club->id)
            ->where('status', 'active')
            ->count();
            
        if ($club->max_members && $currentMembers >= $club->max_members) {
            return redirect()->back()
                ->with('error', 'This club has reached its maximum capacity.');
        }
        
        // Prepare data for creation
        $membershipData = [
            'user_id' => $user->id,
            'club_id' => $club->id,
            'status' => 'pending',
            'role' => 'member',
            'application_message' => $request->message,
            'applied_at' => now(),
            // joined_at is NOT set for pending requests
        ];
        
        // If club has auto-approval (open membership), set joined_at
        if ($club->membership_type === 'open') {
            $membershipData['status'] = 'active';
            $membershipData['joined_at'] = now();
            
            // Update club member count
            $club->increment('current_members');
        }
        
        // Create club member record
        ClubMember::create($membershipData);
        
        $message = $club->membership_type === 'open' 
            ? 'Successfully joined the club!' 
            : 'Membership request sent successfully!';
        
        return redirect()->back()
            ->with('success', $message);
    }
    
    public function leave($slug)
{
    $club = Club::where('slug', $slug)->firstOrFail();
    $userId = Auth::id();
    
    $clubMember = ClubMember::where('user_id', $userId)
        ->where('club_id', $club->id)
        ->where('status', 'active')
        ->firstOrFail();
    
    // Optional: Get reason from request
    $reason = request()->input('reason', 'Voluntarily left club');
    
    // Update membership
    $clubMember->update([
        'status' => 'archived',
        'left_at' => now(),
        'left_reason' => $reason,
        'updated_at' => now()
    ]);
    
    return redirect()->route('student.clubs.myClubs')
        ->with('success', 'You have successfully left ' . $club->name);
}
    
    public function cancelRequest($slug)
    {
        $user = Auth::user();
        $club = Club::where('slug', $slug)->firstOrFail();
        
        // Find pending membership
        $membership = ClubMember::where('user_id', $user->id)
            ->where('club_id', $club->id)
            ->where('status', 'pending')
            ->first();
            
        if (!$membership) {
            return redirect()->back()
                ->with('error', 'No pending request found.');
        }
        
        $membership->delete();
        
        return redirect()->back()
            ->with('success', 'Membership request cancelled.');
    }
    
   public function myClubs()
{
    $user = Auth::user();
    
    // Get memberships using direct query (NO RELATIONSHIP)
    $activeMemberships = ClubMember::where('user_id', $user->id)
        ->where('status', 'active')
        ->with(['club' => function($query) {
            $query->select('id', 'name', 'slug', 'category', 'logo', 'banner_color');
        }])
        ->get();
        
    $pendingMemberships = ClubMember::where('user_id', $user->id)
        ->where('status', 'pending')
        ->with(['club' => function($query) {
            $query->select('id', 'name', 'slug', 'category', 'logo', 'banner_color');
        }])
        ->get();
        
    // FIXED LINE: Include 'archived' status
    $archivedMemberships = ClubMember::where('user_id', $user->id)
        ->whereIn('status', ['archived', 'rejected'])
        ->with(['club' => function($query) {
            $query->select('id', 'name', 'slug', 'category', 'logo', 'banner_color');
        }])
        ->get();
    
    // Get clubs user can still join (not a member and not at limit)
    $joinedClubIds = ClubMember::where('user_id', $user->id)
        ->whereIn('status', ['active', 'pending'])
        ->pluck('club_id')
        ->toArray();
        
    $availableClubs = Club::where('is_active', true)
        ->whereNotIn('id', $joinedClubIds)
        ->where(function($query) {
            $query->whereNull('max_members')
                  ->orWhereRaw('current_members < max_members');
        })
        ->select('id', 'name', 'slug', 'category', 'logo', 'banner_color', 'current_members', 'max_members')
        ->limit(6)
        ->get();
        
    // Count statistics
    $stats = [
        'total_joined' => $activeMemberships->count(),
        'total_pending' => $pendingMemberships->count(),
        'total_archived' => $archivedMemberships->count(),
        'max_allowed' => 5,
        'remaining_slots' => max(0, 5 - $activeMemberships->count()),
    ];
    
    return view('student.clubs.my-clubs', compact(
        'activeMemberships',
        'pendingMemberships',
        'archivedMemberships',
        'availableClubs',
        'stats'
    ));
}
}