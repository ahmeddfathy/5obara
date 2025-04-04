@extends('layouts.admin')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <h1 class="text-2xl font-bold mb-6">Dashboard</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-blue-50 rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4 text-blue-700">Blog Posts</h2>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-3xl font-bold text-gray-700">{{ \App\Models\Post::count() }}</p>
                        <p class="text-sm text-gray-500">Total Posts</p>
                    </div>
                    <svg class="w-12 h-12 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                </div>
                <div class="mt-4">
                    <a href="{{ route('admin.posts.index') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
                        Manage Posts
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <div class="bg-green-50 rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4 text-green-700">Portfolio</h2>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-3xl font-bold text-gray-700">{{ \App\Models\Portfolio::count() }}</p>
                        <p class="text-sm text-gray-500">Portfolio Items</p>
                    </div>
                    <svg class="w-12 h-12 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="mt-4">
                    <a href="{{ route('admin.portfolio.index') }}" class="text-green-600 hover:text-green-800 flex items-center">
                        Manage Portfolio
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <div class="bg-purple-50 rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4 text-purple-700">Investment Opportunities</h2>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-3xl font-bold text-gray-700">{{ \App\Models\Post::whereNotNull('investment_amount')->count() }}</p>
                        <p class="text-sm text-gray-500">Active Opportunities</p>
                    </div>
                    <svg class="w-12 h-12 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="mt-4">
                    <a href="{{ route('blog.opportunities') }}" target="_blank" class="text-purple-600 hover:text-purple-800 flex items-center">
                        View Opportunities
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <div class="mt-10">
            <h2 class="text-xl font-semibold mb-4">Recent Updates</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @php
                            $posts = \App\Models\Post::orderBy('created_at', 'desc')->take(5)->get();
                            $portfolios = \App\Models\Portfolio::orderBy('created_at', 'desc')->take(5)->get();
                            $combined = $posts->concat($portfolios)->sortByDesc('created_at')->take(5);
                        @endphp

                        @forelse($combined as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $item->title }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ get_class($item) === 'App\Models\Post' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                        {{ get_class($item) === 'App\Models\Post' ? 'Blog Post' : 'Portfolio Item' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $item->created_at->format('M j, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    @if(get_class($item) === 'App\Models\Post')
                                        <a href="{{ route('admin.posts.edit', $item) }}" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                                    @else
                                        <a href="{{ route('admin.portfolio.edit', $item) }}" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                    No recent updates found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
