@extends('layouts.admin')

@section('page-title', 'إضافة منتج جديد')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('admin.products.index') }}" class="text-blue-600 hover:text-blue-700 font-semibold flex items-center gap-1 mb-4">
                ← رجوع للمنتجات
            </a>
            <h1 class="text-4xl font-bold text-gray-900 mb-2">✨ إضافة منتج جديد</h1>
            <p class="text-gray-600">قم بملء النموذج أدناه لإضافة منتج جديد إلى المتجر</p>
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
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="p-8">
                @csrf

                <!-- Section 1: Basic Information -->
                <div class="mb-8 pb-8 border-b">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <span class="text-3xl">📋</span> معلومات أساسية
                    </h2>

                    <!-- Product Name -->
                    <div class="mb-6">
                        <label for="name" class="flex items-center text-gray-700 font-bold mb-3 gap-2">
                            <span class="text-xl">📝</span> اسم المنتج <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required 
                               placeholder="مثال: iPhone 15 Pro Max"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                        @error('name') 
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <label for="description" class="flex items-center text-gray-700 font-bold mb-3 gap-2">
                            <span class="text-xl">📄</span> الوصف
                        </label>
                        <textarea id="description" name="description" rows="4" 
                                  placeholder="اكتب وصف تفصيلي للمنتج..."
                                  class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">{{ old('description') }}</textarea>
                        @error('description') 
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Section 2: Category and Pricing -->
                <div class="mb-8 pb-8 border-b">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <span class="text-3xl">🏷️</span> الفئة والسعر
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Category -->
                        <div>
                            <label for="category_id" class="flex items-center text-gray-700 font-bold mb-3 gap-2">
                                <span class="text-xl">📂</span> الفئة <span class="text-red-500">*</span>
                            </label>
                            <select id="category_id" name="category_id" required 
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                                <option value="">-- اختر الفئة --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id') 
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Price -->
                        <div>
                            <label for="price" class="flex items-center text-gray-700 font-bold mb-3 gap-2">
                                <span class="text-xl">💵</span> السعر <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="number" id="price" name="price" value="{{ old('price') }}" required 
                                       step="0.01" min="0"
                                       placeholder="0.00"
                                       class="w-full px-4 py-3 pr-12 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                                <span class="absolute left-4 top-3 text-gray-500 font-bold">ل.س</span>
                            </div>
                            @error('price') 
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 3: Stock and Digital Product -->
                <div class="mb-8 pb-8 border-b">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <span class="text-3xl">📦</span> المخزون والنوع
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Stock -->
                        <div>
                            <label for="stock" class="flex items-center text-gray-700 font-bold mb-3 gap-2">
                                <span class="text-xl">📊</span> عدد القطع المتاحة <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="stock" name="stock" value="{{ old('stock', 1) }}" required 
                                   min="0"
                                   placeholder="0"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                            <p class="text-gray-500 text-sm mt-2">📌 الحد الأدنى المقترح: 1 قطعة</p>
                            @error('stock') 
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Is Digital -->
                        <div>
                            <label class="flex items-center text-gray-700 font-bold mb-3 gap-2">
                                <span class="text-xl">💻</span> منتج رقمي
                            </label>
                            <div class="flex items-center">
                                <input type="checkbox" id="is_digital" name="is_digital" value="1" {{ old('is_digital') ? 'checked' : '' }}
                                       class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                <label for="is_digital" class="ml-2 text-sm font-medium text-gray-900">هذا منتج رقمي (ملف قابل للتحميل)</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 4: Digital File (shown only if digital) -->
                <div class="mb-8 pb-8 border-b digital-file-section" style="display: none;">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <span class="text-3xl">📁</span> ملف المنتج الرقمي
                    </h2>

                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-blue-500 transition cursor-pointer" id="file-dropzone">
                        <input type="file" id="file_path" name="file_path" accept=".pdf,.doc,.docx,.txt,.zip" class="hidden" onchange="handleFileSelect(event)">
                        <div class="mb-4">
                            <span class="text-5xl">📄</span>
                        </div>
                        <p class="text-gray-600 font-semibold mb-2">انقر هنا أو اسحب الملف</p>
                        <p class="text-gray-500 text-sm">الصيغ المسموحة: PDF, DOC, DOCX, TXT, ZIP</p>
                        <p class="text-gray-500 text-sm">الحد الأقصى: 10MB</p>
                    </div>

                    <div id="file-preview" class="mt-4 hidden">
                        <p id="file-name" class="text-gray-700 font-semibold"></p>
                        <button type="button" onclick="removeFile()" class="mt-2 block mx-auto bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
                            ❌ إزالة الملف
                        </button>
                    </div>

                    @error('file_path') 
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Section 5: Product Image -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <span class="text-3xl">🖼️</span> صورة المنتج
                    </h2>

                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-blue-500 transition cursor-pointer" id="dropzone">
                        <input type="file" id="image" name="image" accept="image/*" class="hidden" onchange="handleFileSelect(event)">
                        <div class="mb-4">
                            <span class="text-5xl">📸</span>
                        </div>
                        <p class="text-gray-600 font-semibold mb-2">انقر هنا أو اسحب الصورة</p>
                        <p class="text-gray-500 text-sm">الصيغ المسموحة: JPEG, PNG, JPG, GIF</p>
                        <p class="text-gray-500 text-sm">الحد الأقصى: 2MB</p>
                    </div>

                    <div id="image-preview" class="mt-4 hidden">
                        <img id="preview-img" src="" alt="Preview" class="max-h-64 rounded-lg mx-auto">
                        <button type="button" onclick="removeImage()" class="mt-2 block mx-auto bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
                            ❌ إزالة الصورة
                        </button>
                    </div>

                    @error('image') 
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-4 pt-6">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition transform hover:scale-105">
                        ✅ إضافة المنتج
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="flex-1 bg-gradient-to-r from-gray-400 to-gray-500 hover:from-gray-500 hover:to-gray-600 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition text-center">
                        ❌ إلغاء
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const dropzone = document.getElementById('dropzone');
    const fileInput = document.getElementById('image');
    const preview = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');

    const fileDropzone = document.getElementById('file-dropzone');
    const fileInputField = document.getElementById('file_path');
    const filePreview = document.getElementById('file-preview');
    const fileName = document.getElementById('file-name');
    const isDigitalCheckbox = document.getElementById('is_digital');
    const digitalFileSection = document.querySelector('.digital-file-section');

    // Toggle digital file section
    isDigitalCheckbox.addEventListener('change', function() {
        if (this.checked) {
            digitalFileSection.style.display = 'block';
        } else {
            digitalFileSection.style.display = 'none';
            // Clear file input
            fileInputField.value = '';
            filePreview.classList.add('hidden');
        }
    });

    // Image drag and drop
    dropzone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropzone.classList.add('border-blue-500', 'bg-blue-50');
    });

    dropzone.addEventListener('dragleave', () => {
        dropzone.classList.remove('border-blue-500', 'bg-blue-50');
    });

    dropzone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropzone.classList.remove('border-blue-500', 'bg-blue-50');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
            handleImageSelect({ target: { files } });
        }
    });

    // Click to select image
    dropzone.addEventListener('click', () => {
        fileInput.click();
    });

    // File drag and drop
    fileDropzone.addEventListener('dragover', (e) => {
        e.preventDefault();
        fileDropzone.classList.add('border-blue-500', 'bg-blue-50');
    });

    fileDropzone.addEventListener('dragleave', () => {
        fileDropzone.classList.remove('border-blue-500', 'bg-blue-50');
    });

    fileDropzone.addEventListener('drop', (e) => {
        e.preventDefault();
        fileDropzone.classList.remove('border-blue-500', 'bg-blue-50');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fileInputField.files = files;
            handleFileSelect({ target: { files } });
        }
    });

    // Click to select file
    fileDropzone.addEventListener('click', () => {
        fileInputField.click();
    });

    function handleImageSelect(event) {
        const files = event.target.files;
        if (files.length > 0) {
            const file = files[0];
            const reader = new FileReader();
            
            reader.onload = (e) => {
                previewImg.src = e.target.result;
                preview.classList.remove('hidden');
            };
            
            reader.readAsDataURL(file);
        }
    }

    function handleFileSelect(event) {
        const files = event.target.files;
        if (files.length > 0) {
            const file = files[0];
            fileName.textContent = `📄 ${file.name}`;
            filePreview.classList.remove('hidden');
        }
    }

    function removeImage() {
        fileInput.value = '';
        preview.classList.add('hidden');
    }

    function removeFile() {
        fileInputField.value = '';
        filePreview.classList.add('hidden');
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        if (isDigitalCheckbox.checked) {
            digitalFileSection.style.display = 'block';
        }
    });
</script>

<style>
    #dropzone {
        transition: all 0.3s ease;
    }
</style>
@endsection
