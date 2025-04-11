@extends('layouts.admin')

@section('title', 'لوحة التحكم الرئيسية')

@section('header')
<div class="admin-header admin-fade-in">
    <h1 class="admin-title">لوحة التحكم الرئيسية</h1>
    <div class="admin-actions">
        <a href="{{ route('admin.posts.create') }}" class="admin-action-btn primary">
            <i class="fas fa-plus-circle"></i>
            <span>إضافة مقال</span>
        </a>
        <a href="{{ route('admin.portfolio.create') }}" class="admin-action-btn">
            <i class="fas fa-folder-plus"></i>
            <span>إضافة مشروع</span>
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="admin-stats-card admin-fade-in admin-fade-in-1">
            <div class="admin-stats-icon primary">
                <i class="fas fa-newspaper"></i>
            </div>
            <div class="admin-stats-content">
                <div class="admin-stats-title">إجمالي المقالات</div>
                <div class="admin-stats-value">{{ \App\Models\Post::count() }}</div>
            </div>
            <i class="fas fa-newspaper admin-stats-bg-icon"></i>
        </div>
    </div>
    <div class="col-md-4">
        <div class="admin-stats-card admin-fade-in admin-fade-in-2">
            <div class="admin-stats-icon success">
                <i class="fas fa-briefcase"></i>
            </div>
            <div class="admin-stats-content">
                <div class="admin-stats-title">إجمالي المشاريع</div>
                <div class="admin-stats-value">{{ \App\Models\Portfolio::count() }}</div>
            </div>
            <i class="fas fa-briefcase admin-stats-bg-icon"></i>
        </div>
    </div>
    <div class="col-md-4">
        <div class="admin-stats-card admin-fade-in admin-fade-in-3">
            <div class="admin-stats-icon info">
                <i class="fas fa-users"></i>
            </div>
            <div class="admin-stats-content">
                <div class="admin-stats-title">المستخدمين النشطين</div>
                <div class="admin-stats-value">{{ \App\Models\User::where('is_active', true)->count() }}</div>
            </div>
            <i class="fas fa-users admin-stats-bg-icon"></i>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="admin-card admin-fade-in admin-fade-in-2">
            <div class="admin-card-header">
                <h2 class="admin-card-title">آخر المقالات</h2>
            </div>
            <div class="admin-card-body">
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>العنوان</th>
                                <th>القسم</th>
                                <th>التاريخ</th>
                                <th>الحالة</th>
                                <th>خيارات</th>
                            </tr>
                        </thead>
                        <tbody>
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
                                    <td colspan="5" class="text-center py-5">لا توجد مقالات حالياً</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="admin-card admin-fade-in admin-fade-in-3">
            <div class="admin-card-header">
                <h2 class="admin-card-title">روابط سريعة</h2>
            </div>
            <div class="admin-card-body">
                <div class="list-group">
                    <a href="{{ route('admin.posts.create') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                        <i class="fas fa-plus-circle me-2"></i>
                        <span>إضافة مقال جديد</span>
                    </a>
                    <a href="{{ route('admin.portfolio.create') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                        <i class="fas fa-folder-plus me-2"></i>
                        <span>إضافة مشروع جديد</span>
                    </a>
                    <a href="{{ route('admin.posts.index') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                        <i class="fas fa-list me-2"></i>
                        <span>إدارة المقالات</span>
                    </a>
                    <a href="{{ route('admin.portfolio.index') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                        <i class="fas fa-briefcase me-2"></i>
                        <span>إدارة المشاريع</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="admin-card admin-fade-in admin-fade-in-4 mt-4">
            <div class="admin-card-header">
                <h2 class="admin-card-title">معلومات النظام</h2>
            </div>
            <div class="admin-card-body">
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>إصدار PHP</span>
                        <span class="badge bg-primary rounded-pill">{{ phpversion() }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>إصدار Laravel</span>
                        <span class="badge bg-primary rounded-pill">{{ app()->version() }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>وقت الخادم</span>
                        <span class="badge bg-info rounded-pill">{{ date('Y-m-d H:i:s') }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // مساحة لإضافة سكربتات خاصة بلوحة التحكم
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Admin dashboard loaded!');
    });
</script>
@endsection
