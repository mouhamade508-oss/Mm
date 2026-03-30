# نظام شحن الألعاب والتطبيقات

## نظرة عامة

تم إضافة قسم جديد كامل لشحن رصيد الألعاب والتطبيقات على الموقع.

## الميزات المضافة

### 1. الواجهة الأمامية (Front-End)

- **صفحة الألعاب والتطبيقات**: `/games-and-apps`
    - عرض جميع منتجات الألعاب والتطبيقات
    - فلترة البحث والسعر
    - زر "شحن الرصيد" لكل منتج
    - نافذة منبثقة (Modal) لإدخال بيانات الشحن

### 2. نموذج الشحن

عند الضغط على "شحن الرصيد"، يظهر نموذج يطلب:

- **ID اللعبة/التطبيق** (إلزامي) - معرف اللاعب
- **صورة إثبات الشحن** (إلزامي) - إثبات تحويل الأموال
- **رقم العملية** (إلزامي) - رقم المعاملة البنكية
- **الاسم** (اختياري)
- **رقم الهاتف** (اختياري)
- **ملاحظات** (اختياري)

### 3. قاعدة البيانات

تم إنشاء جدول `game_recharge_requests` يحتوي على:

- `id`: معرف فريد
- `game_name`: اسم اللعبة/التطبيق
- `player_id`: معرف اللاعب
- `proof_image`: رابط صورة الإثبات
- `transaction_number`: رقم العملية
- `customer_name`: اسم العميل
- `customer_phone`: رقم الهاتف
- `notes`: ملاحظات إضافية
- `status`: حالة الطلب (pending, processing, completed, rejected)
- `created_at / updated_at`: تواريخ الإنشاء والتحديث

### 4. لوحة الإدارة

- **قائمة الطلبات**: عرض جميع طلبات الشحن مع تصفية وترتيب
- **تفاصيل الطلب**: عرض كامل معلومات الطلب الواحد
    - عرض صورة إثبات الشحن
    - تحديث حالة الطلب (قيد الانتظار - قيد المعالجة - مكتمل - مرفوض)
    - معلومات العميل كاملة

### 5. التنبيهات الفورية

#### Telegram (مُعد)

- تلقي إشعار فوري على Telegram عند ورود طلب جديد
- الإشعار يتضمن:
    - اسم اللعبة/التطبيق
    - معرف اللاعب
    - رقم العملية
    - بيانات العميل
    - رابط مباشر للطلب في لوحة الإدارة

#### WhatsApp (جاهز للإعداد)

- يمكن إضافة تنبيهات WhatsApp من خلال:
    - Twilio API أو
    - WhatsApp Business API

## التكامل الفعلي

### إعداد Telegram:

1. تحدث مع @BotFather على Telegram
2. أنشئ bot جديد للحصول على Token
3. احصل على Chat ID (أرسل رسالة للbot وستحصل عليه من الـ API)
4. أضف في ملف `.env`:

```
TELEGRAM_BOT_TOKEN=your_bot_token
TELEGRAM_CHAT_ID=your_chat_id
```

### الملفات المضافة

- `database/migrations/2026_03_30_023334_create_game_recharge_requests_table.php` - الجدول
- `app/Models/GameRechargeRequest.php` - النموذج
- `app/Http/Controllers/GameRechargeController.php` - المتحكم
- `resources/views/games/index.blade.php` - الصفحة الأمامية
- `resources/views/admin/game-recharge/index.blade.php` - قائمة الطلبات
- `resources/views/admin/game-recharge/show.blade.php` - تفاصيل الطلب

### الطرق المضافة

- `GET /games-and-apps` - عرض الألعاب والتطبيقات
- `POST /api/game-recharge-requests` - إنشاء طلب شحن جديد
- `GET /admin/game-recharge-requests` - قائمة الطلبات في الإدارة
- `GET /admin/game-recharge-requests/{id}` - تفاصيل الطلب
- `PUT /admin/game-recharge-requests/{id}/status` - تحديث حالة الطلب

## الخطوات التالية

1. إضافة المنتجات في فئة "ألعاب وتطبيقات"
2. إعداد بيانات Telegram في `.env`
3. اختياري: إضافة تنبيهات WhatsApp
4. اختياري: إضافة بريد إلكتروني للإشعارات
