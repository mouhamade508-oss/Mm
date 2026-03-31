@extends('layouts.admin')

@section('title', 'إدارة الأخبار')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-newspaper text-primary me-2"></i>
                        إدارة الأخبار
                    </h1>
                    <p class="text-muted mb-0">إدارة أخبار الموقع والتحكم في عرضها</p>
                </div>
                <div class="d-flex gap-2 align-items-center">
                    <button id="themeToggle" class="btn btn-outline-dark btn-sm" title="تبديل الوضع">
                        <i class="fas fa-moon"></i>
                    </button>
                    <a href="{{ route('admin.news.create') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus me-2"></i>
                        إضافة خبر جديد
                    </a>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        إجمالي الأخبار
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total'] }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-newspaper fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        الأخبار النشطة
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['active'] }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        الأخبار المجدولة
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['scheduled'] }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        غير نشطة
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['inactive'] }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-pause-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-list me-2"></i>
                        قائمة الأخبار
                    </h6>
                    <div class="d-flex gap-2">
                        <input type="text" class="form-control form-control-sm" id="searchInput" placeholder="البحث في الأخبار...">
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown">
                                <i class="fas fa-filter me-1"></i>
                                فلترة
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#" onclick="filterNews('all')">الكل</a></li>
                                <li><a class="dropdown-item" href="#" onclick="filterNews('active')">النشطة</a></li>
                                <li><a class="dropdown-item" href="#" onclick="filterNews('inactive')">غير النشطة</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div id="newsGrid" class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-3">
                        @forelse($news as $item)
                            <div class="col news-card" data-status="{{ $item->is_active ? 'active' : 'inactive' }}">
                                <div class="card news-item-card h-100 border-0 shadow-sm">
                                    <div class="card-body p-3">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <span class="badge bg-secondary">#{{ $item->id }}</span>

                                            @if($item->is_active)
                                                <span class="badge bg-success">نشط</span>
                                            @else
                                                <span class="badge bg-secondary">غير نشط</span>
                                            @endif
                                        </div>

                                        <h5 class="card-title mb-1 text-truncate" title="{{ $item->title }}">
                                            {{ Str::limit($item->title, 50) }}
                                        </h5>

                                        <p class="card-text text-muted small mb-3" title="{{ $item->content }}">
                                            {{ Str::limit($item->content ?: 'لا يوجد محتوى', 90) }}
                                        </p>

                                        <div class="d-flex flex-wrap gap-2 mb-3">
                                            <span class="badge bg-info">ترتيب {{ $item->sort_order }}</span>
                                            @if($item->published_at)
                                                <span class="badge bg-light text-dark">
                                                    {{ $item->published_at->format('d/m/Y H:i') }}
                                                </span>
                                            @else
                                                <span class="badge bg-light text-dark">نشر فوري</span>
                                            @endif
                                        </div>

                                        @if($item->link)
                                            <a href="{{ $item->link }}" target="_blank" class="d-block mb-2 text-decoration-none"><i class="fas fa-link me-1"></i>{{ Str::limit($item->link, 40) }}</a>
                                        @endif

                                        <div class="btn-group w-100" role="group">
                                            <a href="{{ route('admin.news.edit', $item) }}" class="btn btn-sm btn-outline-primary w-50" title="تعديل">
                                                <i class="fas fa-edit"></i>
                                                <span class="d-none d-md-inline"> تعديل</span>
                                            </a>
                                            <form action="{{ route('admin.news.destroy', $item) }}" method="POST" class="w-50" onsubmit="return confirm('هل أنت متأكد من حذف هذا الخبر؟')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger w-100" title="حذف">
                                                    <i class="fas fa-trash"></i>
                                                    <span class="d-none d-md-inline"> حذف</span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="empty-state text-center py-5">
                                    <i class="fas fa-newspaper fa-4x text-muted mb-3"></i>
                                    <h5 class="text-muted">لا توجد أخبار حالياً</h5>
                                    <p class="text-muted mb-4">ابدأ بإضافة أول خبر لموقعك</p>
                                    <a href="{{ route('admin.news.create') }}" class="btn btn-primary btn-lg">
                                        <i class="fas fa-plus me-2"></i>
                                        إضافة أول خبر
                                    </a>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    @if($news->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $news->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
body {
    background: #ffffff !important;
}

.card {
    border: 0 !important;
    border-radius: 0.8rem !important;
    transition: transform 0.2s ease, box-shadow 0.2s ease !important;
}

.card:hover {
    transform: translateY(-2px) !important;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.14) !important;
}

.card-header {
    background: linear-gradient(90deg, #6c5ce7 0%, #00b894 100%) !important;
    color: #fff !important;
    border: 0 !important;
    border-top-left-radius: 0.8rem !important;
    border-top-right-radius: 0.8rem !important;
}

.card-header h6 {
    color: #fff !important;
}

.table {
    background: #ffffff !important;
    border-radius: 0.75rem !important;
    overflow: hidden !important;
}

.table thead th {
    border: 0 !important;
    background: #f7f7ff !important;
    color: #495057 !important;
    font-weight: 700 !important;
}

.table tbody tr:hover {
    background: rgba(58, 59, 69, 0.05) !important;
}

#searchInput {
    box-shadow: inset 0 1px 3px rgba(0,0,0,.1) !important;
}

