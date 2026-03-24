@extends('layouts.pro-store')

@section('content')
<style>
:root {
  --blue-hero: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #60a5fa 100%);
  --blue-glow: 0 25px 50px rgba(59,130,246,0.4);
  --card-radius: 28px;
}

.hero-store {
  background: var(--blue-hero);
  color: white;
  text-align: center;
  padding: 5rem 2rem;
  margin-bottom: 3rem;
  border-radius: var(--card-radius);
  box-shadow: var(--blue-glow);
}

.hero-store h1 {
  font-size: 3.5rem;
  font-weight: 900;
  margin-bottom: 1rem;
}

.hero-store p {
  font-size: 1.4rem;
  opacity: 0.95;
}

.filters-store {
  background: rgba(255,255,255,0.95);
  backdrop-filter: blur(20px);
  padding: 3rem;
  border-radius: var(--card-radius);
  box-shadow: var(--blue-glow);
  margin-bottom: 3rem;
}

.filter-row {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 2rem;
}

.btn-store {
  background: var(--blue-hero);
  color: white;
  border: none;
  padding: 1.2rem 2.5rem;
  border-radius: 20px;
  font-weight: 700;
  cursor: pointer;
  box-shadow: var(--blue-glow);
  transition: all 0.4s ease;
}

.btn-store:hover {
  transform: translateY(-3px);
  box-shadow: 0 25px 50px rgba(59,130,246,0.5);
}

/* باقي الـ CSS كما هو... */
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
  transition: all 0.5s ease;
  border: 1px solid rgba(59,130,246,0.15);
}

.card-modern:hover {
  transform: translateY(-15px);
  box-shadow: 0 40px 80px rgba(59,130,246,0.35);
}

.whatsapp-buy {
  background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
  color: white;
  text-decoration: none;
  padding: 1.5rem;
  border-radius: 24px;
  font-weight: 800;
  text-align: center;
  display: block;
  box-shadow: 0 15px 35px rgba(34,197,94,0.4);
  transition: all 0.4s ease;
}

.whatsapp-buy:hover {
  transform: translateY(-4px);
  box-shadow: 0 25px 50px rgba(34,197,94,0.5);
}

.input-modern, select {
  width: 100%;
  padding: 1.2rem 1.8rem;
  border: 2px solid #e0e7ff;
  border-radius: 20px;
  font-size: 1.1rem;
  font-family: 'Tajawal', sans-serif;
  transition: all 0.3s ease;
}

.input-modern:focus {
  border-color: #3b82f6;
  box-shadow: 0 0 0 4px rgba(59,130,246,0.15);
}

.no-products {
  text-align: center;
  grid-column: 1/-1;
  padding: 8rem 3rem;
}

.icon-large { font-size: 6rem; margin-bottom: 2rem; opacity: 0.8; }
.no-title { font-size: 2.5rem; font-weight: 800; margin-bottom: 1.5rem; color: #1e293b; }
.no-text { color: #64748b; font-size: 1.3rem; margin-bottom: 3rem; }
</style>

<div class="py-4">
  <!-- Hero Store -->
  <section class="hero-store">
    <h1>🛍️ MHD Print Lab</h1>
    <p>اكتشف أفضل المنتجات بأسعار مميزة مع تصميم أزرق أنيق</p>
  </section>

  <!-- Filters -->
  <section class="filters-store">
    <div class="filter-row">
      <form method="GET" action="{{ route('products.index') }}" style="display: contents;">
        <input type="text" name="search" value="{{ request('search') }}" class="input-modern" placeholder="🔍 ابحث عن منتج">
        <button type="submit" class="btn-store">🔍 بحث</button>
      </form>
      <form method="GET" action="{{ route('products.index') }}" style="display: contents;">
        <select name="category" class="input-modern" onchange="this.form.submit()">
          <option value="">📂 جميع الفئات</option>
          <option value="إلكترونيات" {{ request('category') == 'إلكترونيات' ? 'selected' : '' }}>إلكترونيات</option>
          <option value="ملابس" {{ request('category') == 'ملابس' ? 'selected' : '' }}>ملابس</option>
          <option value="إكسسوارات" {{ request('category') == 'إكسسوارات' ? 'selected' : '' }}>إكسسوارات</option>
        </select>
        <input type="hidden" name="search" value="{{ request('search') }}">
      </form>
      <form method="GET" action="{{ route('products.index') }}" style="display: flex; gap: 1rem; align-items: end;">
        <input type="number" name="min_price" value="{{ request('min_price') }}" class="input-modern" placeholder="الحد الأدنى">
        <input type="number" name="max_price" value="{{ request('max_price') }}" class="input-modern" placeholder="الحد الأقصى">
        <button type="submit" class="btn-store" style="padding: 1.2rem 1rem;">فلتر السعر</button>
      </form>
    </div>
  </section>

  <!-- Products Grid -->
  <div class="products-container">
    @forelse($products as $product)
    <article class="card-modern">
      <div class="image-container" style="height: 280px; background: linear-gradient(135deg, #eff6ff, #dbeafe); display: flex; align-items: center; justify-content: center;">
        @if($product->image)
          <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
        @else
          <div style="font-size: 5rem; opacity: 0.5;">🛍️</div>
        @endif
      </div>
      <div class="card-body" style="padding: 2.5rem;">
        <h3 style="font-size: 1.6rem; font-weight: 800; margin-bottom: 1rem;">{{ Str::limit($product->name, 60) }}</h3>
        <p style="color: #64748b; margin-bottom: 1.8rem; line-height: 1.7;">{{ Str::limit($product->description, 100) }}</p>
        <div style="font-size: 2.5rem; font-weight: 900; background: var(--blue-hero); -webkit-background-clip: text; margin-bottom: 1rem;">{{ number_format($product->price, 0) }} <span style="font-size: 0.5em;">ر.س</span></div>
        <div style="color: #94a3b8; font-weight: 600; margin-bottom: 2rem;">📦 المخزون: {{ $product->stock }}</div>
        <a href="https://wa.me/963982617848?text=مرحبا، أريد طلب {{ $product->name }} بسعر {{ $product->price }} ر.س" class="whatsapp-buy">
          💬 اطلب عبر واتساب
        </a>
      </div>
    </article>
    @empty
    <div class="no-products">
      <div class="icon-large">🔍</div>
      <h2 class="no-title">لا توجد منتجات مطابقة</h2>
      <p class="no-text">جرب تعديل شروط البحث أو الفئة</p>
      <a href="{{ route('products.index') }}" class="btn-store" style="padding: 1.5rem 3rem;">عرض جميع المنتجات</a>
    </div>
    @endforelse
  </div>

  <div style="text-align: center; margin: 4rem 0; padding: 2rem; background: linear-gradient(135deg, #f0f9ff, #e0f2fe); border-radius: 24px;">
    <h3 style="font-size: 2rem; color: #1e40af; margin-bottom: 1rem;">🔐 لوحة الإدارة</h3>
    <p style="color: #475569; font-size: 1.2rem;">للإدارة والتحكم الكامل في المنتجات</p>
    <a href="{{ route('login') }}" class="btn-store" style="background: var(--blue-hero); display: inline-block; padding: 1.2rem 3rem; margin-top: 1rem;">إدارة المتجر</a>
  </div>
</div>
@endsection

