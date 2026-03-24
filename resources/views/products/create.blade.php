@extends('layouts.pro-store')

@section('content')
<style>
:root {
  --blue-hero: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #60a5fa 100%);
  --blue-glow: 0 25px 50px rgba(59,130,246,0.4);
  --card-radius: 28px;
}

.create-hero {
  background: var(--blue-hero);
  color: white;
  text-align: center;
  padding: 4rem 2rem;
  margin-bottom: 3rem;
  border-radius: var(--card-radius);
  box-shadow: var(--blue-glow);
}

.create-hero h1 {
  font-size: 3rem;
  font-weight: 900;
  margin-bottom: 1rem;
}

.create-container {
  max-width: 700px;
  margin: 0 auto;
}

.form-card {
  background: rgba(255,255,255,0.95);
  backdrop-filter: blur(20px);
  padding: 4rem;
  border-radius: var(--card-radius);
  box-shadow: var(--blue-glow);
  border: 1px solid rgba(59,130,246,0.2);
}

.form-group {
  margin-bottom: 2.5rem;
}

.label-modern {
  display: block;
  font-weight: 700;
  color: #1e293b;
  margin-bottom: 1rem;
  font-size: 1.1rem;
}

.input-modern, textarea, select {
  width: 100%;
  padding: 1.5rem 2rem;
  border: 2px solid #e0e7ff;
  border-radius: 20px;
  font-size: 1.1rem;
  font-family: 'Tajawal', sans-serif;
  background: linear-gradient(145deg, #ffffff, #f8fafc);
  transition: all 0.3s ease;
  box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);
  resize: vertical;
}

.input-modern:focus, textarea:focus, select:focus {
  border-color: #3b82f6;
  box-shadow: 0 0 0 4px rgba(59,130,246,0.15);
  outline: none;
  transform: translateY(-2px);
}

textarea {
  min-height: 150px;
}

.btn-save {
  background: var(--blue-hero);
  color: white;
  border: none;
  padding: 1.5rem 4rem;
  border-radius: 25px;
  font-size: 1.2rem;
  font-weight: 800;
  cursor: pointer;
  box-shadow: var(--blue-glow);
  width: 100%;
  transition: all 0.4s ease;
}

.btn-save:hover {
  transform: translateY(-4px) scale(1.02);
  box-shadow: 0 30px 60px rgba(59,130,246,0.5);
}

.btn-back {
  display: inline-block;
  background: #6b7280;
  color: white;
  text-decoration: none;
  padding: 1rem 2rem;
  border-radius: 20px;
  margin-top: 1rem;
  transition: all 0.3s ease;
}

.btn-back:hover {
  background: #4b5563;
  transform: translateY(-2px);
}

@media (max-width: 768px) {
  .form-card {
    padding: 2.5rem 2rem;
    margin: 0 1rem;
  }
}
</style>

<div class="py-4">
    <section class="create-hero">
    <h1>➕ إضافة منتج جديد</h1>
    <p>لوحة الإدارة - إضافة منتج للمتجر</p>
  </section>

  <div class="create-container">
    <div class="form-card">
      @if ($errors->any())
        <div style="background: linear-gradient(135deg, #fee2e2, #fecaca); border: 1px solid #fca5a5; border-radius: 20px; padding: 2rem; margin-bottom: 2rem;">
          <h4 style="color: #dc2626; margin-bottom: 1rem;">⚠️ خطأ في البيانات:</h4>
          <ul style="color: #991b1b; list-style: none; padding: 0;">
            @foreach ($errors->all() as $error)
              <li style="margin-bottom: 0.5rem;">• {{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      @if (session('success'))
        <div style="background: linear-gradient(135deg, #dcfce7, #bbf7d0); border: 1px solid #86efac; border-radius: 20px; padding: 2rem; margin-bottom: 2rem; color: #166534;">
          <h4 style="margin-bottom: 1rem;">✅ {{ session('success') }}</h4>
        </div>
      @endif

      <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
          <label class="label-modern">📝 اسم المنتج</label>
          <input type="text" name="name" class="input-modern" value="{{ old('name') }}" required placeholder="مثال: تيشرت ماركة MHD">
        </div>

        <div class="form-group">
          <label class="label-modern">📄 الوصف</label>
          <textarea name="description" class="input-modern" placeholder="وصف مفصل للمنتج...">{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
          <label class="label-modern">📂 الفئة</label>
          <select name="category" class="input-modern" required>
            <option value="">اختر الفئة</option>
            <option value="إلكترونيات" {{ old('category') == 'إلكترونيات' ? 'selected' : '' }}>إلكترونيات</option>
            <option value="ملابس" {{ old('category') == 'ملابس' ? 'selected' : '' }}>ملابس</option>
            <option value="إكسسوارات" {{ old('category') == 'إكسسوارات' ? 'selected' : '' }}>إكسسوارات</option>
            <option value="منزليات" {{ old('category') == 'منزليات' ? 'selected' : '' }}>منزليات</option>
          </select>
        </div>

        <div class="form-group">
          <label class="label-modern">💰 السعر (ر.س)</label>
          <input type="number" name="price" step="0.01" min="0" class="input-modern" value="{{ old('price') }}" required placeholder="مثال: 99.99">
        </div>

        <div class="form-group">
          <label class="label-modern">📸 صورة المنتج (اختياري)</label>
          <input type="file" name="image" class="input-modern" accept="image/*">
        </div>

        <div class="form-group">
          <label class="label-modern">📦 المخزون</label>
          <input type="number" name="stock" min="0" class="input-modern" value="{{ old('stock', 10) }}" required placeholder="عدد القطع المتاحة">
        </div>

        <button type="submit" class="btn-save">💾 حفظ المنتج الجديد</button>
      </form>

      <a href="{{ route('admin.products.index') }}" class="btn-back">← العودة للمنتجات</a>
    </div>
  </div>
</div>
@endsection

