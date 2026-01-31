@extends('layouts.student')

@section('content')
<div class="space-y-8">
    <!-- Modern Header with Glass Morphism -->
    <div class="relative overflow-hidden">
        <!-- Background Effects -->
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-50 via-white to-purple-50"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-br from-indigo-100 to-transparent rounded-full -translate-y-48 translate-x-48 opacity-50"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-gradient-to-tr from-purple-100 to-transparent rounded-full translate-y-48 -translate-x-48 opacity-50"></div>
        
        <div class="relative z-10">
            <!-- Welcome Section with Stats -->
            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6 mb-8">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <h1 class="text-3xl lg:text-4xl font-bold text-gray-900">Welcome back, {{ Auth::user()->name }}! 👋</h1>
                        @if(Auth::user()->year_level)
                            <span class="px-3 py-1 bg-indigo-100 text-indigo-800 text-sm font-medium rounded-full">
                                Year {{ Auth::user()->year_level }}
                            </span>
                        @endif
                    </div>
                    <p class="text-gray-600">Here's what's happening with your clubs today</p>
                </div>
                
                <!-- Quick Stats Bar -->
                <div class="flex items-center gap-4 bg-white/80 backdrop-blur-sm border border-gray-200 rounded-2xl p-4 shadow-sm">
                    <div class="text-center px-4 border-r border-gray-100">
                        <div class="text-2xl font-bold text-gray-900">{{ $stats['active_clubs'] }}</div>
                        <div class="text-xs text-gray-500 font-medium">Active</div>
                    </div>
                    <div class="text-center px-4 border-r border-gray-100">
                        <div class="text-2xl font-bold text-gray-900">{{ $stats['pending_clubs'] }}</div>
                        <div class="text-xs text-gray-500 font-medium">Pending</div>
                    </div>
                    <div class="text-center px-4">
                        <div class="text-2xl font-bold text-gray-900">{{ 5 - $stats['active_clubs'] }}</div>
                        <div class="text-xs text-gray-500 font-medium">Available</div>
                    </div>
                </div>
            </div>
            
            <!-- Quick Actions Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="{{ route('student.clubs.index') }}" 
                   class="group relative overflow-hidden bg-gradient-to-br from-white to-gray-50 border border-gray-200 rounded-2xl p-5 hover:border-indigo-300 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <div>
                            <div class="font-semibold text-gray-900">Browse Clubs</div>
                            <div class="text-sm text-gray-500">Discover & join new clubs</div>
                        </div>
                    </div>
                    <div class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </div>
                </a>
                
                <a href="{{ route('student.clubs.myClubs') }}" 
                   class="group relative overflow-hidden bg-gradient-to-br from-white to-gray-50 border border-gray-200 rounded-2xl p-5 hover:border-green-300 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-gradient-to-br from-green-500 to-green-600 rounded-xl text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <div class="font-semibold text-gray-900">My Clubs</div>
                            <div class="text-sm text-gray-500">Manage memberships</div>
                        </div>
                    </div>
                    <div class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </div>
                </a>
                
                <a href="{{ route('student.profile.show') }}" 
                   class="group relative overflow-hidden bg-gradient-to-br from-white to-gray-50 border border-gray-200 rounded-2xl p-5 hover:border-purple-300 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804l-1.121-1.121a3 3 0 010-4.242L10.879 5.12a3 3 0 014.242 0l1.121 1.121m-8.121 8.121l4.243 4.243m-4.242-4.242L14.88 14.88m-8.121-8.12l4.242-4.242a3 3 0 014.243 0l1.121 1.121" />
                            </svg>
                        </div>
                        <div>
                            <div class="font-semibold text-gray-900">Profile</div>
                            <div class="text-sm text-gray-500">View & edit profile</div>
                        </div>
                    </div>
                    <div class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity">
                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </div>
                </a>
                
                <div class="group relative overflow-hidden bg-gradient-to-br from-white to-gray-50 border border-gray-200 rounded-2xl p-5">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <div class="font-semibold text-gray-900">Upcoming</div>
                            <div class="text-sm text-gray-500">Club meetings & events</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Main Dashboard Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column: Active Clubs & Quick Actions -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Active Clubs Card -->
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Your Active Clubs</h2>
                        <p class="text-sm text-gray-500 mt-1">{{ $stats['active_clubs'] }} clubs • {{ 5 - $stats['active_clubs'] }} slots remaining</p>
                    </div>
                    <a href="{{ route('student.clubs.myClubs') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-700 flex items-center gap-1">
                        View all
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
                
                <div class="p-6">
                    @if($activeMemberships->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($activeMemberships as $membership)
                                <div class="group relative overflow-hidden border border-gray-200 rounded-xl hover:border-indigo-300 hover:shadow-md transition-all duration-300">
                                    <div class="p-5">
                                        <div class="flex items-start justify-between mb-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white font-bold" 
                                                     style="background: linear-gradient(135deg, {{ $membership->club->banner_color ?? '#6366f1' }} 0%, {{ $membership->club->banner_color ?? '#8b5cf6' }} 100%);">
                                                    {{ substr($membership->club->name, 0, 2) }}
                                                </div>
                                                <div>
                                                    <h3 class="font-semibold text-gray-900 group-hover:text-indigo-600">{{ $membership->club->name }}</h3>
                                                    <div class="flex items-center gap-2 mt-1">
                                                        <span class="text-xs px-2 py-1 bg-green-100 text-green-800 rounded-full">Active</span>
                                                        <span class="text-xs text-gray-500">{{ $membership->club->category }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-center justify-between text-sm text-gray-500">
                                            <span>Joined {{ $membership->joined_at->format('M d, Y') }}</span>
                                            <span>{{ $membership->club->meeting_schedule ?? 'Flexible schedule' }}</span>
                                        </div>
                                        
                                        <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between">
                                            <a href="{{ route('student.clubs.show', $membership->club->slug) }}" 
                                               class="text-sm font-medium text-indigo-600 hover:text-indigo-700 flex items-center gap-1">
                                                View club
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                                </svg>
                                            </a>
                                            
                                            @if($membership->canLeave())
                                                <form action="{{ route('student.clubs.leave', $membership->club->slug) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" 
                                                            onclick="return confirm('Leave {{ $membership->club->name }}?')"
                                                            class="text-sm font-medium text-red-600 hover:text-red-700">
                                                        Leave
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No active clubs yet</h3>
                            <p class="text-gray-500 mb-6">Join clubs to start your campus journey</p>
                            <a href="{{ route('student.clubs.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition">
                                Browse available clubs
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Recent Clubs Section -->
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm">
                <div class="px-6 py-5 border-b border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-900">Recently Added Clubs</h2>
                    <p class="text-sm text-gray-500 mt-1">New clubs you might be interested in</p>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($recentClubs as $club)
                            <div class="group border border-gray-200 rounded-xl hover:border-indigo-300 hover:shadow-md transition-all duration-300 overflow-hidden">
                                <div class="p-5">
                                    <div class="flex items-center gap-3 mb-3">
                                        <div class="w-10 h-10 rounded-lg flex items-center justify-center text-white font-bold text-sm"
                                             style="background: linear-gradient(135deg, {{ $club->banner_color ?? '#6366f1' }} 0%, {{ $club->banner_color ?? '#8b5cf6' }} 100%);">
                                            {{ substr($club->name, 0, 2) }}
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h3 class="font-semibold text-gray-900 truncate">{{ $club->name }}</h3>
                                            <p class="text-xs text-gray-500">{{ $club->category }}</p>
                                        </div>
                                    </div>
                                    
                                    <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $club->description }}</p>
                                    
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            <span class="text-xs text-gray-500">{{ $club->activeMembers()->count() }} members</span>
                                        </div>
                                        
                                        <a href="{{ route('student.clubs.show', $club->slug) }}" 
                                           class="text-sm font-medium text-indigo-600 hover:text-indigo-700 flex items-center gap-1">
                                            View
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Column: Pending Requests & Quick Stats -->
        <div class="space-y-8">
            <!-- Pending Requests Card -->
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm">
                <div class="px-6 py-5 border-b border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-900">Pending Requests</h2>
                    <p class="text-sm text-gray-500 mt-1">Awaiting club approval</p>
                </div>
                
                <div class="p-6">
                    @if($pendingRequests->count() > 0)
                        <div class="space-y-4">
                            @foreach($pendingRequests as $request)
                                <div class="p-4 border border-gray-200 rounded-xl">
                                    <div class="flex items-start justify-between mb-2">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-lg flex items-center justify-center text-white font-bold text-sm bg-gradient-to-br from-yellow-400 to-yellow-500">
                                                {{ substr($request->club->name, 0, 2) }}
                                            </div>
                                            <div>
                                                <h3 class="font-medium text-gray-900">{{ $request->club->name }}</h3>
                                                <p class="text-xs text-gray-500">{{ $request->club->category }}</p>
                                            </div>
                                        </div>
                                        <span class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">Pending</span>
                                    </div>
                                    
                                    <p class="text-xs text-gray-500 mb-3">Requested {{ $request->created_at->diffForHumans() }}</p>
                                    
                                    <form action="{{ route('student.clubs.cancelRequest', $request->club->slug) }}" method="POST" class="flex">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="flex-1 text-center text-sm font-medium text-red-600 hover:text-red-700 py-2 border border-gray-200 rounded-lg hover:border-red-200 transition">
                                            Cancel Request
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="w-12 h-12 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <p class="text-gray-500">All requests processed</p>
                        </div>
                    @endif
                </div>
            </div>
            
            
        </div>
    </div>
</div>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .backdrop-blur-sm {
        backdrop-filter: blur(4px);
    }
    
    .hover\:-translate-y-1:hover {
        transform: translateY(-4px);
    }
    
    .group:hover .group-hover\:text-indigo-600 {
        color: #4f46e5;
    }
</style>
@endsection