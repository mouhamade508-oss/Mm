# 🛍️ MHD Print Lab - متجر إلكتروني شامل

متجر إلكتروني مبني بـ Laravel 12 مع دعم المنتجات الرقمية والمادية، نظام الخصومات، وواجهة إدارة متقدمة.

## ✨ المميزات

### 🛒 للزائر:

- **تصفح المنتجات** بفلترة وبحث متقدم
- **نظام الخصومات** (عامة وخاصة بالمنتج)
- **الطلب عبر WhatsApp** مباشرة
- **منتجات رقمية** قابلة للتحميل
- **تصميم responsive** مع Tailwind CSS

### 👨‍💼 لوحة الإدارة:

- **إدارة المنتجات** (إضافة/تعديل/حذف)
- **إدارة الفئات** الديناميكية
- **نظام الخصومات** المتقدم
- **رفع الملفات** للمنتجات الرقمية
- **إحصائيات شاملة**

### 💻 المنتجات الرقمية:

- **رفع الملفات** (PDF, DOC, DOCX, TXT, ZIP)
- **قسم منفصل** للمنتجات الرقمية
- **تسليم فوري** عبر البريد الإلكتروني
- **حماية الملفات** وإدارة الوصول

## 🚀 التثبيت والتشغيل

### متطلبات النظام:

- PHP 8.2+
- MySQL 8.0+
- Node.js 18+
- Composer

### خطوات التثبيت:

```bash
# 1. تحميل المشروع
git clone <repository-url>
cd Mm

# 2. تثبيت dependencies
composer install
npm install

# 3. إعداد البيئة
cp .env.example .env
php artisan key:generate

# 4. إعداد قاعدة البيانات
php artisan migrate
php artisan db:seed

# 5. بناء assets
npm run build
php artisan storage:link

# 6. تشغيل الخادم
php artisan serve
```

## 🌐 النشر على Railway

### إعداد Railway:

1. **ربط المشروع:**

    ```bash
    git add .
    git commit -m "Ready for Railway deployment"
    git push origin main
    ```

2. **في Railway Dashboard:**
    - أضف MySQL Database
    - حدث Environment Variables
    - اضغط Deploy

3. **بعد النشر:**
    ```bash
    php artisan migrate:fresh --seed --force
    php artisan storage:link
    ```

### متغيرات البيئة المطلوبة:

```env
APP_NAME="MHD Print Lab"
APP_ENV=production
APP_KEY=base64_key_here
APP_DEBUG=false
DB_CONNECTION=mysql
DB_HOST=${{ MYSQLHOST }}
DB_PORT=${{ MYSQLPORT }}
DB_DATABASE=${{ MYSQLDATABASE }}
DB_USERNAME=${{ MYSQLUSER }}
DB_PASSWORD=${{ MYSQLPASSWORD }}
```

### 📋 الإجراءات المطلوبة عند التحديث على Railway:

#### ✅ قبل الدفع (Push):

1. **تحديث composer والـ dependencies:**

    ```bash
    composer install --optimize-autoloader --no-dev
    npm install
    npm run build
    ```

2. **التأكد من عدم وجود أخطاء:**

    ```bash
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    ```

3. **قيادة الملفات الجديدة:**
    ```bash
    git add -A
    git commit -m "تحديث تحسينات الأداء والصور"
    git push origin main
    ```

#### ⚙️ بعد الدفع (في Railway CLI أو نمط بناء مخصص):

4. **تشغيل Migrations:**

    ```bash
    php artisan migrate --force
    ```

5. **تنظيف وتحسين الأداء:**

    ```bash
    php artisan config:clear
    php artisan route:clear
    php artisan view:clear
    php artisan cache:clear
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    ```

6. **التأكد من storage symlink:**
    ```bash
    php artisan storage:link
    ```

#### 🔧 إعدادات Railway المتقدمة:

7. **Procfile (اختياري ولكن مُنصح):**
   أنشئ ملف `Procfile` في جذر المشروع:

    ```
    web: vendor/bin/heroku-php-nginx -C nginx.conf public/
    scheduler: php artisan schedule:work
    ```

8. **Nginx Configuration (اختياري):**
   أنشئ `nginx.conf` لدعم GZIP:
    ```nginx
    # Enable GZIP compression
    gzip on;
    gzip_types text/css application/javascript text/javascript application/x-javascript image/svg+xml;
    gzip_vary on;
    gzip_min_length 256;
    ```

### 📌 ملاحظات مهمة عند التحديث:

- **Composer Dependencies:** تم إضافة `spatie/laravel-image-optimizer` - تأكد من تشغيل `composer install` قبل الدفع
- **Image Optimization:** ضغط الصور يحدث تلقائياً في `ProductController` - لا توجد إجراءات إضافية مطلوبة
- **Lazy Loading:** تم تطبيقها في جميع الـ Blade templates - لا توجد إجراءات إضافية
- **GZIP Compression:** يعمل تلقائياً على Railway (يدعم mod_deflate بشكل افتراضي)
- **Storage:** تأكد من أن `storage/` و `public/storage` قابلة للكتابة على Railway

### 🚨 استكشاف الأخطاء:

إذا واجهت مشاكل بعد النشر:

```bash
# التحقق من السجلات
tail -f storage/logs/laravel.log

# إعادة تشغيل الخدمة
railway service restart

# مسح جميع الـ caches
php artisan cache:clear
php artisan config:clear
```

## 🧰 تحسين وتحميل الأصول

### 1. ضغط الصور المرفوعة تلقائياً

تم إضافة `spatie/laravel-image-optimizer` إلى المشروع ويعمل الآن في `ProductController` عند رفع الصور.

لتثبيت يدويًا:

```bash
composer require spatie/laravel-image-optimizer
php artisan vendor:publish --provider="Spatie\LaravelImageOptimizer\ImageOptimizerServiceProvider"
```

### 2. تفعيل Gzip (Apache)

تم إضافة قواعد ضغط إلى `public/.htaccess`:

- `mod_deflate` لضغط CSS/JS/HTML/JSON/SVG وغيرها
- `mod_headers` لإضافة `Vary: Accept-Encoding`

### 3. تفعيل Gzip (Nginx)

أضف التالي داخل `server` (أو `http`):

```nginx
gzip on;
gzip_types text/plain text/css application/json application/javascript text/xml application/xml application/xml+rss text/javascript image/svg+xml;
gzip_proxied no-cache no-store private expired auth;
gzip_min_length 256;
gzip_vary on;
```

## 📁 هيكل المشروع

```
Mm/
├── app/
│   ├── Http/Controllers/
│   │   ├── ProductController.php
│   │   └── VisitorProductController.php
│   └── Models/
│       ├── Product.php
│       ├── Category.php
│       └── Discount.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── views/
│   │   ├── products/
│   │   │   ├── visitor-index.blade.php
│   │   │   └── digital-index.blade.php
│   │   └── admin/
│   └── css/
├── routes/
│   └── web.php
└── storage/
    └── app/public/digital_products/
```

## 🔧 التقنيات المستخدمة

- **Backend:** Laravel 12, PHP 8.2
- **Frontend:** Blade Templates, Tailwind CSS
- **Database:** MySQL
- **Build Tool:** Vite
- **Hosting:** Railway
- **Version Control:** Git

## 📞 الدعم

لأي استفسارات أو مشاكل، يرجى فتح issue في المشروع.

## 📄 الترخيص

هذا المشروع مرخص تحت رخصة MIT.
