@extends('layouts.pro-store')

@section('content')
<style>
:root {
  --blue-hero: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #60a5fa 100%);
  --blue-glow: 0 25px 50px rgba(59,130,246,0.4);
  --card-radius: 24px;
  --whatsapp-green: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
}

.hero-store {
  background: var(--blue-hero);
  color: white;
  text-align: center;
  padding: 6rem 2rem;
  border-radius: 0 0 var(--card-radius) var(--card-radius);
  box-shadow: var(--blue-glow);
  margin-bottom: 4rem;
}


  font-weight: 900;
  margin-bottom: 1rem;
  color: white

.hero-store p {
  font-size: 1.4rem;
  opacity: 0.95;
  max-width: 600px;
  margin: 0 auto 2.5rem;
}

.filters-section {
  background: rgba(255,255,255,0.9);
  backdrop-filter: blur(20px);
  padding: 3rem;
  border-radius: var(--card-radius);
  box-shadow: var(--blue-glow);
  margin-bottom: 4rem;
  max-width: 1200px;
  margin-left: auto;
  margin-right: auto;
}

.filter-grid {
  display: grid;
  grid-template-columns: 2fr 1fr 1fr;
  gap: 1.5rem;
  align-items: end;
}

@media (max-width: 768px) {
  .filter-grid {
    grid-template-columns: 1fr;
    gap: 1rem;
  }
}

.filter-form {
  display: contents;
}

.input-filter, select {
  width: 100%;
  padding: 1.2rem 1.5rem;
  border: 2px solid #e2e8f0;
  border-radius: 16px;
  font-size: 1rem;
  font-family: 'Tajawal', sans-serif;
  transition: all 0.3s;
  background: white;
}

.input-filter:focus, select:focus {
  outline: none;
  border-color: #3b82f6;
  box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
}

.btn-filter {
  background: var(--blue-hero);
  color: white;
  border: none;
  padding: 1.2rem 2rem;
  border-radius: 16px;
  font-weight: 700;
  cursor: pointer;
  width: 100%;
  font-size: 1rem;
  transition: all 0.3s;
}

.btn-filter:hover {
  transform: translateY(-2px);
  box-shadow: var(--blue-glow);
}

.clear-filters {
  background: #f1f5f9;
  color: #475569;
  border: 2px solid #e2e8f0;
}

.products-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
  gap: 2.5rem;
  max-width: 1400px;
  margin: 0 auto 6rem;
  padding: 0 2rem;
}

.product-card {
  background: white;
  border-radius: var(--card-radius);
  overflow: hidden;
  box-shadow: 0 10px 40px rgba(59,130,246,0.15);
  transition: all 0.4s ease;
  border: 1px solid rgba(59,130,246,0.1);
}

.product-card:hover {
  transform: translateY(-12px);
  box-shadow: 0 30px 60px rgba(59,130,246,0.25);
}

.product-image {
  height: 260px;
  background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  position: relative;
}

.product-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.product-image:empty::before {
  content: '🛍️';
  font-size: 4rem;
  opacity: 0.6;
}

.product-info {
  padding: 2.5rem;
}

.product-name {
  font-size: 1.5rem;
  font-weight: 800;
  color: #1e293b;
  margin-bottom: 0.8rem;
  line-height: 1.3;
}

.product-desc {
  color: #64748b;
  line-height: 1.6;
  margin-bottom: 1.5rem;
}

.product-price {
  font-size: 2.2rem;
  font-weight: 900;
  background: var(--blue-hero);
  -webkit-background-clip: text;
  background-clip: text;
  color: transparent;
  margin-bottom: 1rem;
}

.product-stock {
  color: #059669;
  font-weight: 600;
  margin-bottom: 2rem;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.whatsapp-btn {
  width: 100%;
  background: var(--whatsapp-green);
  color: white;
  text-decoration: none;
  padding: 1.3rem;
  border-radius: 16px;
  font-weight: 700;
  font-size: 1.1rem;
  text-align: center;
  display: block;
  box-shadow: 0 10px 30px rgba(37,211,102,0.4);
  transition: all 0.3s ease;
  position: relative;
  overflow: hidden;
}

.whatsapp-btn:hover {
  transform: translateY(-3px);
  box-shadow: 0 20px 40px rgba(37,211,102,0.5);
}

.whatsapp-btn::before {
  content: '💬 ';
}

.no-products {
  grid-column: 1 / -1;
  text-align: center;
  padding: 6rem 2rem;
}

.no-icon {
  font-size: 5rem;
  margin-bottom: 2rem;
  opacity: 0.6;
}

.no-title {
  font-size: 2.5rem;
  font-weight: 800;
  color: #1e293b;
  margin-bottom: 1rem;
}

.no-text {
  color: #64748b;
  font-size: 1.2rem;
  margin-bottom: 3rem;
}

.pagination-custom {
  display: flex;
  justify-content: center;
  gap: 0.5rem;
  margin: 4rem 0;
  flex-wrap: wrap;
}

.pagination-custom a, .pagination-custom span {
  padding: 1rem 1.5rem;
  border-radius: 12px;
  text-decoration: none;
  color: #3b82f6;
  font-weight: 600;
  background: white;
  box-shadow: 0 4px 15px rgba(0,0,0,0.1);
  transition: all 0.3s;
}

.pagination-custom .current {
  background: var(--blue-hero);
  color: white;
}

.admin-link {
  text-align: center;
  margin-top: 4rem;
  padding: 2rem;
  background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
  border-radius: var(--card-radius);
  max-width: 500px;
  margin-left: auto;
  margin-right: auto;
}
</style>

<!-- Hero -->
<section class="hero-store">
  <h1>🛍️ MHD Print Lab</h1>
  <p>اكتشف مجموعتنا المميزة من المنتجات بأسعار تنافسية - اطلب عبر واتساب بسهولة!</p>
</section>

<!-- Filters -->
<section class="filters-section">
  <form method="GET" action="{{ route('home') }}" class="filter-form">
    <div class="filter-grid">
      <input type="text" name="search" value="{{ request('search') }}" class="input-filter" placeholder="🔍 ابحث بالاسم فقط...">
      
      <select name="category" class="input-filter">
        <option value="">📂 جميع الفئات</option>
        <option value="إلكترونيات" {{ request('category') == 'إلكترونيات' ? 'selected' : '' }}>📱 إلكترونيات</option>
        <option value="ملابس" {{ request('category') == 'ملابس' ? 'selected' : '' }}>👕 ملابس</option>
        <option value="إكسسوارات" {{ request('category') == 'إكسسوارات' ? 'selected' : '' }}>💍 إكسسوارات</option>
        <option value="منزليات" {{ request('category') == 'منزليات' ? 'selected' : '' }}>🏠 منزليات</option>
      </select>
      
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
        <input type="number" name="min_price" value="{{ request('min_price') }}" class="input-filter" placeholder="الأدنى" min="0" step="0.01">
        <input type="number" name="max_price" value="{{ request('max_price') }}" class="input-filter" placeholder="الأقصى" min="0" step="0.01">
      </div>
      
      <button type="submit" class="btn-filter">🔍 فلترة النتائج</button>
      
      @if(request()->hasAny(['search', 'category', 'min_price', 'max_price']))
        <a href="{{ route('home') }}" class="btn-filter clear-filters">🧹 مسح الفلاتر</a>
      @endif
    </div>
  </form>
</section>

<!-- Products -->
<div class="products-grid">
  @forelse($products as $product)
    <div class="product-card">
      <div class="product-image">
        @if($product->image)
          <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" loading="lazy">
        @endif
      </div>
      <div class="product-info">
        <h3 class="product-name">{{ Str::limit($product->name, 50) }}</h3>
        <p class="product-desc">{{ Str::limit($product->description, 120) }}</p>
        <div class="product-price">{{ number_format($product->price, 0) }} ر.س</div>
        <div class="product-stock">📦 متوفر: {{ $product->stock }} قطعة</div>
        <a href="https://wa.me/963982617848?text=مرحبا%21%20أريد%20طلب%20%22{{ urlencode($product->name) }}%22%20السعر%3A%20{{ $product->price }}%20ر.س%20{{ urlencode($product->description) }}" 
           class="whatsapp-btn" target="_blank">
           اطلب عبر واتساب
        </a>
      </div>
    </div>
  @empty
    <div class="no-products">
      <div class="no-icon">🔍</div>
      <h2 class="no-title">لا توجد منتجات مطابقة</h2>
      <p class="no-text">جرب تعديل البحث أو الفلاتر للعثور على ما تبحث عنه</p>
      <a href="{{ route('home') }}" class="btn-filter" style="width: auto; padding: 1.2rem 3rem; display: inline-block;">عرض الكل</a>
    </div>
  @endforelse
</div>

{{ $products->appends(request()->query())->links() }}

<!-- Admin Link -->
<div class="admin-link">
  <h3>🔐 لوحة الإدارة</h3>
  <p>لإضافة وإدارة المنتجات</p>
  <a href="{{ route('login') }}" style="background: var(--blue-hero); color: white; padding: 1rem 2.5rem; border-radius: 20px; font-weight: 700; text-decoration: none; display: inline-block;">تسجيل الدخول</a>
</div>

@endsection

