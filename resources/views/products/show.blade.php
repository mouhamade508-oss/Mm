@extends('layouts.pro-store')

@section('meta_title', $product->name . ' - ' . config('app.name', 'MHD Print Lab'))

@section('meta_description', Str::limit(strip_tags($product->description ?? $product->name), 160, '...'))

@section('meta_keywords', $product->category?->name . ', ' . $product->name . ', طباعة')

@section('meta_canonical', route('product.show', $product))

@push('meta')
<script type="application/ld+json">
{
    "@@context": "https://schema.org/",
    "@@type": "Product",
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
        "price": "{{ number_format((float) $product->price, 2, '.', '') }}",
        "availability": "{{ $product->stock > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock' }}",
        "itemCondition": "https://schema.org/NewCondition"
    }
}
</script>
@endpush

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&family=Cairo:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
@endpush

@section('content')
<div class="loading-overlay" id="loading-overlay">MHD</div>

{{-- Discount Notification Bar --}}
@if($generalDiscounts->count() > 0)
<div id="discount-notification-bar" class="discount-notification-bar">
    <div class="discount-notification-content">
        <div class="discount-notification-icon">
            🎁
        </div>
        <div class="discount-notification-text">
            <strong>عرض خاص!</strong>
            @if($generalDiscounts->count() === 1)
                خصم {{ $generalDiscounts->first()->percentage }}% على جميع المنتجات - استفد من العرض الآن!
            @else
                عروض خاصة متاحة - خصومات تصل إلى {{ $generalDiscounts->max('percentage') }}%!
            @endif
        </div>
        <div class="discount-notification-actions">
            <button onclick="scrollToDiscount()" class="discount-notification-btn">
                استفد الآن
            </button>
            <button onclick="closeNotification()" class="discount-notification-close">
                ✕
            </button>
        </div>
    </div>
</div>
@endif

<style>
/* Discount Notification Bar */
.discount-notification-bar {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
  color: white;
  padding: 0.8rem 1rem;
  box-shadow: 0 4px 20px rgba(255, 107, 107, 0.3);
  z-index: 1000;
  transform: translateY(0);
  transition: transform 0.3s ease;
  border-bottom: 3px solid #d63031;
}

.discount-notification-bar.hidden {
  transform: translateY(-100%);
}

.discount-notification-content {
  display: flex;
  align-items: center;
  justify-content: space-between;
  max-width: 1200px;
  margin: 0 auto;
  gap: 1rem;
  flex-wrap: wrap;
}

.discount-notification-icon {
  font-size: 1.5rem;
  animation: bounce 2s infinite;
}

@keyframes bounce {
  0%, 20%, 50%, 80%, 100% {
    transform: translateY(0);
  }
  40% {
    transform: translateY(-5px);
  }
  60% {
    transform: translateY(-3px);
  }
}

.discount-notification-text {
  flex: 1;
  font-size: 1rem;
  font-weight: 600;
  text-align: center;
}

.discount-notification-text strong {
  color: #ffeaa7;
  font-size: 1.1rem;
}

.discount-notification-actions {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.discount-notification-btn {
  background: rgba(255, 255, 255, 0.2);
  color: white;
  border: 2px solid rgba(255, 255, 255, 0.3);
  padding: 0.4rem 1rem;
  border-radius: 20px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  font-size: 0.9rem;
}

.discount-notification-btn:hover {
  background: white;
  color: #ff6b6b;
  transform: scale(1.05);
}

.discount-notification-close {
  background: none;
  border: none;
  color: white;
  font-size: 1.2rem;
  cursor: pointer;
  padding: 0.2rem;
  border-radius: 50%;
  width: 30px;
  height: 30px;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: background-color 0.3s ease;
}

.discount-notification-close:hover {
  background: rgba(255, 255, 255, 0.2);
}

@media (max-width: 768px) {
  .discount-notification-content {
    flex-direction: column;
    text-align: center;
    gap: 0.5rem;
  }

  .discount-notification-text {
    font-size: 0.9rem;
  }

  .discount-notification-actions {
    justify-content: center;
  }
}

:root {
  --blue-hero: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #60a5fa 100%);
  --blue-glow: 0 25px 50px rgba(59,130,246,0.4);
  --card-radius: 24px;
  --whatsapp-green: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
  --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
  --accent-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
  --text-primary: #1e293b;
  --text-secondary: #64748b;
  --bg-light: #f8fafc;
  --shadow-soft: 0 10px 30px rgba(0,0,0,0.1);
  --shadow-strong: 0 20px 60px rgba(0,0,0,0.15);
}

* {
  font-family: 'Tajawal', sans-serif;
}

.product-detail-hero {
  background: var(--primary-gradient);
  color: white;
  text-align: center;
  padding: clamp(2rem, 5vw, 4rem) 1rem;
  border-radius: 0 0 var(--card-radius) var(--card-radius);
  box-shadow: var(--shadow-strong);
  margin-bottom: clamp(2rem, 5vw, 4rem);
}

.product-detail-hero h1 {
  font-size: clamp(1.5rem, 4vw, 2.5rem);
  font-weight: 900;
  font-family: 'Cairo', sans-serif;
  margin-bottom: 1rem;
  text-shadow: 0 2px 4px rgba(0,0,0,0.3);
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
  box-shadow: var(--shadow-soft);
  border: 1px solid rgba(0,0,0,0.05);
}

.product-main-image {
  width: 100%;
  height: clamp(300px, 50vw, 500px);
  background: var(--accent-gradient);
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
}

.product-main-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.3s ease;
}

