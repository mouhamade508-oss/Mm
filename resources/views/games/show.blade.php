@extends('layouts.pro-store')

@section('meta_description', 'شحن رصيد ' . $game->name)
@section('meta_keywords', $game->name . ', شحن رصيد, متجر')
@section('meta_canonical', url('/games/' . $game->id))

@section('content')
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

.game-hero {
  background: var(--blue-hero);
  color: white;
  padding: clamp(3rem, 8vw, 6rem) 1rem;
  text-align: center;
  position: relative;
  overflow: hidden;
  margin-bottom: clamp(2rem, 5vw, 4rem);
}

.game-hero-content {
  max-width: 1200px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 3rem;
  align-items: center;
}

@media (max-width: 900px) {
  .game-hero-content {
    gap: 2rem;
  }
}

@media (max-width: 768px) {
  .game-hero-content {
    grid-template-columns: 1fr;
    gap: 2rem;
  }
  
  .game-hero {
    padding: 2.5rem 1rem;
  }
}

.game-image-holder {
  display: flex;
  justify-content: center;
  animation: fadeInUp 0.8s ease 0.2s both;
}

@media (max-width: 480px) {
  .game-image-holder {
    margin-top: 1rem;
  }
}

.game-image {
  width: 100%;
  max-width: 350px;
  height: 350px;
  object-fit: cover;
  border-radius: 20px;
  box-shadow: 0 30px 60px rgba(0,0,0,0.3);
  animation: fadeInDown 0.8s ease;
}

@media (max-width: 768px) {
  .game-image {
    max-width: 300px;
    height: 300px;
  }
}

@media (max-width: 480px) {
  .game-image {
    max-width: 250px;
    height: 250px;
    border-radius: 16px;
  }
}

@media (max-width: 360px) {
  .game-image {
    max-width: 200px;
    height: 200px;
  }
}

.game-image-placeholder {
  width: 100%;
  max-width: 350px;
  height: 350px;
  border-radius: 20px;
  background: linear-gradient(135deg, rgba(255,255,255,0.1), rgba(255,255,255,0.05));
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 5rem;
  box-shadow: 0 30px 60px rgba(0,0,0,0.3);
}

@media (max-width: 768px) {
  .game-image-placeholder {
    max-width: 300px;
    height: 300px;
    font-size: 4rem;
  }
}

@media (max-width: 480px) {
  .game-image-placeholder {
    max-width: 250px;
    height: 250px;
    font-size: 3rem;
    border-radius: 16px;
  }
}

@media (max-width: 360px) {
  .game-image-placeholder {
    max-width: 200px;
    height: 200px;
    font-size: 2rem;
  }
}

.game-info h1 {
  font-size: clamp(1.8rem, 5vw, 3rem);
  font-weight: 900;
  margin-bottom: 1rem;
  letter-spacing: -0.5px;
  animation: fadeInDown 0.8s ease;
  text-align: left;
}

@media (max-width: 480px) {
  .game-info h1 {
    text-align: center;
    margin-bottom: 0.8rem;
  }
}

.game-info p {
  font-size: clamp(1rem, 2vw, 1.2rem);
  opacity: 0.95;
  line-height: 1.8;
  margin-bottom: 1.5rem;
  font-weight: 500;
  animation: fadeInUp 0.8s ease 0.2s both;
  text-align: left;
}

@media (max-width: 480px) {
  .game-info p {
    text-align: center;
    margin-bottom: 1.2rem;
    font-size: 0.95rem;
  }
}

.game-stats {
  display: flex;
  gap: 2rem;
  margin: 2rem 0;
  animation: fadeInUp 0.8s ease 0.3s both;
  flex-wrap: wrap;
}

@media (max-width: 768px) {
  .game-stats {
    gap: 1.5rem;
  }
}

@media (max-width: 480px) {
  .game-stats {
    justify-content: center;
    flex-direction: row;
    gap: 1rem;
  }
}

.stat {
  text-align: left;
}

@media (max-width: 480px) {
  .stat {
    text-align: center;
    flex: 1;
    min-width: 120px;
  }
}

.stat-label {
  font-size: 0.9rem;
  opacity: 0.9;
  margin-bottom: 0.5rem;
  font-weight: 600;
}

