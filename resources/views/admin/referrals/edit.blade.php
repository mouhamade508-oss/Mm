@extends('layouts.admin')

@section('title', 'تعديل رابط إحالة')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h1 class="h3 mb-0 text-gray-800">تعديل رابط إحالة</h1>
        <p class="text-muted">يمكنك تعديل البيانات أو تعطيل الرابط إذا لم يعد مستخدماً.</p>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.referrals.update', $referral) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>اسم الرابط / العميل</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $referral->name) }}" required>
                </div>

                <div class="form-group">
                    <label>الكود</label>
                    <input type="text" name="code" class="form-control" value="{{ old('code', $referral->code) }}" required>
                </div>

                <div class="form-group">
                    <label>الوصف (اختياري)</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $referral->description) }}</textarea>
                </div>

                <div class="form-group form-check">                    <input type="hidden" name="is_active" value="0">                    <input type="checkbox" name="is_active" id="is_active" value="1" class="form-check-input" {{ old('is_active', $referral->is_active) ? 'checked' : '' }}>
                    <label for="is_active" class="form-check-label">نشط</label>
                </div>

                <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                <a href="{{ route('admin.referrals.index') }}" class="btn btn-secondary">إلغاء</a>
            </form>
        </div>
    </div>
</div>
@endsection
