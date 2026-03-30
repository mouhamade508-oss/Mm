@extends('layouts.admin')

@section('title', 'إدارة الألعاب والتطبيقات')

@section('content')
<style>
.games-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2.5rem 2rem;
    border-radius: 20px;
    margin-bottom: 2.5rem;
    box-shadow: 0 15px 40px rgba(102, 126, 234, 0.2);
}

.games-header h1 {
    font-size: 2.5rem;
    font-weight: 900;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.games-header p {
    margin: 0.5rem 0 0 0;
    opacity: 0.9;
    font-size: 1rem;
}

.add-game-btn {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: white;
    border: none;
    padding: 0.9rem 2.5rem;
    border-radius: 50px;
    font-weight: 700;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 10px 25px rgba(245, 87, 108, 0.3);
    display: inline-flex;
    align-items: center;
    gap: 0.7rem;
    text-decoration: none;
}

.add-game-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 35px rgba(245, 87, 108, 0.4);
    color: white;
}

.alert-success {
    background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);
    border: none;
    color: #0f6946;
    border-radius: 15px;
    padding: 1.2rem 1.5rem;
    margin-bottom: 2rem;
    font-weight: 600;
}

.alert-success::before {
    content: '✓ ';
    margin-right: 0.5rem;
    font-weight: 900;
}

.games-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 2rem;
    margin-bottom: 3rem;
}

.game-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 35px rgba(0, 0, 0, 0.08);
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    border: 1px solid rgba(102, 126, 234, 0.1);
    position: relative;
}

.game-card:hover {
    transform: translateY(-15px);
    box-shadow: 0 25px 55px rgba(102, 126, 234, 0.25);
}

.game-image-container {
    position: relative;
    height: 200px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    overflow: hidden;
}

.game-image-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.game-card:hover .game-image-container img {
    transform: scale(1.1);
}

.no-image-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3rem;
    opacity: 0.3;
}

.status-badge {
    position: absolute;
    top: 12px;
    right: 12px;
    padding: 0.4rem 1rem;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 700;
    backdrop-filter: blur(10px);
}

.status-active {
    background: rgba(132, 250, 176, 0.95);
    color: #0f6946;
}

.status-inactive {
    background: rgba(255, 182, 193, 0.95);
    color: #8b0000;
}

.game-info {
    padding: 1.8rem;
}

.game-name {
    font-size: 1.3rem;
    font-weight: 800;
    color: #1e293b;
    margin-bottom: 0.8rem;
    line-height: 1.3;
}

