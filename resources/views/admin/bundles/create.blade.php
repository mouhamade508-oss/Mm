@extends('layouts.admin')

@section('page-title', '📦 إضافة باقة جديدة')

@section('content')
<div class="px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">📦 إضافة باقة جديدة</h1>
        <p class="text-gray-600 mt-2">إنشاء باقة منتجات بتخفيض سعر</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <form method="POST" action="{{ route('admin.bundles.store') }}">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Bundle Name -->
                <div class="md:col-span-2">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">اسم الباقة</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">وصف الباقة</label>
                    <textarea name="description" id="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Original Price -->
                <div>
                    <label for="original_price" class="block text-sm font-medium text-gray-700 mb-2">السعر الأصلي الإجمالي</label>
                    <input type="number" name="original_price" id="original_price" step="0.01" value="{{ old('original_price') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                    @error('original_price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Bundle Price -->
                <div>
                    <label for="bundle_price" class="block text-sm font-medium text-gray-700 mb-2">سعر الباقة</label>
                    <input type="number" name="bundle_price" id="bundle_price" step="0.01" value="{{ old('bundle_price') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                    @error('bundle_price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Discount Percentage -->
                <div>
                    <label for="discount_percentage" class="block text-sm font-medium text-gray-700 mb-2">نسبة الخصم (%)</label>
                    <input type="number" name="discount_percentage" id="discount_percentage" min="0" max="100" step="0.01" value="{{ old('discount_percentage') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                    @error('discount_percentage')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Is Active -->
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                        <span class="mr-2 text-sm text-gray-700">الباقة نشطة</span>
                    </label>
                    @error('is_active')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Products Selection -->
            <div class="mt-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">اختيار المنتجات للباقة</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach(\App\Models\Product::all() as $product)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center space-x-3 space-x-reverse">
                            <input type="checkbox" name="products[{{ $product->id }}][selected]" value="1" id="product-{{ $product->id }}" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500 product-checkbox">
                            <label for="product-{{ $product->id }}" class="flex-1 cursor-pointer">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12">
                                        @if($product->image)
                                            <img class="h-12 w-12 rounded-lg object-cover" src="{{ $product->image_url }}" alt="{{ $product->name }}">
                                        @else
                                            <div class="h-12 w-12 rounded-lg bg-gray-300 flex items-center justify-center">📦</div>
                                        @endif
                                    </div>
                                    <div class="mr-3">
                                        <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                        <div class="text-sm text-gray-500">{{ number_format($product->price, 0) }} ل.س</div>
                                    </div>
                                </div>
                            </label>
                        </div>
                        <div class="mt-3 product-quantity" style="display: none;">
                            <label class="block text-sm font-medium text-gray-700 mb-1">الكمية</label>
                            <input type="number" name="products[{{ $product->id }}][quantity]" min="1" value="1" class="w-full px-2 py-1 border border-gray-300 rounded text-sm">
                        </div>
                    </div>
                    @endforeach
                </div>
                @error('products')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Buttons -->
            <div class="mt-8 flex justify-end space-x-3 space-x-reverse">
                <a href="{{ route('admin.bundles.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition duration-200">
                    إلغاء
                </a>
                <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition duration-200">
                    💾 حفظ الباقة
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Show/hide quantity input when product is selected
document.querySelectorAll('.product-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        const quantityDiv = this.closest('.border').querySelector('.product-quantity');
        if (this.checked) {
            quantityDiv.style.display = 'block';
        } else {
            quantityDiv.style.display = 'none';
        }
    });
});

// Auto-calculate discount percentage
document.getElementById('bundle_price').addEventListener('input', function() {
    const originalPrice = parseFloat(document.getElementById('original_price').value);
    const bundlePrice = parseFloat(this.value);
    if (originalPrice && bundlePrice) {
        const discount = ((originalPrice - bundlePrice) / originalPrice * 100).toFixed(2);
        document.getElementById('discount_percentage').value = discount;
    }
});
</script>
@endsection