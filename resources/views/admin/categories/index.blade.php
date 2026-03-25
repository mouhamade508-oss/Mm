@extends('layouts.admin')

@section('page-title', 'إدارة الفئات')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">📂 إدارة الفئات</h1>
                    <p class="text-gray-600">قم بإدارة فئات المنتجات</p>
                </div>
                <a href="{{ route('admin.categories.create') }}" class="w-full sm:w-auto bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition duration-200 transform hover:scale-105 flex items-center justify-center gap-2">
                    <span>✨</span> إضافة فئة جديدة
                </a>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-white rounded-lg shadow p-6 border-t-4 border-blue-600">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-600 text-sm mb-1">إجمالي الفئات</p>
                            <p class="text-3xl font-bold text-blue-600">{{ $categories->total() }}</p>
                        </div>
                        <span class="text-3xl">📂</span>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6 border-t-4 border-purple-600">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-600 text-sm mb-1">الفئات النشطة</p>
                            <p class="text-3xl font-bold text-purple-600">{{ \App\Models\Category::withCount('products')->having('products_count', '>', 0)->count() }}</p>
                        </div>
                        <span class="text-3xl">✅</span>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6 border-t-4 border-green-600">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-600 text-sm mb-1">إجمالي المنتجات</p>
                            <p class="text-3xl font-bold text-green-600">{{ \App\Models\Product::count() }}</p>
                        </div>
                        <span class="text-3xl">🛍️</span>
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

        @if ($message = Session::get('error'))
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg flex items-start gap-3">
                <span class="text-2xl">❌</span>
                <div>
                    <p class="font-semibold text-red-800">خطأ</p>
                    <p class="text-red-700">{{ $message }}</p>
                </div>
            </div>
        @endif

        <!-- Categories Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            @if($categories->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gradient-to-r from-blue-600 to-blue-700 text-white">
                            <tr>
                                <th class="px-6 py-4 text-right font-bold">الفئة</th>
                                <th class="px-6 py-4 text-right font-bold">الوصف</th>
                                <th class="px-6 py-4 text-center font-bold">عدد المنتجات</th>
                                <th class="px-6 py-4 text-center font-bold">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($categories as $category)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-gray-900">{{ $category->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $category->slug }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600 max-w-xs truncate">
                                        {{ $category->description ?? '—' }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center justify-center bg-blue-100 text-blue-800 px-3 py-1 rounded-full font-semibold">
                                            {{ $category->products_count }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center space-x-2">
                                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded transition">
                                            ✏️ تعديل
                                        </a>
                                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('هل أنت متأكد؟');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded transition">
                                                🗑️ حذف
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $categories->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <div class="text-6xl mb-4">📂</div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">لا توجد فئات</h2>
                    <p class="text-gray-600 mb-6">ابدأ بإضافة فئة جديدة لتنظيم منتجاتك</p>
                    <a href="{{ route('admin.categories.create') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg transition">
                        إضافة الفئة الأولى
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
