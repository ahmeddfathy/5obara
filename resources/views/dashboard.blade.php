@extends('layouts.admin')

@section('title', 'لوحة التحكم')

@section('styles')
<link href="{{ asset('assets/css/dashboard.css') }}" rel="stylesheet">
<style>
    .welcome-message {
        background: linear-gradient(120deg, #f8f9fa 0%, #e9ecef 100%);
        border-right: 4px solid var(--primary-color);
    }
    .welcome-message::before {
        display: none;
    }
    .card-header {
        background: rgba(79, 209, 197, 0.05);
    }
    .section-title {
        position: relative;
        margin-bottom: 1.5rem;
        font-weight: 700;
        display: inline-block;
        color: var(--dark-color);
    }
    .section-title:after {
        content: '';
        position: absolute;
        bottom: -8px;
        right: 0;
        width: 50%;
        height: 3px;
        background: linear-gradient(to right, var(--primary-color), transparent);
        border-radius: 3px;
    }
    .dashboard-container {
        margin-top: 1rem;
    }
    .badge-role {
        background-color: var(--primary-color);
        color: white;
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 0.8rem;
        margin-left: 5px;
    }
    .badge-permission {
        background-color: #63B3ED;
        color: white;
        padding: 3px 6px;
        border-radius: 4px;
        font-size: 0.75rem;
        margin: 2px;
        display: inline-block;
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    <div class="welcome-message animate-fadeInUp">
        <h3>مرحباً، {{ Auth::user()->name }} <span class="ms-2">👋</span></h3>
        <p class="mb-0">مرحباً بك في لوحة تحكم خبراء. يمكنك إدارة محتوى موقعك من هنا بسهولة.</p>
    </div>

    <h4 class="section-title">لوحة التحكم</h4>

    <div class="dashboard-container animate-fadeInUp delay-1">
        <div class="row">
            <div class="col-md-7">
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <h4 class="mb-0">روابط سريعة</h4>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            @can('manage content')
                            <div class="col-md-6">
                                <a href="{{ route('admin.posts.create') }}" class="list-group-item list-group-item-action">
                                    <i class="fas fa-plus-circle"></i>إضافة مقال جديد
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('admin.portfolio.create') }}" class="list-group-item list-group-item-action">
                                    <i class="fas fa-folder-plus"></i>إضافة مشروع جديد
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('admin.posts.index') }}" class="list-group-item list-group-item-action">
                                    <i class="fas fa-list"></i>إدارة المقالات
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('admin.portfolio.index') }}" class="list-group-item list-group-item-action">
                                    <i class="fas fa-briefcase"></i>إدارة المشاريع
                                </a>
                            </div>
                            @else
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    ليس لديك الصلاحيات الكافية لإدارة المحتوى.
                                </div>
                            </div>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <h4 class="mb-0">معلومات الصلاحيات</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <strong>الأدوار:</strong>
                            @foreach(Auth::user()->roles as $role)
                                <span class="badge-role">{{ $role->name }}</span>
                            @endforeach
                        </div>

                        <div>
                            <strong>الصلاحيات:</strong>
                            <div class="mt-2">
                                @foreach(Auth::user()->getAllPermissions() as $permission)
                                    <span class="badge-permission">{{ $permission->name }}</span>
                                @endforeach
                            </div>
                        </div>

                        @role('admin')
                        <div class="mt-3 alert alert-success">
                            <i class="fas fa-shield-alt me-2"></i>
                            لديك صلاحيات الإدارة الكاملة للنظام
                        </div>
                        @else
                        <div class="mt-3 alert alert-warning">
                            <i class="fas fa-user me-2"></i>
                            لديك صلاحيات محدودة في النظام
                        </div>
                        @endrole
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Dashboard loaded');
    });
</script>
@endsection
