<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Club;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function show()
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }
        
        // Calculate profile completion
        $completion = $this->calculateProfileCompletion($user);
        
        // Count clubs matching user interests
        $matchingClubs = $this->countMatchingClubs($user);
        
        return view('student.profile.show', [
            'user' => $user,
            'profileCompletion' => $completion,
            'matchingClubs' => $matchingClubs,
        ]);
    }
    
    /**
     * Show the form for editing the user's profile.
     */
    public function edit()
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }
        
        $yearLevels = [
            'First Year',
            'Second Year', 
            'Third Year',
            'Fourth Year',
            'Fifth Year',
            'Master Year 1',
            'Master Year 2',
            'PhD',
        ];
        
        $departments = [
            'Computer Science',
            'Information Technology',
            'Software Engineering',
            'Computer Engineering',
            'Network Engineering',
            'Data Science',
            'Artificial Intelligence',
            'Cyber Security',
        ];
        
        $commonInterests = [
            'Programming', 'Web Development', 'Mobile Development',
            'Data Science', 'AI/ML', 'Cyber Security',
            'Football', 'Basketball', 'Badminton', 'Table Tennis',
            'Music', 'Singing', 'Dancing', 'Photography',
            'Drawing', 'Painting', 'Writing', 'Debate',
            'Robotics', 'Electronics', 'Gaming',
        ];
        
        return view('student.profile.edit', compact(
            'user', 
            'yearLevels', 
            'departments', 
            'commonInterests'
        ));
    }
    
    /**
     * Update the user's profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'student_id' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:20',
            'year_level' => 'nullable|string|max:50',
            'department' => 'nullable|string|max:100',
            'bio' => 'nullable|string|max:500',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($user->profile_photo && Storage::exists('public/' . $user->profile_photo)) {
                Storage::delete('public/' . $user->profile_photo);
            }
            
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $validated['profile_photo'] = $path;
        }
        
        // Handle interests if present
        if ($request->has('interests')) {
            $validated['interests'] = json_encode($request->interests);
        }
        
        // Update user
        $user->update($validated);
        
        return redirect()->route('student.profile.show')
            ->with('success', 'Profile updated successfully!');
    }
    
    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }
        
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()
                ->with('error', 'Current password is incorrect.');
        }
        
        // Update password
        $user->update([
            'password' => Hash::make($request->password),
        ]);
        
        return redirect()->route('student.profile.show')
            ->with('success', 'Password updated successfully!');
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