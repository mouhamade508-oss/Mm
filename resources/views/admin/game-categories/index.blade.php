@extends('layouts.admin')

@section('title', 'فئات الألعاب')

@section('content')
<style>
.categories-container {
    margin: 0 auto;
    padding: 2rem 1rem;
}

.page-header {
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

.header-content p {
    margin: 0.5rem 0 0 0;
    opacity: 0.9;
    font-size: 0.95rem;
}

.btn-add-new {
    background: white;
    color: #667eea;
    padding: 0.8rem 1.5rem;
    border-radius: 12px;
    border: none;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
}

.btn-add-new:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
}

.categories-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 2rem;
    margin-bottom: 2rem;
}

.category-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    border: 1px solid #f0f1f3;
}

.category-card:hover {
    transform: translateY(-15px);
    box-shadow: 0 30px 60px rgba(102, 126, 234, 0.15);
}

.category-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 1.5rem;
    min-height: 120px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.category-title {
    font-size: 1.3rem;
    font-weight: 800;
    margin: 0;
    word-break: break-word;
}

.category-game {
    font-size: 0.85rem;
    margin-top: 0.5rem;
    opacity: 0.9;
}

.category-body {
    padding: 1.5rem;
}

.category-price {
    text-align: center;
    margin-bottom: 1rem;
}

.price-label {
    font-size: 0.75rem;
    text-transform: uppercase;
    color: #94a3b8;
    letter-spacing: 0.5px;
    font-weight: 600;
}

.price-value {
    font-size: 1.8rem;
    font-weight: 900;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.category-description {
    color: #64748b;
    font-size: 0.9rem;
    margin-bottom: 1rem;
    line-height: 1.5;
    height: 60px;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

.category-stats {
    display: flex;
    gap: 1rem;
    margin-bottom: 1.5rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid #f0f1f3;
}

.stat-item {
    flex: 1;
    text-align: center;
}

.stat-label {
    font-size: 0.75rem;
    text-transform: uppercase;
    color: #94a3b8;
    margin-bottom: 0.3rem;
}

.stat-value {
    font-size: 1.2rem;
    font-weight: 700;
    color: #1e293b;
}

.category-status {
    display: inline-block;
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    margin-bottom: 1rem;
    letter-spacing: 0.5px;
}

.status-active {
    background: linear-gradient(135deg, rgba(34, 197, 94, 0.15) 0%, rgba(34, 197, 94, 0.1) 100%);
    color: #16a34a;
    border: 1px solid #86efac;
}

.status-inactive {
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.15) 0%, rgba(239, 68, 68, 0.1) 100%);
    color: #dc2626;
    border: 1px solid #fecaca;
}

.category-actions {
    display: flex;
    gap: 0.8rem;
    margin-top: 1rem;
}

.btn-action {
    flex: 1;
    padding: 0.7rem;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.4rem;
}

.btn-view {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.btn-view:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
}

.btn-edit {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: white;
}

.btn-edit:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(245, 87, 108, 0.3);
}

.btn-delete {
    background: linear-gradient(135deg, #fa7e1e 0%, #d62828 100%);
    color: white;
}

.btn-delete:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(250, 126, 30, 0.3);
}

.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
}

.empty-state-icon {
    font-size: 4rem;
    margin-bottom: 1rem;
}

.empty-state-text {
    color: #64748b;
    font-size: 1.1rem;
    margin-bottom: 2rem;
}

.pagination-container {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    margin-top: 2rem;
}

.pagination-link {
    padding: 0.7rem 1rem;
    border-radius: 10px;
    border: 1px solid #e2e8f0;
    background: white;
    color: #64748b;
    text-decoration: none;
    transition: all 0.3s ease;
    cursor: pointer;
}

.pagination-link.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-color: #667eea;
}

.pagination-link:hover:not(.active) {
    border-color: #667eea;
}

.alert-success {
    background: linear-gradient(135deg, rgba(34, 197, 94, 0.1) 0%, rgba(34, 197, 94, 0.05) 100%);
    border: 1px solid #86efac;
    color: #16a34a;
    padding: 1rem;
    border-radius: 12px;
    margin-bottom: 2rem;
}

@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }

    .categories-grid {
        grid-template-columns: 1fr;
    }

    .header-content h1 {
        font-size: 1.5rem;
    }
}
</style>

<div class="categories-container">
    <!-- Success Message -->
    @if(session('success'))
        <div class="alert-success">
            ✓ {{ session('success') }}
        </div>
    @endif

    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <h1>📦 إدارة فئات الألعاب</h1>
            <p>إدارة جميع فئات وحزم اللعب المتاحة</p>
        </div>
        <a href="{{ route('admin.game-categories.create') }}" class="btn-add-new">➕ إضافة فئة جديدة</a>
    </div>

    <!-- Categories Grid -->
    @if($categories->count() > 0)
        <div class="categories-grid">
            @foreach($categories as $category)
                <div class="category-card">
                    <div class="category-header">
                        <h3 class="category-title">{{ $category->name }}</h3>
                        <p class="category-game">🎮 {{ $category->game->name }}</p>
                    </div>

                    <div class="category-body">
                        <!-- Price -->
                        <div class="category-price">
                            <div class="price-label">السعر</div>
                            <div class="price-value">{{ number_format($category->price, 2) }} ل.س</div>
                        </div>

                        <!-- Description -->
                        @if($category->description)
                            <p class="category-description">{{ $category->description }}</p>
                        @endif

                        <!-- Stats -->
                        <div class="category-stats">
                            <div class="stat-item">
                                <div class="stat-label">الفئة</div>
                                <div class="stat-value">#{{ $category->id }}</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-label">الحالة</div>
                                <div class="stat-value">{{ $category->is_active ? '✓' : '✗' }}</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-label">الإنشاء</div>
                                <div class="stat-value">{{ $category->created_at->format('d/m') }}</div>
                            </div>
                        </div>

                        <!-- Status Badge -->
                        <span class="category-status {{ $category->is_active ? 'status-active' : 'status-inactive' }}">
                            {{ $category->is_active ? '🟢 نشطة' : '🔴 معطلة' }}
                        </span>

                        <!-- Actions -->
                        <div class="category-actions">
                            <a href="{{ route('admin.game-categories.show', $category) }}" class="btn-action btn-view">👁️ عرض</a>
                            <a href="{{ route('admin.game-categories.edit', $category) }}" class="btn-action btn-edit">✏️ تعديل</a>
                            <form method="POST" action="{{ route('admin.game-categories.destroy', $category) }}" style="flex: 1;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-delete" onclick="return confirm('هل أنت متأكد من حذف هذه الفئة؟')">🗑️ حذف</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($categories->hasPages())
            <div class="pagination-container">
                {{ $categories->links() }}
            </div>
        @endif
    @else
        <!-- Empty State -->
        <div class="empty-state">
            <div class="empty-state-icon">📭</div>
            <p class="empty-state-text">لا توجد فئات ألعاب حالياً</p>
            <a href="{{ route('admin.game-categories.create') }}" class="btn-add-new">➕ إضافة الفئة الأولى</a>
        </div>
    @endif
</div>

@endsection