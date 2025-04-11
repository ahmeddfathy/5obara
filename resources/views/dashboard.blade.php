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
        <div class="card shadow-sm">
            <div class="card-header">
                <h4 class="mb-0">روابط سريعة</h4>
            </div>
            <div class="card-body">
                <div class="row g-3">
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
