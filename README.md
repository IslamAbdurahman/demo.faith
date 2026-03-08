<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
</p>

# 🎓 EduFaith - Zamonaviy O'quv Markazi Boshqaruv Tizimi (CRM/ERP)

<p align="center">
  <a href="https://github.com/islamabdurahman/edu_faith"><img src="https://img.shields.io/badge/Versiya-1.0.0-blue.svg?style=for-the-badge" alt="Version"></a>
  <a href="https://laravel.com"><img src="https://img.shields.io/badge/Laravel-9.x-FF2D20.svg?style=for-the-badge&logo=laravel" alt="Laravel"></a>
  <a href="https://php.net"><img src="https://img.shields.io/badge/PHP-8.0+-777BB4.svg?style=for-the-badge&logo=php" alt="PHP"></a>
  <a href="#"><img src="https://img.shields.io/badge/Til-O'zbek%20%7C%20Rus%20%7C%20Qoraqalpoq-success.svg?style=for-the-badge" alt="Language"></a>
</p>

---

## 🌟 Loyiha Haqida

**EduFaith** — bu o'quv markazlari, maktablar va turli ta'lim muassasalarini raqamlashtirish, ularning faoliyatini avtomatlashtirish hamda ta'lim sifatini nazorat qilish maqsadida yaratilgan premium darajadagi CRM/ERP tizimidir. 

Foydalanuvchilarga qulay, zamonaviy interfeys va kuchli backend arxitekturasiga ega bo'lgan ushbu platforma o'quv jarayonining barcha bosqichlarini yagona tizimda birlashtiradi.

---

## ✨ Asosiy Imkoniyatlar (Features)

🚀 **Ko'p Darajali Rollar Tizimi (Multi-Role System):**
- **Spatie Laravel Permission** orqali ruxsatlar dinamik tarzda boshqariladi.
- **SuperAdmin:** Tizimning barcha boshqaruv tugunlarini to'liq nazorat qilish va global sozlamalarni o'zgartirish huquqi.
- **Admin & Menejer:** O'quvchilar oqimini tartibga solish, guruhlar tashkil etish, moliya va jami tahliliy hisobotlarni yuritish.
- **O'qituvchi:** Talabalar davomatini nazorat qilish, testlar hamda baholash tizimini yuritish.

