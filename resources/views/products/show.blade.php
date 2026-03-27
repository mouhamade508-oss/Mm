@extends('layouts.pro-store')

@section('meta_title', $product->name . ' - ' . config('app.name', 'MHD Print Lab'))
@section('meta_description', 
    Str::limit(strip_tags($product->description ?? $product->name), 160, '...')
)
@section('meta_keywords', $product->category?->name . ', ' . $product->name . ', طباعة')
@section('meta_canonical', route('product.show', $product))

@push('meta')
    <script type="application/ld+json">
    {
        "@context": "https://schema.org/",
        "@type": "Product",
        "name": "{{ $product->name }}",
        "description": "{{ Str::limit(strip_tags($product->description ?? $product->name), 300, '...') }}",
        "sku": "{{ $product->id }}",
        "brand": {
            "@type": "Brand",
            "name": "{{ config('app.name', 'MHD Print Lab') }}"
        },
        "offers": {
            "@type": "Offer",
            "url": "{{ route('product.show', $product) }}",
            "priceCurrency": "SAR",
            "price": "{{ number_format($product->price, 2, '.', '') }}",
            "availability": "{{ $product->stock > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock'}}",
            "itemCondition": "https://schema.org/NewCondition"
        }
    }
    </script>
@endpush

@section('content')
<style>
:root {
  --blue-hero: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #60a5fa 100%);
  --blue-glow: 0 25px 50px rgba(59,130,246,0.4);
  --card-radius: 24px;
  --whatsapp-green: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
}

.product-detail-hero {
  background: var(--blue-hero);
  color: white;
  text-align: center;
  padding: clamp(2rem, 5vw, 4rem) 1rem;
  border-radius: 0 0 var(--card-radius) var(--card-radius);
  box-shadow: var(--blue-glow);
  margin-bottom: clamp(2rem, 5vw, 4rem);
}

.product-detail-hero h1 {
  font-size: clamp(1.5rem, 4vw, 2.5rem);
  font-weight: 900;
  margin-bottom: 1rem;
}

.product-detail-hero p {
  font-size: clamp(1rem, 3vw, 1.3rem);
  opacity: 0.95;
  max-width: 600px;
  margin: 0 auto;
}

.product-detail-container {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: clamp(2rem, 5vw, 4rem);
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 clamp(1rem, 3vw, 2rem);
}

@media (max-width: 1024px) {
  .product-detail-container {
    grid-template-columns: 1fr;
    gap: clamp(1.5rem, 4vw, 2.5rem);
  }
}

.product-image-section {
  background: white;
  border-radius: var(--card-radius);
  overflow: hidden;
  box-shadow: 0 20px 60px rgba(59,130,246,0.15);
}

.product-main-image {
  width: 100%;
  height: clamp(300px, 50vw, 500px);
  background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
}

.product-main-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.product-main-image:empty::before {
  content: '🛍️';
  font-size: clamp(3rem, 8vw, 6rem);
  opacity: 0.6;
}

.product-info-section {
  background: white;
  border-radius: var(--card-radius);
  padding: clamp(2rem, 4vw, 3rem);
  box-shadow: 0 20px 60px rgba(59,130,246,0.15);
  display: flex;
  flex-direction: column;
}

.product-title {
  font-size: clamp(1.8rem, 4vw, 2.5rem);
  font-weight: 900;
  color: #1e293b;
  margin-bottom: 1rem;
}

.product-description {
  color: #64748b;
  line-height: 1.7;
  margin-bottom: 2rem;
  font-size: clamp(1rem, 2vw, 1.2rem);
}

.product-price-section {
  margin-bottom: 2rem;
}

.product-price {
  font-size: clamp(2rem, 4vw, 2.8rem);
  font-weight: 900;
  background: var(--blue-hero);
  -webkit-background-clip: text;
  background-clip: text;
  color: transparent;
  margin-bottom: 0.5rem;
}

