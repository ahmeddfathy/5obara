@extends('layouts.admin')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/blog.css') }}?t={{ time() }}">
@endsection

@section('content')
<div class="admin-posts-container">
    <div class="admin-posts-header">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="admin-title">
                <i class="fas fa-newspaper me-2"></i>Manage Blogs
            </h1>
            <a href="{{ route('admin.blogs.create') }}" class="admin-btn admin-btn-primary">
                <i class="fas fa-plus-circle me-2"></i>Create New Blog
            </a>
        </div>

        <div class="admin-posts-stats row mb-4">
            <div class="col-md-4">
                <div class="admin-stats-card admin-fade-in admin-fade-in-1">
                    <div class="admin-stats-icon primary">
                        <i class="fas fa-newspaper"></i>
                    </div>
                    <div class="admin-stats-content">
                        <h3 class="admin-stats-title">Total Blogs</h3>
                        <p class="admin-stats-value">{{ $blogs->total() }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="admin-stats-card admin-fade-in admin-fade-in-2">
                    <div class="admin-stats-icon info">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="admin-stats-content">
                        <h3 class="admin-stats-title">Published</h3>
                        <p class="admin-stats-value">{{ $blogs->where('is_published', true)->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="admin-stats-card admin-fade-in admin-fade-in-3">
                    <div class="admin-stats-icon warning">
                        <i class="fas fa-edit"></i>
                    </div>
                    <div class="admin-stats-content">
                        <h3 class="admin-stats-title">Drafts</h3>
                        <p class="admin-stats-value">{{ $blogs->where('is_published', false)->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="admin-card admin-fade-in mb-4">
        <div class="admin-card-header">
            <h2 class="admin-card-title"><i class="fas fa-filter me-2"></i>Filter Blogs</h2>
        </div>
        <div class="admin-card-body">
            <form action="{{ route('admin.blogs.index') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label for="category_id" class="form-label">Category</label>
                    <select name="category_id" id="category_id" class="form-select">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="date_from" class="form-label">From Date</label>
                    <input type="date" class="form-control" id="date_from" name="date_from" value="{{ request('date_from') }}">
                </div>

                <div class="col-md-3">
                    <label for="date_to" class="form-label">To Date</label>
                    <input type="date" class="form-control" id="date_to" name="date_to" value="{{ request('date_to') }}">
                </div>

                <div class="col-12 mt-3 d-flex justify-content-end">
                    <a href="{{ route('admin.blogs.index') }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-redo me-1"></i>Reset
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter me-1"></i>Apply Filters
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="admin-card admin-fade-in">
        <div class="admin-card-header d-flex justify-content-between align-items-center">
            <h2 class="admin-card-title"><i class="fas fa-list me-2"></i>Blogs List</h2>
            <div class="admin-card-actions">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" id="postSearchInput" class="form-control border-start-0 ps-0" placeholder="Search blogs...">
                </div>
            </div>
        </div>
        <div class="admin-card-body">
            <div class="table-responsive">
                <table class="admin-table table" id="postsTable">
                    <thead>
                        <tr>
                            <th class="admin-th"><i class="fas fa-heading me-2"></i>Title</th>
                            <th class="admin-th"><i class="fas fa-tags me-2"></i>Category</th>
                            <th class="admin-th"><i class="fas fa-toggle-on me-2"></i>Status</th>
                            <th class="admin-th"><i class="fas fa-calendar-alt me-2"></i>Published</th>
                            <th class="admin-th"><i class="fas fa-cogs me-2"></i>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($blogs as $blog)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="post-thumbnail me-2">
                                        @if($blog->featured_image)
                                        <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="{{ $blog->title }}" class="rounded">
                                        @else
                                        <div class="placeholder-thumbnail rounded d-flex align-items-center justify-content-center">
                                            <i class="fas fa-newspaper text-muted"></i>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="post-info">
                                        <div class="post-title fw-medium">{{ $blog->title }}</div>
                                        <div class="post-excerpt text-muted small">{{ Str::limit($blog->excerpt, 50) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($blog->category)
                                <span class="badge bg-primary">{{ $blog->category->name }}</span>
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <span class="status-badge {{ $blog->is_published ? 'status-published' : 'status-draft' }}">
                                    <i class="fas {{ $blog->is_published ? 'fa-check-circle' : 'fa-clock' }} me-1"></i>
                                    {{ $blog->is_published ? 'Published' : 'Draft' }}
                                </span>
                            </td>
                            <td>
                                @if($blog->published_at)
                                <span class="date-badge">
                                    <i class="fas fa-calendar-day me-1"></i>
                                    {{ $blog->published_at->format('M j, Y') }}
                                </span>
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="post-actions">
                                    <a href="{{ route('admin.blogs.edit', $blog) }}" class="btn btn-sm btn-outline-primary me-2" title="Edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this blog?')" title="Delete">
                                            <i class="fas fa-trash-alt"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No blogs found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="admin-pagination mt-4">
                {{ $blogs->links() }}
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
