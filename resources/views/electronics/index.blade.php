@extends('layouts.pro-store')

@section('content')
<style>
:root {
  --orange-hero: linear-gradient(135deg, #ea580c 0%, #f97316 50%, #fb923c 100%);
  --orange-glow: 0 25px 50px rgba(249, 115, 22, 0.4);
  --card-radius: 28px;
}

.hero-electronics {
  background: var(--orange-hero);
  color: white;
  text-align: center;
  padding: 5rem 2rem;
  margin-bottom: 3rem;
  border-radius: var(--card-radius);
  box-shadow: var(--orange-glow);
}

.hero-electronics h1 {
  font-size: 3.5rem;
  font-weight: 900;
  margin-bottom: 1rem;
}

.hero-electronics p {
  font-size: 1.4rem;
  opacity: 0.95;
}

.filters-store {
  background: rgba(255,255,255,0.95);
  backdrop-filter: blur(20px);
  padding: 3rem;
  border-radius: var(--card-radius);
  box-shadow: var(--orange-glow);
  margin-bottom: 3rem;
}

.filter-row {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 2rem;
}

.btn-electronics {
  background: var(--orange-hero);
  color: white;
  border: none;
  padding: 1.2rem 2.5rem;
  border-radius: 20px;
  font-weight: 700;
  cursor: pointer;
  box-shadow: var(--orange-glow);
  transition: all 0.4s ease;
}

.btn-electronics:hover {
  transform: translateY(-3px);
  box-shadow: 0 25px 50px rgba(249, 115, 22, 0.5);
}

.products-container {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
  gap: 2.5rem;
  margin-bottom: 5rem;
}

.card-electronics {
  background: white;
  border-radius: var(--card-radius);
  overflow: hidden;
  box-shadow: var(--orange-glow);
  transition: all 0.5s ease;
  border: 1px solid rgba(249, 115, 22, 0.15);
}

.card-electronics:hover {
  transform: translateY(-15px);
  box-shadow: 0 40px 80px rgba(249, 115, 22, 0.35);
}

.product-image {
  width: 100%;
  height: 280px;
  object-fit: cover;
  background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
}

.card-content {
  padding: 2rem;
}

.product-name {
  font-size: 1.4rem;
  font-weight: 800;
  color: #1e293b;
  margin-bottom: 0.5rem;
  line-height: 1.3;
}

.product-description {
  color: #64748b;
  font-size: 0.95rem;
  margin-bottom: 1.5rem;
  line-height: 1.5;
}

.product-price {
  font-size: 2rem;
  font-weight: 900;
  color: #ea580c;
  margin-bottom: 1.5rem;
}

.whatsapp-btn {
  background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
  color: white;
  text-decoration: none;
  padding: 1.2rem;
  border-radius: 20px;
  font-weight: 800;
  text-align: center;
  display: block;
  box-shadow: 0 15px 35px rgba(34, 197, 94, 0.4);
  transition: all 0.4s ease;
  border: none;
  cursor: pointer;
  font-size: 1rem;
}

.whatsapp-btn:hover {
  transform: translateY(-4px);
  box-shadow: 0 25px 50px rgba(34, 197, 94, 0.5);
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
  border-color: #ea580c;
  box-shadow: 0 0 0 4px rgba(234, 88, 12, 0.15);
}

.no-products {
  text-align: center;
  grid-column: 1/-1;
  padding: 8rem 3rem;
}

.icon-large { font-size: 6rem; margin-bottom: 2rem; opacity: 0.8; }
.no-title { font-size: 2.5rem; font-weight: 800; margin-bottom: 1.5rem; color: #1e293b; }
.no-text { color: #64748b; font-size: 1.3rem; margin-bottom: 3rem; }

.back-link {
  display: inline-block;
  color: #ea580c;
  text-decoration: none;
  font-weight: 700;
  margin-bottom: 2rem;
  transition: all 0.3s ease;
}

.back-link:hover {
  color: #c2410c;
}
</style>

<div class="py-4">
  <!-- Hero Electronics -->
  <section class="hero-electronics">
    <h1>⚡ {{ $electronicsCategory->name }}</h1>
    <p>أفضل المنتجات الإلكترونية والأجهزة بأسعار تنافسية</p>
    
    <!-- Navigation -->
    <div style="margin-top: 2rem; display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
      <a href="{{ route('products.index') }}" class="btn-electronics" style="background: rgba(255,255,255,0.2); padding: 0.8rem 1.5rem; font-size: 0.9rem;">🛍️ جميع المنتجات</a>
      <a href="{{ route('products.digital') }}" class="btn-electronics" style="background: rgba(255,255,255,0.2); padding: 0.8rem 1.5rem; font-size: 0.9rem;">💻 المنتجات الرقمية</a>
      <a href="{{ route('games.apps') }}" class="btn-electronics" style="background: rgba(255,255,255,0.2); padding: 0.8rem 1.5rem; font-size: 0.9rem;">🎮 الألعاب والتطبيقات</a>
    </div>
  </section>

  <!-- Filters -->
  <section class="filters-store">
    <div class="filter-row">
      <form method="GET" action="{{ route('electronics.index') }}" style="display: contents;">
        <input type="text" name="search" value="{{ request('search') }}" class="input-modern" placeholder="🔍 ابحث عن منتج إلكتروني">
        <button type="submit" class="btn-electronics">🔍 بحث</button>
      </form>
    </div>
  </section>

  <!-- Products Grid -->
  <section>
    @if($products->count() > 0)
      <div class="products-container">
        @foreach($products as $product)
          <div class="card-electronics">
            @if($product->image)
              <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="product-image" loading="lazy">
            @else
              <div class="product-image" style="display: flex; align-items: center; justify-content: center;">
                <span style="font-size: 4rem;">⚙️</span>
              </div>
            @endif
            
            <div class="card-content">
              <h3 class="product-name">{{ $product->name }}</h3>
              <p class="product-description">{{ Str::limit($product->description, 100) }}</p>
              <div class="product-price">{{ number_format($product->price, 0) }}{{ $product->currency == 'USD' ? '$' : 'ل.س' }}</div>
              
              @if($product->requires_whatsapp && $product->whatsapp_phone)
                <button type="button" class="whatsapp-btn" onclick="openWhatsAppModal({{ $product->id }}, '{{ $product->name }}', {{ $product->price }}, '{{ $product->currency == 'USD' ? '$' : 'ل.س' }}')">
                  📱 طلب عبر WhatsApp
                </button>
              @else
                <p style="text-align: center; color: #64748b; font-size: 0.9rem;">غير متاح للطلب حالياً</p>
              @endif
            </div>
          </div>
        @endforeach
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
    @else
      <div class="products-container">
        <div class="no-products">
          <div class="icon-large">📦</div>
          <h2 class="no-title">لا توجد منتجات</h2>
          <p class="no-text">عذراً، لم نعثر على منتجات إلكترونية في الوقت الحالي</p>
          <a href="{{ route('products.index') }}" class="btn-electronics">العودة للمنتجات الأخرى</a>
        </div>
      </div>
    @endif
  </section>
</div>

<!-- WhatsApp Order Modal -->
<div id="whatsappModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
  <div style="background: white; padding: 2rem; border-radius: 28px; max-width: 500px; width: 90%; box-shadow: 0 25px 50px rgba(0,0,0,0.3);">
    <h2 style="font-size: 1.8rem; font-weight: 800; color: #1e293b; margin-bottom: 1.5rem;">طلب عبر WhatsApp</h2>
    
    <form id="whatsappOrderForm" onsubmit="submitWhatsAppOrder(event)">
      @csrf
      <input type="hidden" id="productId" name="product_id">
      
      <div style="margin-bottom: 1.5rem;">
        <label style="display: block; font-weight: 700; margin-bottom: 0.5rem; color: #1e293b;">اسمك</label>
        <input type="text" name="customer_name" required class="input-modern" placeholder="أدخل اسمك الكامل">
      </div>

      <div style="margin-bottom: 1.5rem;">
        <label style="display: block; font-weight: 700; margin-bottom: 0.5rem; color: #1e293b;">رقم الهاتف (مع رمز الدولة)</label>
        <input type="tel" name="customer_phone" required class="input-modern" placeholder="+966501234567">
      </div>

      <div style="margin-bottom: 1.5rem;">
        <label style="display: block; font-weight: 700; margin-bottom: 0.5rem; color: #1e293b;">الكمية</label>
        <input type="number" id="quantity" name="quantity" required min="1" class="input-modern" value="1" onchange="updateTotal()">
      </div>

      <div style="margin-bottom: 1.5rem; padding: 1.5rem; background: #f3f4f6; border-radius: 20px;">
        <div style="font-size: 0.9rem; color: #64748b; margin-bottom: 0.5rem;">السعر الإجمالي:</div>
        <div id="totalPrice" style="font-size: 2rem; font-weight: 900; color: #ea580c;">0ليره</div>
      </div>

      <div style="display: flex; gap: 1rem;">
        <button type="submit" class="whatsapp-btn" style="flex: 1; background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); margin: 0;">
          ✅ تأكيد الطلب
        </button>
        <button type="button" onclick="closeWhatsAppModal()" class="btn-electronics" style="flex: 1; background: #e5e7eb; color: #1e293b; margin: 0;">
          ✕ إغلاق
        </button>
      </div>
    </form>
  </div>
</div>

<script>
let currentProductData = {};

function openWhatsAppModal(productId, productName, productPrice, productCurrency) {
  currentProductData = { productId, productName, productPrice, productCurrency };
  document.getElementById('productId').value = productId;
  document.getElementById('quantity').value = 1;
  updateTotal();
  document.getElementById('whatsappModal').style.display = 'flex';
}

function closeWhatsAppModal() {
  document.getElementById('whatsappModal').style.display = 'none';
}

function updateTotal() {
  const quantity = parseInt(document.getElementById('quantity').value) || 1;
  const total = currentProductData.productPrice * quantity;
  document.getElementById('totalPrice').textContent = total.toFixed(2) + currentProductData.productCurrency;
}

function submitWhatsAppOrder(event) {
  event.preventDefault();
  
  const formData = new FormData(document.getElementById('whatsappOrderForm'));
  
  fetch('{{ route("whatsapp-orders.store") }}', {
    method: 'POST',
    headers: {
      'Accept': 'application/json',
    },
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      alert(data.message);
      window.open(data.whatsapp_link, '_blank');
      closeWhatsAppModal();
    } else {
      alert('خطأ: ' + (data.error || 'حدث خطأ ما'));
    }
  })
  .catch(error => {
    console.error('Error:', error);
    alert('حدث خطأ في إرسال الطلب');
  });
}

// Close modal when clicking outside
document.getElementById('whatsappModal').addEventListener('click', function(event) {
  if (event.target === this) {
    closeWhatsAppModal();
  }
});
</script>
@endsection
