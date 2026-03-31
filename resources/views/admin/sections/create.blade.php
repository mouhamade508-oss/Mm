@extends('layouts.admin')

@section('content')
<div class="container" style="max-width: 600px;">
    <h1 style="font-size: 2rem; font-weight: bold; margin-bottom: 2rem;">إنشاء قسم جديد</h1>

    <form action="{{ route('admin.sections.store') }}" method="POST" style="background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); padding: 2rem;">
        @csrf

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-weight: bold; margin-bottom: 0.5rem;">اسم القسم *</label>
            <input type="text" name="name" value="{{ old('name') }}" required style="width: 100%; padding: 0.75rem; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 1rem;" placeholder="مثال: الاجهزة والالكترونيات">
            @error('name') <span style="color: #ef4444;">{{ $message }}</span> @enderror
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-weight: bold; margin-bottom: 0.5rem;">Slug *</label>
            <input type="text" name="slug" value="{{ old('slug') }}" required style="width: 100%; padding: 0.75rem; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 1rem;" placeholder="مثال: electronics-devices">
            <small style="color: #666;">الـ URL الصديق للمحركات</small>
            @error('slug') <span style="color: #ef4444;">{{ $message }}</span> @enderror
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-weight: bold; margin-bottom: 0.5rem;">الوصف</label>
            <textarea name="description" style="width: 100%; padding: 0.75rem; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 1rem; min-height: 100px;" placeholder="وصف القسم">{{ old('description') }}</textarea>
            @error('description') <span style="color: #ef4444;">{{ $message }}</span> @enderror
        </div>

        <div style="margin-bottom: 2rem;">
            <label style="display: block; font-weight: bold; margin-bottom: 0.5rem;">الأيقونة (Emoji)</label>
            <input type="text" name="icon" value="{{ old('icon') }}" style="width: 100%; padding: 0.75rem; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 1rem;" placeholder="مثال: ⚡ أو 📱">
            @error('icon') <span style="color: #ef4444;">{{ $message }}</span> @enderror
        </div>

        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn" style="background: #3b82f6; color: white; padding: 0.75rem 2rem; border-radius: 6px; border: none; cursor: pointer; font-weight: bold;">إنشاء القسم</button>
            <a href="{{ route('admin.sections.index') }}" class="btn" style="background: #e5e7eb; color: #333; padding: 0.75rem 2rem; border-radius: 6px; text-decoration: none; font-weight: bold;">إلغاء</a>
        </div>
    </form>
</div>
@endsection
