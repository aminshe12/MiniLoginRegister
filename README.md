# پروژه ورود و ثبت‌نام

یک پروژه ساده با Laravel 12 برای ورود با موبایل/رمز و ثبت‌نام با OTP. ارسال OTP از طریق صف Redis انجام می‌شود و اعداد فارسی هم پشتیبانی می‌شود.

## پیش‌نیازها
- PHP 8.3+
- MySQL
- Redis
- Composer

## نصب
```bash
cd Login
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan queue:work redis --queue=otp
```

## اجرا
```bash
# اجرای کارگر صف (در ترمینال جدا)
php artisan queue:work redis --queue=otp
```

## استفاده
- آدرس ورود: `/auth`
- اگر کاربر ثبت‌نام نشده باشد، کد OTP ارسال می‌شود و بعد فرم ثبت‌نام نمایش داده می‌شود.

## نکته
در `.env` مقدار `QUEUE_CONNECTION=redis` را قرار دهید و تنظیمات Redis (هاست و پورت) درست باشد.


