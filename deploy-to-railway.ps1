# PowerShell deployment script for Windows
# استخدم: .\deploy-to-railway.ps1

Write-Host "🚀 بدء عملية النشر على Railway..." -ForegroundColor Green

# The step 1: Update dependencies
Write-Host "`n📦 تحديث Dependencies..." -ForegroundColor Yellow
composer install --optimize-autoloader --no-dev

if ($LASTEXITCODE -eq 0) {
    Write-Host "✅ تم تحديث Composer" -ForegroundColor Green
} else {
    Write-Host "❌ فشل تحديث Composer" -ForegroundColor Red
    exit 1
}

# الخطوة 2: تجميع Assets
Write-Host "`n🎨 تجميع Assets..." -ForegroundColor Yellow
npm install
npm run build

if ($LASTEXITCODE -eq 0) {
    Write-Host "✅ تم تجميع Assets" -ForegroundColor Green
} else {
    Write-Host "❌ فشل تجميع Assets" -ForegroundColor Red
    exit 1
}

# الخطوة 3: تنظيف وتخزين التكوين
Write-Host "`n⚙️ تخزين التكوين..." -ForegroundColor Yellow
php artisan config:cache
php artisan route:cache
php artisan view:cache
Write-Host "✅ تم تخزين التكوين" -ForegroundColor Green

# الخطوة 4: Commit والدفع
Write-Host "`n📤 Commit والدفع..." -ForegroundColor Yellow
git add -A
git commit -m "تحديث المشروع للنشر على Railway"

$response = Read-Host "هل تريد دفع التغييرات الآن؟ (y/n)"

if ($response -eq 'y' -or $response -eq 'Y') {
    git push origin main
    
    if ($LASTEXITCODE -eq 0) {
        Write-Host "✅ تم الدفع بنجاح" -ForegroundColor Green
        Write-Host "`n📋 الخطوات التالية:" -ForegroundColor Yellow
        Write-Host "1. انتظر اكتمال النشر على Railway Dashboard"
        Write-Host "2. شغل: railway run php artisan migrate --force"
        Write-Host "3. شغل: railway run php artisan cache:clear"
        Write-Host "4. شغل: railway run php artisan storage:link"
    } else {
        Write-Host "❌ فشل الدفع" -ForegroundColor Red
        exit 1
    }
} else {
    Write-Host "⏸️ تم الإيقاف. لم يتم الدفع" -ForegroundColor Yellow
}

Write-Host "`n✨ اكتملت عملية التحضير!" -ForegroundColor Green
