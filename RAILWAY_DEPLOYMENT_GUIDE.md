# 🚀 Railway Deployment Checklist

## قبل الدفع (Local)

- [ ] تحديث composer dependencies:

    ```bash
    composer install --optimize-autoloader --no-dev
    ```

- [ ] تجميع assets:

    ```bash
    npm run build
    ```

- [ ] تنظيف وتخزين التكوين:

    ```bash
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    ```

- [ ] دفع التغييرات:
    ```bash
    git add -A
    git commit -m "تحديث المشروع"
    git push origin main
    ```

---

## بعد النشر (في Railway)

### الخطوة 1: تشغيل Migrations

```bash
railway run php artisan migrate --force
```

### الخطوة 2: تنظيف الـ Caches

```bash
railway run php artisan config:clear
railway run php artisan route:clear
railway run php artisan view:clear
railway run php artisan cache:clear
```

### الخطوة 3: إعادة نمط الأداء

```bash
railway run php artisan config:cache
railway run php artisan route:cache
railway run php artisan view:cache
```

### الخطوة 4: التأكد من Storage Link

```bash
railway run php artisan storage:link
```

---

## إذا كان لديك Database Module

### تحديث قاعدة البيانات المتقدم:

```bash
# تشغيل جميع الـ migrations
railway run php artisan migrate --force

# تشغيل الـ seeders (إذا كنت تريد)
railway run php artisan db:seed --class=DatabaseSeeder
```

---

## مراقبة الأداء

### التحقق من السجلات:

```bash
railway logs -s web
```

### اختبار سرعة الصفحة:

- استخدم Google PageSpeed Insights
- تحقق من ضغط الصور (lazy loading)
- تحقق من GZIP compression

---

## متغيرات البيئة المدعومة

تأكد من وجود جميع هذه المتغيرات في Railway Dashboard:

```
APP_NAME=MHD Print Lab
APP_ENV=production
APP_DEBUG=false
APP_KEY=<your-key-here>
DB_CONNECTION=mysql
DB_HOST=<railway-mysql-host>
DB_PORT=3306
DB_DATABASE=<database-name>
DB_USERNAME=<username>
DB_PASSWORD=<password>
```

---

## استكشاف الأخطاء الشائعة

### ❌ صور لم يتم ضغطها:

- تأكد من تثبيت ImageMagick أو Imagick على Railway
- تحقق من السجلات: `railway logs`

### ❌ مشاكل في Storage:

```bash
railway run php artisan storage:link
```

### ❌ مشاكل في البيانات:

```bash
railway run php artisan migrate:refresh --force
railway run php artisan db:seed
```

### ❌ Cache issues:

```bash
railway run php artisan cache:flush
```

---

## نصائح الأداء

✅ يتم تطبيق Gzip تلقائياً على Railway
✅ Lazy loading مُفعّل في جميع الـ templates
✅ Image optimization يعمل عند الرفع
✅ CDN support متوفر عبر Railway

---

## موارد إضافية

- [Railway Docs](https://docs.railway.app)
- [Laravel Deployment](https://laravel.com/docs/deployment)
- [Spatie Image Optimizer](https://github.com/spatie/laravel-image-optimizer)