.product-discount-price {
  font-size: clamp(1.5rem, 3vw, 2rem);
  color: #22c55e;
  font-weight: 700;
  margin-bottom: 1rem;
}

.product-stock {
  color: #059669;
  font-weight: 600;
  margin-bottom: 2rem;
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-size: clamp(1rem, 2vw, 1.1rem);
}

.product-category {
  background: rgba(59,130,246,0.1);
  padding: 1rem;
  border-radius: 16px;
  margin-bottom: 2rem;
  text-align: center;
}

.product-category h3 {
  color: #1e3a8a;
  font-weight: 700;
  margin-bottom: 0.5rem;
  font-size: clamp(1.1rem, 2vw, 1.3rem);
}

.product-category p {
  color: #3b82f6;
  font-size: clamp(0.9rem, 1.5vw, 1rem);
}

.discount-section {
  background: #f8f9fa;
  padding: 1.5rem;
  border-radius: 16px;
  margin-bottom: 2rem;
  border: 2px dashed #3b82f6;
}

.discount-input-group {
  display: flex;
  gap: 0.8rem;
  margin-bottom: 1rem;
}

.discount-input-group input {
  flex: 1;
  padding: 0.8rem;
  border: 1px solid #e0e7ff;
  border-radius: 8px;
  font-size: 1rem;
  font-family: 'Tajawal', sans-serif;
}

.discount-input-group button {
  padding: 0.8rem 1.5rem;
  background: var(--blue-hero);
  color: white;
  border: none;
  border-radius: 8px;
  font-weight: 600;
  cursor: pointer;
  font-size: 0.9rem;
}

.discount-msg {
  font-size: 0.9rem;
  min-height: 20px;
  color: #64748b;
}

.general-discount-box {
  background: #e0f2fe;
  padding: 1rem;
  border-radius: 8px;
  margin-bottom: 2rem;
  text-align: center;
}

.general-discount-box span {
  color: #0369a1;
  font-weight: 600;
}

.whatsapp-btn {
  width: 100%;
  background: var(--whatsapp-green);
  color: white;
  text-decoration: none;
  padding: 1.2rem;
  border-radius: 16px;
  font-weight: 700;
  font-size: 1.1rem;
  text-align: center;
  display: block;
  box-shadow: 0 10px 30px rgba(37,211,102,0.4);
  transition: all 0.3s ease;
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

.related-products-section {
  margin-top: clamp(3rem, 6vw, 5rem);
  padding: clamp(2rem, 4vw, 3rem);
  background: rgba(255,255,255,0.9);
  backdrop-filter: blur(20px);
  border-radius: var(--card-radius);
  box-shadow: var(--blue-glow);
  max-width: 1400px;
  margin-left: auto;
  margin-right: auto;
}

.related-products-section h2 {
  text-align: center;
  font-size: clamp(1.5rem, 3vw, 2rem);
  font-weight: 900;
  color: #1e293b;
  margin-bottom: 2rem;
}

.related-products-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
  gap: clamp(1.5rem, 3vw, 2rem);
}

.related-product-card {
  background: white;
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 10px 40px rgba(59,130,246,0.1);
  transition: all 0.3s;
  border: 1px solid rgba(59,130,246,0.05);
}

.related-product-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 20px 50px rgba(59,130,246,0.2);
}

.related-product-image {
  height: 180px;
  background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
}

.related-product-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.related-product-info {
  padding: 1rem;
}

.related-product-name {
  font-size: 1rem;
  font-weight: 700;
  color: #1e293b;
  margin-bottom: 0.5rem;
  line-height: 1.3;
}

.related-product-price {
  font-size: 1.2rem;
  font-weight: 800;
  color: #3b82f6;
}

.back-btn {
  display: inline-block;
  background: var(--blue-hero);
  color: white;
  padding: 0.8rem 1.5rem;
  border-radius: 20px;
  font-weight: 600;
  text-decoration: none;
  margin-bottom: 2rem;
  transition: all 0.3s;
}

.back-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 25px rgba(59,130,246,0.3);
}

