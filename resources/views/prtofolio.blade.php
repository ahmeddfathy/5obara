@extends('layouts.main')

@section('title', 'سابقة الأعمال')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/portfolio.css') }}">
@endsection

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="hero-content">
            <h1>سابقة الأعمال</h1>
        </div>
    </div>
</section>

<!-- Portfolio Grid -->
<section class="portfolio-section">
    <div class="container">
        <div class="row g-4">
            <!-- Project 1 -->
            <div class="col-lg-4 col-md-6">
                <div class="portfolio-item">
                    <img src="{{ asset('assets/img/portfolio/project1.jpg') }}" alt="مشروع ورشة تصليح سيارات">
                    <div class="portfolio-overlay">
                        <h3>دراسة جدوى مشروع ورشة تصليح سيارات</h3>
                        <a href="{{ route('contact') }}" class="contact-btn">تواصل معنا</a>
                    </div>
                </div>
            </div>
            <!-- Project 2 -->
            <div class="col-lg-4 col-md-6">
                <div class="portfolio-item">
                    <img src="{{ asset('assets/img/portfolio/project2.jpg') }}" alt="مشروع مصنع مصابيح">
                    <div class="portfolio-overlay">
                        <h3>دراسة جدوى مشروع مصنع مصابيح Led</h3>
                        <a href="{{ route('contact') }}" class="contact-btn">تواصل معنا</a>
                    </div>
                </div>
            </div>
            <!-- Project 3 -->
            <div class="col-lg-4 col-md-6">
                <div class="portfolio-item">
                    <img src="{{ asset('assets/img/portfolio/project3.jpg') }}" alt="مشروع مصنع مظلات">
                    <div class="portfolio-overlay">
                        <h3>دراسة جدوى مشروع مصنع مظلات</h3>
                        <a href="{{ route('contact') }}" class="contact-btn">تواصل معنا</a>
                    </div>
                </div>
            </div>
            <!-- Project 4 -->
            <div class="col-lg-4 col-md-6">
                <div class="portfolio-item">
                    <img src="{{ asset('assets/img/portfolio/project4.jpg') }}" alt="مشروع مصنع الزي الموحد">
                    <div class="portfolio-overlay">
                        <h3>دراسة جدوى مشروع مصنع الزي الموحد</h3>
                        <a href="{{ route('contact') }}" class="contact-btn">تواصل معنا</a>
                    </div>
                </div>
            </div>
            <!-- Project 5 -->
            <div class="col-lg-4 col-md-6">
                <div class="portfolio-item">
                    <img src="{{ asset('assets/img/portfolio/project5.jpg') }}" alt="مشروع مصنع مياه معدنية">
                    <div class="portfolio-overlay">
                        <h3>دراسة جدوى مشروع مصنع مياه معدنية</h3>
                        <a href="{{ route('contact') }}" class="contact-btn">تواصل معنا</a>
                    </div>
                </div>
            </div>
            <!-- Project 6 -->
            <div class="col-lg-4 col-md-6">
                <div class="portfolio-item">
                    <img src="{{ asset('assets/img/portfolio/project6.jpg') }}" alt="مشروع مصنع فلاتر مياه">
                    <div class="portfolio-overlay">
                        <h3>دراسة جدوى مشروع مصنع فلاتر مياه</h3>
                        <a href="{{ route('contact') }}" class="contact-btn">تواصل معنا</a>
                    </div>
                </div>
            </div>
            <!-- Project 7 -->
            <div class="col-lg-4 col-md-6">
                <div class="portfolio-item">
                    <img src="{{ asset('assets/img/portfolio/project7.jpg') }}" alt="مشروع مصنع المواسير البلاستيكية">
                    <div class="portfolio-overlay">
                        <h3>دراسة جدوى مشروع مصنع المواسير البلاستيكية</h3>
                        <a href="{{ route('contact') }}" class="contact-btn">تواصل معنا</a>
                    </div>
                </div>
            </div>
            <!-- Project 8 -->
            <div class="col-lg-4 col-md-6">
                <div class="portfolio-item">
                    <img src="{{ asset('assets/img/portfolio/project8.jpg') }}" alt="مشروع مصنع انتر لوك">
                    <div class="portfolio-overlay">
                        <h3>دراسة جدوى مشروع مصنع انتر لوك</h3>
                        <a href="{{ route('contact') }}" class="contact-btn">تواصل معنا</a>
                    </div>
                </div>
            </div>
            <!-- Project 9 -->
            <div class="col-lg-4 col-md-6">
                <div class="portfolio-item">
                    <img src="{{ asset('assets/img/portfolio/project9.jpg') }}" alt="مشروع مصنع كرتون">
                    <div class="portfolio-overlay">
                        <h3>دراسة جدوى مشروع مصنع كرتون</h3>
                        <a href="{{ route('contact') }}" class="contact-btn">تواصل معنا</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="pagination-wrapper">
            <ul class="pagination">
                <li class="active"><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">5</a></li>
                <li><span>...</span></li>
                <li><a href="#">13</a></li>
                <li><a href="#">التالي</a></li>
            </ul>
        </div>
    </div>
</section>

<div class="chat-btns">
    <a href="https://wa.me/966569617288" class="chat-btn whatsapp">
        <i class="fab fa-whatsapp"></i>
    </a>
    <a href="#" class="chat-btn messenger">
        <i class="fab fa-facebook-messenger"></i>
    </a>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/portfolio.js') }}"></script>
@endsection