.stat-value {
  font-size: 1.5rem;
  font-weight: 900;
}

.breadcrumb {
  max-width: 1200px;
  margin: 0 auto 2rem;
  padding: 0 1rem;
  font-size: 0.95rem;
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  gap: 0.3rem;
}

@media (max-width: 480px) {
  .breadcrumb {
    font-size: 0.8rem;
    margin-bottom: 1rem;
  }
}

.breadcrumb a {
  color: #3b82f6;
  text-decoration: none;
  transition: color 0.3s;
  word-break: break-word;
}

.breadcrumb a:hover {
  color: #1d4ed8;
  text-decoration: underline;
}

.breadcrumb span {
  color: #64748b;
  margin: 0 0.3rem;
}

.categories-section {
  max-width: 1200px;
  margin: 0 auto clamp(3rem, 5vw, 6rem);
  padding: 0 1rem;
}

.section-header {
  text-align: center;
  margin-bottom: clamp(2rem, 5vw, 4rem);
}

@media (max-width: 480px) {
  .section-header {
    margin-bottom: 1.5rem;
  }
}

.section-header h2 {
  font-size: clamp(1.8rem, 4vw, 2.5rem);
  font-weight: 900;
  color: #1e293b;
  margin-bottom: 0.5rem;
}

@media (max-width: 480px) {
  .section-header h2 {
    font-size: 1.3rem;
  }
}

.section-header p {
  color: #64748b;
  font-size: 1.05rem;
}

@media (max-width: 480px) {
  .section-header p {
    font-size: 0.95rem;
  }
}

.categories-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  gap: clamp(1.5rem, 3vw, 2.5rem);
  margin-bottom: clamp(2rem, 5vw, 4rem);
}

@media (max-width: 768px) {
  .categories-grid {
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 1.5rem;
  }
}

@media (max-width: 480px) {
  .categories-grid {
    grid-template-columns: 1fr;
    gap: 1.2rem;
  }
}

.category-card {
  background: white;
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0 10px 40px rgba(59,130,246,0.15);
  transition: all 0.4s ease;
  border: 2px solid transparent;
  display: flex;
  flex-direction: column;
  height: 100%;
}

.category-card:hover {
  transform: translateY(-12px);
  box-shadow: 0 30px 60px rgba(59,130,246,0.25);
  border-color: #3b82f6;
}

@media (max-width: 480px) {
  .category-card {
    border-radius: 16px;
  }
  
  .category-card:hover {
    transform: translateY(-8px);
  }
}