.back-btn::before {
  content: '⬅️ ';
}

@media (max-width: 768px) {
  .product-detail-container {
    padding: 0 1rem;
  }

  .product-info-section {
    padding: 1.5rem;
  }

  .discount-input-group {
    flex-direction: column;
  }

  .related-products-grid {
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 1rem;
  }
}

@media (max-width: 480px) {
  .related-products-grid {
    grid-template-columns: 1fr;
  }
}
</style>

<!-- Hero -->
<section class="product-detail-hero">
  <h1>📦 تفاصيل المنتج</h1>
  <p>اكتشف المزيد عن هذا المنتج واستمتع بالخصومات المتاحة</p>
</section>

<!-- Back Button -->
<div style="max-width: 1200px; margin: 0 auto; padding: 0 1rem;">
  <a href="{{ route('home') }}" class="back-btn">العودة للمنتجات</a>
</div>

<!-- Product Details -->
<div class="product-detail-container">
  <!-- Product Image -->
  <div class="product-image-section">
    <div class="product-main-image">
      @if($product->image)
        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" loading="lazy">
      @endif
    </div>
  </div>

  <!-- Product Info -->
  <div class="product-info-section">
    <!-- Product Discount Badge -->
    @php
      $productDiscount = $product->getActiveDiscount();
    @endphp
    @if($productDiscount)
      <div style="position: absolute; top: 20px; right: 20px; background: linear-gradient(135deg, #f97316, #ea580c); color: white; padding: 0.8rem 1.2rem; border-radius: 12px; font-weight: 700; font-size: 0.9rem; box-shadow: 0 10px 25px rgba(249,115,22,0.3);">
        🎁 خصم {{ $productDiscount->percentage }}%
      </div>
    @endif
    @if($product->is_digital)
      <div style="position: absolute; top: 20px; left: 20px; background: linear-gradient(135deg, #3b82f6, #1d4ed8); color: white; padding: 0.5rem 1rem; border-radius: 12px; font-weight: 700; font-size: 0.8rem; box-shadow: 0 10px 25px rgba(59,130,246,0.3);">
        📁 رقمي
      </div>
    @endif

    <h1 class="product-title">{{ $product->name }}</h1>
    <p class="product-description">{{ $product->description }}</p>

    <!-- Category Info -->
    @if($category)
      <div class="product-category">
        <h3>📂 الفئة: {{ $category->name }}</h3>
        <p>{{ $category->description ?? 'وصف الفئة غير متوفر' }}</p>
      </div>
    @endif

    <!-- Price Section -->
    <div class="product-price-section">
      <div class="product-price" id="original-price">{{ number_format($product->price, 0) }} ل.س</div>
      @if($productDiscount)
        <div class="product-discount-price" id="discount-price">
          {{ number_format($productDiscount->calculateFinalPrice($product->price), 0) }} ل.س
        </div>
      @endif
    </div>

    <!-- Stock -->
    <div class="product-stock">📦 متوفر: {{ $product->stock }} قطعة</div>

    <!-- Discount Section -->
    <div class="discount-section">
      <div class="discount-input-group">
        <input type="text" id="discount-code" placeholder="أدخل كود الخصم">
        <button type="button" onclick="validateDiscount({{ $product->id }})">تطبيق الكود</button>
      </div>
      <div class="discount-msg" id="discount-msg"></div>
    </div>

    <!-- General Discounts -->
    @if($generalDiscounts->count() > 0)
      <div class="general-discount-box">
        <span>🎉 كود عام: <strong>{{ $generalDiscounts->first()->code }}</strong> - {{ $generalDiscounts->first()->percentage }}%</span>
      </div>
    @endif

    <!-- WhatsApp Button -->
    <a href="https://wa.me/963982617848?text=مرحبا%21%20أريد%20طلب%20%22{{ urlencode($product->name) }}%22%20{{ $product->is_digital ? 'المنتج الرقمي' : '' }}%20السعر%3A%20{{ $product->price }}%20ر.س%20{{ urlencode($product->description) }}" 
       class="whatsapp-btn" target="_blank" id="whatsapp-btn">
       اطلب عبر واتساب
    </a>
  </div>
</div>

<!-- Related Products -->
@if($relatedProducts->count() > 0)
<section class="related-products-section">
  <h2>🔗 منتجات مشابهة في نفس الفئة</h2>
  <div class="related-products-grid">
    @foreach($relatedProducts as $related)
      <a href="{{ route('product.show', $related) }}" class="related-product-card">
        <div class="related-product-image">
          @if($related->image)
            <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->name }}" loading="lazy">
          @endif
        </div>
        <div class="related-product-info">
          <h3 class="related-product-name">{{ Str::limit($related->name, 40) }}</h3>
          <div class="related-product-price">{{ number_format($related->price, 0) }} ل.س</div>
        </div>
      </a>
    @endforeach
  </div>
</section>
@endif

<!-- Product Variants -->
@if($variants->count() > 0)
<section class="related-products-section">
  <h2>أصناف المنتج</h2>
  <div class="related-products-grid">
    @foreach($variants as $variant)
      <div class="related-product-card">
        <div class="related-product-image">
          @if($variant->image)
            <img src="{{ asset('storage/' . $variant->image) }}" alt="{{ $variant->name }}" loading="lazy">
          @endif
        </div>
        <div class="related-product-info">
          <h3 class="related-product-name">{{ Str::limit($variant->name, 40) }}</h3>
          <div class="related-product-price">{{ number_format($variant->price, 0) }} ل.س</div>
          <div class="product-stock" style="font-size: 0.8rem; margin-top: 0.5rem;">📦 متوفر: {{ $variant->stock }} قطعة</div>
          <a href="https://wa.me/963982617848?text=مرحبا%21%20أريد%20طلب%20%22{{ urlencode($variant->name) }}%22%20{{ $variant->is_digital ? 'المنتج الرقمي' : '' }}%20السعر%3A%20{{ $variant->price }}%20ر.س%20{{ urlencode($variant->description) }}" 
             class="whatsapp-btn" target="_blank" style="margin-top: 1rem; padding: 0.8rem; font-size: 0.9rem;">
             اطلب هذا المتغير
          </a>
        </div>
      </div>
    @endforeach
  </div>
</section>
@endif

<script>
function validateDiscount(productId) {
    const code = document.getElementById('discount-code').value;
    if (!code) {
        document.getElementById('discount-msg').innerHTML = '<span style="color: #dc2626;">يرجى إدخال كود الخصم</span>';
        return;
    }

    fetch('/api/validate-discount', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ code: code, product_id: productId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const originalPrice = {{ $product->price }};
            const discountAmount = (originalPrice * data.discount.percentage) / 100;
            const finalPrice = originalPrice - discountAmount;

            document.getElementById('original-price').style.textDecoration = 'line-through';
            document.getElementById('original-price').style.opacity = '0.6';
            document.getElementById('discount-price').innerHTML = finalPrice.toLocaleString() + ' ل.س <span style="color: #22c55e; font-size: 0.8em;">(خصم ' + data.discount.percentage + '%)</span>';
            document.getElementById('discount-msg').innerHTML = '<span style="color: #15803d;">تم تطبيق الخصم بنجاح!</span>';

            // Update WhatsApp link
            const whatsappBtn = document.getElementById('whatsapp-btn');
            const newPrice = finalPrice;
            whatsappBtn.href = whatsappBtn.href.replace(/السعر%3A%20\d+/, 'السعر: ' + newPrice);
        } else {
            document.getElementById('discount-msg').innerHTML = '<span style="color: #dc2626;">' + data.message + '</span>';
        }
    })
    .catch(error => {
        document.getElementById('discount-msg').innerHTML = '<span style="color: #dc2626;">حدث خطأ في التحقق من الكود</span>';
    });
}
</script>
@endsection