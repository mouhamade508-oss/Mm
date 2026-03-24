@extends('layouts.pro-store')

@section('content')
<style>
/* تزيين مخصص أزرق جميل - كود Blade نقي */
:root {
  --blue-hero: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #60a5fa 100%);
  --blue-glow: 0 25px 50px rgba(59,130,246,0.4);
  --card-radius: 28px;
}

.hero-custom {
  background: var(--blue-hero);
  color: white;
  text-align: center;
  padding: 5rem 2rem;
  margin-bottom: 3rem;
  border-radius: var(--card-radius);
  box-shadow: var(--blue-glow);
  position: relative;
  overflow: hidden;
}

.hero-custom::before {
  content: '';
  position: absolute;
  top: -50%;
  left: -50%;
  width: 200%;
  height: 200%;
  background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
  animation: rotate 20s linear infinite;
}

@keyframes rotate {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

.hero-custom h1 {
  font-size: 3.5rem;
  font-weight: 900;
  margin-bottom: 1rem;
  text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
  position: relative;
  z-index: 1;
}

.hero-custom p {
  font-size: 1.4rem;
  opacity: 0.95;
  max-width: 700px;
  margin: 0 auto;
  position: relative;
  z-index: 1;
}

.filters-custom {
  background: rgba(255,255,255,0.95);
  backdrop-filter: blur(20px);
  padding: 3rem;
  border-radius: var(--card-radius);
  box-shadow: var(--blue-glow);
  margin-bottom: 3rem;
  border: 1px solid rgba(59,130,246,0.2);
}

.filter-row {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 2rem;
}

.input-modern, select {
  width: 100%;
  padding: 1.2rem 1.8rem;
  border: 2px solid #e0e7ff;
  border-radius: 20px;
  font-size: 1.1rem;
  font-family: 'Tajawal', sans-serif;
  background: linear-gradient(145deg, #ffffff, #f8fafc);
  transition: all 0.3s ease;
  box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);
}

.input-modern:focus {
  border-color: #3b82f6;
  box-shadow: 0 0 0 4px rgba(59,130,246,0.15), inset 0 1px 2px rgba(0,0,0,0.05);
  transform: translateY(-1px);
}

.btn-blue {
  background: var(--blue-hero);
  color: white;
  border: none;
  padding: 1.2rem 2.5rem;
  border-radius: 20px;
  font-weight: 700;
  font-size: 1.1rem;
  cursor: pointer;
  box-shadow: var(--blue-glow);
  transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.btn-blue:hover {
  transform: translateY(-3px) scale(1.05);
  box-shadow: 0 30px 60px rgba(59,130,246,0.5);
}

.products-container {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
  gap: 2.5rem;
  margin-bottom: 5rem;
}

.card-modern {
  background: white;
  border-radius: var(--card-radius);
  overflow: hidden;
  box-shadow: var(--blue-glow);
  transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
  border: 1px solid rgba(59,130,246,0.15);
  position: relative;
}

.card-modern::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 4px;
  background: var(--blue-hero);
  transform: scaleX(0);
  transition: transform 0.5s ease;
}

.card-modern:hover::before {
  transform: scaleX(1);
}

.card-modern:hover {
  transform: translateY(-15px);
  box-shadow: 0 40px 80px rgba(59,130,246,0.35);
}

.image-container {
  height: 280px;
  background: linear-gradient(135deg, #eff6ff, #dbeafe);
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
  overflow: hidden;
}

.image-container img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.6s ease;
}

.card-modern:hover .image-container img {
  transform: scale(1.15);
}

.card-body {
  padding: 2.5rem;
}

.product-title {
  font-size: 1.6rem;
  font-weight: 800;
  margin-bottom: 1rem;
  line-height: 1.3;
  color: #1e293b;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.product-text {
  color: #64748b;
  margin-bottom: 1.8rem;
  line-height: 1.7;
  font-size: 1rem;
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.price-big {
  font-size: 2.5rem;
  font-weight: 900;
  background: var(--blue-hero);
  -webkit-background-clip: text;
  background-clip: text;
  color: transparent;
  margin-bottom: 0.8rem;
}

.stock-info {
  color: #94a3b8;
  font-weight: 600;
  font-size: 1rem;
  margin-bottom: 2rem;
}

.whatsapp-full {
  display: block;
  background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
  color: white;
  text-decoration: none;
  padding: 1.5rem 2rem;
  border-radius: 24px;
  font-weight: 800;
  font-size: 1.2rem;
  text-align: center;
  box-shadow: 0 15px 35px rgba(34,197,94,0.4);
  transition: all 0.4s ease;
  position: relative;
  overflow: hidden;
}

.whatsapp-full::before {
  content: '💬';
  margin-left: 1rem;
}

.whatsapp-full:hover {
  transform: translateY(-4px) scale(1.03);
  box-shadow: 0 25px 50px rgba(34,197,94,0.5);
}

.no-products {
  text-align: center;
  grid-column: 1/-1;
  padding: 8rem 3rem;
}

.icon-large {
  font-size: 6rem;
  margin-bottom: 2rem;
  opacity: 0.8;
}

.no-title {
  font-size: 2.5rem;
  font-weight: 800;
  margin-bottom: 1.5rem;
  color: #1e293b;
}

.no-text {
  color: #64748b;
  font-size: 1.3rem;
  margin-bottom: 3rem;
}

/* Responsive */
@media (max-width: 768px) {
  .products-container {
    grid-template-columns: 1fr;
    gap: 2rem;
  }
  
  .hero-custom h1 {
    font-size: 2.5rem;
  }
}
</style>

<div class="py-4">
    <!-- Admin Panel Header -->
    <div style="background: linear-gradient(135deg, #059669, #047857); color: white; padding: 1.5rem; border-radius: 20px; text-align: center; margin-bottom: 3rem; box-shadow: 0 20px 40px rgba(6, 78, 59, 0.3);">
        <h2 style="font-size: 2.2rem; font-weight: 900; margin: 0 0 0.5rem 0;">👨‍💼 لوحة الإدارة</h2>
        <p style="margin: 0; font-size: 1.1rem; opacity: 0.95;">مرحبا {{ session('admin_user.name') ?? 'الإداري' }} | إدارة المنتجات المتكاملة</p>
    </div>

    <!-- Hero Custom -->
    <section class="hero-custom">
        <h1>MHD Print Lab</h1>
        <p style="font-size: 1.4rem;">مرحبا بك في متجرك المفضل - منتجات جميلة بتصميم أزرق حديث ✨</p>
    </section>

    @if (session('success'))
    <div style="background: linear-gradient(135deg, #dcfce7, #bbf7d0); border: 1px solid #86efac; border-radius: 20px; padding: 2rem; margin-bottom: 2rem; color: #166534; text-align: center; max-width: 600px; margin: 2rem auto 0;">
        <h4 style="margin: 0 0 0.5rem 0;">✅ نجح!</h4>
        <p style="margin: 0; font-size: 1.1rem;">{{ session('success') }}</p>
    </div>
    @endif

    <!-- Filters Custom -->
    <section class="filters-custom">
        <div class="filter-row">
            <form method="GET" action="{{ route('admin.products.index') }}" style="display: contents;">
                <input type="text" name="search" value="{{ request('search') }}" class="input-modern" placeholder="🔍 ابحث بالاسم">
                <button type="submit" class="btn-blue">بحث</button>
            </form>
            <form method="GET" action="{{ route('admin.products.index') }}" style="display: contents;">
                <select name="category" onchange="this.form.submit()" class="input-modern">
                    <option value="">📂 جميع الفئات</option>
                    <option value="إلكترونيات" {{ request('category') == 'إلكترونيات' ? 'selected' : '' }}>إلكترونيات</option>
                    <option value="ملابس" {{ request('category') == 'ملابس' ? 'selected' : '' }}>ملابس</option>
                    <option value="إكسسوارات" {{ request('category') == 'إكسسوارات' ? 'selected' : '' }}>إكسسوارات</option>
                </select>
                <input type="hidden" name="search" value="{{ request('search') }}">
            </form>
            <form method="GET" action="{{ route('admin.products.index') }}" style="display: flex; gap: 1rem; align-items: end;">
                <input type="number" name="min_price" value="{{ request('min_price') }}" class="input-modern" placeholder="الحد الأدنى" style="flex: 1;">
                <input type="number" name="max_price" value="{{ request('max_price') }}" class="input-modern" placeholder="الحد الأقصى" style="flex: 1;">
                <button type="submit" class="btn-blue" style="padding: 1.2rem 1rem; white-space: nowrap;">فلتر السعر</button>
            </form>
        </div>
    </section>

    <!-- Products -->
    <div class="products-container">
        @forelse($products as $product)
        <article class="card-modern">
            <div class="image-container">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                @else
                    <div style="font-size: 5rem; opacity: 0.5;">🛍️</div>
                @endif
            </div>
            <div class="card-body">
                <h3 class="product-title">{{ Str::limit($product->name, 60) }}</h3>
                <p class="product-text">{{ Str::limit($product->description, 140) }}</p>
                <div class="price-big">{{ number_format($product->price, 0) }} <span style="font-size: 0.5em;">ر.س</span></div>
                <div class="stock-info">📦 المخزون: {{ $product->stock }}</div>
                <div style="display: flex; gap: 1rem; margin-top: 1rem;">
                    <a href="https://wa.me/963982617848?text=مرحبا، أريد طلب {{ $product->name }} بسعر {{ $product->price }} ر.س | {{ Str::limit($product->description, 100) }}" class="whatsapp-full" target="_blank" style="flex: 1; padding: 1rem 1.5rem; font-size: 1rem;">
                        واتساب
                    </a>
                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}" style="flex: 1;" onsubmit="return confirm('هل أنت متأكد من حذف هذا المنتج؟')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-blue" style="background: linear-gradient(135deg, #ef4444, #dc2626); border: none; width: 100%; padding: 1rem 1.5rem; font-size: 1rem; cursor: pointer;">🗑️ حذف</button>
                    </form>
                </div>
            </div>
        </article>
        @empty
            <div class="no-products">
                <div class="icon-large">🔍</div>
                <h2 class="no-title">لا توجد منتجات مطابقة</h2>
                <p class="no-text">عدّل شروط البحث أو جرب فئة أخرى</p>
        <a href="{{ route('admin.products.index') }}" class="btn-blue" style="display: inline-block; padding: 1.5rem 3rem; font-size: 1.2rem;">🔄 إعادة تحميل</a>
            </div>
        @endforelse
    </div>
</div>

<script>
document.querySelectorAll('input[type=number], select').forEach(el => {
  el.addEventListener('change', () => el.closest('form').submit());
});
</script>
@endsection
