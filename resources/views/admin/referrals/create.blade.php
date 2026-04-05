@extends('layouts.admin')

@section('title', 'إنشاء رابط إحالة')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h1 class="h3 mb-0 text-gray-800">إنشاء رابط إحالة جديد</h1>
        <p class="text-muted">أدخل اسم العميل أو الوصف ثم أنشئ الكود الذي سيتم مشاركته.</p>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.referrals.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>اسم الرابط / العميل</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>

                <div class="form-group">
                    <label>الكود (اختياري)</label>
                    <input type="text" name="code" class="form-control" value="{{ old('code') }}" placeholder="سيتم إنشاء كود تلقائياً إذا تُرك هذا الحقل فارغاً">
                </div>

                <div class="form-group">
                    <label>الوصف (اختياري)</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                </div>

                <div class="form-group form-check">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" id="is_active" value="1" class="form-check-input" checked>
                    <label for="is_active" class="form-check-label">نشط</label>
                </div>

                <button type="submit" class="btn btn-primary">إنشاء رابط الإحالة</button>
                <a href="{{ route('admin.referrals.index') }}" class="btn btn-secondary">إلغاء</a>
            </form>
        </div>
    </div>
</div>
@endsection
