@extends('layouts.admin')

@section('content')
<div class="category-container">
    <div class="row">
        <div class="col-12">
            <div class="card category-card">
                <div class="category-card-header">
                    <h3 class="category-card-title">Create New Category</h3>
                </div>
                <div class="category-card-body">
                    <form action="{{ route('admin.categories.store') }}" method="POST">
                        @csrf
                        <div class="category-form-group">
                            <label for="name" class="category-form-label">Name</label>
                            <input type="text" class="category-form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                            <div class="category-invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="category-form-group">
                            <label for="description" class="category-form-label">Description</label>
                            <textarea class="category-form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                            <div class="category-invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="category-form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_active">Active Category</label>
                            </div>
                            @error('is_active')
                            <div class="category-invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="category-form-buttons">
                            <button type="submit" class="category-btn category-btn-primary">Create Category</button>
                            <a href="{{ route('admin.categories.index') }}" class="category-btn category-btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection