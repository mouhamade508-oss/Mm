@extends('layouts.admin')

@section('content')
<div class="container">
    <!-- Success/Error Messages -->
    @if(session('success'))
        <div style="background: #d1fae5; border: 1px solid #6ee7b7; color: #065f46; padding: 1rem; border-radius: 8px; margin-bottom: 2rem; font-weight: bold;">
            ✓ {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: 1rem; border-radius: 8px; margin-bottom: 2rem; font-weight: bold;">
            ✕ {{ session('error') }}
        </div>
    @endif

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 2rem; font-weight: bold;">{{ $section->icon ?? '📁' }} {{ $section->name }}</h1>
            <p style="color: #666; margin-top: 0.5rem;">{{ $section->description }}</p>
        </div>
        <div style="display: flex; gap: 1rem;">
            <a href="{{ route('admin.sections.edit', $section) }}" style="background: #3b82f6; color: white; padding: 0.75rem 1.5rem; border-radius: 8px; text-decoration: none; font-weight: bold;">✏️ تعديل القسم</a>
            <form action="{{ route('admin.sections.destroy', $section) }}" method="POST" style="display: inline;" onsubmit="return confirm('هل أنت متأكد من حذف هذا القسم وجميع فئاته؟');">
                @csrf
                @method('DELETE')
                <button type="submit" style="background: #ef4444; color: white; padding: 0.75rem 1.5rem; border-radius: 8px; border: none; cursor: pointer; font-weight: bold;">🗑️ حذف القسم</button>
            </form>
            <a href="{{ route('admin.sections.index') }}" style="background: #6b7280; color: white; padding: 0.75rem 1.5rem; border-radius: 8px; text-decoration: none; font-weight: bold;">← كل الأقسام</a>
        </div>
    </div>

    <div style="background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); padding: 2rem; margin-bottom: 2rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h2 style="font-size: 1.5rem; font-weight: bold;">الفئات ({{ $section->categories()->count() }})</h2>
            <button onclick="document.getElementById('addCategoryForm').style.display = document.getElementById('addCategoryForm').style.display === 'none' ? 'block' : 'none'" style="background: #10b981; color: white; padding: 0.75rem 1.5rem; border-radius: 8px; border: none; cursor: pointer; font-weight: bold; font-size: 1rem;">
                ➕ إضافة فئة جديدة
            </button>
        </div>

        <!-- Add New Category Form -->
        <div id="addCategoryForm" style="display: none; background: #f0fdf4; border: 2px solid #10b981; border-radius: 8px; padding: 2rem; margin-bottom: 2rem;">
            <h3 style="font-size: 1.2rem; font-weight: bold; margin-bottom: 1.5rem;">إضافة فئة جديدة</h3>
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <input type="hidden" name="section_id" value="{{ $section->id }}">
                
                <div style="display: grid; gap: 1.5rem;">
                    <div>
                        <label for="name" style="display: block; font-weight: bold; margin-bottom: 0.5rem;">اسم الفئة</label>
                        <input type="text" name="name" id="name" placeholder="مثال: الهواتف الذكية" required style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem;">
                    </div>

                    <div>
                        <label for="slug" style="display: block; font-weight: bold; margin-bottom: 0.5rem;">الـ Slug (الرابط)</label>
                        <input type="text" name="slug" id="slug" placeholder="مثال: smartphones" required style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem;">
                    </div>

                    <div>
                        <label for="description" style="display: block; font-weight: bold; margin-bottom: 0.5rem;">الوصف (اختياري)</label>
                        <textarea name="description" id="description" placeholder="أضف وصفاً للفئة..." rows="3" style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem;"></textarea>
                    </div>

                    <div style="display: flex; gap: 1rem;">
                        <button type="submit" style="background: #10b981; color: white; padding: 0.75rem 2rem; border-radius: 6px; border: none; cursor: pointer; font-weight: bold; font-size: 1rem;">
                            ✓ إضافة الفئة
                        </button>
                        <button type="button" onclick="document.getElementById('addCategoryForm').style.display = 'none'" style="background: #ef4444; color: white; padding: 0.75rem 2rem; border-radius: 6px; border: none; cursor: pointer; font-weight: bold; font-size: 1rem;">
                            ✕ إلغاء
                        </button>
                    </div>
                </div>
            </form>
        </div>

        @if($section->categories()->count() > 0)
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1.5rem;">
                @foreach($section->categories as $category)
                    <div style="background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; padding: 1.5rem;">
                        <h3 style="font-weight: bold; margin-bottom: 0.5rem;">{{ $category->name }}</h3>
                        <p style="color: #666; font-size: 0.9rem; margin-bottom: 1rem;">{{ $category->products()->count() }} منتج</p>
                        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                            <!-- Add Product Button -->
                            <a href="{{ route('admin.products.create', ['category_id' => $category->id]) }}" style="background: #8b5cf6; color: white; padding: 0.5rem 1rem; border-radius: 6px; text-decoration: none; font-size: 0.9rem; display: inline-block; text-align: center;">➕ إضافة منتج</a>
                            <!-- Edit and Delete Buttons -->
                            <div style="display: flex; gap: 0.75rem;">
                                <a href="{{ route('admin.categories.edit', $category) }}" style="background: #3b82f6; color: white; padding: 0.5rem 1rem; border-radius: 6px; text-decoration: none; font-size: 0.9rem; display: inline-block; flex: 1; text-align: center;">✏️ تعديل</a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display: inline; flex: 1;" onsubmit="return confirm('هل أنت متأكد من حذف هذه الفئة؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background: #ef4444; color: white; padding: 0.5rem 1rem; border-radius: 6px; border: none; cursor: pointer; font-size: 0.9rem; width: 100%;">🗑️ حذف</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p style="color: #999;">لا توجد فئات في هذا القسم حالياً</p>
        @endif
    </div>
</div>
@endsection
