@extends('layouts.admin')

@section('page-title', 'إنشاء كود خصم جديد')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('admin.discounts.index') }}" class="text-orange-600 hover:text-orange-700 font-semibold flex items-center gap-1 mb-4">
                ← رجوع إلى أكواد الخصم
            </a>
            <h1 class="text-4xl font-bold text-gray-900 mb-2">✨ إنشاء كود خصم جديد</h1>
            <p class="text-gray-600">قم بملء النموذج أدناه لإضافة كود خصم جديد</p>
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
        <form method="POST" action="{{ route('admin.discounts.store') }}" class="bg-white rounded-lg shadow-lg overflow-hidden p-8 space-y-8">
            @csrf

            <!-- Section 1: Discount Code -->
            <div class="pb-8 border-b">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <span class="text-3xl">🎁</span> معلومات الكود
                </h2>

                <!-- Code -->
                <div class="mb-6">
                    <label for="code" class="flex items-center text-gray-700 font-bold mb-3 gap-2">
                        <span class="text-xl">📝</span> كود الخصم <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="code" name="code" value="{{ old('code') }}" required 
                           placeholder="مثال: SUMMER2024"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg font-mono text-lg focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition uppercase">
                    <p class="text-gray-500 text-sm mt-2">💡 سيتم تحويل الكود إلى أحرف كبيرة تلقائياً</p>
                    @error('code')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label for="description" class="flex items-center text-gray-700 font-bold mb-3 gap-2">
                        <span class="text-xl">📄</span> الوصف
                    </label>
                    <textarea id="description" name="description" rows="3"
                              placeholder="وصف الكود (اختياري) - مثال: خصم صيفي 20% على المنتجات المختارة"
                              class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Section 2: Discount Details -->
            <div class="pb-8 border-b">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <span class="text-3xl">💰</span> تفاصيل الخصم
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Percentage -->
                    <div>
                        <label for="percentage" class="flex items-center text-gray-700 font-bold mb-3 gap-2">
                            <span class="text-xl">📊</span> نسبة الخصم <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="number" id="percentage" name="percentage" value="{{ old('percentage') }}" required 
                                   step="0.01" min="0.01" max="100"
                                   placeholder="20"
                                   class="w-full px-4 py-3 pr-10 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition font-bold text-2xl text-orange-600">
                            <span class="absolute left-4 top-3 text-2xl font-bold text-orange-600">%</span>
                        </div>
                        <div class="mt-2 p-3 bg-orange-50 rounded-lg">
                            <p class="text-sm text-orange-800"><strong>معاينة:</strong> <span id="preview-discount">0</span>% خصم</p>
                        </div>
                        @error('percentage')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Type -->
                    <div>
                        <label for="discount_type" class="flex items-center text-gray-700 font-bold mb-3 gap-2">
                            <span class="text-xl">🎯</span> نوع الخصم <span class="text-red-500">*</span>
                        </label>
                        <select id="discount_type" name="type" required 
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition">
                            <option value="">-- اختر نوع الخصم --</option>
                            <option value="general" {{ old('type') === 'general' ? 'selected' : '' }}>🌍 عام (جميع المنتجات)</option>
                            <option value="specific" {{ old('type') === 'specific' ? 'selected' : '' }}>🎯 خاص (منتج معين)</option>
                        </select>
                        @error('type')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Product Selection (Specific Type) -->
                <div id="product_field" class="mt-6 hidden">
                    <label for="product_id" class="flex items-center text-gray-700 font-bold mb-3 gap-2">
                        <span class="text-xl">📦</span> اختر المنتج <span class="text-red-500">*</span>
                    </label>
                    <select id="product_id" name="product_id"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition">
                        <option value="">-- اختر المنتج --</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                {{ $product->name }} ({{ number_format($product->price, 0) }} ل.س)
                            </option>
                        @endforeach
                    </select>
                    @error('product_id')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Section 3: Validity Period -->
            <div class="pb-8 border-b">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <span class="text-3xl">📅</span> فترة الصلاحية
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Valid From -->
                    <div>
                        <label for="valid_from" class="flex items-center text-gray-700 font-bold mb-3 gap-2">
                            <span class="text-xl">📅</span> تاريخ البداية <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="valid_from" name="valid_from" value="{{ old('valid_from') }}" required 
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition">
                        @error('valid_from')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Valid Until -->
                    <div>
                        <label for="valid_until" class="flex items-center text-gray-700 font-bold mb-3 gap-2">
                            <span class="text-xl">📅</span> تاريخ الانتهاء <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="valid_until" name="valid_until" value="{{ old('valid_until') }}" required 
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition">
                        @error('valid_until')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Section 4: Usage Limits -->
            <div class="pb-8 border-b">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <span class="text-3xl">⚙️</span> حدود الاستخدام
                </h2>

                <div>
                    <label for="usage_limit" class="flex items-center text-gray-700 font-bold mb-3 gap-2">
                        <span class="text-xl">📊</span> عدد مرات الاستخدام المسموحة <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="usage_limit" name="usage_limit" value="{{ old('usage_limit', 100) }}" required 
                           min="1"
                           placeholder="100"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition">
                    <p class="text-gray-500 text-sm mt-2">💡 عدد المرات التي يمكن استخدام الكود من قبل العملاء</p>
                    @error('usage_limit')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Section 5: Status -->
            <div class="pb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <span class="text-3xl">✅</span> الحالة
                </h2>

                <div class="flex items-center gap-3 p-4 bg-green-50 rounded-lg border-2 border-green-200">
                    <input type="checkbox" id="is_active" name="is_active" value="1" 
                           {{ old('is_active', true) ? 'checked' : '' }} class="w-5 h-5 rounded border-gray-300 cursor-pointer">
                    <label for="is_active" class="flex-1 cursor-pointer">
                        <p class="font-bold text-gray-900">تنشيط الكود</p>
                        <p class="text-gray-600 text-sm">الكود النشط يمكن للعملاء استخدامه مباشرة</p>
                    </label>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-4 pt-6 border-t">
                <button type="submit" class="flex-1 bg-gradient-to-r from-orange-600 to-orange-700 hover:from-orange-700 hover:to-orange-800 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition transform hover:scale-105">
                    ✅ إنشاء الكود
                </button>
                <a href="{{ route('admin.discounts.index') }}" class="flex-1 bg-gradient-to-r from-gray-400 to-gray-500 hover:from-gray-500 hover:to-gray-600 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition text-center">
                    ❌ إلغاء
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    const typeSelect = document.getElementById('discount_type');
    const productField = document.getElementById('product_field');
    const percentageInput = document.getElementById('percentage');
    const previewDiscount = document.getElementById('preview-discount');

    // Show/hide product field based on type
    function toggleProductField() {
        if (typeSelect.value === 'specific') {
            productField.classList.remove('hidden');
        } else {
            productField.classList.add('hidden');
        }
    }

    typeSelect.addEventListener('change', toggleProductField);

    // Update discount preview
    percentageInput.addEventListener('input', function() {
        previewDiscount.textContent = this.value || '0';
    });

    // Show product field on page load if needed
    toggleProductField();

    // Update preview on initial load
    previewDiscount.textContent = percentageInput.value || '0';
</script>

<style>
    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>
@endsection
