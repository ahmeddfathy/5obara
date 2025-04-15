@extends('layouts.admin')

@section('content')
<div class="portfolio-container">
    <div class="portfolio-header d-flex justify-content-between align-items-center">
        <div>
            <h1 class="portfolio-title">إدارة المشاريع</h1>
            <p class="portfolio-subtitle">إنشاء وتعديل وإدارة مشاريعك بسهولة</p>
        </div>
        <div class="portfolio-actions">
            <a href="{{ route('admin.portfolio.create') }}" class="portfolio-btn portfolio-btn-primary">
                <i class="fas fa-plus-circle"></i> إضافة مشروع جديد
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-4 portfolio-fade-in portfolio-fade-in-1">
            <div class="portfolio-stats-card">
                <div class="portfolio-stats-icon primary">
                    <i class="fas fa-briefcase"></i>
                </div>
                <div class="portfolio-stats-content">
                    <p class="portfolio-stats-value">{{ $portfolios->total() }}</p>
                    <h3 class="portfolio-stats-title">إجمالي المشاريع</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4 portfolio-fade-in portfolio-fade-in-2">
            <div class="portfolio-stats-card">
                <div class="portfolio-stats-icon success">
                    <i class="fas fa-star"></i>
                </div>
                <div class="portfolio-stats-content">
                    <p class="portfolio-stats-value">{{ $portfolios->where('is_featured', true)->count() }}</p>
                    <h3 class="portfolio-stats-title">المشاريع المميزة</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4 portfolio-fade-in portfolio-fade-in-3">
            <div class="portfolio-stats-card">
                <div class="portfolio-stats-icon info">
                    <i class="fas fa-calendar"></i>
                </div>
                <div class="portfolio-stats-content">
                    <p class="portfolio-stats-value">{{ $portfolios->where('created_at', '>=', now()->startOfMonth())->count() }}</p>
                    <h3 class="portfolio-stats-title">هذا الشهر</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="portfolio-card portfolio-fade-in">
        <div class="portfolio-card-header">
            <h2 class="portfolio-card-title"><i class="fas fa-briefcase"></i> قائمة المشاريع</h2>
            <div class="portfolio-card-actions">
                <div class="input-group">
                    <input type="text" id="portfolioSearchInput" class="form-control search-input"
                           placeholder="البحث في المشاريع...">
                    <span class="input-group-text search-icon">
                        <i class="fas fa-search"></i>
                    </span>
                </div>
            </div>
        </div>
        <div class="portfolio-card-body">
            <div class="table-responsive">
                <table class="table portfolio-table" id="portfolioTable">
                    <thead>
                        <tr>
                            <th width="50%"><i class="fas fa-file-alt"></i> عنوان المشروع</th>
                            <th width="25%"><i class="fas fa-tag"></i> النوع</th>
                            <th width="15%" class="text-center"><i class="fas fa-star"></i> مميز</th>
                            <th width="10%" class="text-center"><i class="fas fa-cogs"></i> الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($portfolios as $portfolio)
                        <tr class="portfolio-item-row">
                            <td>
                                <div class="portfolio-item-title">
                                    <div class="portfolio-item-thumb">
                                        @if($portfolio->image)
                                            <img src="{{ asset('storage/' . $portfolio->image) }}" alt="{{ $portfolio->title }}">
                                        @else
                                            <div class="portfolio-item-thumb-placeholder">
                                                <i class="fas fa-image"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="portfolio-item-title-text">
                                        {{ $portfolio->title }}
                                        <span class="portfolio-item-subtitle">{{ Str::limit($portfolio->description, 50) }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="portfolio-badge portfolio-badge-info">
                                    <i class="fas fa-tag"></i> {{ $portfolio->project_type }}
                                </span>
                            </td>
                            <td class="text-center">
                                @if($portfolio->is_featured)
                                    <span class="portfolio-badge portfolio-badge-featured">
                                        <i class="fas fa-crown"></i>
                                    </span>
                                @else
                                    <span class="portfolio-badge portfolio-badge-neutral">
                                        <i class="fas fa-minus-circle"></i>
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="portfolio-actions-group">
                                    <a href="{{ route('admin.portfolio.edit', $portfolio) }}"
                                       class="portfolio-btn portfolio-btn-icon portfolio-btn-primary"
                                       data-bs-toggle="tooltip" title="تعديل">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.portfolio.destroy', $portfolio) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="portfolio-btn portfolio-btn-icon portfolio-btn-danger"
                                                onclick="return confirm('هل أنت متأكد من حذف هذا المشروع؟')"
                                                data-bs-toggle="tooltip" title="حذف">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="empty-state">
                                    <div class="empty-state-icon">
                                        <i class="fas fa-folder-open"></i>
                                    </div>
                                    <h5>لا توجد مشاريع</h5>
                                    <p>ابدأ بإضافة مشروعك الأول</p>
                                    <a href="{{ route('admin.portfolio.create') }}" class="portfolio-btn portfolio-btn-primary mt-3">
                                        <i class="fas fa-plus-circle"></i> إضافة مشروع
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="portfolio-pagination">
                {{ $portfolios->links() }}
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .portfolio-stats-card {
        background: var(--portfolio-light);
        border-radius: var(--portfolio-card-radius);
        box-shadow: var(--portfolio-shadow);
        display: flex;
        align-items: center;
        gap: 1.2rem;
        padding: 1.5rem;
        transition: var(--portfolio-transition);
        height: 100%;
    }

    .portfolio-stats-card:hover {
        box-shadow: var(--portfolio-shadow-lg);
        transform: translateY(-5px);
    }

    .portfolio-stats-icon {
        width: 60px;
        height: 60px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        box-shadow: var(--portfolio-shadow-sm);
        flex-shrink: 0;
    }

    .portfolio-stats-icon.primary {
        background: rgba(79, 209, 197, 0.15);
        color: var(--portfolio-primary);
        box-shadow: 0 4px 8px rgba(79, 209, 197, 0.2);
    }

    .portfolio-stats-icon.success {
        background: rgba(72, 187, 120, 0.15);
        color: var(--portfolio-success);
        box-shadow: 0 4px 8px rgba(72, 187, 120, 0.2);
    }

    .portfolio-stats-icon.info {
        background: rgba(66, 153, 225, 0.15);
        color: var(--portfolio-info);
        box-shadow: 0 4px 8px rgba(66, 153, 225, 0.2);
    }

    .portfolio-stats-icon.neutral {
        background: rgba(160, 174, 192, 0.15);
        color: var(--portfolio-gray-600);
        box-shadow: 0 4px 8px rgba(160, 174, 192, 0.2);
    }

    .portfolio-stats-content {
        flex-grow: 1;
    }

    .portfolio-stats-title {
        font-size: 1rem;
        color: var(--portfolio-gray-600);
        margin-bottom: 0.5rem;
        font-weight: 500;
    }

    .portfolio-stats-value {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--portfolio-gray-900);
        margin: 0;
        line-height: 1.2;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('portfolioSearchInput');
    const portfolioTable = document.getElementById('portfolioTable');
    const tableRows = portfolioTable.querySelectorAll('tbody tr');

    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    searchInput.addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        let foundResults = false;

        tableRows.forEach(row => {
            const title = row.querySelector('.portfolio-item-title-text').textContent.toLowerCase();
            const type = row.querySelector('td:nth-child(2)').textContent.toLowerCase();

            if (title.includes(searchTerm) || type.includes(searchTerm)) {
                row.style.display = '';
                foundResults = true;
            } else {
                row.style.display = 'none';
            }
        });

        // Show empty state if no results found
        const emptyState = document.getElementById('emptySearchResults');
        if (emptyState) {
            emptyState.style.display = foundResults ? 'none' : '';
        }
    });
});
</script>
@endpush
@endsection