.news-procard {
    background: #fff !important;
    border-radius: 0.8rem !important;
    transition: transform .2s ease !important;
}

.news-procard:hover {
    transform: translateY(-3px) !important;
}

.empty-state {
    padding: 2.5rem 0 !important;
    color: #6c757d !important;
}

.badge {
    font-size: 0.75rem !important;
    font-weight: 600 !important;
}

.news-item-card {
    border-radius: 1rem !important;
    overflow: hidden !important;
    transition: transform 0.2s ease, box-shadow 0.2s ease !important;
}

.news-item-card:hover {
    transform: translateY(-4px) !important;
    box-shadow: 0 0.8rem 1.4rem rgba(52, 58, 64, 0.2) !important;
}

.news-item-card .card-title {
    color: #343a40 !important;
}

.news-item-card .card-text {
    min-height: 70px !important;
}

.news-item-card a {
    color: #4e73df !important;
    font-size: 0.86rem !important;
}

.empty-state {
    padding: 3rem 0 !important;
    color: #6c757d !important;
    background: #ffffff !important;
    border-radius: 1rem !important;
}

.card-header {
    background: linear-gradient(90deg, #4e73df, #36b9cc) !important;
    color: #fff !important;
    border-bottom: none !important;
}

.card-header h6 {
    color: #fff !important;
}

#searchInput {
    box-shadow: inset 0 1px 3px rgba(0,0,0,.12) !important;
}

body {
    background: #ffffff !important;
}

.btn-group .btn {
    border-radius: 0.35rem !important;
}

/* Dark Mode Styles */
.dark-mode {
    background: #1a1a1a !important;
    color: #e9ecef !important;
}

.dark-mode .card {
    background: #2d3748 !important;
    color: #e9ecef !important;
    border-color: #4a5568 !important;
}

.dark-mode .card-header {
    background: linear-gradient(90deg, #2b6cb0, #3182ce) !important;
    color: #fff !important;
}

.dark-mode .news-item-card {
    background: #374151 !important;
    color: #e9ecef !important;
}

.dark-mode .news-item-card .card-title {
    color: #f7fafc !important;
}

.dark-mode .news-item-card .card-text {
    color: #cbd5e0 !important;
}

.dark-mode .badge {
    background: #4a5568 !important;
    color: #e9ecef !important;
}

.dark-mode .badge.bg-success {
    background: #38a169 !important;
}

.dark-mode .badge.bg-info {
    background: #3182ce !important;
}

.dark-mode .badge.bg-light {
    background: #4a5568 !important;
    color: #e9ecef !important;
}

.dark-mode .empty-state {
    background: #374151 !important;
    color: #cbd5e0 !important;
}

.dark-mode .form-control {
    background: #4a5568 !important;
    color: #e9ecef !important;
    border-color: #718096 !important;
}

.dark-mode .btn-outline-secondary {
    color: #e9ecef !important;
    border-color: #718096 !important;
}

.dark-mode .btn-outline-secondary:hover {
    background: #718096 !important;
    color: #1a1a1a !important;
}
</style>

<script>
// بحث وفلترة بطاقات
const searchInput = document.getElementById('searchInput');
if (searchInput) {
    searchInput.addEventListener('keyup', function() {
        const searchTerm = this.value.trim().toLowerCase();
        const cards = document.querySelectorAll('#newsGrid .news-card');

        cards.forEach(card => {
            const title = card.querySelector('.card-title')?.textContent.toLowerCase() || '';
            const shortText = card.querySelector('.card-text')?.textContent.toLowerCase() || '';

            card.style.display = (title.includes(searchTerm) || shortText.includes(searchTerm)) ? '' : 'none';
        });
    });
}

function filterNews(status) {
    const cards = document.querySelectorAll('#newsGrid .news-card');

    cards.forEach(card => {
        const rowStatus = card.getAttribute('data-status');

        if (status === 'all' || rowStatus === status) {
            card.style.display = '';
        } else {
            card.style.display = 'none';
        }
    });
}

// Dark Mode Toggle
const themeToggle = document.getElementById('themeToggle');
if (themeToggle) {
    themeToggle.addEventListener('click', function() {
        document.body.classList.toggle('dark-mode');
        const icon = this.querySelector('i');
        if (document.body.classList.contains('dark-mode')) {
            icon.className = 'fas fa-sun';
            localStorage.setItem('theme', 'dark');
        } else {
            icon.className = 'fas fa-moon';
            localStorage.setItem('theme', 'light');
        }
    });

    // Load saved theme - Default to light mode and force light mode initially
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark') {
        document.body.classList.add('dark-mode');
        themeToggle.querySelector('i').className = 'fas fa-sun';
    } else {
        // Force light mode by default
        document.body.classList.remove('dark-mode');
        themeToggle.querySelector('i').className = 'fas fa-moon';
        localStorage.setItem('theme', 'light');
    }

    // Force light mode on page load to ensure white background
    document.body.classList.remove('dark-mode');
    localStorage.setItem('theme', 'light');
    themeToggle.querySelector('i').className = 'fas fa-moon';
}
</script>
@endsection