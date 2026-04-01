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
    
    <!-- Navigation -->
    <div style="margin-top: 2rem; display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
      <a href="{{ route('products.index') }}" class="btn-store" style="background: var(--blue-hero); padding: 0.8rem 1.5rem; font-size: 0.9rem;">🛍️ جميع المنتجات</a>
      <a href="{{ route('products.digital') }}" class="btn-store" style="background: linear-gradient(135deg, #3b82f6, #1d4ed8); padding: 0.8rem 1.5rem; font-size: 0.9rem;">💻 المنتجات الرقمية</a>
    </div>
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
          @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
          @endforeach
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
      <div class="image-container" style="height: 280px; background: linear-gradient(135deg, #eff6ff, #dbeafe); display: flex; align-items: center; justify-content: center; position: relative;">
        @if($product->image)
          <img src="{{ $product->image_url }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
        @else
          <div style="font-size: 5rem; opacity: 0.5;">🛍️</div>
        @endif
        
        <!-- عرض الخصم الخاص بالمنتج إن وجد -->
        @php
          $productDiscount = $product->getActiveDiscount();
        @endphp
        @if($productDiscount)
          <div style="position: absolute; top: 15px; right: 15px; background: linear-gradient(135deg, #f97316, #ea580c); color: white; padding: 0.8rem 1.2rem; border-radius: 12px; font-weight: 700; font-size: 0.9rem; box-shadow: 0 10px 25px rgba(249,115,22,0.3);">
            خصم {{ $productDiscount->percentage }}%
          </div>
        @endif
      </div>
      <div class="card-body" style="padding: 2.5rem;">
        <h3 style="font-size: 1.6rem; font-weight: 800; margin-bottom: 1rem;">{{ Str::limit($product->name, 60) }}</h3>
        <p style="color: #64748b; margin-bottom: 1.8rem; line-height: 1.7;">{{ Str::limit($product->description, 100) }}</p>
        
        <div style="margin-bottom: 1.5rem;">
          <!-- السعر الأصلي -->
          <div style="font-size: 2.5rem; font-weight: 900; background: var(--blue-hero); -webkit-background-clip: text; margin-bottom: 0.5rem;" class="original-price-{{ $product->id }}">
            {{ number_format($product->price, 0) }} <span style="font-size: 0.5em;">ل.س</span>
          </div>
          
          <!-- السعر مع الخصم الخاص بالمنتج إن وجد -->
          @if($productDiscount)
            <div style="font-size: 1.3rem; color: #22c55e; font-weight: 700;" class="discounted-price-{{ $product->id }}">
              {{ number_format($productDiscount->calculateFinalPrice($product->price), 0) }} <span style="font-size: 0.6em;">ل.س</span>
            </div>
          @endif
        </div>

        <!-- قسم إدخال كود الخصم -->
        <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 16px; margin-bottom: 1.5rem; border: 2px dashed #3b82f6;">
          <div style="display: flex; gap: 0.8rem; margin-bottom: 1rem;">
            <input type="text" class="discount-code-input-{{ $product->id }}" placeholder="أدخل كود الخصم" style="flex: 1; padding: 0.8rem; border: 1px solid #e0e7ff; border-radius: 8px; font-size: 0.95rem;">
            <button type="button" onclick="validateDiscount({{ $product->id }})" class="btn-store" style="padding: 0.8rem 1.5rem; font-size: 0.95rem; white-space: nowrap;">تطبيق</button>
          </div>
          <div class="discount-message-{{ $product->id }}" style="font-size: 0.85rem; min-height: 20px;"></div>
        </div>

        <!-- عرض الخصومات العامة المتاحة -->
        @if($generalDiscounts->count() > 0)
          <div style="background: #e0f2fe; padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem; text-align: center;">
            <p style="font-size: 0.9rem; color: #0369a1; font-weight: 600; margin: 0;">كود عام متاح: 
              <span style="color: #0284c7; font-weight: 700;">{{ $generalDiscounts->first()->code }}</span>
              - خصم {{ $generalDiscounts->first()->percentage }}%
            </p>
          </div>
        @endif

        <div style="color: #94a3b8; font-weight: 600; margin-bottom: 2rem;">📦 المخزون: {{ $product->stock }}</div>
        
        <a href="https://wa.me/963982617848?text=مرحبا، أريد طلب {{ $product->name }} بسعر {{ $product->price }}ل.س" class="whatsapp-buy" id="whatsapp-{{ $product->id }}">
          💬 اطلب الان
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

<script>
let appliedDiscounts = {};

function validateDiscount(productId) {
    const code = document.querySelector('.discount-code-input-' + productId).value.trim();
    const messageEl = document.querySelector('.discount-message-' + productId);
    
    if (!code) {
        messageEl.innerHTML = '<span style="color: #ef4444;">أدخل كود صحيح</span>';
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
            updateProductPrice(productId, data.percentage);
            messageEl.innerHTML = '<span style="color: #22c55e; font-weight: 700;">✓ تم تطبيق الخصم! ' + data.percentage + '%</span>';
            updateWhatsAppLink(productId);
        } else {
            delete appliedDiscounts[productId];
            messageEl.innerHTML = '<span style="color: #ef4444;">✗ ' + data.message + '</span>';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        messageEl.innerHTML = '<span style="color: #ef4444;">حدث خطأ، حاول لاحقاً</span>';
    });
}

function updateProductPrice(productId, discountPercentage) {
    const priceElement = document.querySelector('.discounted-price-' + productId);
    const originalPriceElement = document.querySelector('.original-price-' + productId);
    
    // الحصول على السعر الأصلي من النص
    const originalPrice = parseFloat(
        originalPriceElement.textContent
            .replace(/[^\d.]/g, '')
            .split(' ')[0]
    );
    
    const discountAmount = (originalPrice * discountPercentage) / 100;
    const finalPrice = originalPrice - discountAmount;
    
    if (priceElement) {
        priceElement.textContent = Math.round(finalPrice).toLocaleString() + ' ل.س';
        priceElement.style.color = '#22c55e';
    } else {
        // إنشاء عنصر السعر المخفض إذا لم يكن موجود
        const newPriceEl = document.createElement('div');
        newPriceEl.className = 'discounted-price-' + productId;
        newPriceEl.style.cssText = 'font-size: 1.3rem; color: #22c55e; font-weight: 700;';
        newPriceEl.textContent = Math.round(finalPrice).toLocaleString() + ' ل.س';
        originalPriceElement.parentNode.insertBefore(newPriceEl, originalPriceElement.nextSibling);
    }
}

function updateWhatsAppLink(productId) {
    const whatsappLink = document.querySelector('#whatsapp-' + productId);
    const code = document.querySelector('.discount-code-input-' + productId).value;
    const discount = appliedDiscounts[productId];
    
    if (discount) {
        whatsappLink.href = `https://wa.me/963982617848?text=مرحبا، أريد طلب المنتج برقم ${productId} مع تطبيق الكود ${code} (خصم ${discount.percentage}%)`;
    }
}

// allow enter key to apply discount
document.querySelectorAll('[class*="discount-code-input-"]').forEach(input => {
    input.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            const productId = this.className.match(/\d+/)[0];
            validateDiscount(productId);
        }
    });
});
</script>
@endsection

