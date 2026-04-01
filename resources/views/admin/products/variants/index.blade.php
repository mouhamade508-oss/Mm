@extends('layouts.admin')

@section('page-title', 'متغيرات المنتج: ' . $product->name)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">🎨 متغيرات المنتج: {{ $product->name }}</h1>
                    <p class="text-gray-600">إدارة المتغيرات والأصناف لهذا المنتج</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('admin.products.variants.create', $product) }}" class="w-full sm:w-auto bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition duration-200 transform hover:scale-105 flex items-center justify-center gap-2">
                        <span>➕</span> إضافة متغير جديد
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="w-full sm:w-auto bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition duration-200 transform hover:scale-105 flex items-center justify-center gap-2">
                        <span>⬅️</span> العودة للمنتجات
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif
        </div>

        <!-- Variants Grid -->
        @if($variants->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($variants as $variant)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
                        <!-- Variant Image -->
                        <div class="relative w-full h-48 bg-gradient-to-br from-gray-200 to-gray-300 overflow-hidden">
                            @if($variant->image)
                                <img src="{{ $variant->image_url }}" alt="{{ $variant->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <span class="text-5xl">🎨</span>
                                </div>
                            @endif
                            <!-- Badges -->
                            <div class="absolute top-4 right-4 flex flex-col gap-2">
                                @if($variant->stock > 0)
                                    <span class="bg-green-500 text-white px-3 py-1 rounded-full font-semibold text-sm">
                                        ✅ متاح
                                    </span>
                                @else
                                    <span class="bg-red-500 text-white px-3 py-1 rounded-full font-semibold text-sm">
                                        ❌ غير متاح
                                    </span>
                                @endif
                                @if($variant->is_digital)
                                    <span class="bg-blue-500 text-white px-3 py-1 rounded-full font-semibold text-sm">
                                        💻 رقمي
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Variant Details -->
                        <div class="p-5">
                            <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-2">{{ $variant->name }}</h3>

                            <div class="mb-4 space-y-2 text-sm text-gray-600">
                                <p><span class="font-semibold">💵 السعر:</span> <span class="text-lg font-bold text-blue-600">{{ number_format($variant->price, 0) }} ل.س</span></p>
                                <p><span class="font-semibold">📦 المخزون:</span>
                                    <span class="inline-block bg-slate-100 text-slate-700 px-3 py-1 rounded-full text-xs font-bold">
                                        {{ $variant->stock }} قطعة
                                    </span>
                                </p>
                            </div>

                            <!-- Actions -->
                            <div class="flex gap-2 pt-4 border-t">
                                <a href="{{ route('admin.products.variants.edit', [$product, $variant]) }}"
                                   class="flex-1 bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-white font-bold py-2 px-3 rounded-lg text-center text-sm transition">
                                    ✏️ تعديل
                                </a>
                                <form method="POST" action="{{ route('admin.products.variants.destroy', [$product, $variant]) }}"
                                      class="flex-1"
                                      onsubmit="return confirm('هل أنت متأكد من حذف هذا المتغير؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-bold py-2 px-3 rounded-lg text-sm transition">
                                        🗑️ حذف
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-lg shadow-lg p-12 text-center">
                <div class="mb-4">
                    <span class="text-6xl">🎨</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">لا توجد متغيرات</h3>
                <p class="text-gray-600 mb-6">ابدأ بإضافة متغير جديد لهذا المنتج</p>
                <a href="{{ route('admin.products.variants.create', $product) }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg inline-block">
                    ✨ إضافة أول متغير
                </a>
            </div>
        @endif
    </div>
</div>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection