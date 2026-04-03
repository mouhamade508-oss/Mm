@extends('layouts.admin')

@section('page-title', '📦 إدارة الباقات')

@section('content')
<div class="px-4 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">📦 الباقات</h1>
            <p class="text-gray-600 mt-2">إدارة عروض الباقات والمنتجات المجمعة</p>
        </div>
        <a href="{{ route('admin.bundles.create') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-semibold transition duration-200">
            ➕ إضافة باقة جديدة
        </a>
    </div>

    <!-- Bundles Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800">قائمة الباقات</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الاسم</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">السعر الأصلي</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">سعر الباقة</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">التوفير</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">عدد المنتجات</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الحالة</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($bundles as $bundle)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $bundle->name }}</div>
                            <div class="text-sm text-gray-500">{{ Str::limit($bundle->description, 50) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($bundle->original_price, 0) }} ل.س</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-purple-600">{{ number_format($bundle->bundle_price, 0) }} ل.س</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600 font-semibold">{{ number_format($bundle->getSavings(), 0) }} ل.س</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $bundle->bundleProducts->count() }} منتج</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($bundle->is_active)
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">نشط</span>
                            @else
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">غير نشط</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2 space-x-reverse">
                                <a href="{{ route('admin.bundles.edit', $bundle) }}" class="text-indigo-600 hover:text-indigo-900">تعديل</a>
                                <form method="POST" action="{{ route('admin.bundles.destroy', $bundle) }}" class="inline-block" onsubmit="return confirm('هل أنت متأكد من حذف هذه الباقة؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">حذف</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                            <div class="text-lg font-medium">لا توجد باقات</div>
                            <p class="mt-2">ابدأ بإضافة باقة جديدة</p>
                            <a href="{{ route('admin.bundles.create') }}" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700">
                                إضافة أول باقة
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection