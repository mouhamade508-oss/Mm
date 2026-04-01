@extends('layouts.admin')

@section('title', 'تفاصيل طلب شحن اللعبة')

@section('content')
<style>
:root {
  --primary-gradient: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
  --success-gradient: linear-gradient(135deg, #10b981 0%, #059669 100%);
  --warning-gradient: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
  --danger-gradient: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
  --info-gradient: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
  --glow: 0 20px 40px rgba(59,130,246,0.2);
}

body {
  background: #f8fafc;
}

.page-header {
  background: var(--primary-gradient);
  color: white;
  padding: 2rem 0;
  margin-bottom: 2rem;
  border-radius: 0;
}

.page-header h1 {
  font-size: 2rem;
  font-weight: 900;
  margin-bottom: 0.5rem;
}

.page-header-actions {
  display: flex;
  gap: 0.5rem;
  margin-top: 1rem;
}

.btn-back {
  background: rgba(255,255,255,0.2);
  border: 2px solid rgba(255,255,255,0.3);
  color: white;
  padding: 0.6rem 1.5rem;
  border-radius: 10px;
  text-decoration: none;
  font-weight: 600;
  transition: all 0.3s;
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
}

.btn-back:hover {
  background: rgba(255,255,255,0.3);
  border-color: rgba(255,255,255,0.5);
  color: white;
  text-decoration: none;
}

.content-wrapper {
  max-width: 1200px;
  margin: 0 auto;
}

.info-card {
  background: white;
  border-radius: 16px;
  padding: 2rem;
  margin-bottom: 1.5rem;
  box-shadow: 0 10px 30px rgba(0,0,0,0.08);
  border-left: 5px solid #3b82f6;
  transition: all 0.3s;
}

.info-card:hover {
  box-shadow: var(--glow);
  transform: translateY(-2px);
}

.info-card.success {
  border-left-color: #10b981;
}

.info-card.warning {
  border-left-color: #f59e0b;
}

.info-card.danger {
  border-left-color: #ef4444;
}

.card-header-info {
  display: flex;
  align-items: center;
  gap: 1rem;
  margin-bottom: 1.5rem;
  padding-bottom: 1rem;
  border-bottom: 2px solid #f1f5f9;
}

.card-header-icon {
  width: 50px;
  height: 50px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.5rem;
}

.card-header-icon.blue {
  background: linear-gradient(135deg, #dbeafe, #bfdbfe);
  color: #1d4ed8;
}

.card-header-icon.green {
  background: linear-gradient(135deg, #dcfce7, #bbf7d0);
  color: #065f46;
}

.card-header-icon.purple {
  background: linear-gradient(135deg, #e9d5ff, #d8b4fe);
  color: #6b21a8;
}

.card-header-title {
  flex: 1;
}

.card-header-title h3 {
  font-size: 1.3rem;
  font-weight: 800;
  color: #1e293b;
  margin: 0;
}

.card-header-title p {
  color: #64748b;
  font-size: 0.9rem;
  margin: 0.25rem 0 0 0;
}

.info-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 1.5rem;
}

.info-item {
  display: flex;
  flex-direction: column;
}

.info-label {
  font-size: 0.85rem;
  color: #64748b;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  font-weight: 600;
  margin-bottom: 0.5rem;
}

.info-value {
  font-size: 1.1rem;
  color: #1e293b;
  font-weight: 700;
}

.info-value.link {
  color: #3b82f6;
  text-decoration: none;
  transition: color 0.3s;
}

.info-value.link:hover {
  color: #1d4ed8;
  text-decoration: underline;
}

.status-badge {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.6rem 1.2rem;
  border-radius: 12px;
  font-weight: 700;
  font-size: 0.9rem;
  white-space: nowrap;
}

.status-pending {
  background: linear-gradient(135deg, #fef3c7, #fde68a);
  color: #92400e;
}

.status-processing {
  background: linear-gradient(135deg, #cffafe, #a5f3fc);
  color: #164e63;
}

.status-completed {
  background: linear-gradient(135deg, #dcfce7, #bbf7d0);
  color: #065f46;
}

.status-rejected {
  background: linear-gradient(135deg, #fee2e2, #fecaca);
  color: #7f1d1d;
}

.image-section {
  background: white;
  border-radius: 16px;
  padding: 2rem;
  margin-bottom: 1.5rem;
  box-shadow: 0 10px 30px rgba(0,0,0,0.08);
  text-align: center;
}

.image-section h3 {
  font-size: 1.2rem;
  font-weight: 800;
  color: #1e293b;
  margin-bottom: 1.5rem;
}

.image-wrapper {
  display: inline-block;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 20px 40px rgba(0,0,0,0.15);
}

.image-wrapper img {
  max-width: 500px;
  height: auto;
  display: block;
  border-radius: 12px;
}

.form-card {
  background: white;
  border-radius: 16px;
  padding: 2rem;
  box-shadow: 0 10px 30px rgba(0,0,0,0.08);
  border-top: 5px solid #3b82f6;
}

.form-card h3 {
  font-size: 1.2rem;
  font-weight: 800;
  color: #1e293b;
  margin-bottom: 1.5rem;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.form-group {
  margin-bottom: 1.5rem;
}

.form-label {
  font-weight: 700;
  color: #1e293b;
  margin-bottom: 0.6rem;
  display: block;
  font-size: 0.95rem;
}

.form-control {
  border: 2px solid #e2e8f0;
  border-radius: 10px;
  padding: 0.8rem 1rem;
  font-size: 1rem;
  transition: all 0.3s;
  font-family: inherit;
}

.form-control:focus {
  outline: none;
  border-color: #3b82f6;
  box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
}

.form-buttons {
  display: flex;
  gap: 1rem;
  margin-top: 2rem;
}

.btn-primary-custom {
  background: var(--primary-gradient);
  color: white;
  border: none;
  padding: 0.95rem 2rem;
  border-radius: 10px;
  font-weight: 700;
  font-size: 0.95rem;
  cursor: pointer;
  transition: all 0.3s;
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
}

.btn-primary-custom:hover {
  transform: translateY(-2px);
  box-shadow: var(--glow);
}

.btn-primary-custom:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.alert-info {
  background: linear-gradient(135deg, #dbeafe, #bfdbfe);
  border: 2px solid #3b82f6;
  color: #1d4ed8;
  padding: 1rem 1.5rem;
  border-radius: 10px;
  margin-bottom: 1.5rem;
  font-weight: 600;
}

.alert-success {
  background: linear-gradient(135deg, #dcfce7, #bbf7d0);
  border: 2px solid #10b981;
  color: #047857;
  padding: 1rem 1.5rem;
  border-radius: 10px;
  margin-bottom: 1.5rem;
  font-weight: 600;
}

.row-responsive {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 1.5rem;
  margin-bottom: 1.5rem;
}

@media (max-width: 768px) {
  .page-header {
    padding: 1.5rem 1rem;
  }

  .page-header h1 {
    font-size: 1.5rem;
  }

  .info-card {
    padding: 1.5rem;
  }

  .form-card {
    padding: 1.5rem;
  }

  .image-wrapper img {
    max-width: 100%;
  }

  .form-buttons {
    flex-direction: column;
  }

  .btn-primary-custom {
    width: 100%;
    justify-content: center;
  }
}
</style>

<div class="page-header">
  <div class="content-wrapper">
    <div style="display: flex; align-items: center; justify-content: space-between;">
      <div>
        <h1>🎮 تفاصيل طلب الشحن #{{ $gameRequest->id }}</h1>
        <p style="margin: 0.5rem 0 0 0; opacity: 0.9;">إدارة وتتبع طلب شحن رصيد اللعبة</p>
      </div>
      <a href="{{ route('admin.game-recharge.index') }}" class="btn-back">
        ← العودة للقائمة
      </a>
    </div>
  </div>
</div>

<div class="content-wrapper">
  @if(session('success'))
    <div class="alert-success">
      ✅ {{ session('success') }}
    </div>
  @endif

  <!-- معلومات الطلب -->
  <div class="info-card">
    <div class="card-header-info">
      <div class="card-header-icon blue">🎮</div>
      <div class="card-header-title">
        <h3>معلومات الطلب</h3>
        <p>تفاصيل اللعبة والفئة والسعر</p>
      </div>
    </div>
    <div class="info-grid">
      <div class="info-item">
        <span class="info-label">اللعبة/التطبيق</span>
        <span class="info-value">{{ $gameRequest->game_name }}</span>
      </div>

      @if($gameRequest->gameCategory)
        <div class="info-item">
          <span class="info-label">فئة الشحن</span>
          <a href="{{ route('admin.game-categories.show', $gameRequest->gameCategory) }}" class="info-value link">
            {{ $gameRequest->gameCategory->name }} ↗
          </a>
        </div>
        <div class="info-item">
          <span class="info-label">السعر</span>
          <span class="info-value">{{ number_format($gameRequest->gameCategory->price, 2) }} ل.س</span>
        </div>
      @endif

      <div class="info-item">
        <span class="info-label">معرّف اللاعب</span>
        <span class="info-value" style="font-family: 'Courier New', monospace; background: #f1f5f9; padding: 0.5rem; border-radius: 6px;">{{ $gameRequest->player_id }}</span>
      </div>

      <div class="info-item">
        <span class="info-label">تاريخ الطلب</span>
        <span class="info-value">{{ $gameRequest->created_at->format('d/m/Y H:i') }}</span>
      </div>

      <div class="info-item">
        <span class="info-label">الحالة الحالية</span>
        <span class="status-badge status-{{ $gameRequest->status }}">
          @if($gameRequest->status == 'pending') ⏳ قيد الانتظار
          @elseif($gameRequest->status == 'processing') ⚙️ قيد المعالجة
          @elseif($gameRequest->status == 'completed') ✅ مكتمل
          @else ❌ مرفوض
          @endif
        </span>
      </div>
    </div>
  </div>

  <!-- معلومات العميل -->
  <div class="info-card success">
    <div class="card-header-info">
      <div class="card-header-icon green">👤</div>
      <div class="card-header-title">
        <h3>معلومات العميل</h3>
        <p>بيانات الشخص الذي قام بالطلب</p>
      </div>
    </div>
    <div class="info-grid">
      <div class="info-item">
        <span class="info-label">اسم العميل</span>
        <span class="info-value">{{ $gameRequest->customer_name ?: '—' }}</span>
      </div>
      <div class="info-item">
        <span class="info-label">رقم الهاتف</span>
        <span class="info-value">{{ $gameRequest->customer_phone ?: '—' }}</span>
      </div>
      <div class="info-item">
        <span class="info-label">الملاحظات</span>
        <span class="info-value">{{ $gameRequest->notes ?: 'لا توجد ملاحظات' }}</span>
      </div>
    </div>
  </div>

  <!-- صورة الإثبات -->
  @if($gameRequest->proof_image)
    <div class="image-section">
      <h3>📸 صورة إثبات الشحن</h3>
      <div class="image-wrapper">
        <img src="{{ asset('storage/' . $gameRequest->proof_image) }}" alt="إثبات الشحن">
      </div>
    </div>
  @else
    <div class="alert-info">
      ℹ️ لم يتم رفع صورة إثبات للشحن
    </div>
  @endif

  <!-- تحديث الحالة -->
  <div class="form-card">
    <h3>🔄 تحديث حالة الطلب</h3>
    <form action="{{ route('admin.game-recharge.update-status', $gameRequest) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="form-group">
        <label for="status" class="form-label">اختر الحالة الجديدة</label>
        <select name="status" id="status" class="form-control" required>
          <option value="pending" {{ $gameRequest->status == 'pending' ? 'selected' : '' }}>⏳ قيد الانتظار</option>
          <option value="processing" {{ $gameRequest->status == 'processing' ? 'selected' : '' }}>⚙️ قيد المعالجة</option>
          <option value="completed" {{ $gameRequest->status == 'completed' ? 'selected' : '' }}>✅ مكتمل</option>
          <option value="rejected" {{ $gameRequest->status == 'rejected' ? 'selected' : '' }}>❌ مرفوض</option>
        </select>
      </div>

      <div class="form-buttons">
        <button type="submit" class="btn-primary-custom">
          💾 تحديث الحالة
        </button>
        <a href="{{ route('admin.game-recharge.index') }}" class="btn-primary-custom" style="background: #64748b; cursor: pointer;">
          ← إلغاء
        </a>
      </div>
    </form>
  </div>
</div>

@endsection