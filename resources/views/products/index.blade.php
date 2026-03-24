@extends('layouts.app')

@section('content')

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Hero Section -->
        <div class="text-center mb-12">
            <h1 class="text-5xl md:text-6xl font-bold bg-gradient-to-r from-blue-600 via-blue-500 to-indigo-600 bg-clip-text text-transparent mb-6">
                MHD Print Lab
            </h1>
            <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
                اكتشف مجموعتنا الواسعة من المنتجات عالية الجودة بأسعار تنافسية. اطلب الآن عبر واتساب!
            </p>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-3xl shadow-xl p-8 mb-12">
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <!-- Search -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">البحث</label>
                    <form method="GET" action="{{ route('products.index') }}" class="flex">
                        <input type="text" name="search" value="{{ request('search') }}" 
                               class="flex-1 px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                               placeholder="اسم المنتج...">
                        <button type="submit" class="ml-2 px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white rounded-xl font-medium transition-all">
                            بحث
                        </button>
                    </form>
                </div>

                <!-- Category Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">الفئة</label>
                    <select name="category" onchange="this.form.submit()" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">جميع الفئات</option>
                        <option value="إلكترونيات" {{ request('category') == 'إلكترونيات' ? 'selected' : '' }}>إلكترونيات</option>
                        <option value="ملابس" {{ request('category') == 'ملابس' ? 'selected' : '' }}>ملابس</option>
                        <option value="إكسسوارات" {{ request('category') == 'إكسسوارات' ? 'selected' : '' }}>إكسسوارات</option>
                        <option value="طابعات" {{ request('category') == 'طابعات' ? 'selected' : '' }}>طابعات</option>
                    </select>
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <input type="hidden" name="min_price" value="{{ request('min_price') }}">
                    <input type="hidden" name="max_price" value="{{ request('max_price') }}">
                </div>

                <!-- Price Range -->
                <div class="md:col-span-2 lg:col-span-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">السعر</label>
                    <div class="flex space-x-2 space-x-reverse">
                        <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="الحد الأدنى" 
                               class="flex-1 px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500">
                        <span>-</span>
                        <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="الحد الأقصى" 
                               class="flex-1 px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500">
                        <button onclick="this.form.submit()" class="px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white rounded-xl font-medium transition-all whitespace-nowrap">
                            فلتر
                        </button>
                    </div>
                    <form hidden></form>
                </div>
            </div>

            <!-- Filter Summary -->
            @if(request('search') || request('category') || request('min_price') || request('max_price'))
            <div class="mt-6 pt-6 border-t border-gray-200 flex flex-wrap gap-4">
                <span class="bg-blue-100 text-blue-800 px-4 py-2 rounded-full text-sm">مفلتر: 
                    @if(request('search')){{ request('search') }} @endif
                    @if(request('category')){{ request('category') }} @endif
                    @if(request('min_price')){{ request('min_price') }} - @endif
                    @if(request('max_price')){{ request('max_price') }} @endif
                </span>
                <a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium underline">إزالة الفلاتر</a>
            </div>
            @endif
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @forelse($products as $product)
                <div class="group bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 overflow-hidden border border-gray-100 hover:border-blue-200">
                    <!-- Product Image -->
                    <div class="h-64 bg-gradient-to-br from-blue-50 to-indigo-50 flex items-center justify-center overflow-hidden relative">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="w-24 h-24 bg-gradient-to-br from-gray-300 to-gray-400 rounded-2xl flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Product Info -->
                    <div class="p-8">
                        <h3 class="font-bold text-xl mb-2 leading-tight line-clamp-2 group-hover:text-blue-600 transition-colors">{{ $product->name }}</h3>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-3 leading-relaxed">{{ $product->description }}</p>
                        
                        <!-- Price & WhatsApp -->
                        <div class="flex items-center justify-between mb-6">
                            <div class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                                {{ number_format($product->price, 2) }} ر.س
                            </div>
                            <div class="flex items-center space-x-2 space-x-reverse">
                                <span class="text-sm text-gray-500 font-medium">المخزون: {{ $product->stock }}</span>
                            </div>
                        </div>

                        <!-- WhatsApp Button -->
                        <a href="https://wa.me/963982617848?text=مرحبا، أريد طلب: {{ urlencode($product->name) }} - السعر: {{ $product->price }} ر.س - {{ urlencode($product->description) }}" 
                           class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-4 px-6 rounded-2xl text-lg flex items-center justify-center space-x-3 space-x-reverse transition-all hover:scale-105 shadow-xl hover:shadow-2xl transform"
                           target="_blank" rel="noopener">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.446l-.232-.139-3.578-.503-1.043-.12-.005-.005-.002-.001-.001-.001l-.001-.001-.001-.001-.001-.001l-.001-.001-.001-.001-.001-.001l-.001-.001l-.001-.001l-.001-.001l-.001-.001l-.001-.001l-.001-.001l-.001-.001l-.001-.001l-.001-.001l-.001-.001l-.001-.001l-.001-.001l-.001-.001l-.001-.001l-.001-.001l-.001-.001l Providers/AppServiceProvider.php
                            </svg>
                            <span>اطلب عبر واتساب</span>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-24">
                    <div class="w-32 h-32 mx-auto mb-8 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-3xl flex items-center justify-center">
                        <svg class="w-16 h-16 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">لا توجد منتجات</h3>
                    <p class="text-lg text-gray-600 mb-8">لم نجد منتجات تطابق شروط البحث الخاصة بك</p>
                    <a href="{{ route('products.index') }}" class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-8 py-4 rounded-2xl font-bold text-lg shadow-xl hover:shadow-2xl transition-all">
                        عرض جميع المنتجات
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="flex justify-center mt-16">
            {{ $products->appends(request()->query())->links() }}
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto-submit filters
    document.querySelectorAll('select[name="category"], input[name="min_price"], input[name="max_price"]').forEach(el => {
        el.addEventListener('change', function() {
            this.form.submit();
        });
    });
</script>
@endpush>

