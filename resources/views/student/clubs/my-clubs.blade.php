@extends('layouts.student')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-3xl font-bold text-gray-900">My Club Memberships</h1>
        <p class="mt-2 text-gray-600">Manage all your club memberships in one place</p>
    </div>

    <!-- Alpine.js Tabs Container -->
    <div x-data="{ activeTab: 'active' }">
        <!-- Tabs Navigation -->
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8">
                <button @click="activeTab = 'active'" 
                        :class="activeTab === 'active' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="py-4 px-1 border-b-2 font-medium text-sm">
                    Active Clubs ({{ $activeMemberships->count() }})
                </button>
                <button @click="activeTab = 'pending'" 
                        :class="activeTab === 'pending' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="py-4 px-1 border-b-2 font-medium text-sm">
                    Pending Requests ({{ $pendingMemberships->count() }})
                </button>
                <button @click="activeTab = 'archived'" 
                        :class="activeTab === 'archived' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="py-4 px-1 border-b-2 font-medium text-sm">
                    Past Memberships ({{ $archivedMemberships->count() }})
                </button>
            </nav>
        </div>

        <!-- Active Clubs -->
        <div x-show="activeTab === 'active'" class="space-y-4 mt-6">
            @if($activeMemberships->count() > 0)
                @foreach($activeMemberships as $membership)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-14 h-14 rounded-xl flex items-center justify-center text-white font-bold text-lg"
                                     style="background-color: {{ $membership->club->banner_color }};">
                                    {{ substr($membership->club->name, 0, 2) }}
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $membership->club->name }}</h3>
                                    <p class="text-sm text-gray-500 mt-1">{{ $membership->club->category }}</p>
                                    <div class="flex items-center mt-2 space-x-4">
                                        <span class="flex items-center text-sm text-gray-600">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            Joined {{ $membership->joined_at->format('M d, Y') }}
                                        </span>
                                        <span class="status-badge status-active">Active</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex space-x-3">
                                <a href="{{ route('student.clubs.show', $membership->club->slug) }}" 
                                   class="px-4 py-2 text-sm font-medium text-indigo-600 border border-indigo-600 rounded-lg hover:bg-indigo-50 transition">
                                    View Club
                                </a>
                                @if($membership->canLeave())
                                    <form action="{{ route('student.clubs.leave', $membership->club->slug) }}" 
                                        method="POST" 
                                        class="inline-block">
                                        @csrf
                                        <button type="submit" 
                                                onclick="return confirm('Are you sure you want to leave {{ $membership->club->name }}?')"
                                                class="px-4 py-2 text-sm font-medium text-red-600 border border-red-600 rounded-lg hover:bg-red-50 transition">
                                            Leave
                                        </button>
                                    </form>
                                @else
                                    <div class="px-4 py-2 text-sm font-medium text-gray-500 border border-gray-300 rounded-lg bg-gray-50 cursor-not-allowed"
                                        title="Cannot leave due to pending payments">
                                        Cannot Leave
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Payment Warning -->
                        @if($membership->has_paid_events && $membership->outstanding_balance > 0)
                            <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="text-sm text-yellow-700">
                                        You have an outstanding balance of ${{ number_format($membership->outstanding_balance, 2) }} for club events.
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <p class="mt-4 text-gray-500">You are not an active member of any clubs.</p>
                    <a href="{{ route('student.clubs.index') }}" class="mt-2 inline-block text-indigo-600 hover:text-indigo-800 font-medium">
                        Browse Clubs →
                    </a>
                </div>
            @endif
        </div>

        <!-- Pending Requests -->
        <div x-show="activeTab === 'pending'" class="space-y-4 mt-6">
            @if($pendingMemberships->count() > 0)
                @foreach($pendingMemberships as $membership)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 rounded-lg flex items-center justify-center text-white font-bold"
                                     style="background-color: {{ $membership->club->banner_color }};">
                                    {{ substr($membership->club->name, 0, 2) }}
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">{{ $membership->club->name }}</h3>
                                    <p class="text-sm text-gray-500">{{ $membership->club->category }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-4">
                                <span class="status-badge status-pending">Pending Approval</span>
                                <form action="{{ route('student.clubs.cancelRequest', $membership->club->slug) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="px-4 py-2 text-sm font-medium text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                                        Cancel
                                    </button>
                                </form>
                            </div>
                        </div>
                        <p class="mt-4 text-sm text-gray-600">
                            Requested {{ $membership->created_at->diffForHumans() }}
                        </p>
                    </div>
                @endforeach
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="mt-4 text-gray-500">No pending membership requests.</p>
                </div>
            @endif
        </div>

        <!-- Archived Memberships -->
        <div x-show="activeTab === 'archived'" class="space-y-4 mt-6">
            @if($archivedMemberships->count() > 0)
                @foreach($archivedMemberships as $membership)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 rounded-lg flex items-center justify-center text-gray-400 font-bold bg-gray-100">
                                    {{ substr($membership->club->name, 0, 2) }}
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">{{ $membership->club->name }}</h3>
                                    <p class="text-sm text-gray-500">{{ $membership->club->category }}</p>
                                </div>
                            </div>
                            <span class="status-badge status-archived">Former Member</span>
                        </div>
                        <div class="mt-4 grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-gray-500">Joined</p>
                                <p class="font-medium">{{ $membership->joined_at->format('M d, Y') }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Left</p>
                                <p class="font-medium">{{ $membership->left_at ? $membership->left_at->format('M d, Y') : 'N/A' }}</p>
                            </div>
                        </div>
                        @if($membership->left_reason)
                            <div class="mt-4 p-3 bg-gray-50 rounded-lg">
                                <p class="text-sm text-gray-600">{{ $membership->left_reason }}</p>
                            </div>
                        @endif
                    </div>
                @endforeach
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z" />
                    </svg>
                    <p class="mt-4 text-gray-500">No past memberships found.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
/* Add this to prevent flickering */
[x-cloak] { 
    display: none !important; 
}
</style>
@endsection