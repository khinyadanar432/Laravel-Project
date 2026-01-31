@extends('layouts.student')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Browse Clubs</h1>
            <p class="mt-2 text-gray-600">Discover and join clubs that match your interests</p>
        </div>
        <div class="mt-4 md:mt-0">
            <form action="{{ route('student.clubs.index') }}" method="GET" class="flex space-x-2">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Search clubs..." 
                       class="w-full md:w-64 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                    Search
                </button>
            </form>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
        <div class="flex flex-wrap items-center gap-4">
            <span class="text-sm font-medium text-gray-700">Filter by:</span>
            
            <a href="{{ route('student.clubs.index', ['category' => 'all']) }}"
               class="px-4 py-2 rounded-lg {{ request('category', 'all') == 'all' ? 'bg-indigo-100 text-indigo-700' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                All Categories
            </a>
            
            @foreach($categories as $category)
                <a href="{{ route('student.clubs.index', ['category' => $category]) }}"
                   class="px-4 py-2 rounded-lg {{ request('category') == $category ? 'bg-indigo-100 text-indigo-700' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    {{ $category }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- Clubs Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($clubs as $club)
            <div class="club-card bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <!-- Club Header -->
                <div class="h-32" style="background-color: {{ $club->banner_color }};"></div>
                
                <div class="p-6">
                    <!-- Club Info -->
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900">{{ $club->name }}</h3>
                            <p class="mt-1 text-sm text-gray-500">{{ $club->category }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-lg flex items-center justify-center text-white font-bold" 
                             style="background-color: {{ $club->banner_color }};">
                            {{ substr($club->name, 0, 2) }}
                        </div>
                    </div>

                    <!-- Description -->
                    <p class="mt-4 text-gray-600 line-clamp-2">{{ $club->description }}</p>

                    <!-- Stats -->
                    <div class="mt-4 flex items-center justify-between text-sm text-gray-500">
                        <div class="flex items-center space-x-4">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                {{ $club->activeMembers()->count() }} members
                            </span>
                            @if($club->max_members)
                                <span>{{ $club->max_members - $club->activeMembers()->count() }} spots left</span>
                            @endif
                        </div>
                        <span class="px-2 py-1 rounded-full bg-green-100 text-green-800 text-xs font-medium">
                            {{ $club->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>

                    <!-- Tags -->
                    @if($club->tags)
                        <div class="mt-4 flex flex-wrap gap-2">
                            @foreach(array_slice($club->tags, 0, 3) as $tag)
                                <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs">
                                    {{ $tag }}
                                </span>
                            @endforeach
                        </div>
                    @endif

                    <!-- Actions -->
                    <div class="mt-6">
                        <a href="{{ route('student.clubs.show', $club->slug) }}" 
                           class="block w-full text-center px-4 py-2 text-sm font-medium text-indigo-600 border border-indigo-600 rounded-lg hover:bg-indigo-50 transition">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    @if($clubs->hasPages())
        <div class="mt-6">
            {{ $clubs->withQueryString()->links() }}
        </div>
    @endif

    <!-- Empty State -->
    @if($clubs->count() == 0)
        <div class="text-center py-12">
            <svg class="w-16 h-16 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
            <p class="mt-4 text-gray-500">No clubs found matching your criteria.</p>
            <a href="{{ route('student.clubs.index') }}" class="mt-2 inline-block text-indigo-600 hover:text-indigo-800 font-medium">
                Clear filters
            </a>
        </div>
    @endif
</div>
@endsection