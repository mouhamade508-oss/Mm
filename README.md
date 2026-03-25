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
