@extends('layouts.admin')

@section('content')
<div class="category-container">
    <div class="row">
        <div class="col-12">
            <div class="card category-card">
                <div class="category-card-header">
                    <h3 class="category-card-title">Categories</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.categories.create') }}" class="category-btn category-btn-primary category-btn-sm">
                            <i class="fas fa-plus"></i> Add New Category
                        </a>
                    </div>
                </div>
                <div class="category-card-body">
                    @if(session('success'))
                    <div class="category-alert category-alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    <table class="table category-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                            <tr>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->slug }}</td>
                                <td>{{ Str::limit($category->description, 50) }}</td>
                                <td>
                                    <span class="badge {{ $category->is_active ? 'bg-success' : 'bg-danger' }}">
                                        {{ $category->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.categories.edit', $category) }}" class="category-btn category-btn-info category-btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="category-btn category-btn-danger category-btn-sm" onclick="return confirm('Are you sure you want to delete this category?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="category-empty-state">No categories found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="category-pagination">
                        {{ $categories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection