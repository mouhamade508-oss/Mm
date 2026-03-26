@extends('layouts.admin')

@section('page-title', 'تعديل المتغير')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">✏️ تعديل المتغير</h1>
                    <p class="text-gray-600">{{ $variant->name }}</p>
                </div>
                <a href="{{ route('admin.products.variants', $product) }}" class="w-full sm:w-auto bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition duration-200 transform hover:scale-105 flex items-center justify-center gap-2">
                    <span>⬅️</span> العودة
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow-lg p-8">
            <form action="{{ route('admin.products.variants.update', [$product, $variant]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">اسم المتغير *</label>
                        <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror" id="name" name="name" value="{{ old('name', $variant->name) }}" required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Price -->
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-2">السعر *</label>
                        <input type="number" step="0.01" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('price') border-red-500 @enderror" id="price" name="price" value="{{ old('price', $variant->price) }}" required>
                        @error('price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Stock -->
                    <div>
                        <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">المخزون *</label>
                        <input type="number" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('stock') border-red-500 @enderror" id="stock" name="stock" value="{{ old('stock', $variant->stock) }}" required>
                        @error('stock')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Image -->
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-2">الصورة</label>
                        <input type="file" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('image') border-red-500 @enderror" id="image" name="image" accept="image/*">
                        @if($variant->image)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $variant->image) }}" alt="{{ $variant->name }}" class="w-20 h-20 object-cover rounded-lg border">
                                <p class="text-sm text-gray-500 mt-1">اترك فارغاً للاحتفاظ بالصورة الحالية</p>
                            </div>
                        @endif
                        @error('image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Description -->
                <div class="mt-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">الوصف</label>
                    <textarea class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror" id="description" name="description" rows="4">{{ old('description', $variant->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Digital Product -->
                <div class="mt-6">
                    <div class="flex items-center">
                        <input type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded @error('is_digital') border-red-500 @enderror" id="is_digital" name="is_digital" value="1" {{ old('is_digital', $variant->is_digital) ? 'checked' : '' }}>
                        <label for="is_digital" class="ml-2 block text-sm text-gray-900">منتج رقمي</label>
                    </div>
                    @error('is_digital')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Digital File -->
                <div class="mt-6" id="file_path_group" style="{{ old('is_digital', $variant->is_digital) ? '' : 'display: none;' }}">
                    <label for="file_path" class="block text-sm font-medium text-gray-700 mb-2">ملف المنتج الرقمي</label>
                    <input type="file" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('file_path') border-red-500 @enderror" id="file_path" name="file_path">
                    @if($variant->file_path)
                        <p class="text-sm text-gray-500 mt-1">اترك فارغاً للاحتفاظ بالملف الحالي</p>
                    @endif
                    @error('file_path')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="mt-8">
                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition duration-200 transform hover:scale-105">
                        💾 تحديث المتغير
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('is_digital').addEventListener('change', function() {
    const fileGroup = document.getElementById('file_path_group');
    if (this.checked) {
        fileGroup.style.display = 'block';
    } else {
        fileGroup.style.display = 'none';
    }
});
</script>
@endsection