.category-header {
  background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
  color: white;
  padding: 2rem 1.5rem;
  flex: 1;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

@media (max-width: 480px) {
  .category-header {
    padding: 1.5rem 1.2rem;
  }
}

.category-name {
  font-size: 1.3rem;
  font-weight: 800;
  margin-bottom: 0.5rem;
}

@media (max-width: 480px) {
  .category-name {
    font-size: 1.1rem;
  }
}

.category-description {
  font-size: 0.9rem;
  opacity: 0.9;
  line-height: 1.5;
}

@media (max-width: 480px) {
  .category-description {
    font-size: 0.8rem;
  }
}

.category-body {
  padding: 1.5rem;
  flex: 1;
  display: flex;
  flex-direction: column;
}

@media (max-width: 480px) {
  .category-body {
    padding: 1.2rem;
  }
}

.price-display {
  text-align: center;
  margin-bottom: 1.5rem;
}

@media (max-width: 480px) {
  .price-display {
    margin-bottom: 1.2rem;
  }
}

.price-label {
  color: #64748b;
  font-size: 0.9rem;
  margin-bottom: 0.5rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

@media (max-width: 480px) {
  .price-label {
    font-size: 0.8rem;
  }
}

.price-value {
  font-size: 2rem;
  font-weight: 900;
  background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

@media (max-width: 480px) {
  .price-value {
    font-size: 1.5rem;
  }
}

.category-actions {
  display: flex;
  gap: 1rem;
  margin-top: auto;
}

@media (max-width: 480px) {
  .category-actions {
    gap: 0.8rem;
  }
}

.btn-select {
  flex: 1;
  background: var(--blue-hero);
  color: white;
  border: none;
  padding: 0.9rem 1.5rem;
  border-radius: 12px;
  font-weight: 700;
  font-size: 0.95rem;
  cursor: pointer;
  transition: all 0.3s;
  text-decoration: none;
  text-align: center;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
}

.btn-select:hover {
  transform: translateY(-3px);
  box-shadow: var(--blue-glow);
}

@media (max-width: 480px) {
  .btn-select {
    padding: 0.8rem 1rem;
    font-size: 0.9rem;
    border-radius: 10px;
  }
}

.no-categories {
  text-align: center;
  padding: 4rem 2rem;
  background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
  border-radius: 20px;
  border: 2px dashed #3b82f6;
}

.no-categories-icon {
  font-size: 4rem;
  margin-bottom: 1rem;
}

.no-categories-text {
  color: #64748b;
  font-size: 1.1rem;
  margin-bottom: 2rem;
}

.modal-overlay {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.7);
  backdrop-filter: blur(5px);
  z-index: 1000;
  align-items: center;
  justify-content: center;
  overflow-y: auto;
  padding: 1rem;
}

.modal-overlay.active {
  display: flex;
}

.modal-content {
  background: white;
  border-radius: 20px;
  padding: 2.5rem;
  max-width: 500px;
  width: 100%;
  max-height: 90vh;
  overflow-y: auto;
  box-shadow: 0 50px 100px rgba(0,0,0,0.3);
  animation: fadeInUp 0.4s ease;
}

.modal-header {
  text-align: center;
  margin-bottom: 2rem;
}

.modal-header h3 {
  font-size: 1.5rem;
  font-weight: 900;
  color: #1e293b;
  margin-bottom: 0.5rem;
}

.modal-header p {
  color: #3b82f6;
  font-size: 1.1rem;
  font-weight: 700;
}

.form-group {
  margin-bottom: 1.5rem;
}

.form-label {
  display: block;
  font-weight: 700;
  color: #1e293b;
  margin-bottom: 0.8rem;
  font-size: 0.95rem;
}

.form-input, .form-textarea {
  width: 100%;
  padding: 0.9rem 1.2rem;
  border: 2px solid #e2e8f0;
  border-radius: 12px;
  font-size: 1rem;
  font-family: inherit;
  transition: all 0.3s ease;
  box-sizing: border-box;
}

.form-textarea {
  resize: vertical;
  min-height: 100px;
}

.form-input:focus, .form-textarea:focus {
  outline: none;
  border-color: #3b82f6;
  box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
}

.form-file {
  position: relative;
  display: block;
  width: 100%;
  padding: 2rem 1.5rem;
  border: 2px dashed #3b82f6;
  border-radius: 12px;
  text-align: center;
  background: linear-gradient(135deg, rgba(59,130,246,0.05), rgba(29,78,216,0.05));
  cursor: pointer;
  transition: all 0.3s;
}

.form-file:hover {
  border-color: #1d4ed8;
  background: linear-gradient(135deg, rgba(59,130,246,0.1), rgba(29,78,216,0.1));
}

@media (max-width: 480px) {
  .form-file {
    padding: 1.5rem 1rem;
  }
}

.form-file input {
  display: none;
}

.file-text {
  color: #1d4ed8;
  font-weight: 700;
  margin-bottom: 0.5rem;
}

@media (max-width: 480px) {
  .file-text {
    font-size: 0.9rem;
  }
}

.file-hint {
  color: #64748b;
  font-size: 0.85rem;
}

@media (max-width: 480px) {
  .file-hint {
    font-size: 0.75rem;
  }
}

.modal-buttons {
  display: flex;
  gap: 1rem;
  margin-top: 2rem;
}

@media (max-width: 480px) {
  .modal-buttons {
    flex-direction: column;
    gap: 0.8rem;
  }
}

.btn-close {
  flex: 1;
  background: #f1f5f9;
  color: #475569;
  border: 2px solid #e2e8f0;
  padding: 0.9rem 1.5rem;
  border-radius: 12px;
  font-weight: 700;
  cursor: pointer;
  transition: all 0.3s;
}

.btn-close:hover {
  background: #e2e8f0;
  border-color: #cbd5e1;
}

@media (max-width: 480px) {
  .btn-close {
    padding: 0.8rem 1rem;
    font-size: 0.9rem;
  }
}

.btn-submit {
  flex: 1;
  background: var(--blue-hero);
  color: white;
  border: none;
  padding: 0.9rem 1.5rem;
  border-radius: 12px;
  font-weight: 700;
  cursor: pointer;
  transition: all 0.3s;
}

.btn-submit:hover {
  transform: translateY(-2px);
  box-shadow: var(--blue-glow);
}

.btn-submit:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

@media (max-width: 480px) {
  .btn-submit {
    padding: 0.8rem 1rem;
    font-size: 0.9rem;
  }
}

@media (max-width: 768px) {
  .game-hero-content {
    grid-template-columns: 1fr;
    gap: 2rem;
  }
  
  .game-hero {
    padding: 2rem 1rem;
  }
  
  .categories-grid {
    grid-template-columns: 1fr;
  }
}

@media (max-width: 480px) {
  .modal-content {
    padding: 1.5rem;
    width: 95%;
  }

  .modal-header h3 {
    font-size: 1.2rem;
  }

  .game-hero-content {
    grid-template-columns: 1fr;
  }

  .game-info h1 {
    text-align: center;
  }

  .game-info p {
    text-align: center;
  }

  .game-stats {
    justify-content: center;
    flex-direction: column;
    gap: 1.5rem;
  }

  .stat {
    text-align: center;
  }
  
  .game-image {
    max-width: 280px;
    height: 280px;
  }
  
  .game-image-placeholder {
    max-width: 280px;
    height: 280px;
    font-size: 3.5rem;
  }
  
  .section-header h2 {
    font-size: 1.5rem;
  }
  
  .form-group {
    margin-bottom: 1.2rem;
  }
  
  .modal-buttons {
    flex-direction: column;
  }
  
  .btn-close, .btn-submit {
    width: 100%;
  }
  
  .category-card {
    border-radius: 16px;
  }
  
  .category-header {
    padding: 1.5rem 1.2rem;
  }
  
  .category-body {
    padding: 1.2rem;
  }
  
  .price-value {
    font-size: 1.5rem;
  }
}

@media (max-width: 360px) {
  .modal-content {
    width: 98%;
    padding: 1.2rem;
  }
  
  .game-image {
    max-width: 200px;
    height: 200px;
  }
  
  .game-image-placeholder {
    max-width: 200px;
    height: 200px;
    font-size: 2rem;
  }
  
  .game-info h1 {
    font-size: 1.2rem !important;
  }
  
  .section-header h2 {
    font-size: 1.1rem;
  }
}

</style>

<div class="breadcrumb">
  <a href="{{ route('home') }}">المتجر</a>
  <span>›</span>
  <a href="{{ route('games.apps') }}">الألعاب والتطبيقات</a>
  <span>›</span>
  <span>{{ $game->name }}</span>
</div>

<div class="game-hero">
  <div class="game-hero-content">
    <div class="game-image-holder">
      @if($game->image)
        <img src="{{ asset('storage/' . $game->image) }}" alt="{{ $game->name }}" class="game-image">
      @else
        <div class="game-image-placeholder">🎮</div>
      @endif
    </div>
    <div class="game-info">
      <h1>{{ $game->name }}</h1>
      @if($game->description)
        <p>{{ $game->description }}</p>
      @endif
      <div class="game-stats">
        <div class="stat">
          <div class="stat-label">عدد الخطط</div>
          <div class="stat-value">{{ $categories->count() }}</div>
        </div>
        @if($categories->count() > 0)
          <div class="stat">
            <div class="stat-label">السعر من</div>
            <div class="stat-value">{{ number_format($categories->min('price'), 0) }} ر.س</div>
          </div>
        @endif
      </div>
    </div>
  </div>
</div>

<div class="categories-section">
  <div class="section-header">
    <h2>🎁 اختر خطة الشحن</h2>
    <p>ابدأ بشحن رصيدك الآن واختر الخطة المناسبة لك</p>
  </div>

  @if($categories->count() > 0)
    <div class="categories-grid">
      @foreach($categories as $category)
        <div class="category-card">
          <div class="category-header">
            <div class="category-name">{{ $category->name }}</div>
            @if($category->description)
              <div class="category-description">{{ $category->description }}</div>
            @endif
          </div>
          <div class="category-body">
            <div class="price-display">
              <div class="price-label">السعر</div>
              <div class="price-value">{{ number_format($category->price, 2) }} ريال</div>
            </div>
            <div class="category-actions">
              <button onclick="openRechargeModal('{{ $game->id }}', '{{ $category->id }}', '{{ $game->name }}', '{{ $category->name }}', '{{ $category->price }}')" class="btn-select">
                ✅ اختر الخطة
              </button>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @else
    <div class="no-categories">
      <div class="no-categories-icon">📭</div>
      <p class="no-categories-text">لا توجد خطط متاحة لهذه اللعبة حالياً</p>
      <a href="{{ route('games.apps') }}" class="btn-select">← العودة للألعاب</a>
    </div>
  @endif
</div>

<!-- Recharge Modal -->
<div class="modal-overlay" id="rechargeModal">
  <div class="modal-content">
    <div class="modal-header">
      <h3 id="modalGameName"></h3>
      <p id="modalCategoryName"></p>
    </div>

    <form method="POST" action="{{ route('game-recharge.store') }}" enctype="multipart/form-data" id="rechargeForm">
      @csrf

      <input type="hidden" id="gameId" name="game_id">
      <input type="hidden" id="categoryId" name="game_category_id">

      <div class="form-group">
        <label class="form-label">👤 اسمك الكامل *</label>
        <input type="text" name="customer_name" class="form-input" placeholder="أدخل اسمك" required>
      </div>

      <div class="form-group">
        <label class="form-label">📱 رقم الهاتف (اختياري)</label>
        <input type="tel" name="phone_number" class="form-input" placeholder="رقم الهاتف أو الايميل">
      </div>

      <div class="form-group">
        <label class="form-label">🎮 معرّف اللعبة / حسابك *</label>
        <input type="text" name="game_account" class="form-input" placeholder="معرّفك في اللعبة" required>
      </div>

      <div class="form-group">
        <label class="form-label">💰 السعر المدفوع</label>
        <input type="text" id="priceDisplay" class="form-input" disabled>
      </div>

      <div class="form-group">
        <label class="form-label">📸 إرسال إثبات البيع (اختياري)</label>
        <label class="form-file">
          <input type="file" name="proof_image" accept="image/*">
          <div class="file-text">📤 اضغط لاختيار صورة</div>
          <div class="file-hint">JPG, PNG (حتى 5MB)</div>
        </label>
      </div>

      <textarea name="notes" class="form-textarea" placeholder="ملاحظات إضافية (اختيارية)"></textarea>

      <div class="modal-buttons">
        <button type="button" class="btn-close" onclick="closeRechargeModal()">إلغاء</button>
        <button type="submit" class="btn-submit">✅ إرسال الطلب</button>
      </div>
    </form>
  </div>
</div>

<script>
function openRechargeModal(gameId, categoryId, gameName, categoryName, price) {
  document.getElementById('gameId').value = gameId;
  document.getElementById('categoryId').value = categoryId;
  document.getElementById('modalGameName').textContent = gameName;
  document.getElementById('modalCategoryName').textContent = categoryName;
  document.getElementById('priceDisplay').value = parseFloat(price).toFixed(2) + ' ريال';
  
  document.getElementById('rechargeModal').classList.add('active');
  document.body.style.overflow = 'hidden';
}

function closeRechargeModal() {
  document.getElementById('rechargeModal').classList.remove('active');
  document.body.style.overflow = 'auto';
  document.getElementById('rechargeForm').reset();
}

// Close modal when clicking outside
document.getElementById('rechargeModal').addEventListener('click', function(e) {
  if (e.target === this) {
    closeRechargeModal();
  }
});

// Prevent form submission if incomplete
document.getElementById('rechargeForm').addEventListener('submit', function(e) {
  const requiredFields = this.querySelectorAll('input[required], textarea[required]');
  let isValid = true;
  
  requiredFields.forEach(field => {
    if (!field.value.trim()) {
      field.style.borderColor = '#dc2626';
      isValid = false;
    } else {
      field.style.borderColor = '#e2e8f0';
    }
  });

  if (!isValid) {
    e.preventDefault();
    alert('يرجى ملء جميع الحقول المطلوبة (المحددة بـ *)');
  }
});
</script>

@endsection
