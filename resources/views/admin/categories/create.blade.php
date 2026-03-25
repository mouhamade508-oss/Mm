@extends('layouts.admin')

@section('page-title', 'إضافة فئة جديدة')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('admin.categories.index') }}" class="text-blue-600 hover:text-blue-700 font-semibold flex items-center gap-1 mb-4">
                ← رجوع للفئات
            </a>
            <h1 class="text-4xl font-bold text-gray-900 mb-2">✨ إضافة فئة جديدة</h1>
            <p class="text-gray-600">قم بملء النموذج أدناه لإضافة فئة جديدة</p>
        </div>

        <!-- Errors Alert -->
        @if ($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                <p class="font-semibold text-red-800 mb-2">❌ حدثت أخطاء في النموذج:</p>
                <ul class="space-y-1">
                    @foreach ($errors->all() as $error)
                        <li class="text-red-700 text-sm">• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Card -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <form method="POST" action="{{ route('admin.categories.store') }}" class="p-8">
                @csrf

                <!-- Category Name -->
                <div class="mb-6">
                    <label for="name" class="flex items-center text-gray-700 font-bold mb-3 gap-2">
                        <span class="text-xl">📝</span> اسم الفئة <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required 
                           placeholder="مثال: إلكترونيات"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                    @error('name') 
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label for="description" class="flex items-center text-gray-700 font-bold mb-3 gap-2">
                        <span class="text-xl">📄</span> الوصف
                    </label>
                    <textarea id="description" name="description" rows="4" 
                              placeholder="اكتب وصف تفصيلي للفئة (اختياري)..."
                              class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">{{ old('description') }}</textarea>
                    @error('description') 
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Buttons -->
                <div class="flex gap-4 pt-6 border-t">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-3 px-6 rounded-lg transition transform hover:scale-105">
                        ✅ إضافة الفئة
                    </button>
                    <a href="{{ route('admin.categories.index') }}" class="flex-1 bg-gray-400 hover:bg-gray-500 text-white font-bold py-3 px-6 rounded-lg transition text-center">
                        ❌ إلغاء
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
