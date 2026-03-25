@extends('layouts.admin')

@section('page-title', 'إدارة أكواد الخصم')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">🎁 إدارة أكواد الخصم</h1>
                    <p class="text-gray-600">قم بإدارة جميع أكواد الخصم والعروض الخاصة</p>
                </div>
                <a href="{{ route('admin.discounts.create') }}" class="w-full sm:w-auto bg-gradient-to-r from-orange-600 to-orange-700 hover:from-orange-700 hover:to-orange-800 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition duration-200 transform hover:scale-105 flex items-center justify-center gap-2">
                    <span>✨</span> إضافة كود خصم جديد
                </a>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                <div class="bg-white rounded-lg shadow p-6 border-t-4 border-orange-600">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-600 text-sm mb-1">إجمالي الأكواد</p>
                            <p class="text-3xl font-bold text-orange-600">{{ $discounts->total() }}</p>
                        </div>
                        <span class="text-3xl">🎁</span>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6 border-t-4 border-green-600">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-600 text-sm mb-1">أكواد نشطة</p>
                            <p class="text-3xl font-bold text-green-600">{{ \App\Models\Discount::where('is_active', true)->count() }}</p>
                        </div>
                        <span class="text-3xl">✅</span>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6 border-t-4 border-red-600">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-600 text-sm mb-1">أكواد معطلة</p>
                            <p class="text-3xl font-bold text-red-600">{{ \App\Models\Discount::where('is_active', false)->count() }}</p>
                        </div>
                        <span class="text-3xl">⛔</span>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6 border-t-4 border-purple-600">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-600 text-sm mb-1">أكواد عامة</p>
                            <p class="text-3xl font-bold text-purple-600">{{ \App\Models\Discount::where('type', 'general')->count() }}</p>
                        </div>
                        <span class="text-3xl">🌍</span>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6 border-t-4 border-blue-600">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-600 text-sm mb-1">متوسط الخصم</p>
                            <p class="text-3xl font-bold text-blue-600">{{ number_format(\App\Models\Discount::avg('percentage') ?? 0, 0) }}%</p>
                        </div>
                        <span class="text-3xl">📊</span>
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
            <form method="GET" action="{{ route('admin.discounts.index') }}" class="flex flex-col gap-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                    <input type="text" name="search" placeholder="🔍 ابحث عن كود..." value="{{ request('search') }}" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                    <select name="type" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                        <option value="">جميع الأنواع</option>
                        <option value="general" {{ request('type') === 'general' ? 'selected' : '' }}>عام</option>
                        <option value="specific" {{ request('type') === 'specific' ? 'selected' : '' }}>خاص</option>
                    </select>
                    <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                        <option value="">جميع الحالات</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>نشط</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>معطل</option>
                    </select>
                    <input type="number" name="min_discount" placeholder="أدنى خصم %" min="0" max="100" value="{{ request('min_discount') }}" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                    <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded-lg transition">
                        🔎 بحث
                    </button>
                </div>
            </form>
        </div>

        <!-- Discounts Grid -->
        @if($discounts->count())
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                @foreach($discounts as $discount)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
                        <!-- Header with Status -->
                        <div class="bg-gradient-to-r {{ $discount->is_active ? 'from-green-50 to-green-100' : 'from-red-50 to-red-100' }} p-6 border-b-2 {{ $discount->is_active ? 'border-green-300' : 'border-red-300' }}">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-2xl font-mono font-bold text-blue-600 mb-1">{{ $discount->code }}</h3>
                                    <p class="text-gray-600 text-sm">{{ $discount->type === 'general' ? '🌍 خصم عام' : '🎯 خصم خاص' }}</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    @if($discount->is_active)
                                        <span class="bg-green-500 text-white px-4 py-1 rounded-full font-bold text-sm">✅ نشط</span>
                                    @else
                                        <span class="bg-red-500 text-white px-4 py-1 rounded-full font-bold text-sm">⛔ معطل</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Discount Percentage -->
                            <div class="text-5xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-orange-500 to-orange-600">
                                {{ $discount->percentage }}%
                            </div>
                        </div>

                        <!-- Details Section -->
                        <div class="p-6 space-y-4">
                            <!-- Product Info -->
                            @if($discount->product)
                                <div class="flex items-center gap-3 pb-4 border-b">
                                    <span class="text-2xl">📦</span>
                                    <div>
                                        <p class="text-xs text-gray-500 font-semibold">المنتج</p>
                                        <p class="text-gray-800 font-semibold">{{ $discount->product->name }}</p>
                                    </div>
                                </div>
                            @endif

                            <!-- Usage Stats -->
                            <div class="grid grid-cols-2 gap-4 pb-4 border-b">
                                <div>
                                    <p class="text-xs text-gray-500 font-semibold mb-1">الاستخدام</p>
                                    <div class="flex items-baseline gap-1">
                                        <span class="text-2xl font-bold text-blue-600">{{ $discount->used_count }}</span>
                                        <span class="text-gray-600">/ {{ $discount->usage_limit }}</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-2 rounded-full" style="width: {{ min(($discount->used_count / $discount->usage_limit) * 100, 100) }}%"></div>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-semibold mb-1">المتبقي</p>
                                    <div class="flex items-baseline gap-1">
                                        <span class="text-2xl font-bold text-purple-600">{{ $discount->usage_limit - $discount->used_count }}</span>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-2">{{ number_format((($discount->usage_limit - $discount->used_count) / $discount->usage_limit) * 100, 0) }}% متبقي</p>
                                </div>
                            </div>

                            <!-- Dates -->
                            <div class="grid grid-cols-2 gap-4 pb-4 border-b text-sm">
                                <div>
                                    <p class="text-xs text-gray-500 font-semibold mb-1">📅 من</p>
                                    <p class="font-semibold text-gray-800">{{ $discount->valid_from->format('d/m/Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-semibold mb-1">📅 إلى</p>
                                    <p class="font-semibold text-gray-800">{{ $discount->valid_until->format('d/m/Y') }}</p>
                                </div>
                            </div>

                            <!-- Validity Status -->
                            <div class="text-sm mb-4">
                                @php
                                    $now = \Carbon\Carbon::now();
                                    $status = 'قيد الانتظار';
                                    $statusColor = 'gray';
                                    
                                    if ($now->lt($discount->valid_from)) {
                                        $status = '⏰ ينتظر البدء';
                                        $statusColor = 'yellow';
                                    } elseif ($now->between($discount->valid_from, $discount->valid_until)) {
                                        $status = '🎯 قيد الصلاحية';
                                        $statusColor = 'green';
                                    } else {
                                        $status = '⏱️ انتهت الصلاحية';
                                        $statusColor = 'red';
                                    }
                                @endphp
                                <p class="text-xs text-gray-500 font-semibold mb-1">حالة الصلاحية</p>
                                <span class="bg-{{ $statusColor }}-100 text-{{ $statusColor }}-800 px-3 py-1 rounded-full text-xs font-bold">
                                    {{ $status }}
                                </span>
                            </div>

                            <!-- Actions -->
                            <div class="flex gap-2 pt-4 border-t">
                                <a href="{{ route('admin.discounts.edit', $discount) }}" 
                                   class="flex-1 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-bold py-2 px-3 rounded-lg text-center text-sm transition">
                                    ✏️ تعديل
                                </a>
                                <form method="POST" action="{{ route('admin.discounts.destroy', $discount) }}" 
                                      class="flex-1"
                                      onsubmit="return confirm('هل أنت متأكد من حذف هذا الكود؟');">
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
                {{ $discounts->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-lg shadow-lg p-12 text-center">
                <div class="mb-4">
                    <span class="text-6xl">🎁</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">لا توجد أكواد خصم</h3>
                <p class="text-gray-600 mb-6">ابدأ بإنشاء كود خصم جديد للعملاء</p>
                <a href="{{ route('admin.discounts.create') }}" class="bg-orange-600 hover:bg-orange-700 text-white font-bold py-2 px-6 rounded-lg inline-block">
                    ✨ إنشاء أول كود
                </a>
            </div>
        @endif
    </div>
</div>

<style>
    .bg-gray-100 {
        @apply bg-gray-100;
    }
</style>
@endsection
