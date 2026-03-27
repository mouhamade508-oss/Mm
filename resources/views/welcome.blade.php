@extends('layouts.pro-store')

@section('meta_title', config('app.name', 'MHD Print Lab'))
@section('meta_description', 'تسوّق أضخم تشكيلة من منتجات الطباعة الرقمية والمطبوعة مع خصومات فورية وخدمة توصيل سريعة.')
@section('meta_keywords', 'طباعة, منتجات, متجر, خصم, شحن, تصميم')
@section('meta_canonical', url('/'))

@section('content')
<style>
:root {
  --blue-hero: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #60a5fa 100%);
  --blue-glow: 0 25px 50px rgba(59,130,246,0.4);
  --card-radius: 24px;
  --whatsapp-green: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
}

@keyframes fadeInDown {
  from {
    opacity: 0;
    transform: translateY(-20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.hero-store {
  background: var(--blue-hero);
  color: white;
  text-align: center;
  padding: clamp(2rem, 5vw, 6rem) 1rem;
  border-radius: 0 0 var(--card-radius) var(--card-radius);
  box-shadow: var(--blue-glow);
  margin-bottom: clamp(2rem, 5vw, 4rem);
}

.hero-store h1 {
  font-size: clamp(2rem, 5vw, 3.5rem);
  font-weight: 900;
  margin-bottom: 1rem;
  color: white;
  letter-spacing: -0.5px;
  text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
}

.hero-store h2 {
  font-size: clamp(1.5rem, 4vw, 2.8rem);
  font-weight: 900;
  margin-bottom: 1rem;
  color: white;
}

.hero-store p {
  font-size: clamp(1rem, 3vw, 1.4rem);
  opacity: 0.95;
  max-width: 600px;
  margin: 0 auto clamp(1.5rem, 4vw, 2.5rem);
  padding: 0 0.5rem;
}

.hero-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  padding: clamp(0.95rem, 2.5vw, 1.3rem) clamp(1.5rem, 3vw, 2.5rem);
  border-radius: 16px;
  font-weight: 700;
  text-decoration: none;
  font-size: clamp(0.95rem, 2vw, 1.1rem);
  transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
  border: 2px solid transparent;
  position: relative;
  overflow: hidden;
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
  font-family: 'Tajawal', sans-serif;
}

.hero-btn::before {
  content: '';
  position: absolute;
  top: 50%;
  left: 50%;
  width: 0;
  height: 0;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.3);
  transform: translate(-50%, -50%);
  transition: width 0.6s, height 0.6s;
  z-index: 0;
}

.hero-btn:hover::before {
  width: 300px;
  height: 300px;
}

.hero-btn-primary {
  background: var(--blue-hero);
  color: white;
  z-index: 1;
}

.hero-btn-primary:hover {
  transform: translateY(-6px);
  box-shadow: 0 15px 40px rgba(59, 130, 246, 0.5);
}

.hero-btn-primary:active {
  transform: translateY(-2px);
}

.hero-btn-secondary {
  background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%);
  color: white;
  z-index: 1;
}

.hero-btn-secondary:hover {
  transform: translateY(-6px);
  box-shadow: 0 15px 40px rgba(234, 88, 12, 0.5);
  background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
}

.hero-btn-secondary:active {
  transform: translateY(-2px);
}

@media (max-width: 768px) {
  .hero-btn {
    padding: 0.9rem 1.3rem;
    font-size: 1rem;
  }
}

@media (max-width: 480px) {
  .hero-btn {
    width: 100%;
    padding: 1rem 1.5rem;
  }
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
  grid-template-columns: 2fr 1fr 1fr;
  gap: 1.5rem;
  align-items: end;
}

@media (max-width: 1024px) {
  .filter-grid {
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
  }
}

@media (max-width: 768px) {
  .filters-section {
    padding: clamp(1rem, 3vw, 2rem);
    margin-bottom: clamp(1.5rem, 4vw, 2.5rem);
  }
  
  .filter-grid {
    grid-template-columns: 1fr;
    gap: 1rem;
  }
}

@media (max-width: 480px) {
  .filters-section {
    padding: 1rem;
    margin-bottom: 1.5rem;
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
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: clamp(1rem, 2vw, 2rem);
    margin: 0 auto clamp(2rem, 4vw, 3rem);
    padding: 0 0.5rem;
  }
}

@media (max-width: 480px) {
  .products-grid {
    grid-template-columns: 1fr;
    gap: 1.2rem;
    margin: 0 auto 2rem;
    padding: 0 0.5rem;
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
  content: '🛍️';
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
  content: '💬 ';
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
    <h1 style="font-size: clamp(2rem, 5vw, 3.5rem); font-weight: 900; margin-bottom: 1rem; letter-spacing: -0.5px; animation: fadeInDown 0.8s ease;">🛍️ MHD Print Lab</h1>
    <p style="font-size: clamp(1rem, 2vw, 1.3rem); opacity: 0.95; line-height: 1.8; margin-bottom: 2.5rem; font-weight: 500; animation: fadeInUp 0.8s ease 0.2s both;">اكتشف مجموعتنا المميزة من المنتجات بأسعار تنافسية - اطلب عبر واتساب بسهولة حيث يتوفر شحن سريع لجميع المحافظات!</p>
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

<!-- Global Discount Code -->
<section class="global-discount-section">
  <h2>🎁 هل لديك كود خصم عام؟</h2>
  <p>أدخل الكود للحصول على خصم على جميع المنتجات</p>
  
  <div class="global-discount-input-group">
    <input type="text" id="global-discount-code" placeholder="أدخل كود الخصم..." maxlength="50">
    <button type="button" onclick="validateGlobalDiscount()">تطبيق الكود</button>
  </div>
  
  <div class="global-discount-msg" id="global-discount-msg"></div>
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
        <!-- عرض الخصم الخاص بالمنتج -->
        @php
          $productDiscount = $product->getActiveDiscount();
        @endphp
        @if($productDiscount)
          <div style="position: absolute; top: 15px; right: 15px; background: linear-gradient(135deg, #f97316, #ea580c); color: white; padding: 0.8rem 1.2rem; border-radius: 12px; font-weight: 700; font-size: 0.85rem; box-shadow: 0 10px 25px rgba(249,115,22,0.3);">
            🎁 خصم {{ $productDiscount->percentage }}%
          </div>
        @endif
        @if($product->is_digital)
          <div style="position: absolute; top: 15px; left: 15px; background: linear-gradient(135deg, #3b82f6, #1d4ed8); color: white; padding: 0.5rem 1rem; border-radius: 12px; font-weight: 700; font-size: 0.8rem; box-shadow: 0 10px 25px rgba(59,130,246,0.3);">
            📁 رقمي
          </div>
        @endif

        <h3 class="product-name"><a href="{{ route('product.show', $product) }}" style="color: inherit; text-decoration: none;">{{ Str::limit($product->name, 50) }}</a></h3>
        <p class="product-desc">{{ Str::limit($product->description, 120) }}</p>
        
        <!-- السعر والخصم -->
        <div style="margin-bottom: 1rem;">
          <div class="product-price" id="original-price-{{ $product->id }}">{{ number_format($product->price, 0) }}ل.س</div>
          @if($productDiscount)
            <div style="font-size: 1.3rem; color: #22c55e; font-weight: 700; margin-top: 0.5rem;" id="discount-price-{{ $product->id }}">
              {{ number_format($productDiscount->calculateFinalPrice($product->price), 0) }} ل.س
            </div>
          @endif
        </div>

        <!-- حقل الخصم -->
        <div style="background: #f8f9fa; padding: 1.2rem; border-radius: 12px; margin-bottom: 1.5rem; border: 2px dashed #3b82f6;">
          <div style="display: flex; gap: 0.6rem; margin-bottom: 0.8rem;">
            <input type="text" id="discount-code-{{ $product->id }}" placeholder="كود الخصم" style="flex: 1; padding: 0.7rem; border: 1px solid #e0e7ff; border-radius: 8px; font-size: 0.9rem; font-family: 'Tajawal', sans-serif;">
            <button type="button" onclick="validateDiscount({{ $product->id }})" class="btn-filter" style="padding: 0.7rem 1.2rem; font-size: 0.9rem; white-space: nowrap; width: auto;">تطبيق</button>
          </div>
          <div id="discount-msg-{{ $product->id }}" style="font-size: 0.8rem; min-height: 18px; color: #64748b;"></div>
        </div>

        <!-- عرض الخصومات العامة -->
        @if($generalDiscounts->count() > 0)
          <div style="background: #e0f2fe; padding: 0.8rem; border-radius: 8px; margin-bottom: 1.5rem; text-align: center; font-size: 0.9rem;">
            <span style="color: #0369a1; font-weight: 600;">🎉 كود عام: <span style="font-weight: 700;">{{ $generalDiscounts->first()->code }}</span> - {{ $generalDiscounts->first()->percentage }}%</span>
          </div>
        @endif

        <div class="product-stock">📦 متوفر: {{ $product->stock }} قطعة</div>
        <a href="https://wa.me/963982617848?text=مرحبا%21%20أريد%20طلب%20%22{{ urlencode($product->name) }}%22%20{{ $product->is_digital ? 'المنتج الرقمي' : '' }}%20السعر%3A%20{{ $product->price }}%20ر.س%20{{ urlencode($product->description) }}" 
           class="whatsapp-btn" target="_blank" id="whatsapp-{{ $product->id }}">
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

<!-- JavaScript للخصومات -->
<script>
let appliedDiscounts = {};
let globalDiscount = null;

function validateGlobalDiscount() {
    const code = document.getElementById('global-discount-code').value.trim();
    const msgEl = document.getElementById('global-discount-msg');
    
    if (!code) {
        msgEl.innerHTML = '<span class="error">❌ أدخل كود صحيح</span>';
        msgEl.className = 'global-discount-msg error';
        return;
    }

    // Don't send product_id for global discount
    fetch('{{ route("validate-discount") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            code: code.toUpperCase()
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.valid) {
            globalDiscount = {
                code: code.toUpperCase(),
                percentage: data.percentage,
                discount_id: data.discount_id,
                type: data.type
            };
            
            msgEl.innerHTML = '<span class="success">✓ تم تطبيق الكود العام بنجاح! خصم ' + data.percentage + '%</span>';
            msgEl.className = 'global-discount-msg success';
            
            // Apply to all products
            applyGlobalDiscountToAll();
        } else {
            globalDiscount = null;
            msgEl.innerHTML = '<span class="error">✗ ' + data.message + '</span>';
            msgEl.className = 'global-discount-msg error';
            // Reset all prices
            resetAllPrices();
        }
    })
    .catch(() => {
        globalDiscount = null;
        msgEl.innerHTML = '<span class="error">❌ خطأ في التحقق</span>';
        msgEl.className = 'global-discount-msg error';
        resetAllPrices();
    });
}

