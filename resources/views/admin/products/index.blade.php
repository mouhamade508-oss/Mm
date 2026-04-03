@extends('layouts.admin')

@section('page-title', 'إدارة المنتجات')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">📦 إدارة المنتجات</h1>
                    <p class="text-gray-600">قم بإدارة جميع المنتجات في المتجر</p>
                </div>
                <a href="{{ route('admin.products.create') }}" class="w-full sm:w-auto bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition duration-200 transform hover:scale-105 flex items-center justify-center gap-2">
                    <span>✨</span> إضافة منتج جديد
                </a>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white rounded-lg shadow p-6 border-t-4 border-blue-600">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-600 text-sm mb-1">إجمالي المنتجات</p>
                            <p class="text-3xl font-bold text-blue-600">{{ $products->total() }}</p>
                        </div>
                        <span class="text-3xl">📦</span>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6 border-t-4 border-green-600">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-600 text-sm mb-1">المنتجات المتاحة</p>
                            <p class="text-3xl font-bold text-green-600">{{ \App\Models\Product::where('stock', '>', 0)->count() }}</p>
                        </div>
                        <span class="text-3xl">✅</span>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6 border-t-4 border-red-600">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-600 text-sm mb-1">المنتجات المنتهية</p>
                            <p class="text-3xl font-bold text-red-600">{{ \App\Models\Product::where('stock', '=', 0)->count() }}</p>
                        </div>
                        <span class="text-3xl">⚠️</span>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6 border-t-4 border-purple-600">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-600 text-sm mb-1">قيمة المخزون</p>
                            <p class="text-3xl font-bold text-purple-600">{{ number_format(\App\Models\Product::query()->select(\Illuminate\Support\Facades\DB::raw('SUM(price * stock) as total'))->first()->total ?? 0, 0) }} ل.س</p>
                        </div>
                        <span class="text-3xl">💰</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alerts -->
        @if ($message = Session::get('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg flex items-start gap-3">
                <span class="text-2xl">✅</span>
                <div>
                    <p class="font-semibold text-green-800">نجح</p>
                    <p class="text-green-700">{{ $message }}</p>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                <p class="font-semibold text-red-800 mb-2">❌ حدثت أخطاء:</p>
                @foreach ($errors->all() as $error)
                    <p class="text-red-700 text-sm">• {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- Search and Filter -->
        <div class="bg-white rounded-lg shadow p-4 mb-6">
            <form method="GET" action="{{ route('admin.products.index') }}" class="flex flex-col gap-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <input type="text" name="search" placeholder="🔍 ابحث عن منتج..." value="{{ request('search') }}" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <select name="category" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">جميع الفئات</option>
                        @foreach(\App\Models\Category::all() as $cat)
                            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    <select name="stock_status" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">جميع الحالات</option>
                        <option value="in_stock" {{ request('stock_status') === 'in_stock' ? 'selected' : '' }}>متاح</option>
                        <option value="out_of_stock" {{ request('stock_status') === 'out_of_stock' ? 'selected' : '' }}>غير متاح</option>
                    </select>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition">
                        🔎 بحث
                    </button>
                </div>
            </form>
        </div>

        <!-- Products Grid -->
        @if($products->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach($products as $product)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
                        <!-- Product Image -->
                        <div class="relative w-full h-48 bg-gradient-to-br from-gray-200 to-gray-300 overflow-hidden">
                            @if($product->image)
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <span class="text-5xl">📦</span>
                                </div>
                            @endif
                            <!-- Stock Badge -->
                            <div class="absolute top-4 right-4 flex flex-col gap-2">
                                @if($product->stock > 0)
                                    <span class="bg-green-500 text-white px-3 py-1 rounded-full font-semibold text-sm">
                                        ✅ متاح
                                    </span>
                                @else
                                    <span class="bg-red-500 text-white px-3 py-1 rounded-full font-semibold text-sm">
                                        ❌ غير متاح
                                    </span>
                                @endif
                                @if($product->is_digital)
                                    <span class="bg-blue-500 text-white px-3 py-1 rounded-full font-semibold text-sm">
                                        💻 رقمي
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Product Details -->
                        <div class="p-5">
                            <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-2">{{ $product->name }}</h3>
                            
                            <div class="mb-4 space-y-2 text-sm text-gray-600">
                                <p><span class="font-semibold">📂 الفئة:</span> {{ $product->category ? $product->category->name : 'بدون فئة' }}</p>
                                <p><span class="font-semibold">💵 السعر:</span> <span class="text-lg font-bold text-blue-600">{{ number_format($product->price, 0) }} {{ $product->currency == 'USD' ? '$' : 'ل.س' }}</span></p>
                                <p><span class="font-semibold">📦 المخزون:</span> 
                                    <span class="inline-block bg-slate-100 text-slate-700 px-3 py-1 rounded-full text-xs font-bold">
                                        {{ $product->stock }} قطعة
                                    </span>
                                </p>
                            </div>

                            <!-- Actions -->
                            <div class="flex gap-2 pt-4 border-t">
                                <a href="{{ route('admin.products.variants', $product) }}" 
                                   class="flex-1 bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white font-bold py-2 px-3 rounded-lg text-center text-sm transition">
                                    🎨 متغيرات
                                </a>
                                <a href="{{ route('admin.products.edit', $product) }}" 
                                   class="flex-1 bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-white font-bold py-2 px-3 rounded-lg text-center text-sm transition">
                                    ✏️ تعديل
                                </a>
                                <form method="POST" action="{{ route('admin.products.destroy', $product) }}" 
                                      class="flex-1"
                                      onsubmit="return confirm('هل أنت متأكد من حذف هذا المنتج؟');">
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

            <!-- Pagination -->
            <div class="flex justify-center">
                {{ $products->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-lg shadow-lg p-12 text-center">
                <div class="mb-4">
                    <span class="text-6xl">📦</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">لا توجد منتجات</h3>
                <p class="text-gray-600 mb-6">ابدأ بإضافة منتج جديد إلى المتجر</p>
                <a href="{{ route('admin.products.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg inline-block">
                    ✨ إضافة أول منتج
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
