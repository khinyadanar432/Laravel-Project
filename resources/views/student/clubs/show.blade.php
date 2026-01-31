@extends('layouts.student')

@section('content')
<div class="space-y-6">
    <!-- Club Header -->
    <div class="relative h-64 rounded-2xl overflow-hidden" style="background-color: {{ $club->banner_color }};">
        <div class="absolute inset-0 bg-black/20"></div>
        <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold">{{ $club->name }}</h1>
                    <p class="mt-2 text-lg opacity-90">{{ $club->category }}</p>
                </div>
                <div class="text-right">
                    <div class="text-2xl font-bold">{{ $activeMembers }} members</div>
                    @if($club->max_members)
                        <div class="text-sm opacity-80">{{ $club->max_members - $activeMembers }} spots remaining</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Club Info Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">About the Club</h2>
                <p class="text-gray-600 leading-relaxed">{{ $club->description }}</p>
                
                <!-- Meeting Schedule -->
                <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <div>
                            <p class="font-medium text-gray-900">Meeting Schedule</p>
                            <p class="text-gray-600">{{ $club->meeting_schedule }}</p>
                        </div>
                    </div>
                </div>

                <!-- Tags -->
                @if($club->tags)
                    <div class="mt-6">
                        <h3 class="font-medium text-gray-900 mb-2">Tags & Interests</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($club->tags as $tag)
                                <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm">
                                    {{ $tag }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Faculty Advisor -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Faculty Advisor</h2>
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-semibold">
                        {{ substr($club->facultyAdvisor->name, 0, 2) }}
                    </div>
                    <div class="ml-4">
                        <p class="font-medium text-gray-900">{{ $club->facultyAdvisor->name }}</p>
                        <p class="text-gray-600">Faculty Advisor</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Membership Status & Actions -->
        <div class="space-y-6">
            <!-- Membership Status Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Your Membership Status</h2>
                
                @if($isMember && $membership)
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-500">Status</p>
                            @if($membership->status == 'active')
                                <div class="flex items-center mt-1">
                                    <span class="status-badge status-active">Active Member</span>
                                </div>
                                <p class="mt-2 text-sm text-gray-600">
                                    Joined on {{ $membership->joined_at->format('F d, Y') }}
                                </p>
                                
                                <!-- Leave Club Button -->
                                @if($membership->canLeave())
                                    <button onclick="confirmLeave('{{ $club->name }}', '{{ route('student.clubs.leave', $club->slug) }}')"
                                            class="mt-4 w-full px-4 py-2 text-sm font-medium text-red-600 border border-red-600 rounded-lg hover:bg-red-50 transition">
                                        Leave Club
                                    </button>
                                @else
                                    <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                                        <p class="text-sm text-yellow-700">
                                            You have pending payments. Please settle your balance before leaving.
                                        </p>
                                    </div>
                                @endif
                            @elseif($membership->status == 'pending')
                                <div class="flex items-center mt-1">
                                    <span class="status-badge status-pending">Pending Approval</span>
                                </div>
                                <p class="mt-2 text-sm text-gray-600">
                                    Your request is under review by club administrators.
                                </p>
                                <form action="{{ route('student.clubs.cancel-request', $club->slug) }}" method="POST" class="mt-4">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="w-full px-4 py-2 text-sm font-medium text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                                        Cancel Request
                                    </button>
                                </form>
                            @else
                                <span class="status-badge status-archived">Former Member</span>
                            @endif
                        </div>
                    </div>
                @elseif($pendingRequest)
                    <div class="text-center p-4">
                        <span class="status-badge status-pending mb-4">Request Pending</span>
                        <p class="text-gray-600">Your membership request is awaiting approval.</p>
                        <form action="{{ route('student.clubs.cancelRequest', $club->slug) }}" method="POST" class="mt-4">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full px-4 py-2 text-sm font-medium text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                                Cancel Request
                            </button>
                        </form>
                    </div>
                @else
                    <!-- Join Club Form -->
                    <form action="{{ route('student.clubs.join', $club->slug) }}" method="POST" class="space-y-4">
                        @csrf
                        
                        @if($club->isFull())
                            <div class="p-4 bg-red-50 border border-red-200 rounded-lg">
                                <p class="text-red-700 font-medium">Club is Full</p>
                                <p class="text-red-600 text-sm mt-1">
                                    This club has reached its maximum capacity. Check back later for openings.
                                </p>
                            </div>
                        @else
                            <div>
                                <label for="message" class="block text-sm font-medium text-gray-700 mb-1">
                                    Optional Message (Optional)
                                </label>
                                <textarea name="message" 
                                          id="message" 
                                          rows="3"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                          placeholder="Tell them why you want to join..."></textarea>
                            </div>
                            
                            <button type="submit" 
                                    class="w-full px-4 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Join This Club
                            </button>
                        @endif
                    </form>
                @endif
            </div>

            <!-- Club Stats -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Club Information</h2>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Status</span>
                        <span class="px-3 py-1 rounded-full text-sm font-medium {{ $club->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $club->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Members</span>
                        <span class="font-medium">{{ $activeMembers }} active</span>
                    </div>
                    @if($club->max_members)
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Capacity</span>
                            <span class="font-medium">{{ $club->max_members }} max</span>
                        </div>
                    @endif
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Category</span>
                        <span class="font-medium">{{ $club->category }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection