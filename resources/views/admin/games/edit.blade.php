@extends('layouts.admin')

@section('title', 'تعديل اللعبة')

@section('content')
<style>
.form-container {
    max-width: 600px;
    margin: 2rem auto;
}

.form-header {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
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
    box-shadow: 0 20px 50px rgba(245, 87, 108, 0.15);
    border: 1px solid rgba(245, 87, 108, 0.1);
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

.form-control-custom {
    width: 100%;
    padding: 0.9rem 1.2rem;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    font-size: 1rem;
    font-family: inherit;
    transition: all 0.3s ease;
    background: white;
}

.form-control-custom:focus {
    outline: none;
    border-color: #f5576c;
    box-shadow: 0 0 0 4px rgba(245, 87, 108, 0.1);
}

textarea.form-control-custom {
    resize: vertical;
    min-height: 120px;
}

.file-input-wrapper {
    position: relative;
}

.file-input {
    position: absolute;
    left: -9999px;
}

.file-input-label {
    display: block;
    padding: 2rem;
    border: 2px dashed #f5576c;
    border-radius: 12px;
    text-align: center;
    cursor: pointer;
    background: linear-gradient(135deg, rgba(245, 87, 108, 0.05) 0%, rgba(240, 147, 251, 0.05) 100%);
    transition: all 0.3s ease;
}

.file-input-label:hover {
    background: linear-gradient(135deg, rgba(245, 87, 108, 0.1) 0%, rgba(240, 147, 251, 0.1) 100%);
    border-color: #f093fb;
}

.file-input-icon {
    font-size: 2.5rem;
    margin-bottom: 0.8rem;
}

.file-input-text {
    color: #64748b;
    font-weight: 600;
}

.file-input-hint {
    color: #94a3b8;
    font-size: 0.85rem;
    margin-top: 0.5rem;
}

.current-image {
    margin-top: 1rem;
}

.current-image-title {
    font-size: 0.85rem;
    color: #64748b;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.8rem;
}

.image-preview {
    margin-top: 1rem;
    border-radius: 12px;
    overflow: hidden;
    max-width: 200px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

.image-preview img {
    width: 100%;
    height: auto;
    display: block;
}

.checkbox-wrapper {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.2rem;
    background: linear-gradient(135deg, rgba(240, 147, 251, 0.1) 0%, rgba(245, 87, 108, 0.1) 100%);
    border-radius: 12px;
    cursor: pointer;
}

.checkbox-wrapper input[type="checkbox"] {
    width: 20px;
    height: 20px;
    cursor: pointer;
    accent-color: #f5576c;
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
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: white;
    border: none;
    padding: 1rem 2rem;
    border-radius: 12px;
    font-weight: 700;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 10px 25px rgba(245, 87, 108, 0.3);
}

.btn-submit:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 35px rgba(245, 87, 108, 0.4);
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
        <h1>✏️ تعديل اللعبة</h1>
        <p>{{ $game->name }}</p>
    </div>

    <div class="form-card">
        <form method="POST" action="{{ route('admin.games.update', $game) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Game Name -->
            <div class="form-group-custom">
                <label class="form-label">
                    🎮 اسم اللعبة
                    <span class="required">*</span>
                </label>
                <input 
                    type="text" 
                    class="form-control-custom" 
                    name="name" 
                    value="{{ old('name', $game->name) }}" 
                    placeholder="مثال: PUBG Mobile" 
                    required
                >
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Description -->
            <div class="form-group-custom">
                <label class="form-label">
                    📝 الوصف
                </label>
                <textarea 
                    class="form-control-custom" 
                    name="description" 
                    placeholder="اكتب وصفاً جميلاً عن اللعبة..."
                >{{ old('description', $game->description) }}</textarea>
                @error('description')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Image Upload -->
            <div class="form-group-custom">
                <label class="form-label">
                    🖼️ صورة اللعبة
                </label>
                
                @if($game->image)
                    <div class="current-image">
                        <div class="current-image-title">الصورة الحالية:</div>
                        <div class="image-preview">
                            <img src="{{ asset('storage/' . $game->image) }}" alt="{{ $game->name }}">
                        </div>
                    </div>
                @endif

                <div class="file-input-wrapper" style="margin-top: 1.5rem;">
                    <input 
                        type="file" 
                        name="image" 
                        accept="image/*" 
                        class="file-input"
                        id="imageInput"
                    >
                    <label for="imageInput" class="file-input-label">
                        <div class="file-input-icon">📸</div>
                        <div class="file-input-text">اضغط أو اسحب الصورة الجديدة هنا</div>
                        <div class="file-input-hint">JPG, PNG, GIF (حتى 2MB)</div>
                    </label>
                </div>
                <div id="imagePreview"></div>
                @error('image')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Active Status -->
            <div class="form-group-custom">
                <label class="checkbox-wrapper">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $game->is_active) ? 'checked' : '' }}>
                    <span class="checkbox-label">✓ تفعيل هذه اللعبة</span>
                </label>
            </div>

            <!-- Actions -->
            <div class="form-actions">
                <button type="submit" class="btn-submit">💾 تحديث اللعبة</button>
                <a href="{{ route('admin.games.index') }}" class="btn-cancel">← العودة</a>
            </div>
        </form>
    </div>
</div>

<script>
// Image preview
document.getElementById('imageInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('imagePreview');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `
                <div style="margin-top: 1rem;">
                    <div class="current-image-title">المعاينة:</div>
                    <div class="image-preview">
                        <img src="${e.target.result}" alt="Preview">
                    </div>
                </div>
            `;
        };
        reader.readAsDataURL(file);
    } else {
        preview.innerHTML = '';
    }
});

// Drag and drop
const fileInputLabel = document.querySelector('.file-input-label');
const fileInput = document.querySelector('.file-input');

['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    fileInputLabel.addEventListener(eventName, preventDefaults, false);
});

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

['dragenter', 'dragover'].forEach(eventName => {
    fileInputLabel.addEventListener(eventName, highlight, false);
});

['dragleave', 'drop'].forEach(eventName => {
    fileInputLabel.addEventListener(eventName, unhighlight, false);
});

function highlight(e) {
    fileInputLabel.style.background = 'linear-gradient(135deg, rgba(245, 87, 108, 0.2) 0%, rgba(240, 147, 251, 0.2) 100%)';
    fileInputLabel.style.borderColor = '#f093fb';
}

function unhighlight(e) {
    fileInputLabel.style.background = 'linear-gradient(135deg, rgba(245, 87, 108, 0.05) 0%, rgba(240, 147, 251, 0.05) 100%)';
    fileInputLabel.style.borderColor = '#f5576c';
}

fileInputLabel.addEventListener('drop', handleDrop, false);

function handleDrop(e) {
    const dt = e.dataTransfer;
    const files = dt.files;
    fileInput.files = files;
    
    // Trigger change event
    const event = new Event('change', { bubbles: true });
    fileInput.dispatchEvent(event);
}
</script>

@endsection