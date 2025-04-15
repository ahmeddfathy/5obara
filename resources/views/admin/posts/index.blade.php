@extends('layouts.admin')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/posts.css') }}">
@endsection

@section('content')
<div class="admin-posts-container">
    <div class="admin-posts-header">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="admin-title">
                <i class="fas fa-newspaper me-2"></i>Manage Posts
            </h1>
            <a href="{{ route('admin.posts.create') }}" class="admin-btn admin-btn-primary">
                <i class="fas fa-plus-circle me-2"></i>Create New Post
            </a>
        </div>

        <div class="admin-posts-stats row mb-4">
            <div class="col-md-3">
                <div class="admin-stats-card admin-fade-in admin-fade-in-1">
                    <div class="admin-stats-icon primary">
                        <i class="fas fa-newspaper"></i>
                    </div>
                    <div class="admin-stats-content">
                        <h3 class="admin-stats-title">Total Posts</h3>
                        <p class="admin-stats-value">{{ $posts->total() }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="admin-stats-card admin-fade-in admin-fade-in-2">
                    <div class="admin-stats-icon info">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="admin-stats-content">
                        <h3 class="admin-stats-title">Published</h3>
                        <p class="admin-stats-value">{{ $posts->where('is_published', true)->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="admin-stats-card admin-fade-in admin-fade-in-3">
                    <div class="admin-stats-icon warning">
                        <i class="fas fa-edit"></i>
                    </div>
                    <div class="admin-stats-content">
                        <h3 class="admin-stats-title">Drafts</h3>
                        <p class="admin-stats-value">{{ $posts->where('is_published', false)->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="admin-stats-card admin-fade-in admin-fade-in-4">
                    <div class="admin-stats-icon success">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="admin-stats-content">
                        <h3 class="admin-stats-title">Investments</h3>
                        <p class="admin-stats-value">{{ number_format($posts->sum('investment_amount')) }} ر.س</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="admin-card admin-fade-in">
        <div class="admin-card-header d-flex justify-content-between align-items-center">
            <h2 class="admin-card-title"><i class="fas fa-list me-2"></i>Posts List</h2>
            <div class="admin-card-actions">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" id="postSearchInput" class="form-control border-start-0 ps-0" placeholder="Search posts...">
                </div>
            </div>
        </div>
        <div class="admin-card-body">
            <div class="table-responsive">
                <table class="admin-table table" id="postsTable">
                    <thead>
                        <tr>
                            <th class="admin-th"><i class="fas fa-heading me-2"></i>Title</th>
                            <th class="admin-th"><i class="fas fa-toggle-on me-2"></i>Status</th>
                            <th class="admin-th"><i class="fas fa-dollar-sign me-2"></i>Investment</th>
                            <th class="admin-th"><i class="fas fa-calendar-alt me-2"></i>Published</th>
                            <th class="admin-th"><i class="fas fa-cogs me-2"></i>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($posts as $post)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="post-thumbnail me-2">
                                        @if($post->featured_image)
                                            <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" width="40" height="40" class="rounded">
                                        @else
                                            <div class="placeholder-thumbnail rounded d-flex align-items-center justify-content-center">
                                                <i class="fas fa-newspaper text-muted"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="post-info">
                                        <div class="post-title fw-medium">{{ $post->title }}</div>
                                        <div class="post-excerpt text-muted small">{{ Str::limit($post->excerpt, 50) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="status-badge {{ $post->is_published ? 'status-published' : 'status-draft' }}">
                                    <i class="fas {{ $post->is_published ? 'fa-check-circle' : 'fa-clock' }} me-1"></i>
                                    {{ $post->is_published ? 'Published' : 'Draft' }}
                                </span>
                            </td>
                            <td>
                                @if($post->investment_amount)
                                    <span class="investment-amount">{{ number_format($post->investment_amount) }} ر.س</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($post->published_at)
                                    <span class="date-badge">
                                        <i class="fas fa-calendar-day me-1"></i>
                                        {{ $post->published_at->format('M j, Y') }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="post-actions">
                                    <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-sm btn-outline-primary me-2" title="Edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this post?')" title="Delete">
                                            <i class="fas fa-trash-alt"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="admin-pagination mt-4">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('postSearchInput');
    const postsTable = document.getElementById('postsTable');
    const tableRows = postsTable.querySelectorAll('tbody tr');

    searchInput.addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();

        tableRows.forEach(row => {
            const title = row.querySelector('.post-title').textContent.toLowerCase();
            const excerpt = row.querySelector('.post-excerpt').textContent.toLowerCase();

            if (title.includes(searchTerm) || excerpt.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
});
</script>
@endsection
@endsection
