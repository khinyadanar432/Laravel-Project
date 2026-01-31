@extends('layouts.student')

@section('title', 'My Profile - UIT ClubHub')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Professional Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <nav class="flex mb-4" aria-label="Breadcrumb">
                        <ol class="flex items-center space-x-2">
                            <li>
                                <a href="{{ route('student.dashboard') }}" class="text-gray-500 hover:text-gray-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </li>
                            <li class="text-sm font-medium text-gray-900">My Profile</li>
                        </ol>
                    </nav>
                    <h1 class="text-3xl font-bold text-gray-900">My Profile</h1>
                    <p class="mt-2 text-gray-600">Manage your personal and academic information</p>
                </div>
                
                <div class="flex items-center space-x-3">
                    <a href="{{ route('student.profile.edit') }}" 
                       class="inline-flex items-center px-4 py-2.5 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Profile
                    </a>
                </div>
            </div>
        </div>

        <!-- Profile Overview Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8 overflow-hidden">
            <div class="p-6">
                <div class="flex flex-col md:flex-row md:items-center gap-6">
                    <!-- Avatar Section -->
                    <div class="flex-shrink-0">
                        <div class="relative">
                            @if($user->profile_photo)
                                <img src="{{ Storage::url($user->profile_photo) }}" 
                                     alt="{{ $user->name }}" 
                                     class="w-24 h-24 rounded-xl object-cover border-2 border-white shadow-lg">
                            @else
                                <div class="w-24 h-24 rounded-xl bg-gradient-to-br from-gray-100 to-gray-200 border-2 border-white shadow-lg flex items-center justify-center">
                                    <span class="text-gray-600 text-3xl font-bold">{{ substr($user->name, 0, 1) }}</span>
                                </div>
                            @endif
                            <div class="absolute -bottom-2 -right-2 bg-green-500 text-white text-xs font-medium px-2 py-1 rounded-full border-2 border-white">
                                Active
                            </div>
                        </div>
                    </div>
                    
                    <!-- Profile Info -->
                    <div class="flex-1">
                        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h2>
                                <div class="flex items-center gap-3 mt-2">
                                    <span class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-800 text-sm font-medium rounded-full">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $user->student_id ?? 'STU000' }}
                                    </span>
                                    @if($user->year_level)
                                    <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 text-sm font-medium rounded-full">
                                        Year {{ $user->year_level }}
                                    </span>
                                    @endif
                                </div>
                                <div class="mt-3 text-gray-600">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        {{ $user->email }}
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Stats -->
                            <div class="flex items-center space-x-6">
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-gray-900">{{ $stats['active_clubs'] ?? 0 }}</div>
                                    <div class="text-sm text-gray-500">Active Clubs</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-gray-900">{{ $stats['pending_clubs'] ?? 0 }}</div>
                                    <div class="text-sm text-gray-500">Pending</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-gray-900">{{ $profileCompletion ?? 0 }}%</div>
                                    <div class="text-sm text-gray-500">Profile Complete</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Personal & Academic Info -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Personal Information -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="px-6 py-5 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-900">Personal Information</h3>
                        <p class="mt-1 text-sm text-gray-500">Your basic personal details</p>
                    </div>
                    
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-500">Full Name</label>
                                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                    <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span class="font-medium text-gray-900">{{ $user->name }}</span>
                                </div>
                            </div>
                            
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-500">Student ID</label>
                                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                    <svg class="w-5 h-5 text-gray-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="font-medium text-gray-900">{{ $user->student_id ?? 'Not provided' }}</span>
                                </div>
                            </div>
                            
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-500">Email Address</label>
                                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                    <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    <span class="font-medium text-gray-900">{{ $user->email }}</span>
                                </div>
                            </div>
                            
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-500">Phone Number</label>
                                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                    <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    <span class="font-medium text-gray-900">{{ $user->phone ?? 'Not provided' }}</span>
                                </div>
                            </div>
                            
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-500">Date of Birth</label>
                                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                    <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="font-medium text-gray-900">
                                        @if($user->date_of_birth)
                                            {{ \Carbon\Carbon::parse($user->date_of_birth)->format('M d, Y') }}
                                        @else
                                            Not provided
                                        @endif
                                    </span>
                                </div>
                            </div>
                            
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-500">Gender</label>
                                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                    <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4" />
                                    </svg>
                                    <span class="font-medium text-gray-900">
                                        {{ $user->gender ? ucfirst($user->gender) : 'Not specified' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        @if($user->address)
                            <div class="mt-6 pt-6 border-t border-gray-100">
                                <label class="block text-sm font-medium text-gray-500 mb-3">Address</label>
                                <div class="flex items-start p-3 bg-gray-50 rounded-lg">
                                    <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span class="font-medium text-gray-900">{{ $user->address }}</span>
                                </div>
                            </div>
                        @endif
                        
                        @if($user->bio)
                            <div class="mt-6 pt-6 border-t border-gray-100">
                                <label class="block text-sm font-medium text-gray-500 mb-3">About Me</label>
                                <div class="p-4 bg-gray-50 rounded-lg">
                                    <p class="text-gray-700 leading-relaxed">{{ $user->bio }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Academic Information -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="px-6 py-5 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-900">Academic Information</h3>
                        <p class="mt-1 text-sm text-gray-500">Your university and program details</p>
                    </div>
                    
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-500">Year Level</label>
                                <div class="p-4 bg-blue-50 rounded-lg border border-blue-100">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" opacity="0.5" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-semibold text-gray-900">{{ $user->year_level ?? 'Not set' }}</div>
                                            <div class="text-xs text-gray-500">Current year</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-500">Department</label>
                                <div class="p-4 bg-purple-50 rounded-lg border border-purple-100">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                            <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-semibold text-gray-900">{{ $user->department ?? 'Not set' }}</div>
                                            <div class="text-xs text-gray-500">Academic department</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            @if($user->academic_year)
                            <div class="md:col-span-2 space-y-2">
                                <label class="block text-sm font-medium text-gray-500">Academic Year</label>
                                <div class="p-4 bg-green-50 rounded-lg border border-green-100">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-semibold text-gray-900">{{ $user->academic_year }}</div>
                                            <div class="text-xs text-gray-500">Current academic year</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                        
                        @if($user->program || $user->specialization)
                        <div class="mt-6 pt-6 border-t border-gray-100">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @if($user->program)
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-500">Program</label>
                                    <div class="p-3 bg-gray-50 rounded-lg">
                                        <span class="font-medium text-gray-900">{{ $user->program }}</span>
                                    </div>
                                </div>
                                @endif
                                
                                @if($user->specialization)
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-500">Specialization</label>
                                    <div class="p-3 bg-gray-50 rounded-lg">
                                        <span class="font-medium text-gray-900">{{ $user->specialization }}</span>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column - Profile Stats & Actions -->
            <div class="space-y-8">
                <!-- Profile Completion -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="px-6 py-5 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-900">Profile Completion</h3>
                        <p class="mt-1 text-sm text-gray-500">Complete your profile for better recommendations</p>
                    </div>
                    
                    <div class="p-6">
                        <div class="mb-6">
                            <div class="flex justify-between text-sm mb-2">
                                <span class="font-medium text-gray-700">{{ $profileCompletion ?? 0 }}% Complete</span>
                                <span class="text-gray-500">{{ 100 - ($profileCompletion ?? 0) }}% remaining</span>
                            </div>
                            <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                                <div class="h-full bg-indigo-600 rounded-full transition-all duration-500" 
                                     style="width: {{ $profileCompletion ?? 0 }}%"></div>
                            </div>
                        </div>
                        
                        <div class="space-y-4">
                            @php
                                $profileItems = [
                                    ['icon' => '👤', 'label' => 'Basic Info', 'completed' => !empty($user->name) && !empty($user->email)],
                                    ['icon' => '🎓', 'label' => 'Academic Info', 'completed' => !empty($user->year_level) && !empty($user->department)],
                                    ['icon' => '📸', 'label' => 'Profile Photo', 'completed' => !empty($user->profile_photo)],
                                    ['icon' => '📝', 'label' => 'Bio', 'completed' => !empty($user->bio)],
                                    ['icon' => '🎯', 'label' => 'Interests', 'completed' => !empty($user->interests)],
                                    ['icon' => '📞', 'label' => 'Contact Info', 'completed' => !empty($user->phone)],
                                ];
                            @endphp
                            
                            @foreach($profileItems as $item)
                                <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition">
                                    <div class="flex items-center">
                                        <span class="text-lg mr-3">{{ $item['icon'] }}</span>
                                        <span class="font-medium text-gray-700">{{ $item['label'] }}</span>
                                    </div>
                                    @if($item['completed'])
                                        <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                    @else
                                        <a href="{{ route('student.profile.edit') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                                            Add
                                        </a>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        
                        @if(($profileCompletion ?? 0) < 100)
                            <a href="{{ route('student.profile.edit') }}" 
                               class="mt-6 inline-flex items-center justify-center w-full px-4 py-2.5 bg-indigo-50 text-indigo-700 font-medium rounded-lg hover:bg-indigo-100 border border-indigo-200 transition-colors">
                                Complete Profile
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Interests -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="px-6 py-5 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-900">Interests & Skills</h3>
                        <p class="mt-1 text-sm text-gray-500">Helps match you with relevant clubs</p>
                    </div>
                    
                    <div class="p-6">
                        @if($user->interests && count(json_decode($user->interests, true)) > 0)
                            <div class="flex flex-wrap gap-2 mb-6">
                                @foreach(json_decode($user->interests, true) as $interest)
                                    <span class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-700 text-sm font-medium rounded-full border border-blue-100">
                                        {{ $interest }}
                                    </span>
                                @endforeach
                            </div>
                            
                            @if(isset($matchingClubs) && $matchingClubs > 0)
                                <div class="p-4 bg-green-50 rounded-lg border border-green-200 mb-6">
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-green-800 mb-1">{{ $matchingClubs }}</div>
                                        <div class="text-sm text-green-700">Clubs match your interests</div>
                                    </div>
                                </div>
                            @endif
                            
                            <a href="{{ route('student.clubs.index') }}" 
                               class="inline-flex items-center justify-center w-full px-4 py-2.5 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                Browse Matching Clubs
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        @else
                            <div class="text-center py-6">
                                <div class="w-12 h-12 mx-auto mb-4 rounded-full bg-gray-100 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                    </svg>
                                </div>
                                <p class="text-gray-600 mb-4">No interests added yet</p>
                                <a href="{{ route('student.profile.edit') }}" 
                                   class="inline-flex items-center px-4 py-2.5 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Add Interests
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Emergency Information -->
                @if($user->emergency_contact || $user->blood_group || $user->allergies)
                <div class="bg-white rounded-xl shadow-sm border border-red-200">
                    <div class="px-6 py-5 border-b border-red-100 bg-red-50 rounded-t-xl">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-red-900">Emergency Information</h3>
                            <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <p class="mt-1 text-sm text-red-700">Visible only to authorized staff</p>
                    </div>
                    
                    <div class="p-6">
                        <div class="space-y-4">
                            @if($user->emergency_contact)
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-500">Emergency Contact</label>
                                <div class="flex items-center p-3 bg-red-50 rounded-lg border border-red-100">
                                    <svg class="w-5 h-5 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                    <span class="font-medium text-gray-900">{{ $user->emergency_contact }}</span>
                                </div>
                            </div>
                            @endif
                            
                            @if($user->blood_group)
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-500">Blood Group</label>
                                <div class="flex items-center p-3 bg-red-50 rounded-lg border border-red-100">
                                    <svg class="w-5 h-5 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                    </svg>
                                    <span class="font-medium text-gray-900">{{ $user->blood_group }}</span>
                                </div>
                            </div>
                            @endif
                            
                            @if($user->allergies)
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-500">Medical Notes</label>
                                <div class="p-3 bg-red-50 rounded-lg border border-red-100">
                                    <p class="font-medium text-gray-900">{{ $user->allergies }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Footer Actions -->
        <div class="mt-8 pt-8 border-t border-gray-200">
            <div class="flex flex-col sm:flex-row justify-between gap-4">
                <div class="text-sm text-gray-500">
                    Last updated {{ $user->updated_at->diffForHumans() }}
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('student.dashboard') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                        Back to Dashboard
                    </a>
                    <a href="{{ route('student.profile.edit') }}" 
                       class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                        Edit Profile
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Ensure proper text colors */
    .text-gray-900 { color: #111827 !important; }
    .text-gray-700 { color: #374151 !important; }
    .text-gray-600 { color: #4b5563 !important; }
    .text-gray-500 { color: #6b7280 !important; }
</style>
@endsection