@extends('layouts.pro-store')

@section('content')
<style>
:root {
  --orange-theme: linear-gradient(135deg, #ea580c 0%, #f97316 50%, #fb923c 100%);
  --orange-glow: 0 25px 50px rgba(249, 115, 22, 0.4);
}

.product-detail {
  max-width: 900px;
  margin: 0 auto;
  background: white;
  border-radius: 28px;
  box-shadow: var(--orange-glow);
  overflow: hidden;
}

.product-detail-content {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 3rem;
  padding: 3rem;
}

@media (max-width: 768px) {
  .product-detail-content {
    grid-template-columns: 1fr;
    gap: 2rem;
  }
}

.product-image-container {
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
  border-radius: 20px;
  height: 400px;
}

.product-image-container img {
  max-width: 100%;
  max-height: 100%;
  object-fit: contain;
}

.product-image-container.empty {
  font-size: 5rem;
}

.product-info h1 {
  font-size: 2.5rem;
  font-weight: 900;
  color: #1e293b;
  margin-bottom: 1.5rem;
}

.product-info .price {
  font-size: 3rem;
  font-weight: 900;
  color: #ea580c;
  margin-bottom: 1.5rem;
}

.product-info .description {
  font-size: 1.1rem;
  color: #64748b;
  line-height: 1.8;
  margin-bottom: 2rem;
}

.order-section {
  background: #f3f4f6;
  padding: 2rem;
  border-radius: 20px;
  margin-top: 2rem;
}

.input-modern {
  width: 100%;
  padding: 1.2rem;
  border: 2px solid #e0e7ff;
  border-radius: 20px;
  font-size: 1rem;
  font-family: 'Tajawal', sans-serif;
  margin-bottom: 1rem;
}

.input-modern:focus {
  border-color: #ea580c;
  box-shadow: 0 0 0 4px rgba(234, 88, 12, 0.15);
  outline: none;
}

.whatsapp-btn-large {
  background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
  color: white;
  padding: 1.5rem;
  border: none;
  border-radius: 20px;
  font-weight: 800;
  font-size: 1.1rem;
  cursor: pointer;
  width: 100%;
  box-shadow: 0 15px 35px rgba(34, 197, 94, 0.4);
  transition: all 0.4s ease;
}

.whatsapp-btn-large:hover {
  transform: translateY(-4px);
  box-shadow: 0 25px 50px rgba(34, 197, 94, 0.5);
}

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

.quantity-selector {
  display: flex;
  align-items: center;
  gap: 1rem;
}

.quantity-btn {
  background: white;
  border: 2px solid #e0e7ff;
  width: 50px;
  height: 50px;
  border-radius: 12px;
  font-weight: 800;
  font-size: 1.2rem;
  cursor: pointer;
  transition: all 0.3s ease;
}

.quantity-btn:hover {
  background: #ea580c;
  color: white;
  border-color: #ea580c;
}

.quantity-input {
  width: 80px;
  text-align: center;
  font-weight: 800;
  font-size: 1.2rem;
  border: none;
  background: transparent;
}

.total-price-box {
  background: var(--orange-theme);
  color: white;
  padding: 1.5rem;
  border-radius: 20px;
  text-align: center;
  margin: 1rem 0;
}

.total-price-label {
  font-size: 0.9rem;
  opacity: 0.9;
  margin-bottom: 0.5rem;
}

.total-price-value {
  font-size: 2rem;
  font-weight: 900;
}
</style>

<div class="py-4" style="max-width: 1200px; margin: 0 auto;">
  <a href="{{ route('electronics.index') }}" class="back-link">← العودة للمنتجات الإلكترونية</a>

  <div class="product-detail">
    <div class="product-detail-content">
      <!-- Product Image -->
      <div class="product-image-container{{ ! $product->image ? ' empty' : '' }}">
        @if($product->image)
          <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
        @else
          <span>⚙️</span>
        @endif
      </div>

      <!-- Product Info -->
      <div class="product-info">
        <h1>{{ $product->name }}</h1>
        <div class="price">{{ number_format($product->price, 2) }}دولار</div>
        
        <div class="description">
          {{ $product->description }}
        </div>

        <!-- WhatsApp Order Form -->
        <div class="order-section">
          <h3 style="font-weight: 800; margin-bottom: 1.5rem; color: #1e293b;">📱 اطلب عبر WhatsApp</h3>
          
          <form id="whatsappOrderForm" onsubmit="submitOrder(event)">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">

            <div>
              <label style="display: block; font-weight: 700; margin-bottom: 0.5rem; color: #1e293b;">اسمك</label>
              <input type="text" name="customer_name" required class="input-modern" placeholder="أدخل اسمك الكامل">
            </div>

            <div>
              <label style="display: block; font-weight: 700; margin-bottom: 0.5rem; color: #1e293b;">رقم الهاتف مع رمز الدولة</label>
              <input type="tel" name="customer_phone" required class="input-modern" placeholder="+966501234567">
            </div>

            <div>
              <label style="display: block; font-weight: 700; margin-bottom: 0.5rem; color: #1e293b;">الكمية</label>
              <div class="quantity-selector">
                <button type="button" class="quantity-btn" onclick="decreaseQuantity()">−</button>
                <input type="number" id="quantity" name="quantity" value="1" min="1" class="quantity-input" onchange="updateTotal()">
                <button type="button" class="quantity-btn" onclick="increaseQuantity()">+</button>
              </div>
            </div>

            <div class="total-price-box">
              <div class="total-price-label">الإجمالي:</div>
              <div class="total-price-value" id="totalPrice">{{ number_format($product->price, 2) }}دولار</div>
            </div>

            <button type="submit" class="whatsapp-btn-large">📱 إرسال الطلب عبر WhatsApp</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
const productPrice = {{ $product->price }};

function increaseQuantity() {
  const input = document.getElementById('quantity');
  input.value = parseInt(input.value) + 1;
  updateTotal();
}

function decreaseQuantity() {
  const input = document.getElementById('quantity');
  if (parseInt(input.value) > 1) {
    input.value = parseInt(input.value) - 1;
    updateTotal();
  }
}

function updateTotal() {
  const quantity = parseInt(document.getElementById('quantity').value) || 1;
  const total = productPrice * quantity;
  document.getElementById('totalPrice').textContent = total.toFixed(2) + 'دولار';
}

function submitOrder(event) {
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
      window.open(data.whatsapp_link, '_blank');
    } else {
      alert('خطأ: ' + (data.error || 'حدث خطأ ما'));
    }
  })
  .catch(error => {
    console.error('Error:', error);
    alert('حدث خطأ في إرسال الطلب');
  });
}
</script>
@endsection
