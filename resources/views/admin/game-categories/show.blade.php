@extends('layouts.admin')

@section('title', 'تفاصيل الفئة')

@section('content')
<style>
.details-container {
    max-width: 700px;
    margin: 2rem auto;
    padding: 1rem;
}

.details-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    border-radius: 20px 20px 0 0;
    text-align: center;
    margin-bottom: 0;
}

.details-header h1 {
    font-size: 2rem;
    font-weight: 900;
    margin: 0;
}

.details-header p {
    margin: 0.5rem 0 0 0;
    opacity: 0.9;
}

.details-card {
    background: white;
    border-radius: 0 0 20px 20px;
    padding: 2.5rem;
    box-shadow: 0 20px 50px rgba(102, 126, 234, 0.15);
    border: 1px solid rgba(102, 126, 234, 0.1);
}

.detail-section {
    margin-bottom: 2.5rem;
}

.detail-section:last-child {
    margin-bottom: 2rem;
}

.detail-item {
    display: flex;
    align-items: flex-start;
    padding: 1.5rem;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
    border-radius: 12px;
    margin-bottom: 1rem;
    border-left: 4px solid #667eea;
    transition: all 0.3s ease;
}

.detail-item:hover {
    transform: translateX(5px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.1);
}

.detail-icon {
    font-size: 1.8rem;
    margin-right: 1rem;
    min-width: 40px;
    text-align: center;
}

.detail-content {
    flex: 1;
}

.detail-label {
    font-size: 0.85rem;
    font-weight: 700;
    text-transform: uppercase;
    color: #64748b;
    letter-spacing: 0.5px;
    margin-bottom: 0.3rem;
}

.detail-value {
    font-size: 1rem;
    color: #1e293b;
    font-weight: 600;
}

.detail-value a {
    color: #667eea;
    text-decoration: none;
    border-bottom: 2px solid #e2e8f0;
    transition: all 0.3s ease;
}

.detail-value a:hover {
    color: #764ba2;
    border-bottom-color: #667eea;
}

.badge-status {
    display: inline-block;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: 700;
    font-size: 0.85rem;
    text-transform: uppercase;
}

.badge-active {
    background: linear-gradient(135deg, rgba(34, 197, 94, 0.2) 0%, rgba(34, 197, 94, 0.1) 100%);
    color: #16a34a;
    border: 1px solid #86efac;
}

.badge-inactive {
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.2) 0%, rgba(239, 68, 68, 0.1) 100%);
    color: #dc2626;
    border: 1px solid #fecaca;
}

.price-highlight {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-size: 1.5rem;
}

.description-text {
    line-height: 1.6;
    color: #475569;
}

.actions-section {
    display: flex;
    gap: 1rem;
    margin-top: 2.5rem;
    padding-top: 2rem;
    border-top: 2px solid #e2e8f0;
}

.btn-action {
    flex: 1;
    padding: 0.9rem 1.5rem;
    border: none;
    border-radius: 12px;
    font-weight: 700;
    font-size: 0.95rem;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    text-align: center;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.btn-edit {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: white;
    box-shadow: 0 10px 25px rgba(245, 87, 108, 0.3);
}

.btn-edit:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 35px rgba(245, 87, 108, 0.4);
}

.btn-back {
    background: #f1f5f9;
    color: #64748b;
    border: 2px solid #e2e8f0;
}

.btn-back:hover {
    background: #e2e8f0;
    border-color: #cbd5e1;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 2px solid #e2e8f0;
}

.info-box {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(59, 130, 246, 0.05) 100%);
    border: 1px solid #93c5fd;
    padding: 1rem;
    border-radius: 12px;
    text-align: center;
}

.info-label {
    font-size: 0.75rem;
    text-transform: uppercase;
    color: #64748b;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.info-value {
    font-size: 1.1rem;
    color: #1e40af;
    font-weight: 700;
}

@media (max-width: 768px) {
    .details-container {
        margin: 1rem 0;
    }
    
    .details-card {
        padding: 1.5rem;
    }

    .actions-section {
        flex-direction: column;
    }

    .info-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="details-container">
    <div class="details-header">
        <h1>📦 تفاصيل الفئة</h1>
        <p>{{ $gameCategory->name }}</p>
    </div>

    <div class="details-card">
        <!-- Main Details -->
        <div class="detail-section">
            <!-- Game -->
            <div class="detail-item">
                <div class="detail-icon">🎮</div>
                <div class="detail-content">
                    <div class="detail-label">اللعبة</div>
                    <div class="detail-value">
                        <a href="{{ route('admin.games.show', $gameCategory->game) }}">
                            {{ $gameCategory->game->name }} →
                        </a>
                    </div>
                </div>
            </div>

            <!-- Category Name -->
            <div class="detail-item">
                <div class="detail-icon">📝</div>
                <div class="detail-content">
                    <div class="detail-label">اسم الفئة</div>
                    <div class="detail-value">{{ $gameCategory->name }}</div>
                </div>
            </div>

            <!-- Price -->
            <div class="detail-item">
                <div class="detail-icon">💰</div>
                <div class="detail-content">
                    <div class="detail-label">السعر</div>
                    <div class="detail-value price-highlight">{{ number_format($gameCategory->price, 2) }} ر.س</div>
                </div>
            </div>

            <!-- Status -->
            <div class="detail-item">
                <div class="detail-icon">✨</div>
                <div class="detail-content">
                    <div class="detail-label">الحالة</div>
                    <div class="detail-value">
                        <span class="badge-status {{ $gameCategory->is_active ? 'badge-active' : 'badge-inactive' }}">
                            {{ $gameCategory->is_active ? '🟢 نشطة' : '🔴 معطلة' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Description -->
        @if($gameCategory->description)
            <div class="detail-section">
                <div class="detail-item">
                    <div class="detail-icon">📄</div>
                    <div class="detail-content">
                        <div class="detail-label">الوصف</div>
                        <div class="detail-value description-text">{{ $gameCategory->description }}</div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Timestamps -->
        <div class="info-grid">
            <div class="info-box">
                <div class="info-label">تاريخ الإنشاء</div>
                <div class="info-value">{{ $gameCategory->created_at->format('d/m/Y') }}</div>
                <div style="font-size: 0.75rem; color: #64748b; margin-top: 0.5rem;">{{ $gameCategory->created_at->format('H:i') }}</div>
            </div>
            <div class="info-box">
                <div class="info-label">آخر تحديث</div>
                <div class="info-value">{{ $gameCategory->updated_at->format('d/m/Y') }}</div>
                <div style="font-size: 0.75rem; color: #64748b; margin-top: 0.5rem;">{{ $gameCategory->updated_at->format('H:i') }}</div>
            </div>
            <div class="info-box">
                <div class="info-label">رقم الفئة</div>
                <div class="info-value">#{{ $gameCategory->id }}</div>
            </div>
        </div>

        <!-- Actions -->
        <div class="actions-section">
            <a href="{{ route('admin.game-categories.edit', $gameCategory) }}" class="btn-action btn-edit">✏️ تعديل الفئة</a>
            <a href="{{ route('admin.game-categories.index') }}" class="btn-action btn-back">← العودة للقائمة</a>
        </div>
    </div>
</div>

@endsection