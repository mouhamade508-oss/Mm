@extends('layouts.pro-store')

@section('meta_description', 'شحن رصيد الألعاب والتطبيقات - MHD Print Lab')
@section('meta_keywords', 'ألعاب, تطبيقات, شحن رصيد, متجر, خصم')
@section('meta_canonical', url('/games-and-apps'))

@section('content')
@if(session('referral_code'))
<div style="background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 1rem; border-radius: 12px; margin-bottom: 2rem; text-align: center; box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);">
    <h4 style="margin: 0; font-weight: 700;">اهلا بك</h4>
    <p style="margin: 0.5rem 0 0 0; opacity: 0.9;">يمكنك الآن متابعة طلب شحن رصيد اللعبة.</p>
</div>
@endif

<style>
:root {
  --blue-hero: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
  --blue-glow: 0 20px 40px rgba(59,130,246,0.3);
  --card-radius: 20px;
}

@keyframes fadeInDown {
  from {
    opacity: 0;
    transform: translateY(-30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.hero-store {
  background: var(--blue-hero);
  color: white;
  padding: clamp(3rem, 8vw, 6rem) 1rem;
  text-align: center;
  position: relative;
  overflow: hidden;
}

.hero-store h1 {
  font-size: clamp(2rem, 5vw, 3.5rem);
  font-weight: 900;
  margin-bottom: 1rem;
  letter-spacing: -0.5px;
  animation: fadeInDown 0.8s ease;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 1rem;
}

.hero-store h2 {
  font-size: clamp(1.2rem, 3vw, 1.8rem);
  font-weight: 700;
  margin-bottom: 0.5rem;
  animation: fadeInUp 0.8s ease 0.2s both;
}

.hero-store p {
  font-size: clamp(1rem, 2vw, 1.3rem);
  opacity: 0.95;
  line-height: 1.8;
  margin-bottom: 2.5rem;
  font-weight: 500;
  animation: fadeInUp 0.8s ease 0.4s both;
}

.hero-btn {
  background: white;
  color: #1d4ed8;
  text-decoration: none;
  padding: clamp(0.8rem, 2vw, 1.2rem) clamp(1rem, 2vw, 2rem);
  border-radius: 16px;
  font-weight: 700;
  font-size: clamp(0.9rem, 2vw, 1rem);
  transition: all 0.3s;
  display: inline-block;
  position: relative;
  overflow: hidden;
  border: 2px solid white;
}

.hero-btn::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
  transition: left 0.5s;
}

.hero-btn:hover::before {
  left: 100%;
}

.hero-btn:hover {
  transform: translateY(-2px);
  box-shadow: var(--blue-glow);
}

.hero-btn-primary {
  background: var(--blue-hero);
  color: white;
}

.hero-btn-primary:hover {
  box-shadow: var(--blue-glow);
}

.hero-btn-secondary {
  background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
  color: white;
}

.hero-btn-secondary:hover {
  box-shadow: 0 15px 40px rgba(234, 88, 12, 0.5);
}

.filters-section {
  background: rgba(255,255,255,0.9);
  backdrop-filter: blur(20px);
  padding: clamp(1.5rem, 4vw, 3rem);
  border-radius: var(--card-radius);
  box-shadow: var(--blue-glow);
  margin-bottom: clamp(2rem, 5vw, 4rem);
  max-width: 1200px;
  margin-left: auto;
  margin-right: auto;
}

.filter-grid {
  display: grid;
  grid-template-columns: 2fr 1fr;
  gap: 1.5rem;
  align-items: end;
}

@media (max-width: 1024px) {
  .filter-grid {
    grid-template-columns: 1fr;
  }
}

@media (max-width: 768px) {
  .filters-section {
    padding: clamp(1rem, 3vw, 2rem);
  }
  
  .filter-grid {
    gap: 1rem;
  }
}

.filter-form {
  display: contents;
}

.input-filter, select {
  width: 100%;
  padding: clamp(0.8rem, 2vw, 1.2rem) clamp(1rem, 2vw, 1.5rem);
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
  padding: clamp(0.8rem, 2vw, 1.2rem) clamp(1rem, 2vw, 2rem);
  border-radius: 16px;
  font-weight: 700;
  cursor: pointer;
  width: 100%;
  font-size: clamp(0.9rem, 2vw, 1rem);
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
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  gap: clamp(1.5rem, 3vw, 2.5rem);
  max-width: 1400px;
  margin: 0 auto clamp(3rem, 5vw, 6rem);
  padding: 0 clamp(0.5rem, 2vw, 2rem);
}

@media (max-width: 768px) {
  .products-grid {
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: clamp(1rem, 2vw, 1.5rem);
  }
}

@media (max-width: 480px) {
  .products-grid {
    grid-template-columns: 1fr;
  }
}

.product-card {
  background: white;
  border-radius: var(--card-radius);
  overflow: hidden;
  box-shadow: 0 10px 40px rgba(59,130,246,0.15);
  transition: all 0.4s ease;
  border: 1px solid rgba(59,130,246,0.1);
  display: flex;
  flex-direction: column;
}

.product-card:hover {
  transform: translateY(-12px);
  box-shadow: 0 30px 60px rgba(59,130,246,0.25);
}

.product-image {
  height: clamp(200px, 40vw, 260px);
  background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  position: relative;
  width: 100%;
}

.product-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.product-image:empty::before {
  content: '🎮';
  font-size: clamp(2rem, 5vw, 4rem);
  opacity: 0.6;
}

.product-info {
  padding: clamp(1rem, 3vw, 2.5rem);
  flex-grow: 1;
  display: flex;
  flex-direction: column;
}

.product-name {
  font-size: clamp(1.1rem, 2vw, 1.5rem);
  font-weight: 800;
  color: #1e293b;
  margin-bottom: 0.8rem;
  line-height: 1.3;
}

.product-desc {
  color: #64748b;
  line-height: 1.6;
  margin-bottom: 1rem;
  font-size: clamp(0.85rem, 1.5vw, 1rem);
  flex-grow: 1;
}

.product-price {
  font-size: clamp(1.5rem, 3vw, 2.2rem);
  font-weight: 900;
  background: var(--blue-hero);
  -webkit-background-clip: text;
  background-clip: text;
  color: transparent;
  margin-bottom: 0.8rem;
}

.product-stock {
  color: #059669;
  font-weight: 600;
  margin-bottom: 1.5rem;
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-size: clamp(0.85rem, 1.5vw, 1rem);
}

.whatsapp-btn {
  width: 100%;
  background: var(--whatsapp-green);
  color: white;
  text-decoration: none;
  padding: clamp(0.9rem, 2vw, 1.3rem);
  border-radius: 16px;
  font-weight: 700;
  font-size: clamp(0.85rem, 1.5vw, 1.1rem);
  text-align: center;
  display: block;
  box-shadow: 0 10px 30px rgba(37,211,102,0.4);
  transition: all 0.3s ease;
  position: relative;
  overflow: hidden;
  border: none;
  cursor: pointer;
}

.whatsapp-btn:hover {
  transform: translateY(-3px);
  box-shadow: 0 20px 40px rgba(37,211,102,0.5);
}

.whatsapp-btn::before {
  content: '🎮 ';
}

.no-products {
  grid-column: 1 / -1;
  text-align: center;
  padding: clamp(2rem, 5vw, 6rem) 1rem;
}

.no-icon {
  font-size: clamp(2.5rem, 5vw, 5rem);
  margin-bottom: 2rem;
  opacity: 0.6;
}

.no-title {
  font-size: clamp(1.5rem, 3vw, 2.5rem);
  font-weight: 800;
  color: #1e293b;
  margin-bottom: 1rem;
}

.no-text {
  color: #64748b;
  font-size: clamp(1rem, 2vw, 1.2rem);
  margin-bottom: 3rem;
}

.pagination-custom {
  display: flex;
  justify-content: center;
  gap: clamp(0.3rem, 1vw, 0.5rem);
  margin: clamp(2rem, 5vw, 4rem) 0;
  flex-wrap: wrap;
}

.pagination-custom a, .pagination-custom span {
  padding: clamp(0.6rem, 1.5vw, 1rem) clamp(0.8rem, 2vw, 1.5rem);
  border-radius: 12px;
  text-decoration: none;
  color: #3b82f6;
  font-weight: 600;
  background: white;
  box-shadow: 0 4px 15px rgba(0,0,0,0.1);
  transition: all 0.3s;
  font-size: clamp(0.8rem, 1.5vw, 1rem);
}

.pagination-custom .current {
  background: var(--blue-hero);
  color: white;
}

.admin-link {
  text-align: center;
  margin-top: clamp(2rem, 5vw, 4rem);
  padding: clamp(1rem, 3vw, 2rem);
  background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
  border-radius: var(--card-radius);
  max-width: 500px;
  margin-left: auto;
  margin-right: auto;
}

.global-discount-section {
  background: linear-gradient(135deg, #fef08a 0%, #fde047 50%, #facc15 100%);
  padding: clamp(1.5rem, 4vw, 2.5rem);
  border-radius: var(--card-radius);
  box-shadow: 0 25px 50px rgba(250,204,21,0.3);
  margin-bottom: clamp(2rem, 5vw, 4rem);
  max-width: 800px;
  margin-left: auto;
  margin-right: auto;
  border: 2px solid rgba(255,255,255,0.5);
}

.global-discount-section h2 {
  color: #854d0e;
  font-size: clamp(1.3rem, 3vw, 1.8rem);
  margin-bottom: 1rem;
  font-weight: 900;
  text-align: center;
}

.global-discount-section p {
  color: #b45309;
  text-align: center;
  margin-bottom: 1.5rem;
  font-size: clamp(0.9rem, 2vw, 1.1rem);
  font-weight: 600;
}

.global-discount-input-group {
  display: flex;
  gap: 1rem;
  margin-bottom: 1.5rem;
}

.global-discount-input-group input {
  flex: 1;
  padding: clamp(0.8rem, 2vw, 1.2rem) clamp(1rem, 2vw, 1.5rem);
  border: 2px solid rgba(255,255,255,0.6);
  border-radius: 16px;
  font-size: clamp(0.9rem, 1.5vw, 1.1rem);
  font-family: 'Tajawal', sans-serif;
  font-weight: 600;
  background: rgba(255,255,255,0.9);
  text-align: center;
  transition: all 0.3s;
}

.global-discount-input-group input:focus {
  outline: none;
  border-color: #b45309;
  background: white;
  box-shadow: 0 0 0 4px rgba(180,83,9,0.15);
}

.global-discount-input-group button {
  background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%);
  color: white;
  border: none;
  padding: clamp(0.8rem, 2vw, 1.2rem) clamp(1rem, 2vw, 2.5rem);
  border-radius: 16px;
  font-weight: 700;
  cursor: pointer;
  font-size: clamp(0.85rem, 1.5vw, 1.1rem);
  transition: all 0.3s;
  white-space: nowrap;
  box-shadow: 0 10px 30px rgba(202,65,12,0.3);
}

.global-discount-input-group button:hover {
  transform: translateY(-2px);
  box-shadow: 0 15px 40px rgba(202,65,12,0.4);
}

.global-discount-msg {
  text-align: center;
  font-weight: 600;
  font-size: clamp(0.9rem, 1.5vw, 1.1rem);
  min-height: 30px;
  color: #854d0e;
}

.global-discount-msg.success {
  color: #15803d;
}

.global-discount-msg.error {
  color: #dc2626;
}

@media (max-width: 1024px) {
  .global-discount-input-group {
    gap: 0.8rem;
  }
}

@media (max-width: 768px) {
  .global-discount-section {
    padding: clamp(1rem, 3vw, 2rem);
  }
  
  .global-discount-section h2 {
    font-size: clamp(1rem, 2.5vw, 1.5rem);
  }
  
  .global-discount-input-group {
    flex-direction: column;
    gap: 0.8rem;
  }
  
  .global-discount-input-group button {
    width: 100%;
  }
}

@media (max-width: 480px) {
  .global-discount-section {
    padding: 1rem;
    margin-bottom: 1.5rem;
  }
  
  .global-discount-input-group {
    gap: 0.5rem;
  }
  
  .global-discount-input-group input {
    font-size: 16px;
  }
}

/* Additional Responsive Styles for Inline Elements */
.discount-badge {
  position: absolute;
  top: clamp(0.8rem, 2vw, 15px);
  right: clamp(0.8rem, 2vw, 15px);
  background: linear-gradient(135deg, #f97316, #ea580c);
  color: white;
  padding: clamp(0.5rem, 1vw, 0.8rem) clamp(0.8rem, 2vw, 1.2rem);
  border-radius: 12px;
  font-weight: 700;
  font-size: clamp(0.7rem, 1.5vw, 0.85rem);
  box-shadow: 0 10px 25px rgba(249,115,22,0.3);
}

.discount-field {
  background: #f8f9fa;
  padding: clamp(0.8rem, 2vw, 1.2rem);
  border-radius: 12px;
  margin-bottom: 1.5rem;
  border: 2px dashed #3b82f6;
}

.discount-field-input {
  display: flex;
  gap: 0.6rem;
  margin-bottom: 0.8rem;
  flex-wrap: wrap;
}

.discount-field-input input {
  flex: 1;
  min-width: 150px;
  padding: clamp(0.5rem, 1.5vw, 0.7rem);
  border: 1px solid #e0e7ff;
  border-radius: 8px;
  font-size: clamp(0.8rem, 1.5vw, 0.9rem);
  font-family: 'Tajawal', sans-serif;
}

.discount-field-input button {
  padding: clamp(0.5rem, 1.5vw, 0.7rem) clamp(0.8rem, 1.5vw, 1.2rem);
  font-size: clamp(0.75rem, 1.5vw, 0.9rem);
  white-space: nowrap;
}

.general-discount-box {
  background: #e0f2fe;
  padding: 0.8rem;
  border-radius: 8px;
  margin-bottom: 1.5rem;
  text-align: center;
  font-size: clamp(0.8rem, 1.5vw, 0.9rem);
}

.general-discount-box span {
  color: #0369a1;
  font-weight: 600;
}

.admin-link-btn {
  background: var(--blue-hero);
  color: white;
  padding: clamp(0.7rem, 2vw, 1rem) clamp(1.5rem, 3vw, 2.5rem);
  border-radius: 20px;
  font-weight: 700;
  text-decoration: none;
  display: inline-block;
  font-size: clamp(0.9rem, 1.5vw, 1rem);
}

.no-products-btn {
  width: auto;
  padding: clamp(0.8rem, 2vw, 1.2rem) clamp(1.5rem, 3vw, 3rem);
  display: inline-block;
  font-size: clamp(0.9rem, 1.5vw, 1rem);
}

@media (max-width: 768px) {
  .discount-field {
    padding: 1rem;
  }
  
  .discount-field-input {
    gap: 0.5rem;
  }
  
  .discount-field-input input {
    min-width: 120px;
  }
  
  .discount-field-input button {
    width: 100%;
  }
}

@media (max-width: 480px) {
  .discount-badge {
    padding: 0.5rem 0.8rem;
    font-size: 0.7rem;
  }
  
  .discount-field {
    padding: 0.8rem;
    margin-bottom: 1rem;
  }
  
  .discount-field-input {
    flex-direction: column;
    gap: 0.5rem;
  }
  
  .discount-field-input input {
    width: 100%;
    min-width: unset;
  }
  
  .discount-field-input button {
    width: 100%;
  }
  
  .general-discount-box {
    padding: 0.6rem;
    margin-bottom: 1rem;
    font-size: 0.8rem;
  }
}
</style>

<!-- Hero -->
<section class="hero-store">
  <div style="max-width: 700px; margin: 0 auto;">
    <h1 style="font-size: clamp(2rem, 5vw, 3.5rem); font-weight: 900; margin-bottom: 1rem; letter-spacing: -0.5px; animation: fadeInDown 0.8s ease; display: flex; align-items: center; justify-content: center; gap: 1rem;">
      <img src="{{ asset('images/logo.png') }}" alt="MHD Print Lab Logo" style="height: clamp(2rem, 5vw, 3.5rem); width: auto;">
      MHD Print Lab
    </h1>
    <h2>🎮 شحن رصيد الألعاب والتطبيقات</h2>
    <p style="font-size: clamp(1rem, 2vw, 1.3rem); opacity: 0.95; line-height: 1.8; margin-bottom: 2.5rem; font-weight: 500; animation: fadeInUp 0.8s ease 0.2s both;">اختر لعبتك أو تطبيقك المفضل وشحن رصيدك بسهولة وأمان. خدمة سريعة وموثوقة!</p>
  </div>
  
  <!-- Navigation Buttons -->
  <div style="display: flex; gap: clamp(0.8rem, 2vw, 1.5rem); justify-content: center; flex-wrap: wrap; animation: fadeInUp 0.8s ease 0.4s both;">
    <a href="{{ route('home') }}" class="hero-btn hero-btn-primary">
      <span style="font-size: 1.2rem; margin-right: 0.5rem;">🛍️</span>جميع المنتجات
    </a>
    <a href="{{ route('products.digital') }}" class="hero-btn hero-btn-secondary">
      <span style="font-size: 1.2rem; margin-right: 0.5rem;">💻</span>المنتجات الرقمية
    </a>
  </div>
</section>

<!-- Filters -->
<section class="filters-section">
  <form method="GET" action="{{ route('games.apps') }}" class="filter-form">
    <div class="filter-grid">
      <input type="text" name="search" value="{{ request('search') }}" class="input-filter" placeholder="🔍 ابحث باللعبة أو التطبيق...">
      
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
        <input type="number" name="min_price" value="{{ request('min_price') }}" class="input-filter" placeholder="السعر الادنى" min="0" step="0.01">
        <input type="number" name="max_price" value="{{ request('max_price') }}" class="input-filter" placeholder="السعر الأقصى" min="0" step="0.01">
      </div>
      
      <button type="submit" class="btn-filter">🔍 فلترة النتائج</button>
      
      @if(request()->hasAny(['search', 'min_price', 'max_price']))
        <a href="{{ route('games.apps') }}" class="btn-filter clear-filters">🧹 مسح الفلاتر</a>
      @endif
    </div>
  </form>
</section>

<!-- Products -->
<div class="products-grid">
  @forelse($products as $product)
    <a href="{{ route('games.show', ['game' => $product->id, 'ref' => request()->query('ref')]) }}" class="product-card" style="text-decoration: none; color: inherit;">
      <div class="product-image">
        @if($product->image)
          <img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy">
        @else
          <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 3rem;">🎮</div>
        @endif
      </div>
      <div class="product-info">
        <h3 class="product-name">{{ $product->name }}</h3>
        <p class="product-desc">{{ $product->description }}</p>
        @if($product->activeCategories->count() > 0)
          <div class="product-price">من {{ number_format($product->activeCategories->min('price'), 2) }}ليره </div>
          <div class="product-stock">
            <span>✅</span> متوفر
          </div>
        @else
          <div class="product-price">-</div>
          <div class="product-stock" style="color: #dc2626;">
            <span>❌</span> غير متوفر
          </div>
        @endif
        <button onclick="event.preventDefault(); event.stopPropagation();" class="whatsapp-btn" style="cursor: pointer;">🎮 اختر الخطة</button>
      </div>
    </a>
  @empty
    <div class="no-products">
      <div class="no-icon">🎮</div>
      <h3 class="no-title">لا توجد ألعاب أو تطبيقات متاحة حالياً</h3>
      <p class="no-text">سنضيف المزيد من الألعاب والتطبيقات قريباً. تابعونا!</p>
      <a href="{{ route('home') }}" class="no-products-btn hero-btn hero-btn-primary">العودة للمتجر</a>
    </div>
  @endforelse
</div>

<!-- Pagination -->
@if($products->hasPages())
<style>
  .pagination-wrapper { display: flex; justify-content: center; margin: clamp(1.5rem, 4vw, 3rem) 0; }
  .pagination-controls { display: flex; align-items: center; gap: 0.8rem; background: linear-gradient(135deg, rgba(15, 23, 42, 0.22), rgba(30, 41, 59, 0.22)); border: 1px solid rgba(148, 163, 184, 0.4); border-radius: 999px; padding: 0.4rem; box-shadow: 0 12px 24px rgba(15, 23, 42, 0.12); }
  .pagination-btn { display: inline-flex; align-items: center; justify-content: center; padding: 0.6rem 1.2rem; border-radius: 999px; border: 1px solid rgba(255, 255, 255, 0.25); background: linear-gradient(135deg, #0284c7, #0284c7 40%, #0ea5e9); color: #fff; font-size: 0.95rem; font-weight: 700; text-decoration: none; transition: transform 0.2s ease, box-shadow 0.2s ease; }
  .pagination-btn:hover { transform: translateY(-2px) scale(1.02); box-shadow: 0 8px 22px rgba(2, 132, 199, 0.45); }
  .pagination-btn.animate { animation: bounceButton 1.5s ease-in-out infinite; }
  @keyframes bounceButton { 0%, 100% { transform: translateY(0) scale(1); } 50% { transform: translateY(-4px) scale(1.03); } }
  .pagination-btn.disabled { background: #cbd5e1; border-color: #94a3b8; color: #475569; cursor: default; box-shadow: none; }
  .pagination-info { color: #e2e8f0; font-size: 0.95rem; font-weight: 600; padding: 0 0.6rem; }
</style>
<div class="pagination-wrapper">
  <div class="pagination-controls">
    @if($products->onFirstPage())
      <span class="pagination-btn disabled">◀ السابق</span>
    @else
      <a href="{{ $products->appends(request()->query())->previousPageUrl() }}" class="pagination-btn animate">◀ السابق</a>
    @endif
    <span class="pagination-info">صفحة {{ $products->currentPage() }} من {{ $products->lastPage() }}</span>
    @if($products->hasMorePages())
      <a href="{{ $products->appends(request()->query())->nextPageUrl() }}" class="pagination-btn animate">التالي ▶</a>
    @else
      <span class="pagination-btn disabled">التالي ▶</span>
    @endif
  </div>
</div>
@endif

<!-- Recharge Modal -->
<div id="rechargeModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 1000; animation: fadeIn 0.3s;">
  <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 2rem; border-radius: 20px; max-width: 500px; width: 90%; max-height: 90%; overflow-y: auto;">
    <h3 style="margin-bottom: 1.5rem; color: #1e293b; text-align: center;">🎮 شحن رصيد <span id="gameName"></span></h3>
    
    <form id="rechargeForm" enctype="multipart/form-data">
      @csrf
      <input type="hidden" id="gameId" name="game_id">
      <input type="hidden" id="gameCategoryId" name="game_category_id">
      <!-- حفظ ref parameter إذا كان موجوداً -->
      <input type="hidden" id="refParam" name="ref" value="">
      
      <div id="categoriesSection" style="margin-bottom: 1rem;">
        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">اختر فئة الشحن *</label>
        <select id="categorySelect" name="game_category_id" required style="width: 100%; padding: 0.8rem; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 1rem;">
          <option value="">اختر فئة...</option>
        </select>
      </div>

      <div id="priceSection" style="margin-bottom: 1rem; background: #e0f2fe; padding: 1rem; border-radius: 12px; text-align: center; display: none;">
        <span style="font-size: 0.9rem; color: #0369a1;">السعر: <strong id="categoryPrice">0</strong>ليره سورية</span>
      </div>
      
      <div style="margin-bottom: 1rem;">
        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">ID اللعبة / التطبيق *</label>
        <input type="text" id="playerId" name="player_id" required style="width: 100%; padding: 0.8rem; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 1rem;">
      </div>
      
      <div style="margin-bottom: 1rem;">
        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">صورة إثبات الشحن *</label>
        <input type="file" id="proofImage" name="proof_image" accept="image/*" required style="width: 100%; padding: 0.8rem; border: 2px solid #e2e8f0; border-radius: 12px;">
      </div>
      
      <div style="margin-bottom: 1rem;">
        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">رقم العملية *</label>
        <input type="text" id="transactionNumber" name="transaction_number" required style="width: 100%; padding: 0.8rem; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 1rem;">
      </div>
      
      <div style="margin-bottom: 1rem;">
        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">اسمك (اختياري)</label>
        <input type="text" id="customerName" name="customer_name" style="width: 100%; padding: 0.8rem; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 1rem;">
      </div>
      
      <div style="margin-bottom: 1rem;">
        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">رقم الهاتف (اختياري)</label>
        <input type="tel" id="customerPhone" name="customer_phone" style="width: 100%; padding: 0.8rem; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 1rem;">
      </div>
      
      <div style="margin-bottom: 1.5rem;">
        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">ملاحظات (اختياري)</label>
        <textarea id="notes" name="notes" rows="3" style="width: 100%; padding: 0.8rem; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 1rem; resize: vertical;"></textarea>
      </div>
      
      <div style="display: flex; gap: 1rem; justify-content: flex-end;">
        <button type="button" onclick="closeRechargeModal()" style="padding: 0.8rem 1.5rem; background: #f1f5f9; color: #475569; border: none; border-radius: 12px; cursor: pointer;">إلغاء</button>
        <button type="submit" style="padding: 0.8rem 1.5rem; background: var(--blue-hero); color: white; border: none; border-radius: 12px; cursor: pointer; font-weight: 600;">إرسال الطلب</button>
      </div>
    </form>
    
    <!-- رسالة النجاح -->
    <div id="successMessage" style="display: none; text-align: center; padding: 2rem;">
      <div style="background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 2rem; border-radius: 20px; box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);">
        <h3 style="margin: 0 0 1rem 0; font-size: 1.5rem;">🎉 تم إرسال طلبك بنجاح!</h3>
        <p style="margin: 0 0 1.5rem 0; font-size: 1.1rem; opacity: 0.9;">شكراً لك على اختيار خدماتنا.اذا واجهتك أي مشكلة لا تتردد بالتواصل معنا.</p>
        <button type="button" class="btn-submit" onclick="closeRechargeModal()" style="background: white; color: #059669; border: none; padding: 0.75rem 1.5rem; border-radius: 12px; font-weight: 600; cursor: pointer;">العودة للألعاب</button>
      </div>
    </div>
  </div>
</div>

<script>
// جلب ref parameter من URL إذا كان موجوداً
const urlParams = new URLSearchParams(window.location.search);
const refParam = urlParams.get('ref');
if (refParam) {
  document.getElementById('refParam').value = refParam;
} else {
  // إذا لم يكن هناك ref في URL، استخدم الكود من الجلسة إذا كان موجوداً
  const sessionRef = '{{ $currentReferralCode ?? "" }}';
  if (sessionRef) {
    document.getElementById('refParam').value = sessionRef;
  }
}

let gameCategories = {!! json_encode(\App\Models\Game::with('categories')->where('is_active', true)->get()->mapWithKeys(function($game) { return [$game->id => $game->categories->where('is_active', true)->values()]; })) !!};

function openGamesModal(gameId, gameName) {
  document.getElementById('gameName').textContent = gameName;
  document.getElementById('rechargeModal').style.display = 'block';
  document.body.style.overflow = 'hidden';
  
  // Set game ID
  document.getElementById('gameId').value = gameId;
  
  // Ensure ref parameter is set from URL if available
  const urlParams = new URLSearchParams(window.location.search);
  const refParam = urlParams.get('ref');
  if (refParam) {
    document.getElementById('refParam').value = refParam;
  } else {
    // إذا لم يكن هناك ref في URL، استخدم الكود من الجلسة إذا كان موجوداً
    const sessionRef = '{{ $currentReferralCode ?? "" }}';
    if (sessionRef) {
      document.getElementById('refParam').value = sessionRef;
    }
  }
  
  // Load categories for this game
  const categorySelect = document.getElementById('categorySelect');
  categorySelect.innerHTML = '<option value="">اختر فئة...</option>';
  
  if (gameCategories[gameId]) {
    gameCategories[gameId].forEach(category => {
      const option = document.createElement('option');
      option.value = category.id;
      option.textContent = `${category.name} - ${category.price}دولار`;
      option.dataset.price = category.price;
      categorySelect.appendChild(option);
    });
  }
  
  // Reset when changing category
  categorySelect.addEventListener('change', function() {
    const selected = this.options[this.selectedIndex];
    if (selected.value) {
      document.getElementById('categoryPrice').textContent = selected.dataset.price;
      document.getElementById('priceSection').style.display = 'block';
      document.getElementById('gameCategoryId').value = selected.value;
    } else {
      document.getElementById('priceSection').style.display = 'none';
      document.getElementById('gameCategoryId').value = '';
    }
  });
}

function closeRechargeModal() {
  document.getElementById('rechargeModal').style.display = 'none';
  document.body.style.overflow = 'auto';
  // إعادة تعيين النموذج وإخفاء رسالة النجاح
  document.getElementById('rechargeForm').style.display = 'block';
  document.getElementById('successMessage').style.display = 'none';
  document.getElementById('rechargeForm').reset();
  document.getElementById('priceSection').style.display = 'none';
}

document.getElementById('rechargeForm').addEventListener('submit', function(e) {
  e.preventDefault();
  console.log('Index form submit event triggered');
  
  const formData = new FormData(this);
  
  console.log('Sending request from index');
  fetch('/api/game-recharge-requests', {
    method: 'POST',
    body: formData,
    headers: {
      'Accept': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
  })
  .then(response => {
    console.log('Index response status:', response.status);
    return response.json();
  })
  .then(data => {
    console.log('Index response data:', data);
    if (data.success) {
      // إخفاء النموذج وعرض رسالة النجاح
      document.getElementById('rechargeForm').style.display = 'none';
      document.getElementById('successMessage').style.display = 'block';
    } else {
      alert('حدث خطأ. يرجى المحاولة مرة أخرى.');
    }
  })
  .catch(error => {
    console.error('Index error:', error);
    alert('حدث خطأ. يرجى المحاولة مرة أخرى.');
  });
});

// Close modal when clicking outside
document.getElementById('rechargeModal').addEventListener('click', function(e) {
  if (e.target === this) {
    closeRechargeModal();
  }
});
</script>

@endsection