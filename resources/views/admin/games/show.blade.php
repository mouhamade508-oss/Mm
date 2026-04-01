@extends('layouts.admin')

@section('title', 'تفاصيل اللعبة')

@section('content')
<style>
.details-wrapper {
    padding: 2rem 1rem;
    max-width: 1200px;
    margin: 0 auto;
}

.details-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    border-radius: 20px;
    margin-bottom: 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 20px 50px rgba(102, 126, 234, 0.2);
}

.header-content h1 {
    margin: 0;
    font-size: 2rem;
    font-weight: 900;
}

.header-actions {
    display: flex;
    gap: 0.8rem;
}

.btn-header {
    background: white;
    color: #667eea;
    border: none;
    padding: 0.8rem 1.5rem;
    border-radius: 12px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
}

.btn-header:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
}

.details-grid {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 2rem;
    margin-bottom: 2rem;
}

.details-main {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
}

.game-image-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
}

.game-image-wrapper {
    width: 100%;
    aspect-ratio: 1;
    overflow: hidden;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
}

.game-image-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.game-info-section {
    padding: 1.5rem;
}

.info-badge {
    display: inline-block;
    padding: 0.4rem 0.8rem;
    background: linear-gradient(135deg, rgba(34, 197, 94, 0.15) 0%, rgba(34, 197, 94, 0.1) 100%);
    color: #16a34a;
    border: 1px solid #86efac;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 700;
}

.info-badge.inactive {
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.15) 0%, rgba(239, 68, 68, 0.1) 100%);
    color: #dc2626;
    border-color: #fecaca;
}

.section-title {
    font-size: 1.3rem;
    font-weight: 800;
    color: #1e293b;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.8rem;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    padding: 1rem 0;
    border-bottom: 1px solid #f0f1f3;
    align-items: start;
}

.detail-row:last-child {
    border-bottom: none;
}

.detail-label {
    font-weight: 700;
    color: #64748b;
    font-size: 0.9rem;
    min-width: 120px;
}

.detail-value {
    color: #1e293b;
    text-align: right;
    flex: 1;
}

.description-text {
    line-height: 1.6;
    color: #475569;
}

.categories-section {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    grid-column: 1 / -1;
}

.categories-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.btn-add-category {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 0.8rem 1.5rem;
    border-radius: 12px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
}

.btn-add-category:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
}

.categories-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 1.5rem;
}

.category-mini-card {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    padding: 1.2rem;
    transition: all 0.3s ease;
}

.category-mini-card:hover {
    transform: translateY(-5px);
    border-color: #667eea;
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.1);
}

.cat-name {
    font-weight: 800;
    color: #1e293b;
    margin-bottom: 0.5rem;
    font-size: 1rem;
}

.cat-price {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-size: 1.3rem;
    font-weight: 900;
    margin-bottom: 0.8rem;
}

.cat-status {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.8rem 0;
    border-top: 1px solid #e5e7eb;
    margin-top: 0.8rem;
}

.cat-actions {
    display: flex;
    gap: 0.5rem;
    margin-top: 0.8rem;
}

