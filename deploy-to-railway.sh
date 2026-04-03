#!/bin/bash

# Railway Deployment Script
# استخدم: bash deploy-to-railway.sh

echo "🚀 بدء عملية النشر على Railway..."

# الألوان للطباعة
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# التحقق من وجود git
if ! command -v git &> /dev/null; then
    echo -e "${RED}❌ Git غير مثبت${NC}"
    exit 1
fi

# التحقق من وجود composer
if ! command -v composer &> /dev/null; then
    echo -e "${RED}❌ Composer غير مثبت${NC}"
    exit 1
fi

# الخطوة 1: تحديث dependencies
echo -e "\n${YELLOW}📦 تحديث Dependencies...${NC}"
composer install --optimize-autoloader --no-dev
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✅ تم تحديث Composer${NC}"
else
    echo -e "${RED}❌ فشل تحديث Composer${NC}"
    exit 1
fi

# الخطوة 2: تجميع Assets
echo -e "\n${YELLOW}🎨 تجميع Assets...${NC}"
npm install
npm run build
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✅ تم تجميع Assets${NC}"
else
    echo -e "${RED}❌ فشل تجميع Assets${NC}"
    exit 1
fi

# الخطوة 3: تنظيف وتخزين التكوين
echo -e "\n${YELLOW}⚙️ تخزين التكوين...${NC}"
php artisan config:cache
php artisan route:cache
php artisan view:cache
echo -e "${GREEN}✅ تم تخزين التكوين${NC}"

# الخطوة 4: Commit والدفع
echo -e "\n${YELLOW}📤 Commit والدفع...${NC}"
git add -A
git commit -m "تحديث المشروع للنشر على Railway"

read -p "هل تريد دفع التغييرات الآن؟ (y/n) " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    git push origin main
    if [ $? -eq 0 ]; then
        echo -e "${GREEN}✅ تم الدفع بنجاح${NC}"
        echo -e "\n${YELLOW}📋 الخطوات التالية:${NC}"
        echo "1. انتظر اكتمال النشر على Railway Dashboard"
        echo "2. شغل: railway run php artisan migrate --force"
        echo "3. شغل: railway run php artisan cache:clear"
        echo "4. شغل: railway run php artisan storage:link"
    else
        echo -e "${RED}❌ فشل الدفع${NC}"
        exit 1
    fi
else
    echo -e "${YELLOW}⏸️  تم الإيقاف. لم يتم الدفع${NC}"
fi

echo -e "\n${GREEN}✨ اكتملت عملية التحضير!${NC}"
