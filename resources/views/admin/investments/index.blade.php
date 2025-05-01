@extends('layouts.admin')

@section('title', 'إدارة الفرص الاستثمارية')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/blog.css') }}?t={{ time() }}">
@endsection

@section('content')
<div class="admin-posts-container">
    <!-- Header Section -->
    <div class="admin-posts-header">
        <h1 class="admin-title"><i class="fas fa-chart-line"></i> إدارة الفرص الاستثمارية</h1>
        <p class="admin-subtitle">إدارة وتنظيم الفرص الاستثمارية المنشورة في الموقع</p>

        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <a href="{{ route('admin.investments.create') }}" class="admin-btn admin-btn-primary">
                <i class="fas fa-plus-circle"></i> إضافة فرصة استثمارية جديدة
            </a>

            <div class="input-group mt-3 mt-md-0" style="max-width: 300px;">
                <input type="text" id="investmentSearchInput" class="form-control" placeholder="بحث عن فرصة استثمارية...">
                <button class="btn btn-outline-secondary" type="button" id="investmentSearchBtn">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row admin-posts-stats">
        <div class="col-md-3 admin-fade-in admin-fade-in-1">
            <div class="admin-stats-card">
                <div class="admin-stats-icon primary">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="admin-stats-content">
                    <div class="admin-stats-title">إجمالي الفرص</div>
                    <div class="admin-stats-value">{{ \App\Models\Investment::count() }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 admin-fade-in admin-fade-in-2">
            <div class="admin-stats-card">
                <div class="admin-stats-icon success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="admin-stats-content">
                    <div class="admin-stats-title">الفرص المنشورة</div>
                    <div class="admin-stats-value">{{ \App\Models\Investment::where('is_published', true)->count() }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 admin-fade-in admin-fade-in-3">
            <div class="admin-stats-card">
                <div class="admin-stats-icon warning">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="admin-stats-content">
                    <div class="admin-stats-title">الفرص المؤرشفة</div>
                    <div class="admin-stats-value">{{ \App\Models\Investment::where('is_published', false)->count() }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 admin-fade-in admin-fade-in-4">
            <div class="admin-stats-card">
                <div class="admin-stats-icon info">
                    <i class="fas fa-image"></i>
                </div>
                <div class="admin-stats-content">
                    <div class="admin-stats-title">معرض الصور</div>
                    <div class="admin-stats-value">{{ \App\Models\InvestmentImage::count() }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Posts List Card -->
    <div class="admin-card mt-5 admin-fade-in">
        <div class="admin-card-header">
            <h2 class="admin-card-title"><i class="fas fa-list"></i> قائمة الفرص الاستثمارية</h2>
            <div class="admin-card-actions d-flex gap-2 flex-wrap justify-content-end">
                <a href="{{ route('admin.investments.index', ['filter' => 'published']) }}" class="admin-btn admin-btn-outline">
                    <i class="fas fa-check-circle"></i> المنشورة
                </a>
                <a href="{{ route('admin.investments.index', ['filter' => 'draft']) }}" class="admin-btn admin-btn-outline">
                    <i class="fas fa-clock"></i> المؤرشفة
                </a>
                <a href="{{ route('admin.investments.index') }}" class="admin-btn admin-btn-outline">
                    <i class="fas fa-redo"></i> الكل
                </a>
            </div>
        </div>
        <div class="admin-card-body">
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th class="admin-th" style="min-width: 250px;"><i class="fas fa-chart-line"></i> العنوان</th>
                            <th class="admin-th"><i class="fas fa-money-bill-wave"></i> قيمة الاستثمار</th>
                            <th class="admin-th"><i class="fas fa-tag"></i> نوع الاستثمار</th>
                            <th class="admin-th"><i class="fas fa-map-marker-alt"></i> الموقع</th>
                            <th class="admin-th text-center"><i class="fas fa-check-circle"></i> الحالة</th>
                            <th class="admin-th"><i class="fas fa-calendar-alt"></i> تاريخ النشر</th>
                            <th class="admin-th text-center" style="min-width: 150px;"><i class="fas fa-cogs"></i> الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($investments as $investment)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    @if($investment->featured_image)
                                    <img src="{{ asset('storage/' . $investment->featured_image) }}"
                                        alt="{{ $investment->title }}"
                                        class="investment-thumbnail"
                                        style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                                    @endif
                                    <div>
                                        <div class="fw-bold">{{ $investment->title }}</div>
                                        <small class="text-muted">{{ Str::limit(strip_tags($investment->content), 60) }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $investment->investment_amount }} ر.س</td>
                            <td>{{ optional($investment->category)->name ?? '-' }}</td>
                            <td>{{ $investment->location }}</td>
                            <td class="text-center">
                                <span class="status-badge {{ $investment->is_published ? 'status-published' : 'status-draft' }}">
                                    {{ $investment->is_published ? 'منشور' : 'مؤرشف' }}
                                </span>
                            </td>
                            <td>
                                @if($investment->published_at)
                                {{ $investment->published_at->format('d/m/Y') }}
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2 justify-content-center">
                                    <a href="{{ route('investments.show', $investment->slug) }}"
                                        class="btn btn-sm btn-outline-primary"
                                        target="_blank"
                                        title="عرض">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.investments.edit', $investment) }}"
                                        class="btn btn-sm btn-outline-info"
                                        title="تعديل">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.investments.destroy', $investment) }}"
                                        method="POST"
                                        class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="btn btn-sm btn-outline-danger"
                                            title="حذف">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="mb-3">
                                    <i class="fas fa-chart-line fa-3x text-muted"></i>
                                </div>
                                <h4 class="text-muted mb-3">لا توجد فرص استثمارية</h4>
                                <a href="{{ route('admin.investments.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus-circle"></i> إضافة فرصة استثمارية جديدة
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="admin-pagination">
                {{ $investments->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Delete confirmation
        const deleteForms = document.querySelectorAll('.delete-form');

        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                if (confirm('هل أنت متأكد من حذف هذه الفرصة الاستثمارية؟ لا يمكن التراجع عن هذا الإجراء.')) {
                    this.submit();
                }
            });
        });

        // Simple search functionality
        const searchInput = document.getElementById('investmentSearchInput');
        const searchBtn = document.getElementById('investmentSearchBtn');
        const tableRows = document.querySelectorAll('.admin-table tbody tr');

        function performSearch() {
            const searchTerm = searchInput.value.toLowerCase().trim();

            tableRows.forEach(row => {
                const title = row.querySelector('.post-title').textContent.toLowerCase();
                const excerpt = row.querySelector('.post-excerpt').textContent.toLowerCase();
                const investmentType = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                const location = row.querySelector('td:nth-child(4)').textContent.toLowerCase();

                if (title.includes(searchTerm) || excerpt.includes(searchTerm) || investmentType.includes(searchTerm) || location.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        searchBtn.addEventListener('click', performSearch);

        searchInput.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                performSearch();
            }

            // If search input is empty, show all rows
            if (this.value === '') {
                tableRows.forEach(row => {
                    row.style.display = '';
                });
            }
        });
    });
</script>
@endsection