.btn-cat-edit {
    flex: 1;
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: white;
    border: none;
    padding: 0.5rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-cat-edit:hover {
    transform: translateY(-2px);
}

.btn-cat-delete {
    flex: 1;
    background: linear-gradient(135deg, #fa7e1e 0%, #d62828 100%);
    color: white;
    border: none;
    padding: 0.5rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-cat-delete:hover {
    transform: translateY(-2px);
}

.empty-state {
    text-align: center;
    padding: 3rem;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
    border-radius: 12px;
    border: 2px dashed #667eea;
}

.empty-state-icon {
    font-size: 3rem;
    margin-bottom: 1rem;
}

.empty-state-text {
    color: #64748b;
    margin-bottom: 1rem;
}

@media (max-width: 968px) {
    .details-grid {
        grid-template-columns: 1fr;
    }

    .details-header {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
}

@media (max-width: 768px) {
    .details-wrapper {
        padding: 1rem;
    }

    .categories-grid {
        grid-template-columns: 1fr;
    }

    .header-actions {
        width: 100%;
        flex-direction: column;
    }

    .btn-header {
        width: 100%;
    }
}
</style>

<div class="details-wrapper">
    <!-- Header -->
    <div class="details-header">
        <div class="header-content">
            <h1>🎮 {{ $game->name }}</h1>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.games.edit', $game) }}" class="btn-header">✏️ تعديل</a>
            <a href="{{ route('admin.games.index') }}" class="btn-header">← العودة</a>
        </div>
    </div>

    <!-- Main Details Grid -->
    <div class="details-grid">
        <!-- Details -->
        <div class="details-main">
            <div class="section-title">📋 معلومات اللعبة</div>

            <div class="detail-row">
                <span class="detail-label">الاسم:</span>
                <span class="detail-value">{{ $game->name }}</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">الحالة:</span>
                <span class="detail-value">
                    <span class="info-badge {{ !$game->is_active ? 'inactive' : '' }}">
                        {{ $game->is_active ? '🟢 نشطة' : '🔴 معطلة' }}
                    </span>
                </span>
            </div>

            @if($game->description)
                <div class="detail-row">
                    <span class="detail-label">الوصف:</span>
                    <span class="detail-value description-text">{{ $game->description }}</span>
                </div>
            @endif

            <div class="detail-row">
                <span class="detail-label">تاريخ الإنشاء:</span>
                <span class="detail-value">{{ $game->created_at->format('d/m/Y H:i') }}</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">آخر تحديث:</span>
                <span class="detail-value">{{ $game->updated_at->format('d/m/Y H:i') }}</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">عدد الفئات:</span>
                <span class="detail-value" style="font-size: 1.3rem; font-weight: 900; color: #667eea;">{{ $game->categories->count() }}</span>
            </div>
        </div>

        <!-- Image -->
        <div class="game-image-card">
            <div class="game-image-wrapper">
                @if($game->image_url)
                    <img src="{{ $game->image_url }}" alt="{{ $game->name }}">
                @else
                    <div style="text-align: center; color: #94a3b8;">
                        <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">🎮</div>
                        <div>لا توجد صورة</div>
                    </div>
                @endif
            </div>
            <div class="game-info-section">
                <div style="text-align: center;">
                    <div style="color: #64748b; font-size: 0.85rem; font-weight: 600;">رقم اللعبة</div>
                    <div style="font-size: 1.3rem; font-weight: 900; color: #667eea;">#{{ $game->id }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories Section -->
    <div class="categories-section">
        <div class="categories-header">
            <div class="section-title">📦 فئات ووحدات اللعبة</div>
            <a href="{{ route('admin.game-categories.create') }}?game_id={{ $game->id }}" class="btn-add-category">➕ إضافة فئة جديدة</a>
        </div>

        @if($game->categories->count() > 0)
            <div class="categories-grid">
                @foreach($game->categories as $category)
                    <div class="category-mini-card">
                        <div class="cat-name">{{ $category->name }}</div>
                        <div class="cat-price">{{ number_format($category->price, 2) }} ل.س</div>
                        
                        @if($category->description)
                            <div style="font-size: 0.85rem; color: #64748b; margin: 0.8rem 0; line-height: 1.4;">
                                {{ Str::limit($category->description, 80) }}
                            </div>
                        @endif

                        <div class="cat-status">
                            <span class="info-badge {{ !$category->is_active ? 'inactive' : '' }}">
                                {{ $category->is_active ? '🟢 نشطة' : '🔴 معطلة' }}
                            </span>
                        </div>

                        <div class="cat-actions">
                            <a href="{{ route('admin.game-categories.edit', $category) }}" class="btn-cat-edit">✏️ تعديل</a>
                            <form method="POST" action="{{ route('admin.game-categories.destroy', $category) }}" style="flex: 1;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-cat-delete" onclick="return confirm('هل أنت متأكد من حذف هذه الفئة؟')">🗑️ حذف</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">📭</div>
                <p class="empty-state-text">لا توجد فئات لهذه اللعبة حتى الآن</p>
                <a href="{{ route('admin.game-categories.create') }}?game_id={{ $game->id }}" class="btn-add-category">➕ إضافة أول فئة</a>
            </div>
        @endif
    </div>
</div>

@endsection