.product-main-image:hover img {
  transform: scale(1.05);
}

.related-product-image:empty::before,
.product-main-image:empty::before {
  content: 'MHD';
  font-size: clamp(2rem, 5vw, 4rem);
  opacity: 0.6;
  font-weight: 900;
  color: #1e3a8a;
}

.product-info-section {
  background: white;
  border-radius: var(--card-radius);
  padding: clamp(2rem, 4vw, 3rem);
  box-shadow: var(--shadow-soft);
  display: flex;
  flex-direction: column;
  position: relative;
  border: 1px solid rgba(0,0,0,0.05);
}

.product-title {
  font-size: clamp(1.8rem, 4vw, 2.5rem);
  font-weight: 900;
  font-family: 'Cairo', sans-serif;
  color: var(--text-primary);
  margin-bottom: 1rem;
  line-height: 1.2;
}

.product-description {
  color: var(--text-secondary);
  line-height: 1.7;
  margin-bottom: 2rem;
  font-size: clamp(1rem, 2vw, 1.2rem);
  font-weight: 400;
}

.product-price-section {
  margin-bottom: 2rem;
}

.product-price {
  font-size: clamp(2rem, 4vw, 2.8rem);
  font-weight: 900;
  background: var(--primary-gradient);
  -webkit-background-clip: text;
  background-clip: text;
  color: transparent;
  margin-bottom: 0.5rem;
  font-family: 'Cairo', sans-serif;
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

.discount-badge {
  position: absolute;
  top: 20px;
  right: 20px;
  background: var(--secondary-gradient);
  color: white;
  padding: 0.8rem 1.2rem;
  border-radius: 12px;
  font-weight: 700;
  font-size: 0.9rem;
  box-shadow: 0 10px 25px rgba(245,87,108,0.3);
  font-family: 'Cairo', sans-serif;
}

.digital-badge {
  position: absolute;
  top: 20px;
  left: 20px;
  background: var(--accent-gradient);
  color: white;
  padding: 0.5rem 1rem;
  border-radius: 12px;
  font-weight: 700;
  font-size: 0.8rem;
  box-shadow: 0 10px 25px rgba(79,172,254,0.3);
  font-family: 'Cairo', sans-serif;
}

.discount-section {
  background: var(--bg-light);
  padding: 1.5rem;
  border-radius: 16px;
  margin-bottom: 2rem;
  border: 2px dashed #3b82f6;
  box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);
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
  transition: border-color 0.3s ease;
}

.discount-input-group input:focus {
  outline: none;
  border-color: #3b82f6;
  box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
}

.discount-input-group button {
  padding: 0.8rem 1.5rem;
  background: var(--primary-gradient);
  color: white;
  border: none;
  border-radius: 8px;
  font-weight: 600;
  cursor: pointer;
  font-size: 0.9rem;
  position: relative;
  overflow: hidden;
  transition: transform 0.3s ease;
}

.discount-msg {
  font-size: 0.9rem;
  min-height: 20px;
  color: #64748b;
}

.discount-progress-bar {
  width: 100%;
  height: 12px;
  background: linear-gradient(90deg, #e0e7ff, #f0f4ff);
  border-radius: 8px;
  overflow: hidden;
  margin-top: 1rem;
  display: none;
  box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);
  position: relative;
}

.discount-progress-bar::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: url('data:image/svg+xml,<svg width="4" height="4" xmlns="http://www.w3.org/2000/svg"><circle cx="2" cy="2" r="1" fill="%23dbeafe" opacity="0.5"/></svg>');
  background-size: 4px 4px;
  z-index: 1;
}

.discount-progress-fill {
  height: 100%;
  background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
  border-radius: 8px;
  transition: width 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
  position: relative;
  box-shadow: 0 0 20px rgba(102, 126, 234, 0.5);
  overflow: hidden;
}

.discount-progress-fill::after {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
  animation: shimmer 2s infinite;
}

@keyframes shimmer {
  0% { transform: translateX(-100%); }
  100% { transform: translateX(100%); }
}

.discount-percentage-label {
  position: absolute;
  top: -25px;
  left: 0;
  color: #667eea;
  font-weight: 700;
  font-size: 0.85rem;
  font-family: 'Cairo', sans-serif;
  opacity: 0;
  transition: opacity 0.3s ease;
}

.general-discount-box {
  background: linear-gradient(135deg, #e0f2fe, #f0f9ff);
  padding: 1rem;
  border-radius: 8px;
  margin-bottom: 2rem;
  text-align: center;
  border: 1px solid rgba(59,130,246,0.2);
}

.general-discount-box span {
  color: #0369a1;
  font-weight: 600;
  font-family: 'Cairo', sans-serif;
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
  position: relative;
  overflow: hidden;
  font-family: 'Cairo', sans-serif;
}

.whatsapp-btn:hover {
  transform: translateY(-3px);
  box-shadow: 0 20px 40px rgba(37,211,102,0.5);
}

.ripple {
  position: relative;
  overflow: hidden;
}

.ripple::before {
  content: '';
  position: absolute;
  top: 50%;
  left: 50%;
  width: 0;
  height: 0;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.5);
  transform: translate(-50%, -50%);
  transition: width 0.6s, height 0.6s;
}

