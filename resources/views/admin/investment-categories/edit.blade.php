@extends('layouts.admin')

@section('title', 'تعديل تصنيف الفرص الاستثمارية')

@section('content')
<div class="category-container">
    <div class="row">
        <div class="col-12">
            <div class="card category-card">
                <div class="category-card-header">
                    <h3 class="category-card-title">تعديل تصنيف الفرص الاستثمارية</h3>
                </div>
                <div class="category-card-body">
                    <form action="{{ route('admin.investment-categories.update', $investmentCategory) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="category-form-group">
                            <label for="name" class="category-form-label">الاسم</label>
                            <input type="text"
                                class="category-form-control @error('name') is-invalid @enderror"
                                id="name"
                                name="name"
                                value="{{ old('name', $investmentCategory->name) }}"
                                required>
                            @error('name')
                            <div class="category-invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="category-form-group">
                            <label for="description" class="category-form-label">الوصف</label>
                            <textarea class="category-form-control @error('description') is-invalid @enderror"
                                id="description"
                                name="description"
                                rows="3">{{ old('description', $investmentCategory->description) }}</textarea>
                            @error('description')
                            <div class="category-invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="category-form-group">
                            <div class="category-switch">
                                <input type="checkbox"
                                    class="category-switch-input"
                                    id="is_active"
                                    name="is_active"
                                    value="1"
                                    {{ old('is_active', $investmentCategory->is_active) ? 'checked' : '' }}>
                                <label class="category-switch-label" for="is_active">نشط</label>
                            </div>
                        </div>

                        <div class="category-form-buttons">
                            <button type="submit" class="category-btn category-btn-primary">تحديث التصنيف</button>
                            <a href="{{ route('admin.investment-categories.index') }}" class="category-btn category-btn-secondary">إلغاء</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
