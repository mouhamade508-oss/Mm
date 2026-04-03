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

/* Flash Sale Animations */
@keyframes flashPulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.02); }
}

.flash-sale-card {
    animation: flashPulse 2s ease-in-out infinite;
}

.flash-sale-card:hover {
    animation: flashPulse 1s ease-in-out infinite;
}

/* Bundle Animations */
@keyframes bundleGlow {
    0%, 100% { box-shadow: 0 10px 30px rgba(124, 58, 237, 0.3); }
    50% { box-shadow: 0 10px 40px rgba(124, 58, 237, 0.5); }
}

.bundle-card {
    animation: bundleGlow 3s ease-in-out infinite;
}

.bundle-card:hover {
    animation: bundleGlow 1.5s ease-in-out infinite;
}
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

  <!-- Flash Sales & Bundles -->
  @if($activeFlashSales->count() > 0 || $activeBundles->count() > 0)
  <section class="offers-section" style="background: linear-gradient(135deg, #fef3c7, #fde68a); padding: 3rem; border-radius: var(--card-radius); margin-bottom: 3rem; box-shadow: 0 10px 30px rgba(245, 158, 11, 0.2);">
    <h2 style="text-align: center; font-size: 2.5rem; font-weight: 900; margin-bottom: 2rem; color: #92400e;">⚡ عروض محدودة الوقت</h2>

    <!-- Flash Sales -->
    @if($activeFlashSales->count() > 0)
    <div style="margin-bottom: 3rem;">
      <h3 style="font-size: 1.8rem; font-weight: 700; margin-bottom: 1.5rem; color: #dc2626;">🔥 عروض فلاش</h3>
      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
        @foreach($activeFlashSales as $flashSale)
        <div class="card-modern flash-sale-card" style="background: linear-gradient(135deg, #fee2e2, #fecaca); border: 2px solid #dc2626; position: relative; overflow: visible;">
          <!-- Timer Badge -->
          <div class="flash-timer" id="timer-{{ $flashSale->id }}" style="position: absolute; top: -10px; right: -10px; background: #dc2626; color: white; padding: 0.5rem 1rem; border-radius: 20px; font-weight: 700; font-size: 0.9rem; z-index: 10; box-shadow: 0 4px 12px rgba(220, 38, 38, 0.4);">
            ⏰ ينتهي خلال: <span class="time-left">جاري الحساب...</span>
          </div>

          <div class="image-container" style="height: 200px; background: linear-gradient(135deg, #fef3c7, #fde68a); display: flex; align-items: center; justify-content: center;">
            @if($flashSale->product->image)
              <img src="{{ $flashSale->product->image_url }}" alt="{{ $flashSale->product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
            @else
              <div style="font-size: 3rem; opacity: 0.5;">🛍️</div>
            @endif
          </div>

          <div class="card-body" style="padding: 2rem;">
            <h4 style="font-size: 1.4rem; font-weight: 800; margin-bottom: 1rem; color: #dc2626;">{{ $flashSale->name }}</h4>
            <p style="color: #7f1d1d; margin-bottom: 1rem; font-weight: 600;">{{ Str::limit($flashSale->description, 80) }}</p>

            <div style="margin-bottom: 1.5rem;">
              <div style="font-size: 1.8rem; font-weight: 900; color: #dc2626; margin-bottom: 0.5rem;">
                {{ number_format($flashSale->sale_price, 0) }} <span style="font-size: 0.6em;">ل.س</span>
              </div>
              <div style="font-size: 1.2rem; color: #9ca3af; text-decoration: line-through;">
                {{ number_format($flashSale->original_price, 0) }} ل.س
              </div>
              <div style="font-size: 1rem; color: #059669; font-weight: 700;">
                خصم {{ $flashSale->discount_percentage }}%
              </div>
            </div>

            <a href="https://wa.me/963982617848?text=مرحبا، أريد شراء {{ $flashSale->product->name }} من عرض الفلاش بسعر {{ $flashSale->sale_price }}ل.س" class="whatsapp-buy" style="background: linear-gradient(135deg, #dc2626, #b91c1c);">
              🛒 اطلب الآن - عرض محدود!
            </a>
          </div>
        </div>
        @endforeach
      </div>
    </div>
    @endif

    <!-- Bundles -->
    @if($activeBundles->count() > 0)
    <div>
      <h3 style="font-size: 1.8rem; font-weight: 700; margin-bottom: 1.5rem; color: #7c3aed;">📦 عروض الباقات</h3>
      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 2rem;">
        @foreach($activeBundles as $bundle)
        <div class="card-modern bundle-card" style="background: linear-gradient(135deg, #e9d5ff, #d8b4fe); border: 2px solid #7c3aed;">
          <div class="image-container" style="height: 200px; background: linear-gradient(135deg, #f3e8ff, #e9d5ff); display: flex; align-items: center; justify-content: center;">
            @if($bundle->image)
              <img src="{{ Storage::url($bundle->image) }}" alt="{{ $bundle->name }}" style="width: 100%; height: 100%; object-fit: cover;">
            @else
              <div style="font-size: 3rem; opacity: 0.5;">📦</div>
            @endif
          </div>

          <div class="card-body" style="padding: 2rem;">
            <h4 style="font-size: 1.4rem; font-weight: 800; margin-bottom: 1rem; color: #7c3aed;">{{ $bundle->name }}</h4>
            <p style="color: #6b21a8; margin-bottom: 1rem; font-weight: 600;">{{ Str::limit($bundle->description, 100) }}</p>

            <!-- Products in bundle -->
            <div style="margin-bottom: 1.5rem;">
              <p style="font-size: 0.9rem; color: #6b21a8; font-weight: 600; margin-bottom: 0.5rem;">المنتجات في الباقة:</p>
              <ul style="list-style: none; padding: 0; margin: 0;">
                @foreach($bundle->bundleProducts as $bundleProduct)
                <li style="font-size: 0.85rem; color: #6b21a8; margin-bottom: 0.3rem;">
                  • {{ $bundleProduct->product->name }} (×{{ $bundleProduct->quantity }})
                </li>
                @endforeach
              </ul>
            </div>

            <div style="margin-bottom: 1.5rem;">
              <div style="font-size: 1.8rem; font-weight: 900; color: #7c3aed; margin-bottom: 0.5rem;">
                {{ number_format($bundle->bundle_price, 0) }} <span style="font-size: 0.6em;">ل.س</span>
              </div>
              <div style="font-size: 1.2rem; color: #9ca3af; text-decoration: line-through;">
                {{ number_format($bundle->original_price, 0) }} ل.س
              </div>
              <div style="font-size: 1rem; color: #059669; font-weight: 700;">
                توفير {{ number_format($bundle->getSavings(), 0) }} ل.س ({{ $bundle->discount_percentage }}%)
              </div>
            </div>

            <a href="https://wa.me/963982617848?text=مرحبا، أريد شراء باقة {{ $bundle->name }} بسعر {{ $bundle->bundle_price }}ل.س" class="whatsapp-buy" style="background: linear-gradient(135deg, #7c3aed, #6d28d9);">
              🛒 اطلب الباقة الآن
            </a>
          </div>
        </div>
        @endforeach
      </div>
    </div>
    @endif
  </section>
  @endif

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
        
        <div style="display: flex; gap: 1rem; margin-bottom: 1.5rem;">
          <button type="button" onclick="openQuickView({{ $product->id }})" class="btn-store" style="flex: 1; background: linear-gradient(135deg, #3b82f6, #1d4ed8); padding: 1rem;">
            👁️ عرض سريع
          </button>
          <a href="https://wa.me/963982617848?text=مرحبا، أريد طلب {{ $product->name }} بسعر {{ $product->price }}ل.س" class="whatsapp-buy" id="whatsapp-{{ $product->id }}" style="flex: 2;">
            💬 اطلب الان
          </a>
        </div>
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

  <!-- Quick View Modal -->
  <div id="quick-view-modal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.7); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 24px; max-width: 600px; width: 90%; max-height: 90vh; overflow-y: auto; position: relative; box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);">
      <!-- Close Button -->
      <button type="button" onclick="closeQuickView()" style="position: absolute; top: 1.5rem; right: 1.5rem; background: #f3f4f6; border: none; width: 40px; height: 40px; border-radius: 50%; cursor: pointer; font-size: 1.5rem; z-index: 10000; transition: all 0.3s;">✕</button>

      <!-- Modal Content -->
      <div id="quick-view-content" style="padding: 2.5rem;">
        <div style="text-align: center; padding: 3rem;">
          <div style="font-size: 3rem; margin-bottom: 1rem; animation: spin 2s linear infinite;">⏳</div>
          <p style="color: #64748b; font-size: 1.1rem;">جاري تحميل المنتج...</p>
        </div>
      </div>
    </div>
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

