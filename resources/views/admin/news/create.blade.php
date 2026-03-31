@extends('layouts.admin')

@section('title', 'إضافة خبر جديد')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-plus text-success me-2"></i>
                        إضافة خبر جديد
                    </h3>
                </div>

                <form action="{{ route('admin.news.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <!-- Title -->
                            <div class="col-md-12 mb-3">
                                <label for="title" class="form-label">
                                    <i class="fas fa-heading text-primary me-1"></i>
                                    عنوان الخبر <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                       id="title" name="title" value="{{ old('title') }}" required>
                                <div class="form-text">العنوان الذي سيظهر في شريط الأخبار</div>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Content -->
                            <div class="col-md-12 mb-3">
                                <label for="content" class="form-label">
                                    <i class="fas fa-file-alt text-info me-1"></i>
                                    محتوى الخبر
                                </label>
                                <textarea class="form-control @error('content') is-invalid @enderror"
                                          id="content" name="content" rows="3"
                                          placeholder="اكتب تفاصيل الخبر هنا...">{{ old('content') }}</textarea>
                                <div class="form-text">المحتوى التفصيلي للخبر (اختياري)</div>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Link -->
                            <div class="col-md-6 mb-3">
                                <label for="link" class="form-label">
                                    <i class="fas fa-link text-warning me-1"></i>
                                    رابط الخبر
                                </label>
                                <input type="url" class="form-control @error('link') is-invalid @enderror"
                                       id="link" name="link" value="{{ old('link') }}"
                                       placeholder="https://example.com">
                                <div class="form-text">رابط اختياري للخبر (اتركه فارغاً إذا لم يكن هناك رابط)</div>
                                @error('link')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Sort Order -->
                            <div class="col-md-3 mb-3">
                                <label for="sort_order" class="form-label">
                                    <i class="fas fa-sort-numeric-up text-secondary me-1"></i>
                                    ترتيب العرض
                                </label>
                                <input type="number" class="form-control @error('sort_order') is-invalid @enderror"
                                       id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
                                <div class="form-text">رقم أقل = أولوية أعلى في العرض</div>
                                @error('sort_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Published At -->
                            <div class="col-md-3 mb-3">
                                <label for="published_at" class="form-label">
                                    <i class="fas fa-calendar-alt text-success me-1"></i>
                                    تاريخ النشر
                                </label>
                                <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror"
                                       id="published_at" name="published_at" value="{{ old('published_at') }}">
                                <div class="form-text">اتركه فارغاً للنشر الفوري</div>
                                @error('published_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Is Active -->
                            <div class="col-md-12 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                                           {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        <i class="fas fa-toggle-on text-success me-1"></i>
                                        تفعيل الخبر
                                    </label>
                                </div>
                                <div class="form-text">الأخبار النشطة فقط تظهر للزوار</div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i>
                                العودة للقائمة
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-1"></i>
                                حفظ الخبر
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection