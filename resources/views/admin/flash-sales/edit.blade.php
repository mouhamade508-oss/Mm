@extends('layouts.admin')

@section('page-title', '🔥 تعديل عرض الفلاش')

@section('content')
<div class="px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">🔥 تعديل عرض الفلاش</h1>
        <p class="text-gray-600 mt-2">تعديل عرض البيع المحدود الوقت</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <form method="POST" action="{{ route('admin.flash-sales.update', $flashSale) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Product Selection -->
                <div>
                    <label for="product_id" class="block text-sm font-medium text-gray-700 mb-2">المنتج</label>
                    <select name="product_id" id="product_id" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        <option value="">اختر المنتج</option>
                        @foreach(\App\Models\Product::all() as $product)
                        <option value="{{ $product->id }}" {{ old('product_id', $flashSale->product_id) == $product->id ? 'selected' : '' }}>
                            {{ $product->name }} - {{ number_format($product->price, 0) }} ل.س
                        </option>
                        @endforeach
                    </select>
                    @error('product_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Flash Sale Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">اسم العرض</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $flashSale->name) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">وصف العرض</label>
                    <textarea name="description" id="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">{{ old('description', $flashSale->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Original Price -->
                <div>
                    <label for="original_price" class="block text-sm font-medium text-gray-700 mb-2">السعر الأصلي</label>
                    <input type="number" name="original_price" id="original_price" step="0.01" value="{{ old('original_price', $flashSale->original_price) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                    @error('original_price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Sale Price -->
                <div>
                    <label for="sale_price" class="block text-sm font-medium text-gray-700 mb-2">سعر العرض</label>
                    <input type="number" name="sale_price" id="sale_price" step="0.01" value="{{ old('sale_price', $flashSale->sale_price) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                    @error('sale_price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Discount Percentage -->
                <div>
                    <label for="discount_percentage" class="block text-sm font-medium text-gray-700 mb-2">نسبة الخصم (%)</label>
                    <input type="number" name="discount_percentage" id="discount_percentage" min="0" max="100" value="{{ old('discount_percentage', $flashSale->discount_percentage) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                    @error('discount_percentage')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Start Date & Time -->
                <div>
                    <label for="start_at" class="block text-sm font-medium text-gray-700 mb-2">تاريخ ووقت البداية</label>
                    <input type="datetime-local" name="start_at" id="start_at" value="{{ old('start_at', $flashSale->start_at->format('Y-m-d\TH:i')) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                    @error('start_at')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- End Date & Time -->
                <div>
                    <label for="end_at" class="block text-sm font-medium text-gray-700 mb-2">تاريخ ووقت النهاية</label>
                    <input type="datetime-local" name="end_at" id="end_at" value="{{ old('end_at', $flashSale->end_at->format('Y-m-d\TH:i')) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                    @error('end_at')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Is Active -->
                <div class="md:col-span-2">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $flashSale->is_active) ? 'checked' : '' }} class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                        <span class="mr-2 text-sm text-gray-700">العرض نشط</span>
                    </label>
                    @error('is_active')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="mt-8 flex justify-end space-x-3 space-x-reverse">
                <a href="{{ route('admin.flash-sales.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition duration-200">
                    إلغاء
                </a>
                <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition duration-200">
                    💾 حفظ التغييرات
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Auto-calculate discount percentage
document.getElementById('sale_price').addEventListener('input', function() {
    const originalPrice = parseFloat(document.getElementById('original_price').value);
    const salePrice = parseFloat(this.value);
    if (originalPrice && salePrice) {
        const discount = ((originalPrice - salePrice) / originalPrice * 100).toFixed(2);
        document.getElementById('discount_percentage').value = discount;
    }
});
</script>
@endsection