.ripple:active::before {
  width: 300px;
  height: 300px;
}

.share-btn {
  width: 100%;
  background: var(--accent-gradient);
  color: white;
  text-decoration: none;
  padding: 1.2rem;
  border-radius: 16px;
  font-weight: 700;
  font-size: 1.1rem;
  text-align: center;
  display: block;
  box-shadow: 0 10px 30px rgba(79,172,254,0.4);
  transition: all 0.3s ease;
  border: none;
  cursor: pointer;
  position: relative;
  overflow: hidden;
  font-family: 'Cairo', sans-serif;
  margin-top: 1rem;
}

.share-btn:hover {
  transform: translateY(-3px);
  box-shadow: 0 20px 40px rgba(79,172,254,0.5);
}

/* Share Modal Styles */
.share-modal {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  z-index: 10000;
  justify-content: center;
  align-items: center;
  backdrop-filter: blur(4px);
  animation: fadeIn 0.3s ease;
}

.share-modal.active {
  display: flex;
}

.share-modal-content {
  background: white;
  border-radius: 24px;
  padding: clamp(2rem, 4vw, 3rem);
  max-width: 400px;
  width: 90%;
  box-shadow: 0 25px 60px rgba(0,0,0,0.3);
  position: relative;
  animation: slideUp 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
}

@keyframes slideUp {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.share-modal-header {
  text-align: center;
  margin-bottom: 2rem;
}

.share-modal-header h3 {
  font-size: 1.5rem;
  font-weight: 900;
  font-family: 'Cairo', sans-serif;
  color: #1e293b;
  margin: 0;
}

.share-modal-header p {
  color: #64748b;
  font-size: 0.95rem;
  margin-top: 0.5rem;
}

.close-share-modal {
  position: absolute;
  top: 1rem;
  right: 1rem;
  background: #f1f5f9;
  border: none;
  width: 36px;
  height: 36px;
  border-radius: 50%;
  cursor: pointer;
  font-size: 1.5rem;
  color: #64748b;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  justify-content: center;
}

.close-share-modal:hover {
  background: #e2e8f0;
  color: #1e293b;
}

.share-buttons-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1rem;
}

.share-btn-item {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 0.8rem;
  padding: 1.5rem;
  border-radius: 16px;
  background: #f8fafc;
  border: 2px solid transparent;
  cursor: pointer;
  transition: all 0.3s ease;
  text-decoration: none;
  color: inherit;
}

.share-btn-item:hover {
  border-color: currentColor;
  transform: translateY(-4px);
}

.share-btn-item svg {
  width: 32px;
  height: 32px;
}

.share-btn-item-text {
  font-size: 0.9rem;
  font-weight: 600;
  font-family: 'Cairo', sans-serif;
  text-align: center;
}

.share-whatsapp {
  color: #25D366;
}

.share-whatsapp:hover {
  background: rgba(37, 211, 102, 0.1);
}

.share-facebook {
  color: #1877F2;
}

.share-facebook:hover {
  background: rgba(24, 119, 242, 0.1);
}

.share-twitter {
  color: #1DA1F2;
}

.share-twitter:hover {
  background: rgba(29, 161, 242, 0.1);
}

.share-telegram {
  color: #0088cc;
}

.share-telegram:hover {
  background: rgba(0, 136, 204, 0.1);
}

.share-linkedin {
  color: #0A66C2;
}

.share-linkedin:hover {
  background: rgba(10, 102, 194, 0.1);
}

.share-copy-link {
  color: #8b5cf6;
}

.share-copy-link:hover {
  background: rgba(139, 92, 246, 0.1);
}

.copy-success-message {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background: white;
  padding: 1.5rem 2rem;
  border-radius: 12px;
  box-shadow: 0 10px 25px rgba(0,0,0,0.2);
  z-index: 10001;
  font-family: 'Cairo', sans-serif;
  animation: slideUp 0.4s ease;
}