.game-description {
    color: #64748b;
    font-size: 0.9rem;
    line-height: 1.5;
    margin-bottom: 1.2rem;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.game-stats {
    display: flex;
    gap: 1rem;
    margin-bottom: 1.5rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid #e2e8f0;
}

.stat-item {
    flex: 1;
    text-align: center;
}

.stat-value {
    font-size: 1.4rem;
    font-weight: 900;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.stat-label {
    font-size: 0.75rem;
    color: #94a3b8;
    font-weight: 600;
    margin-top: 0.3rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.game-actions {
    display: flex;
    gap: 0.7rem;
}

.action-btn {
    flex: 1;
    padding: 0.7rem 1rem;
    border: none;
    border-radius: 12px;
    font-weight: 700;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.3s ease;
    text-align: center;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.action-view {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.action-view:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
}

.action-edit {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: white;
}

.action-edit:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(245, 87, 108, 0.3);
}

.action-delete {
    background: linear-gradient(135deg, #fa7e1e 0%, #d62828 100%);
    color: white;
}

.action-delete:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(250, 126, 30, 0.3);
}

.no-games {
    text-align: center;
    padding: 4rem 2rem;
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    border-radius: 20px;
    margin: 2rem 0;
}

.no-games-icon {
    font-size: 4rem;
    margin-bottom: 1rem;
}

.no-games-title {
    font-size: 1.8rem;
    font-weight: 800;
    color: #1e293b;
    margin-bottom: 0.5rem;
}

.no-games-text {
    color: #64748b;
    font-size: 1rem;
    margin-bottom: 2rem;
}

.pagination-custom {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    margin-top: 3rem;
}

.pagination-custom a, .pagination-custom span {
    padding: 0.6rem 1rem;
    border-radius: 12px;
    text-decoration: none;
    color: #667eea;
    font-weight: 600;
    transition: all 0.3s;
    background: white;
    border: 1px solid #e2e8f0;
}

.pagination-custom a:hover {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    transform: translateY(-2px);
}

.pagination-custom .active span {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-color: transparent;
}

@media (max-width: 768px) {
    .games-header h1 {
        font-size: 1.8rem;
    }
    
    .games-grid {
        grid-template-columns: 1fr;
    }
    
    .game-actions {
        flex-direction: column;
    }
    
    .action-btn {
        width: 100%;
    }
}
</style>

<div style="padding: 2rem;">
    <!-- Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div class="games-header" style="flex: 1; margin-right: 2rem;">
            <h1>🎮 إدارة الألعاب والتطبيقات</h1>
            <p>أضف وأدر جميع الألعاب والتطبيقات المتاحة</p>
        </div>
        <a href="{{ route('admin.games.create') }}" class="add-game-btn">
            <span>✨</span> إضافة لعبة جديدة
        </a>
    </div>

    <!-- Success Alert -->
    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Games Grid -->
    @if($games->count() > 0)
        <div class="games-grid">
            @foreach($games as $game)
                <div class="game-card">
                    <!-- Image Container -->
                    <div class="game-image-container">
                        @if($game->image)
                            <img src="{{ asset('storage/' . $game->image) }}" alt="{{ $game->name }}">
                        @else
                            <div class="no-image-placeholder">🎮</div>
                        @endif
                        <div class="status-badge {{ $game->is_active ? 'status-active' : 'status-inactive' }}">
                            {{ $game->is_active ? '✓ نشط' : '✕ غير نشط' }}
                        </div>
                    </div>

                    <!-- Info -->
                    <div class="game-info">
                        <h3 class="game-name">{{ $game->name }}</h3>
                        <p class="game-description">
                            {{ $game->description ?: 'لا يوجد وصف متاح' }}
                        </p>

                        <!-- Stats -->
                        <div class="game-stats">
                            <div class="stat-item">
                                <div class="stat-value">{{ $game->categories->count() }}</div>
                                <div class="stat-label">فئات</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value">#{{ $game->id }}</div>
                                <div class="stat-label">ID</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value">{{ $game->created_at->format('m/d') }}</div>
                                <div class="stat-label">التاريخ</div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="game-actions">
                            <a href="{{ route('admin.games.show', $game) }}" class="action-btn action-view">
                                👁️ عرض
                            </a>
                            <a href="{{ route('admin.games.edit', $game) }}" class="action-btn action-edit">
                                ✏️ تعديل
                            </a>
                            <form method="POST" action="{{ route('admin.games.destroy', $game) }}" style="flex: 1;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn action-delete" style="width: 100%;" onclick="return confirm('هل أنت متأكد من حذف &quot;{{ $game->name }}&quot;؟')">
                                    🗑️ حذف
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($games->hasPages())
            <div class="pagination-custom">
                {{ $games->links() }}
            </div>
        @endif
    @else
        <!-- Empty State -->
        <div class="no-games">
            <div class="no-games-icon">🎮</div>
            <h3 class="no-games-title">لا توجد ألعاب</h3>
            <p class="no-games-text">ابدأ بإضافة أول لعبة أو تطبيق الآن</p>
            <a href="{{ route('admin.games.create') }}" class="add-game-btn">
                <span>➕</span> إضافة أول لعبة
            </a>
        </div>
    @endif
</div>

@endsection