@extends('layouts.admin')

@section('title', 'تصنيفات الفرص الاستثمارية')

@section('content')
<div class="category-container">
    <div class="row">
        <div class="col-12">
            <div class="card category-card">
                <div class="category-card-header">
                    <h3 class="category-card-title">تصنيفات الفرص الاستثمارية</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.investment-categories.create') }}" class="category-btn category-btn-primary category-btn-sm">
                            <i class="fas fa-plus"></i> إضافة تصنيف جديد
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
                                <th>الاسم</th>
                                <th>الوصف</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                            <tr>
                                <td>{{ $category->name }}</td>
                                <td>{{ Str::limit($category->description, 50) }}</td>
                                <td>
                                    <span class="category-badge {{ $category->is_active ? 'category-badge-success' : 'category-badge-danger' }}">
                                        {{ $category->is_active ? 'نشط' : 'غير نشط' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.investment-categories.edit', $category) }}"
                                            class="category-btn category-btn-info category-btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.investment-categories.destroy', $category) }}"
                                            method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('هل أنت متأكد من حذف هذا التصنيف؟');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="category-btn category-btn-danger category-btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="category-empty-state">لا توجد تصنيفات.</td>
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