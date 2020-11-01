## Teligro PHP Tunnel

With the PHP tunnel, you can send and receive a request from another server as a tunnel.
This is useful for websites host that have blocked telegram requests.
Currently, the telegram is filtered/blocked in Iran, Russia, and China.


### How to use:

Clone or [download](https://github.com/teligro/teligro-php-tunnel/archive/master.zip) this repository and upload it to another server that can send/receive requests from the telegram.
```bash
git clone https://github.com/teligro/teligro-php-tunnel.git
```
Make sure the `TeligroTunnel.php` file directory has read and write permission.

Activate [Teligro](https://wordpress.org/plugins/wp-telegram-pro) plugin on your wordpress website, 
Go to Settings page then Proxy tab, And select Tunnel option, 
Then enter `TeligroTunnel.php` URL on input box, For example: `https://mydomain.tld/telegram-tunnel/TeligroTunnel.php`

### Persian/Farsi Guide
<div dir='rtl' align='right'>

با توجه به فیلتر بودن تلگرام در ایران، در صورتی که از سرویس‌های داخلی برای میزبانی سایت خود استفاده می‌کنید، احتمال دارد در دریافت یا ارسال درخواست به تلگرام با مشکل مواجه شوید. برای حل این موضوع می‌توانید از امکان تونل پروکسی در افزونه [Teligro](https://wordpress.org/plugins/wp-telegram-pro) استفاده کنید.

برای استفاده از این امکان نیاز به این دارید فضای میزبانی (با فضای کم) در خارج از ایران را به همراه دامنه اجاره کنید، و مخزن جاری را [دانلود](https://github.com/teligro/teligro-php-tunnel/archive/master.zip) یا Clone بگیرید و برروی فضای میزبانی جدید آپلود کنید.
مطمئن شوید که پوشه فایلها دسترسی خواندن و نوشتن داشته باشد.

بعد از آپلود می‌توانید با وارد کردن آدرس فایل در تنظیمات » پروکسی » تونل، از این فایل به عنوان یک تونل بین وبسایت و تلگرام استفاده کنید.
برای نمونه: `https://mydomain.tld/telegram-tunnel/TeligroTunnel.php`

</div>