/* Countdown Timer Styles */
.countdown-banner {
  background: linear-gradient(135deg, #f5576c 0%, #f093fb 100%);
  color: white;
  padding: 1.5rem;
  border-radius: 16px;
  margin-bottom: 2rem;
  box-shadow: 0 10px 35px rgba(245, 87, 108, 0.3);
  border: 1px solid rgba(255, 255, 255, 0.2);
  animation: slideDown 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
  position: relative;
  overflow: hidden;
}

.countdown-banner::before {
  content: '';
  position: absolute;
  top: -50%;
  left: -50%;
  width: 200%;
  height: 200%;
  background: linear-gradient(
    45deg,
    transparent 30%,
    rgba(255, 255, 255, 0.1) 50%,
    transparent 70%
  );
  animation: shine 3s infinite;
}

@keyframes slideDown {
  from {
    opacity: 0;
    transform: translateY(-20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes shine {
  0% {
    transform: translateX(-100%) translateY(-100%) rotate(45deg);
  }
  100% {
    transform: translateX(100%) translateY(100%) rotate(45deg);
  }
}

.countdown-content {
  position: relative;
  z-index: 2;
  display: grid;
  grid-template-columns: auto 1fr;
  gap: 1.5rem;
  align-items: center;
}

.countdown-icon {
  font-size: 2.5rem;
  animation: pulse 1.5s ease-in-out infinite;
}

@keyframes pulse {
  0%, 100% {
    transform: scale(1);
  }
  50% {
    transform: scale(1.1);
  }
}

.countdown-text h3 {
  font-size: 1.3rem;
  font-weight: 900;
  font-family: 'Cairo', sans-serif;
  margin: 0 0 0.5rem 0;
  color: white;
  text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.countdown-text p {
  font-size: 0.9rem;
  opacity: 0.95;
  margin: 0;
  color: rgba(255, 255, 255, 0.95);
}

.countdown-timer {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 0.8rem;
}

.countdown-unit {
  background: rgba(255, 255, 255, 0.2);
  backdrop-filter: blur(10px);
  padding: 1rem 0.6rem;
  border-radius: 12px;
  text-align: center;
  border: 1px solid rgba(255, 255, 255, 0.3);
  transition: all 0.3s ease;
}

.countdown-unit:hover {
  background: rgba(255, 255, 255, 0.3);
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.countdown-number {
  font-size: clamp(1.2rem, 3vw, 1.8rem);
  font-weight: 900;
  font-family: 'Cairo', sans-serif;
  margin-bottom: 0.3rem;
  display: block;
  color: white;
  text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
}

.countdown-label {
  font-size: 0.75rem;
  font-weight: 700;
  opacity: 0.9;
  text-transform: uppercase;
  letter-spacing: 0.05em;
  color: rgba(255, 255, 255, 0.9);
}

.countdown-expired {
  background: linear-gradient(135deg, #64748b 0%, #475569 100%);
  color: white;
  text-align: center;
  padding: 1.5rem;
  border-radius: 16px;
  margin-bottom: 2rem;
  font-weight: 700;
  font-family: 'Cairo', sans-serif;
  font-size: 1.1rem;
}

@media (max-width: 768px) {
  .countdown-content {
    gap: 1rem;
  }

  .countdown-icon {
    font-size: 2rem;
  }

  .countdown-text h3 {
    font-size: 1.1rem;
  }

  .countdown-timer {
    grid-template-columns: repeat(4, 1fr);
    gap: 0.5rem;
  }

  .countdown-unit {
    padding: 0.8rem 0.4rem;
  }

  .countdown-number {
    font-size: 1.2rem;
  }

  .countdown-label {
    font-size: 0.65rem;
  }
}

.related-products-section {
  margin-top: clamp(3rem, 6vw, 5rem);
  padding: clamp(2rem, 4vw, 3rem);
  background: rgba(255,255,255,0.9);
  backdrop-filter: blur(20px);
  border-radius: var(--card-radius);
  box-shadow: var(--shadow-strong);
  max-width: 1400px;
  margin-left: auto;
  margin-right: auto;
  border: 1px solid rgba(0,0,0,0.05);
}

.related-products-section h2 {
  text-align: center;
  font-size: clamp(1.5rem, 3vw, 2rem);
  font-weight: 900;
  font-family: 'Cairo', sans-serif;
  color: var(--text-primary);
  margin-bottom: 2rem;
  text-shadow: 0 1px 2px rgba(0,0,0,0.1);
}

.related-products-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
  gap: clamp(1.5rem, 3vw, 2rem);
  overflow-x: auto;
  scroll-snap-type: x mandatory;
  -webkit-overflow-scrolling: touch;
}

.related-product-card {
  background: white;
  border-radius: 16px;
  overflow: hidden;
  box-shadow: var(--shadow-soft);
  transition: all 0.3s;
  border: 1px solid rgba(0,0,0,0.05);
  will-change: transform, box-shadow;
  scroll-snap-align: start;
  flex-shrink: 0;
  width: 250px;
}

.related-product-card:hover {
  transform: translateY(-5px);
  box-shadow: var(--shadow-strong);
}

.related-product-image {
  height: 180px;
  background: var(--accent-gradient);
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
}

.related-product-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.3s ease;
}

.related-product-image:hover img {
  transform: scale(1.1);
}

.related-product-info {
  padding: 1rem;
}

.related-product-name {
  font-size: 1rem;
  font-weight: 700;
  font-family: 'Cairo', sans-serif;
  color: var(--text-primary);
  margin-bottom: 0.5rem;
  line-height: 1.3;
}

.related-product-price {
  font-size: 1.2rem;
  font-weight: 800;
  color: #3b82f6;
  font-family: 'Cairo', sans-serif;
}

.back-btn {
  display: inline-block;
  background: var(--primary-gradient);
  color: white;
  padding: 0.8rem 1.5rem;
  border-radius: 20px;
  font-weight: 600;
  text-decoration: none;
  margin-bottom: 2rem;
  transition: all 0.3s;
  font-family: 'Cairo', sans-serif;
  box-shadow: 0 5px 15px rgba(102,126,234,0.3);
}

.back-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 25px rgba(102,126,234,0.4);
}

.loading-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: var(--primary-gradient);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 9999;
  font-size: 3rem;
  font-weight: 900;
  font-family: 'Cairo', sans-serif;
  color: white;
  animation: pulse 2s infinite;
}

@keyframes pulse {
  0%, 100% { opacity: 1; }
  50% { opacity: 0.5; }
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}

.fade-in {
  animation: fadeIn 0.6s ease-out forwards;
  will-change: opacity, transform;
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

  .whatsapp-btn {
    padding: 1.5rem;
    font-size: 1.2rem;
  }

  .discount-input-group button {
    padding: 1rem 1.8rem;
    font-size: 1rem;
  }

  .related-products-grid {
    display: flex;
    gap: 1rem;
    overflow-x: auto;
    scroll-snap-type: x mandatory;
    -webkit-overflow-scrolling: touch;
    padding-bottom: 1rem;
  }

  .related-product-card {
    flex-shrink: 0;
    width: 200px;
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
  <h1>تفاصيل المنتج</h1>
  <p>اطلع على معلومات المنتج وخيارات الشراء المتاحة مع أفضل الأسعار.</p>
</section>

<!-- Back Button -->
<div style="max-width: 1200px; margin: 0 auto; padding: 0 1rem;">
  <a href="{{ route('home') }}" class="back-btn">العودة إلى الرئيسية</a>
</div>

<!-- Product Details -->
<div class="product-detail-container fade-in">
  <!-- Product Image -->
  <div class="product-image-section">
    <div class="product-main-image">
      @if($product->image_url)
        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy">
      @endif
    </div>
  </div>

  <!-- Product Info -->
  <div class="product-info-section">
    @php
      $productDiscount = $product->getActiveDiscount();
    @endphp
    
    <!-- Countdown Timer for Temporary Discounts -->
    @if($productDiscount && $productDiscount->valid_until)
      @php
        $now = \Carbon\Carbon::now();
        $expiresAt = \Carbon\Carbon::parse($productDiscount->valid_until);
        $isExpired = $expiresAt->isPast();
        $totalSeconds = $now->diffInSeconds($expiresAt);
      @endphp
      
      @if(!$isExpired && $totalSeconds > 0)
        <div class="countdown-banner" id="countdown-banner">
          <div class="countdown-content">
            <div class="countdown-icon">⏰</div>
            <div class="countdown-text" style="grid-column: 1 / -1;">
              <h3>عرض محدود الوقت!</h3>
              <p>استغل هذا الخصم الخاص قبل انتهاء المدة</p>
            </div>
          </div>
          <div class="countdown-timer" id="countdown-timer">
            <div class="countdown-unit">
              <span class="countdown-number" id="days">00</span>
              <span class="countdown-label">يوم</span>
            </div>
            <div class="countdown-unit">
              <span class="countdown-number" id="hours">00</span>
              <span class="countdown-label">ساعة</span>
            </div>
            <div class="countdown-unit">
              <span class="countdown-number" id="minutes">00</span>
              <span class="countdown-label">دقيقة</span>
            </div>
            <div class="countdown-unit">
              <span class="countdown-number" id="seconds">00</span>
              <span class="countdown-label">ثانية</span>
            </div>
          </div>
        </div>
        
        <script>
          const expiresAt = new Date('{{ $expiresAt->toIso8601String() }}');
          
          function updateCountdown() {
            const now = new Date().getTime();
            const distance = expiresAt - now;

            if (distance < 0) {
              document.getElementById('countdown-banner').innerHTML = 
                '<div class="countdown-expired">✗ انتهت مدة العرض الخاص</div>';
              clearInterval(countdownInterval);
              return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById('days').textContent = String(days).padStart(2, '0');
            document.getElementById('hours').textContent = String(hours).padStart(2, '0');
            document.getElementById('minutes').textContent = String(minutes).padStart(2, '0');
            document.getElementById('seconds').textContent = String(seconds).padStart(2, '0');

            // Change color to red when time is running out (less than 1 hour)
            const countdownBanner = document.getElementById('countdown-banner');
            if (distance < 3600000) {
              countdownBanner.style.background = 'linear-gradient(135deg, #dc2626 0%, #991b1b 100%)';
              countdownBanner.style.boxShadow = '0 10px 35px rgba(220, 38, 38, 0.4)';
            }
          }

          // Initial call
          updateCountdown();
          
          // Update every second
          const countdownInterval = setInterval(updateCountdown, 1000);
        </script>
      @endif
    @endif
    
    @if($productDiscount)
      <div class="discount-badge">
        خصم {{ $productDiscount->percentage }}%
      </div>
    @endif
    
    @if($product->is_digital)
      <div class="digital-badge">
        منتج رقمي
      </div>
    @endif

    <h1 class="product-title">{{ $product->name }}</h1>
    <p class="product-description">{{ $product->description }}</p>

    <!-- Price Section -->
    <div class="product-price-section">
      <div class="product-price" id="original-price">{{ number_format((float) $product->price, 0) }} دولار</div>
      @if($productDiscount)
        <div class="product-discount-price" id="discount-price">
          {{ number_format((float) $productDiscount->calculateFinalPrice($product->price), 0) }} دولار
        </div>
      @endif
    </div>

    <!-- Stock -->
    <div class="product-stock">المخزون: {{ $product->stock }} قطعة</div>

    <!-- Discount Section -->
    <div class="discount-section">
      <div class="discount-input-group">
        <input type="text" id="discount-code" placeholder="أدخل رمز الخصم">
        <button type="button" onclick="validateDiscount({{ $product->id }})" title="انقر لتطبيق رمز الخصم على السعر">تطبيق الخصم</button>
      </div>
      <div class="discount-msg" id="discount-msg"></div>
      <div class="discount-progress-bar" id="discount-progress-bar">
        <div class="discount-progress-fill" id="discount-progress-fill"></div>
      </div>
    </div>

    <!-- General Discounts -->
    @if(isset($generalDiscounts) && $generalDiscounts->count() > 0)
      <div class="general-discount-box">
        <span>رمز الخصم المتاح: <strong>{{ $generalDiscounts->first()->code }}</strong> - {{ $generalDiscounts->first()->percentage }}%</span>
      </div>
    @endif

    <!-- WhatsApp Button -->
    <a href="https://wa.me/963982617848?text=مرحباً! أريد طلب {{ urlencode($product->name . ' ' . ($product->is_digital ? '(منتج رقمي)' : '') . ' السعر: ' . $product->price . ' ل.س') }}" 
       class="whatsapp-btn ripple" target="_blank" id="whatsapp-btn" data-price="{{ $product->price }}" title="اضغط للطلب عبر WhatsApp مباشرة">
      اطلب عبر الواتساب
    </a>

    <!-- Share Button -->
    <button class="share-btn ripple" onclick="openShareModal()" title="اضغط لمشاركة المنتج على وسائل التواصل">
      مشاركة المنتج
    </button>
  </div>
</div>

<!-- Share Modal -->
<div class="share-modal" id="shareModal">
  <div class="share-modal-content">
    <button class="close-share-modal" onclick="closeShareModal()">&times;</button>
    <div class="share-modal-header">
      <h3>مشاركة المنتج</h3>
      <p>اختر المنصة المناسبة للمشاركة</p>
    </div>
    <div class="share-buttons-grid">
      <a href="#" class="share-btn-item share-whatsapp" onclick="shareOnWhatsApp(event)">
        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.67-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.076 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421-7.403h-.004a9.87 9.87 0 00-4.255.949c-1.238.417-2.337 1.013-3.257 1.955-3.537 3.636-3.823 9.506-.722 13.314 1.925 2.32 4.816 3.667 7.978 3.667 2.16 0 4.238-.733 5.881-2.129l.015-.01c3.645-3.738 3.954-9.649.728-13.565-1.925-2.319-4.816-3.666-7.978-3.666zm7.905-1.779C13.97 1.444 11.055 0 8.059 0 3.615 0 0 3.596 0 8.041c0 1.538.399 3.04 1.147 4.358L0 24l5.668-1.498c1.25.666 2.653 1.027 4.135 1.027 4.444 0 8.059-3.596 8.059-8.041 0-2.151-.799-4.163-2.247-5.734z"/></svg>
        <span class="share-btn-item-text">واتساب</span>
      </a>
      <a href="#" class="share-btn-item share-facebook" onclick="shareOnFacebook(event)">
        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
        <span class="share-btn-item-text">فيسبوك</span>
      </a>
      <a href="#" class="share-btn-item share-twitter" onclick="shareOnTwitter(event)">
        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M23.953 4.57a10 10 0 002.856-3.515 10 10 0 01-2.836.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
        <span class="share-btn-item-text">تويتر</span>
      </a>
      <a href="#" class="share-btn-item share-telegram" onclick="shareOnTelegram(event)">
        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a11.955 11.955 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a1.675 1.675 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.365-1.337.175-.437-.148-1.33-.515-1.98-.953-.798-.529-1.432-1.476-.98-2.08.46-.608 1.921-.821 2.7-.98 2.6-.62 5.11-.72 6.175-.36z"/></svg>
        <span class="share-btn-item-text">تيليجرام</span>
      </a>
      <a href="#" class="share-btn-item share-linkedin" onclick="shareOnLinkedIn(event)">
        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.475-2.236-1.986-2.236-1.081 0-1.722.722-2.006 1.42-.103.249-.129.597-.129.946v5.439h-3.554s.05-8.736 0-9.646h3.554v1.364c.429-.647 1.175-1.568 2.82-1.568 2.04 0 3.575 1.336 3.575 4.205v5.645zM5.337 8.855c-1.144 0-1.915-.761-1.915-1.712 0-.951.77-1.71 1.954-1.71 1.185 0 1.916.759 1.94 1.71 0 .951-.769 1.712-1.979 1.712zm1.667 11.597h-3.56V9.206h3.56v11.246zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
        <span class="share-btn-item-text">لينكدين</span>
      </a>
      <a href="#" class="share-btn-item share-copy-link" onclick="copyShareLink(event)">
        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M16 1H4c-1.1 0-2 .9-2 2v14h2V3h12V1zm4 4H8c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2zm0 16H8V7h12v14z"/></svg>
        <span class="share-btn-item-text">نسخ الرابط</span>
      </a>
    </div>
  </div>


<!-- Related Products -->
@if(isset($relatedProducts) && $relatedProducts->count() > 0)
<section class="related-products-section fade-in">
  <h2>منتجات ذات صلة</h2>
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
@if(isset($variants) && $variants->count() > 0)
<section class="related-products-section fade-in">
  <h2>خيارات المنتج</h2>
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
          <div class="product-stock" style="font-size: 0.8rem; margin-top: 0.5rem;">المخزون: {{ $variant->stock }} قطعة</div>
          <a href="https://wa.me/963982617848?text=مرحباً! أريد طلب {{ urlencode($variant->name . ' السعر: ' . $variant->price . ' ل.س') }}" 
             class="whatsapp-btn ripple" target="_blank" style="margin-top: 1rem; padding: 0.8rem; font-size: 0.9rem;" title="اضغط لطلب هذا الخيار عبر WhatsApp">
             اطلب الآن
          </a>
        </div>
      </div>
    @endforeach
  </div>
</section>
@endif

<script>
function updateWhatsappLink(finalPrice) {
    const whatsappBtn = document.getElementById('whatsapp-btn');
    if (!whatsappBtn) return;

    const baseText = 'مرحباً! أريد طلب {{ $product->name }}' + 
                     ({{ $product->is_digital ? 'true' : 'false' }} ? ' (منتج رقمي)' : '') + 
                     ' السعر: ' + finalPrice + ' ل.س';
    
    whatsappBtn.href = 'https://wa.me/963982617848?text=' + encodeURIComponent(baseText);
}

function validateDiscount(productId) {
    const code = document.getElementById('discount-code').value.trim();
    const messageEl = document.getElementById('discount-msg');

    if (!code) {
        messageEl.innerHTML = '<span style="color: #dc2626;">يرجى إدخال رمز الخصم</span>';
        return;
    }

    fetch('/api/validate-discount', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        },
        body: JSON.stringify({ code: code, product_id: productId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const originalPrice = Number({{ $product->price }});
            const discountAmount = (originalPrice * data.discount.percentage) / 100;
            const finalPrice = originalPrice - discountAmount;

            document.getElementById('original-price').style.textDecoration = 'line-through';
            document.getElementById('original-price').style.opacity = '0.6';

            let discountPriceEl = document.getElementById('discount-price');
            if (!discountPriceEl) {
                discountPriceEl = document.createElement('div');
                discountPriceEl.id = 'discount-price';
                discountPriceEl.className = 'product-discount-price';
                document.querySelector('.product-price-section').appendChild(discountPriceEl);
            }

            discountPriceEl.innerHTML = Math.round(finalPrice).toLocaleString() + ' ل.س ' + 
                                       '<span style="color: #22c55e; font-size: 0.8em;">(خصم ' + 
                                       data.discount.percentage + '%)</span>';
            
            messageEl.innerHTML = '<span style="color: #15803d;">تم تطبيق الخصم بنجاح!</span>';
            
            // Show discount progress bar
            const progressBar = document.getElementById('discount-progress-bar');
            const progressFill = document.getElementById('discount-progress-fill');
            progressBar.style.display = 'block';
            
            // Animate progress bar
            setTimeout(() => {
                progressFill.style.width = data.discount.percentage + '%';
            }, 100);
            
            updateWhatsappLink(Math.round(finalPrice));
        } else {
            messageEl.innerHTML = '<span style="color: #dc2626;">' + (data.message || 'رمز الخصم غير صالح') + '</span>';
        }
    })
    .catch(error => {
        console.error('Error validating discount:', error);
        messageEl.innerHTML = '<span style="color: #dc2626;">حدث خطأ أثناء التحقق من الخصم</span>';
    });
}

// إخفاء loading overlay عند تحميل الصفحة
window.addEventListener('load', function() {
    const overlay = document.getElementById('loading-overlay');
    if (overlay) {
        overlay.style.display = 'none';
    }
    
    // إضافة تأخير بسيط للإنيميشن
    setTimeout(() => {
        const fadeElements = document.querySelectorAll('.fade-in');
        fadeElements.forEach((el, index) => {
            el.style.animationDelay = `${index * 0.1}s`;
        });
    }, 100);

    // إضافة swipe gestures للمنتجات المتعلقة
    initSwipeGestures();
});

function initSwipeGestures() {
    const grids = document.querySelectorAll('.related-products-grid');
    
    grids.forEach(grid => {
        let startX = 0;
        let scrollLeft = 0;
        let isDown = false;

        grid.addEventListener('touchstart', (e) => {
            isDown = true;
            startX = e.touches[0].pageX - grid.offsetLeft;
            scrollLeft = grid.scrollLeft;
        });

        grid.addEventListener('touchend', () => {
            isDown = false;
        });

        grid.addEventListener('touchmove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.touches[0].pageX - grid.offsetLeft;
            const walk = (x - startX) * 2; // سرعة التمرير
            grid.scrollLeft = scrollLeft - walk;
        });
    });
}

function shareProduct() {
    const productName = "{{ $product->name }}";
    const productUrl = "{{ route('product.show', $product) }}";
    const shareText = "تحقق من هذا المنتج: " + productName + " - " + productUrl;

    if (navigator.share) {
        // استخدام Web Share API إذا كان مدعوماً
        navigator.share({
            title: productName,
            text: shareText,
            url: productUrl
        }).catch(console.error);
    } else {
        // روابط بديلة للمشاركة
        const whatsappUrl = "https://wa.me/?text=" + encodeURIComponent(shareText);
        const facebookUrl = "https://www.facebook.com/sharer/sharer.php?u=" + encodeURIComponent(productUrl);
        const twitterUrl = "https://twitter.com/intent/tweet?text=" + encodeURIComponent(shareText);

        // فتح نافذة منبثقة لاختيار المنصة
        const shareWindow = window.open('', 'share', 'width=400,height=300');
        shareWindow.document.write(`
            <html>
            <head><title>مشاركة المنتج</title></head>
            <body style="font-family: Arial, sans-serif; padding: 20px;">
                <h3>مشاركة المنتج</h3>
                <p><a href="${whatsappUrl}" target="_blank">مشاركة على WhatsApp</a></p>
                <p><a href="${facebookUrl}" target="_blank">مشاركة على Facebook</a></p>
                <p><a href="${twitterUrl}" target="_blank">مشاركة على Twitter</a></p>
            </body>
            </html>
        `);
    }
}

function openShareModal() {
    const shareModal = document.getElementById('shareModal');
    if (shareModal) {
        shareModal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
}

function closeShareModal() {
    const shareModal = document.getElementById('shareModal');
    if (shareModal) {
        shareModal.classList.remove('active');
        document.body.style.overflow = 'auto';
    }
}

function getShareUrl() {
    return "{{ route('product.show', $product) }}";
}

function getShareText() {
    return "تحقق من هذا المنتج: {{ $product->name }}";
}

function shareOnWhatsApp(event) {
    event.preventDefault();
    const productName = "{{ $product->name }}";
    const productPrice = "{{ $product->price }}";
    const productUrl = getShareUrl();
    const text = `تحقق من هذا المنتج: ${productName} - السعر: ${productPrice} ل.س\n${productUrl}`;
    const whatsappUrl = "https://wa.me/?text=" + encodeURIComponent(text);
    window.open(whatsappUrl, '_blank');
    closeShareModal();
}

function shareOnFacebook(event) {
    event.preventDefault();
    const productUrl = getShareUrl();
    const facebookUrl = "https://www.facebook.com/sharer/sharer.php?u=" + encodeURIComponent(productUrl);
    window.open(facebookUrl, '_blank', 'width=600,height=400');
    closeShareModal();
}

function shareOnTwitter(event) {
    event.preventDefault();
    const shareText = getShareText();
    const productUrl = getShareUrl();
    const twitterUrl = "https://twitter.com/intent/tweet?text=" + encodeURIComponent(shareText + " " + productUrl);
    window.open(twitterUrl, '_blank', 'width=550,height=420');
    closeShareModal();
}

function shareOnTelegram(event) {
    event.preventDefault();
    const shareText = getShareText();
    const productUrl = getShareUrl();
    const telegramUrl = "https://t.me/share/url?url=" + encodeURIComponent(productUrl) + "&text=" + encodeURIComponent(shareText);
    window.open(telegramUrl, '_blank', 'width=600,height=400');
    closeShareModal();
}

function shareOnLinkedIn(event) {
    event.preventDefault();
    const productUrl = getShareUrl();
    const linkedinUrl = "https://www.linkedin.com/sharing/share-offsite/?url=" + encodeURIComponent(productUrl);
    window.open(linkedinUrl, '_blank', 'width=550,height=420');
    closeShareModal();
}

function copyShareLink(event) {
    event.preventDefault();
    const productUrl = getShareUrl();
    
    navigator.clipboard.writeText(productUrl).then(() => {
        // Show success message
        const message = document.createElement('div');
        message.className = 'copy-success-message';
        message.textContent = '✓ تم نسخ الرابط بنجاح';
        document.body.appendChild(message);
        
        setTimeout(() => {
            message.remove();
        }, 2000);
        
        closeShareModal();
    }).catch(() => {
        // Fallback for older browsers
        const textarea = document.createElement('textarea');
        textarea.value = productUrl;
        document.body.appendChild(textarea);
        textarea.select();
        document.execCommand('copy');
        document.body.removeChild(textarea);
        
        const message = document.createElement('div');
        message.className = 'copy-success-message';
        message.textContent = '✓ تم نسخ الرابط بنجاح';
        document.body.appendChild(message);
        
        setTimeout(() => {
            message.remove();
        }, 2000);
        
        closeShareModal();
    });
}

// Close modal when clicking outside
document.addEventListener('DOMContentLoaded', () => {
    const shareModal = document.getElementById('shareModal');
    if (shareModal) {
        shareModal.addEventListener('click', (e) => {
            if (e.target === shareModal) {
                closeShareModal();
            }
        });
    }
});

// Discount Notification Bar Functions
function closeNotification() {
    const bar = document.getElementById('discount-notification-bar');
    if (bar) {
        bar.classList.add('hidden');
        // Remove from DOM after animation
        setTimeout(() => {
            bar.remove();
        }, 300);
    }
}

function scrollToDiscount() {
    const discountSection = document.querySelector('.discount-section');
    if (discountSection) {
        discountSection.scrollIntoView({ 
            behavior: 'smooth',
            block: 'center'
        });
        // Close notification after scrolling
        setTimeout(() => {
            closeNotification();
        }, 500);
    } else {
        // If no discount section, scroll to price section
        const priceSection = document.querySelector('.product-price-section');
        if (priceSection) {
            priceSection.scrollIntoView({ 
                behavior: 'smooth',
                block: 'center'
            });
            setTimeout(() => {
                closeNotification();
            }, 500);
        }
    }
}

// Auto-hide notification after 10 seconds
setTimeout(() => {
    const bar = document.getElementById('discount-notification-bar');
    if (bar && !bar.classList.contains('hidden')) {
        closeNotification();
    }
}, 10000);


</script>
@endsection