// ============ Quick View Functions ============
function openQuickView(productId) {
    const modal = document.getElementById('quick-view-modal');
    const content = document.getElementById('quick-view-content');
    
    modal.style.display = 'flex';
    content.innerHTML = '<div style="text-align: center; padding: 3rem;"><div style="font-size: 3rem; margin-bottom: 1rem; animation: spin 2s linear infinite;">⏳</div><p style="color: #64748b; font-size: 1.1rem;">جاري تحميل المنتج...</p></div>';
    
    fetch(`/api/quick-view/${productId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const product = data.product;
                let html = `
                    <div style="margin-bottom: 2rem;">
                        <div style="background: linear-gradient(135deg, #eff6ff, #dbeafe); border-radius: 16px; height: 300px; display: flex; align-items: center; justify-content: center; overflow: hidden; margin-bottom: 1.5rem;">
                            ${product.image_url ? `<img src="${product.image_url}" alt="${product.name}" style="width: 100%; height: 100%; object-fit: cover;">` : '<div style="font-size: 4rem; opacity: 0.5;">🛍️</div>'}
                        </div>
                        
                        <h2 style="font-size: 1.8rem; font-weight: 900; margin-bottom: 1rem; color: #0f172a;">${product.name}</h2>
                        
                        <p style="color: #64748b; margin-bottom: 1.5rem; line-height: 1.8;">${product.description}</p>
                        
                        <div style="margin-bottom: 1.5rem;">
                            <div style="font-size: 2rem; font-weight: 900; background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #60a5fa 100%); -webkit-background-clip: text; margin-bottom: 0.5rem;">
                                ${product.price.toLocaleString()} <span style="font-size: 0.5em;">ل.س</span>
                            </div>
                            ${product.discount ? `<div style="font-size: 1.3rem; color: #22c55e; font-weight: 700;">السعر بعد الخصم: ${product.discount.final_price.toLocaleString()} ل.س (-${product.discount.percentage}%)</div>` : ''}
                        </div>
                        
                        <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 12px; margin-bottom: 1.5rem;">
                            <p style="margin: 0.5rem 0; color: #475569;"><strong>📦 المخزون:</strong> ${product.stock} وحدة</p>
                            <p style="margin: 0.5rem 0; color: #475569;"><strong>📂 الفئة:</strong> ${product.category}</p>
                            <p style="margin: 0.5rem 0; color: #475569;"><strong>🔖 حالة:</strong> ${product.active ? '<span style="color: #22c55e;">✓ متاح</span>' : '<span style="color: #ef4444;">✗ غير متاح</span>'}</p>
                        </div>
                        
                        <a href="https://wa.me/963982617848?text=مرحبا، أريد طلب ${product.name} بسعر ${product.price}ل.س" style="background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); color: white; text-decoration: none; padding: 1.2rem; border-radius: 16px; font-weight: 800; text-align: center; display: block; box-shadow: 0 15px 35px rgba(34,197,94,0.4); transition: all 0.4s;">
                            💬 اطلب الآن عبر WhatsApp
                        </a>
                    </div>
                `;
                content.innerHTML = html;
            }
        })
        .catch(err => {
            console.error(err);
            content.innerHTML = '<div style="text-align: center; padding: 3rem; color: #ef4444;"><p>حدث خطأ في تحميل المنتج</p></div>';
        });
}

function closeQuickView() {
    const modal = document.getElementById('quick-view-modal');
    modal.style.display = 'none';
}

// Close modal when clicking outside
document.getElementById('quick-view-modal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeQuickView();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeQuickView();
    }
});

// ============ Flash Sale Countdown Timers ============
function updateCountdownTimers() {
    @if($activeFlashSales->count() > 0)
    @foreach($activeFlashSales as $flashSale)
    const timerElement = document.getElementById('timer-{{ $flashSale->id }}');
    if (timerElement) {
        const endTime = new Date('{{ $flashSale->end_at->toISOString() }}').getTime();
        const now = new Date().getTime();
        const distance = endTime - now;

        if (distance > 0) {
            const hours = Math.floor(distance / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            const timeLeftElement = timerElement.querySelector('.time-left');
            if (timeLeftElement) {
                timeLeftElement.textContent = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            }
        } else {
            timerElement.innerHTML = '⏰ انتهى العرض';
            timerElement.style.background = '#6b7280';
        }
    }
    @endforeach
    @endif
}

// Update timers every second
setInterval(updateCountdownTimers, 1000);
updateCountdownTimers(); // Initial call
</script>
@endsection