👥 **O'quvchilar va Guruhlar Boshqaruvi:**
- O'quvchilar ma'lumotlar bazasini yuritish, shartnomalar va to'lovlar holatini monitoring qilish.
- Mutlaqo moslanuvchan dars jadvallari (graphics) va yangi guruhlar tuzish.
- "Lid" (Potensial mijozlar/o'quvchilar) jalb qilish funksiyasi bilan ishlash.

💰 **Moliya va To'lovlar (Billing & Finance):**
- Mahalliy to'lov tizimlari bilan integratsiya (**Pay-uz, Payme, Click** va boshqalar yordamida avto-to'lov).
- Xodimlar (o'qituvchi va menejerlar) uchun ishlagan soati/ulushi bo'yicha oylik maoshni (Salary) avtomatik hisoblash.
- Kassa operatsiyalari va xarajatlarni qat'iy nazorat qilish tizimi.

📊 **Davomat va Test Tizimi:**
- O'quvchilar davomatini elektron jurnal orqali yuritish.
- Testlar yaratish, imtihon natijalarini tizimda shakllantirish va tahlil qilish.

📱 **Xabarnomalar va Orqa fon Jarayonlari (Queues & Telegram Bot):**
- **Telegram Bot SDK:** Tizimga Telegram Bot ulangan bo'lib, o'quvchilarga to'lov, dars jadvalidagi o'zgarishlar va boshqalar yuzasidan xabarnomalar telegram orqali keladi (avtomatlashtirilgan Webhook integratsiyasi).
- **Asinxron SMS/Xabarnomalar (Jobs & Queues):** Minglab ustoz va o'quvchilarga xabar jo'natish foydalanuvchi oynasini qotirib qo'ymasligi uchun "Queue" orqali fonga o'tkazilgan (Background processing).
- Lokal SMS xizmatlar (Eskiz, PlayMobile, sysdc) integratsiyasi mavjud.

📈 **Hisobotlar formati (Reports & Analytics):**
- Keng qamrovli Excel formatdagi eksport va import imkoniyatlari (Ma'lumotlarni oson ko'chirish va zaxiralash).

---

## 🌍 Qo'llab-quvvatlanadigan Tillar

Platforma o'z foydalanuvchilariga maksimal qulaylik yaratish maqsadida keng imkoniyatli ko'p tilli (Multi-language) interfeysga ega:
- 🇺🇿 **O'zbek (Lotin)**
- 🇺🇿 **O'zbek (Kirill)**
- 🇷🇺 **Русский**
- 🇺🇿 **Qoraqalpoq**

---

## ⚙️ O'rnatish bo'yicha Yo'riqnoma

Dasturni mahalliy (local) serverda ishga tushirish uchun ushbu qadamlarni bajaring:

**1. Repozitoriyni ko'chirib oling:**
```bash
git clone git@gitlab.com:IslamAbdurahman/edu_faith.git
cd edu_faith
```

**2. Kutubxonalarni o'rnating:**
```bash
composer install --ignore-platform-reqs
npm install && npm run dev
```

**3. Muhit faylini yarating va maxfiy kalitni generatsiya qiling:**
```bash
cp .env.example .env
php artisan key:generate
```

**4. Ma'lumotlar bazasini ulab, strukturani migratsiya qiling:**
`.env` faylida Database sozlamalarini (DB_DATABASE, DB_USERNAME, DB_PASSWORD) to'g'rilagandan so'ng:
```bash
php artisan migrate --seed
```

**5. Storage fayllari uchun ommaviy havola (link) yarating:**
```bash
php artisan storage:link
```

**6. Asinxron jarayonlarni (Queue) va Serverni ishga tushiring:**
Katta hajmdagi SMS xabarlar va eksport/import amaliyotlari platforma qotib qolmasligi uchun fonga o'tkazilgan. Ularni ishlab turishi uchun alohida terminal oynasida worker'ni yoqing:
```bash
php artisan queue:work
```
So'ngra asosiy serverni yoqing:
```bash
php artisan serve
```
Endi tizim lokalingizda `http://127.0.0.1:8000` manzilida ishlay boshladi! 🎉

**7. Telegram Bot ni sozlash (Opsional):**
Tizimda Telegram Webhook xizmatlari ishlashi uchun `.env` da `TELEGRAM_BOT_TOKEN=huddi_shu_yerga_token` qatorini qo'shing.  
So'ng Webhook manzilini ishga tushiring:
```bash
php artisan telegram:webhook
```

---

## 🔐 Tizimga Kirish (Default Access)

Dasturni muvaffaqiyatli ishga tushirgach, quyidagi SuperAdmin akkounti orqali tizimga kirishingiz mumkin:

> **Email:** `superadmin@gmail.com`  
> **Parol:** `11221122`

*(Tizimga kirgach ushbu parolni o'zgartirish tavsiya etiladi!)*

---

## ☕ Muallifni Qo'llab-quvvatlash

Agar ushbu loyiha sizga manzur kelgan bo'lsa yoki biznesingiz rivojiga o'z hissasini qo'shsa, loyiha muallifini qo'llab-quvvatlashingiz mumkin:

<p align="center">
  <a href="https://payme.uz/@longevity" target="_blank">
    <img src="https://www.buymeacoffee.com/assets/img/custom_images/orange_img.png" alt="Buy Me A Coffee" style="height: 41px !important;width: 174px !important;box-shadow: 0px 3px 2px 0px rgba(190, 190, 190, 0.5) !important;-webkit-box-shadow: 0px 3px 2px 0px rgba(190, 190, 190, 0.5) !important;" >
  </a>
</p>

---

## 👨‍💻 Aloqa va Ijtimoiy Tarmoqlar

Loyihaga qiziqish bildirganingiz uchun tashakkur! Muallif bilan bog'lanish uchun:

🎓 **Islam Abdurahman**

- 🌐 [GitHub - islamabdurahman](https://github.com/islamabdurahman)
- 🦊 [GitLab - islamabdurahman](https://gitlab.com/islamabdurahman)
- 📺 [YouTube - @IslamAbdurahman](https://www.youtube.com/@IslamAbdurahman)
- ✈️ [Telegram - @LiveLongevity](https://t.me/LiveLongevity)
- 📧 Poshcha xizmati: abdurahmanislam304@gmail.com

---

<p align="center">
  <i>EduFaith loyihasi <a href="LICENSE.md">MIT Litsenziyasi</a> ostida tarqatiladi. Ta'lim raqamlashtirishiga o'z hissangizni qo'shing!</i>
</p>
