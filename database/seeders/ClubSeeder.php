<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Club;
use App\Models\ClubMember;
use App\Models\MembershipRequest;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ClubSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'student_id' => 'ADM001',
                'year_level' => 'Faculty',
                'department' => 'Administration',
            ]
        );

        // Create student user
        $student = User::firstOrCreate(
            ['email' => 'student@example.com'],
            [
                'name' => 'John Student',
                'password' => Hash::make('password'),
                'student_id' => 'STU001',
                'year_level' => '3rd Year',
                'department' => 'Computer Science',
                'interests' => json_encode(['programming', 'web development', 'AI']),
            ]
        );

        // Create clubs
        $clubs = [
            [
                'name' => 'Programming Club',
                'slug' => 'programming-club',
                'description' => 'Learn and practice programming skills. Weekly coding challenges, hackathons, and workshops on various programming languages and frameworks.',
                'category' => 'Technology',
                'banner_color' => '#4f46e5',
                'meeting_schedule' => 'Every Wednesday 3-5 PM at Tech Lab 101',
                'faculty_advisor_id' => $admin->id,
                'max_members' => 50,
                'tags' => json_encode(['coding', 'web development', 'algorithms', 'python', 'javascript']),
            ],
            [
                'name' => 'Debate Society',
                'slug' => 'debate-society',
                'description' => 'Improve public speaking and critical thinking skills. Participate in inter-college debates and public speaking competitions.',
                'category' => 'Arts & Humanities',
                'banner_color' => '#10b981',
                'meeting_schedule' => 'Every Friday 2-4 PM at Humanities Hall',
                'faculty_advisor_id' => $admin->id,
                'max_members' => 30,
                'tags' => json_encode(['public speaking', 'debate', 'politics', 'communication']),
            ],
            [
                'name' => 'Robotics Club',
                'slug' => 'robotics-club',
                'description' => 'Build robots and learn about automation. Hands-on projects with Arduino, Raspberry Pi, and 3D printing.',
                'category' => 'Engineering',
                'banner_color' => '#f59e0b',
                'meeting_schedule' => 'Every Tuesday 4-6 PM at Engineering Lab',
                'faculty_advisor_id' => $admin->id,
                'max_members' => 40,
                'tags' => json_encode(['robotics', 'engineering', 'arduino', 'automation']),
            ],
            [
                'name' => 'Photography Club',
                'slug' => 'photography-club',
                'description' => 'Learn photography techniques and photo editing. Regular photo walks and editing workshops.',
                'category' => 'Arts & Humanities',
                'banner_color' => '#8b5cf6',
                'meeting_schedule' => 'Every Thursday 3-5 PM at Arts Center',
                'faculty_advisor_id' => $admin->id,
                'max_members' => 25,
                'tags' => json_encode(['photography', 'editing', 'photoshop', 'creative']),
            ],
            [
                'name' => 'Environmental Club',
                'slug' => 'environmental-club',
                'description' => 'Promote environmental awareness and sustainability. Tree planting, recycling programs, and eco-workshops.',
                'category' => 'Science',
                'banner_color' => '#059669',
                'meeting_schedule' => 'Every Monday 2-4 PM at Science Building',
                'faculty_advisor_id' => $admin->id,
                'max_members' => 35,
                'tags' => json_encode(['environment', 'sustainability', 'science', 'nature']),
            ],
            [
                'name' => 'Entrepreneurship Club',
                'slug' => 'entrepreneurship-club',
                'description' => 'Learn about startups and business development. Pitch competitions and mentorship programs.',
                'category' => 'Business',
                'banner_color' => '#dc2626',
                'meeting_schedule' => 'Every Wednesday 5-7 PM at Business School',
                'faculty_advisor_id' => $admin->id,
                'max_members' => 45,
                'tags' => json_encode(['business', 'startup', 'entrepreneurship', 'finance']),
            ],
        ];

        foreach ($clubs as $clubData) {
            $club = Club::firstOrCreate(
                ['slug' => $clubData['slug']],
                $clubData
            );

            // Make student a member of Programming Club
            if ($club->slug === 'programming-club') {
                ClubMember::firstOrCreate(
                    ['user_id' => $student->id, 'club_id' => $club->id],
                    [
                        'status' => 'active',
                        'role' => 'member',
                        'joined_at' => now()->subMonths(2),
                    ]
                );
            }

            // Create a pending request for Robotics Club
            if ($club->slug === 'robotics-club') {
                MembershipRequest::firstOrCreate(
                    ['user_id' => $student->id, 'club_id' => $club->id],
                    [
                        'message' => 'I have experience with Arduino and want to learn more about robotics.',
                        'status' => 'pending',
                    ]
                );

                ClubMember::firstOrCreate(
                    ['user_id' => $student->id, 'club_id' => $club->id],
                    [
                        'status' => 'pending',
                        'role' => 'member',
                        'joined_at' => now(),
                    ]
                );
            }

            // Create archived membership for Debate Society
            if ($club->slug === 'debate-society') {
                ClubMember::firstOrCreate(
                    ['user_id' => $student->id, 'club_id' => $club->id],
                    [
                        'status' => 'archived',
                        'role' => 'member',
                        'joined_at' => now()->subYear(),
                        'left_at' => now()->subMonths(6),
                        'left_reason' => 'Graduated from the program',
                    ]
                );
            }
        }

        // Add some other members to clubs
        $otherStudents = [
            ['email' => 'jane@example.com', 'name' => 'Jane Smith', 'student_id' => 'STU002'],
            ['email' => 'bob@example.com', 'name' => 'Bob Johnson', 'student_id' => 'STU003'],
            ['email' => 'alice@example.com', 'name' => 'Alice Brown', 'student_id' => 'STU004'],
        ];

        foreach ($otherStudents as $studentData) {
            $otherStudent = User::firstOrCreate(
                ['email' => $studentData['email']],
                [
                    'name' => $studentData['name'],
                    'password' => Hash::make('password'),
                    'student_id' => $studentData['student_id'],
                    'year_level' => '2nd Year',
                    'department' => 'Various Departments',
                ]
            );

            // Add to some clubs
            $programmingClub = Club::where('slug', 'programming-club')->first();
            if ($programmingClub) {
                ClubMember::firstOrCreate(
                    ['user_id' => $otherStudent->id, 'club_id' => $programmingClub->id],
                    [
                        'status' => 'active',
                        'role' => 'member',
                        'joined_at' => now()->subMonths(rand(1, 6)),
                    ]
                );
            }
        }
    }
}