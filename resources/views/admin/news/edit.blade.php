@extends('layouts.admin')

@section('title', 'تعديل الخبر')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0" style="border-radius: 1rem;">
                <div class="card-header py-4" style="background: linear-gradient(90deg, #f39c12, #e74c3c); color: #fff; border: 0; border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">
                            <i class="fas fa-edit text-white me-2"></i>
                            تعديل الخبر: {{ Str::limit($news->title, 50) }}
                        </h3>
                        <button id="themeToggle" class="btn btn-outline-light btn-sm" title="تبديل الوضع">
                            <i class="fas fa-moon"></i>
                        </button>
                    </div>
                </div>

                <form action="{{ route('admin.news.update', $news) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <!-- Title -->
                            <div class="col-md-12">
                                <label for="title" class="form-label fw-bold">
                                    <i class="fas fa-heading text-primary me-2"></i>
                                    عنوان الخبر <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-lg @error('title') is-invalid @enderror"
                                       id="title" name="title" value="{{ old('title', $news->title) }}" required
                                       style="border-radius: 0.75rem; box-shadow: inset 0 1px 3px rgba(0,0,0,.1);">
                                <div class="form-text">العنوان الذي سيظهر في شريط الأخبار</div>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Content -->
                            <div class="col-md-12">
                                <label for="content" class="form-label fw-bold">
                                    <i class="fas fa-file-alt text-info me-2"></i>
                                    محتوى الخبر
                                </label>
                                <textarea class="form-control form-control-lg @error('content') is-invalid @enderror"
                                          id="content" name="content" rows="4"
                                          placeholder="اكتب تفاصيل الخبر هنا..."
                                          style="border-radius: 0.75rem; box-shadow: inset 0 1px 3px rgba(0,0,0,.1);">{{ old('content', $news->content) }}</textarea>
                                <div class="form-text">المحتوى التفصيلي للخبر (اختياري)</div>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Link -->
                            <div class="col-md-6">
                                <label for="link" class="form-label fw-bold">
                                    <i class="fas fa-link text-warning me-2"></i>
                                    رابط الخبر
                                </label>
                                <input type="url" class="form-control form-control-lg @error('link') is-invalid @enderror"
                                       id="link" name="link" value="{{ old('link', $news->link) }}"
                                       placeholder="https://example.com"
                                       style="border-radius: 0.75rem; box-shadow: inset 0 1px 3px rgba(0,0,0,.1);">
                                <div class="form-text">رابط اختياري للخبر (اتركه فارغاً إذا لم يكن هناك رابط)</div>
                                @error('link')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Sort Order -->
                            <div class="col-md-3">
                                <label for="sort_order" class="form-label fw-bold">
                                    <i class="fas fa-sort-numeric-up text-secondary me-2"></i>
                                    ترتيب العرض
                                </label>
                                <input type="number" class="form-control form-control-lg @error('sort_order') is-invalid @enderror"
                                       id="sort_order" name="sort_order" value="{{ old('sort_order', $news->sort_order) }}" min="0"
                                       style="border-radius: 0.75rem; box-shadow: inset 0 1px 3px rgba(0,0,0,.1);">
                                <div class="form-text">رقم أقل = أولوية أعلى في العرض</div>
                                @error('sort_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Published At -->
                            <div class="col-md-3">
                                <label for="published_at" class="form-label fw-bold">
                                    <i class="fas fa-calendar-alt text-success me-2"></i>
                                    تاريخ النشر
                                </label>
                                <input type="datetime-local" class="form-control form-control-lg @error('published_at') is-invalid @enderror"
                                       id="published_at" name="published_at"
                                       value="{{ old('published_at', $news->published_at ? $news->published_at->format('Y-m-d\TH:i') : '') }}"
                                       style="border-radius: 0.75rem; box-shadow: inset 0 1px 3px rgba(0,0,0,.1);">
                                <div class="form-text">اتركه فارغاً للنشر الفوري</div>
                                @error('published_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Is Active -->
                            <div class="col-md-12">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1"
                                           {{ old('is_active', $news->is_active) ? 'checked' : '' }}
                                           style="width: 3rem; height: 1.5rem;">
                                    <label class="form-check-label fw-bold ms-3" for="is_active">
                                        <i class="fas fa-toggle-on text-success me-2"></i>
                                        تفعيل الخبر
                                    </label>
                                </div>
                                <div class="form-text">الأخبار النشطة فقط تظهر للزوار</div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer p-4 bg-light border-0" style="border-bottom-left-radius: 1rem; border-bottom-right-radius: 1rem;">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.news.index') }}" class="btn btn-outline-secondary btn-lg px-4">
                                <i class="fas fa-arrow-left me-2"></i>
                                العودة للقائمة
                            </a>
                            <button type="submit" class="btn btn-warning btn-lg px-4">
                                <i class="fas fa-save me-2"></i>
                                تحديث الخبر
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
body {
    background: #ffffff !important;
}

.card {
    transition: transform 0.2s ease, box-shadow 0.2s ease !important;
}

.card:hover {
    transform: translateY(-2px) !important;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.14) !important;
}

.form-control:focus {
    border-color: #f39c12 !important;
    box-shadow: 0 0 0 0.2rem rgba(243, 156, 18, 0.25) !important;
}

.form-switch .form-check-input:checked {
    background-color: #28a745 !important;
    border-color: #28a745 !important;
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
    background: linear-gradient(90deg, #d69e2e, #c53030) !important;
    color: #fff !important;
}

.dark-mode .form-control {
    background: #4a5568 !important;
    color: #e9ecef !important;
    border-color: #718096 !important;
}

.dark-mode .form-label {
    color: #e9ecef !important;
}

.dark-mode .form-text {
    color: #cbd5e0 !important;
}

.dark-mode .btn-outline-secondary {
    color: #e9ecef !important;
    border-color: #718096 !important;
}

.dark-mode .btn-outline-secondary:hover {
    background: #718096 !important;
    color: #1a1a1a !important;
}

.dark-mode .card-footer {
    background: #374151 !important;
    border-color: #4a5568 !important;
}
</style>

<script>
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