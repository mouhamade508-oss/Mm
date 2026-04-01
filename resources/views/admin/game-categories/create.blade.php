@extends('layouts.admin')

@section('title', 'إضافة فئة جديدة')

@section('content')
<style>
.form-container {
    max-width: 600px;
    margin: 2rem auto;
}

.form-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    border-radius: 20px 20px 0 0;
    text-align: center;
    margin-bottom: 0;
}

.form-header h1 {
    font-size: 2rem;
    font-weight: 900;
    margin: 0;
}

.form-header p {
    margin: 0.5rem 0 0 0;
    opacity: 0.9;
}

.form-card {
    background: white;
    border-radius: 0 0 20px 20px;
    padding: 2.5rem;
    box-shadow: 0 20px 50px rgba(102, 126, 234, 0.15);
    border: 1px solid rgba(102, 126, 234, 0.1);
}

.form-group-custom {
    margin-bottom: 2rem;
}

.form-label {
    display: block;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.8rem;
    font-size: 0.95rem;
}

.form-label .required {
    color: #ef4444;
    margin-left: 0.3rem;
}

.form-control-custom,
.form-select-custom {
    width: 100%;
    padding: 0.9rem 1.2rem;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    font-size: 1rem;
    font-family: inherit;
    transition: all 0.3s ease;
    background: white;
}

.form-control-custom:focus,
.form-select-custom:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
}

textarea.form-control-custom {
    resize: vertical;
    min-height: 120px;
}

.price-input-wrapper {
    position: relative;
}

.price-currency {
    position: absolute;
    right: 1.2rem;
    top: 50%;
    transform: translateY(-50%);
    color: #667eea;
    font-weight: 700;
    pointer-events: none;
}

.form-control-custom.has-currency {
    padding-right: 3rem;
}

.checkbox-wrapper {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.2rem;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    border-radius: 12px;
    cursor: pointer;
}

.checkbox-wrapper input[type="checkbox"] {
    width: 20px;
    height: 20px;
    cursor: pointer;
    accent-color: #667eea;
}

.checkbox-label {
    cursor: pointer;
    color: #1e293b;
    font-weight: 600;
}

.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 2.5rem;
}

.btn-submit {
    flex: 1;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 1rem 2rem;
    border-radius: 12px;
    font-weight: 700;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
}

.btn-submit:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
}

.btn-cancel {
    flex: 1;
    background: #f1f5f9;
    color: #64748b;
    border: 2px solid #e2e8f0;
    padding: 1rem 2rem;
    border-radius: 12px;
    font-weight: 700;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    text-align: center;
}

.btn-cancel:hover {
    background: #e2e8f0;
    border-color: #cbd5e1;
}

.error-message {
    color: #ef4444;
    font-size: 0.85rem;
    margin-top: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.error-message::before {
    content: "⚠️";
}

.success-message {
    background: linear-gradient(135deg, rgba(34, 197, 94, 0.1) 0%, rgba(34, 197, 94, 0.05) 100%);
    border: 1px solid #86efac;
    color: #16a34a;
    padding: 1rem;
    border-radius: 12px;
    margin-bottom: 2rem;
}

.price-info {
    font-size: 0.85rem;
    color: #64748b;
    margin-top: 0.5rem;
}

@media (max-width: 768px) {
    .form-container {
        margin: 1rem;
    }
    
    .form-card {
        padding: 1.5rem;
    }
    
    .form-actions {
        flex-direction: column;
    }
}
</style>

<div class="form-container">
    <div class="form-header">
        <h1>➕ إضافة فئة جديدة</h1>
        <p>أنشئ فئة / حزمة جديدة للعبة</p>
    </div>

    <div class="form-card">
        <form method="POST" action="{{ route('admin.game-categories.store') }}">
            @csrf

            <!-- Game Selection -->
            <div class="form-group-custom">
                <label class="form-label">
                    🎮 اختر اللعبة
                    <span class="required">*</span>
                </label>
                <select class="form-select-custom" name="game_id" required>
                    <option value="">-- اختر اللعبة --</option>
                    @foreach($games as $game)
                        <option value="{{ $game->id }}" {{ old('game_id', request('game_id')) == $game->id ? 'selected' : '' }}>
                            {{ $game->name }}
                        </option>
                    @endforeach
                </select>
                @error('game_id')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Category Name -->
            <div class="form-group-custom">
                <label class="form-label">
                    📝 اسم الفئة
                    <span class="required">*</span>
                </label>
                <input 
                    type="text" 
                    class="form-control-custom" 
                    name="name" 
                    value="{{ old('name') }}" 
                    placeholder="مثال: حزمة 100 دولار" 
                    required
                >
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Description -->
            <div class="form-group-custom">
                <label class="form-label">
                    📄 الوصف
                </label>
                <textarea 
                    class="form-control-custom" 
                    name="description" 
                    placeholder="اكتب وصفاً تفصيلياً عن هذه الفئة/الحزمة..."
                >{{ old('description') }}</textarea>
                @error('description')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Price -->
            <div class="form-group-custom">
                <label class="form-label">
                    💰 السعر
                    <span class="required">*</span>
                </label>
                <div class="price-input-wrapper">
                    <input 
                        type="number" 
                        class="form-control-custom has-currency" 
                        name="price" 
                        value="{{ old('price') }}" 
                        step="0.01" 
                        min="0" 
                        placeholder="0.00"
                        required
                    >
                    <div class="price-currency">ل.س</div>
                </div>
                <div class="price-info">اكتب السعر برقم صحيح أو عشري (مثال: 100 أو 99.99)</div>
                @error('price')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Active Status -->
            <div class="form-group-custom">
                <label class="checkbox-wrapper">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                    <span class="checkbox-label">✓ تفعيل هذه الفئة فوراً</span>
                </label>
            </div>

            <!-- Actions -->
            <div class="form-actions">
                <button type="submit" class="btn-submit">💾 حفظ الفئة</button>
                <a href="{{ route('admin.game-categories.index') }}" class="btn-cancel">← العودة</a>
            </div>
        </form>
    </div>
</div>

@endsection