function applyGlobalDiscountToAll() {
    if (!globalDiscount) return;
    
    // Get all product cards
    document.querySelectorAll('[id^="original-price-"]').forEach(el => {
        const productId = el.id.replace('original-price-', '');
        updatePrice(productId, globalDiscount.percentage, true);
    });
}

function validateDiscount(productId) {
    const code = document.getElementById('discount-code-' + productId).value.trim();
    const msgEl = document.getElementById('discount-msg-' + productId);
    
    if (!code) {
        msgEl.innerHTML = '<span style="color: #ef4444;">أدخل كود صحيح</span>';
        return;
    }

    fetch('{{ route("validate-discount") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            code: code.toUpperCase(),
            product_id: productId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.valid) {
            appliedDiscounts[productId] = data;
            updatePrice(productId, data.percentage);
            msgEl.innerHTML = '<span style="color: #22c55e; font-weight: 700;">✓ تم تطبيق الخصم ' + data.percentage + '%</span>';
            updateWhatsAppLink(productId, code, data.percentage);
        } else {
            delete appliedDiscounts[productId];
            msgEl.innerHTML = '<span style="color: #ef4444;">✗ ' + data.message + '</span>';
        }
    })
    .catch(() => {
        msgEl.innerHTML = '<span style="color: #ef4444;">❌ خطأ في التحقق</span>';
    });
}

function updatePrice(productId, percentage, isGlobal = false) {
    const originalEl = document.getElementById('original-price-' + productId);
    let discountEl = document.getElementById('discount-price-' + productId);
    
    const price = parseFloat(originalEl.textContent.replace(/[^\d.]/g, '').split(' ')[0] || 0);
    if (!price) return;
    
    // Use the highest discount available
    let finalPercentage = percentage;
    if (appliedDiscounts[productId] && isGlobal) {
        // If both global and product discount exist, use the higher one
        finalPercentage = Math.max(percentage, appliedDiscounts[productId].percentage);
    }
    
    const finalPrice = price - (price * finalPercentage) / 100;
    
    if (!discountEl) {
        discountEl = document.createElement('div');
        discountEl.id = 'discount-price-' + productId;
        discountEl.style = 'font-size: 1.3rem; color: #22c55e; font-weight: 700; margin-top: 0.5rem;';
        originalEl.parentNode.insertBefore(discountEl, originalEl.nextSibling);
    }
    
    discountEl.textContent = Math.round(finalPrice).toLocaleString() + 'ل.س ';
}

function resetAllPrices() {
    document.querySelectorAll('[id^="discount-price-"]').forEach(el => {
        el.remove();
    });
}

function updateWhatsAppLink(productId, code, percentage) {
    document.getElementById('whatsapp-' + productId).href = 
        `https://wa.me/963982617848?text=مرحبا%21%20أريد%20طلب%20هذا%20المنتج%20برقم%20${productId}%20مع%20تطبيق%20الكود%20${code}%20(خصم%20${percentage}%)`;
}

// Enter key support for product discount
document.querySelectorAll('[id*="discount-code-"]').forEach(input => {
    input.addEventListener('keypress', e => {
        if (e.key === 'Enter') {
            const id = input.id.replace('discount-code-', '');
            validateDiscount(id);
        }
    });
});

// Enter key support for global discount
const globalDiscountInput = document.getElementById('global-discount-code');
if (globalDiscountInput) {
    globalDiscountInput.addEventListener('keypress', e => {
        if (e.key === 'Enter') {
            validateGlobalDiscount();
        }
    });
}
</script>

@endsection

