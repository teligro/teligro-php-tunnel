## WP Telegram Pro PHP Tunnel

With the PHP tunnel, you can send and receive a request from another server as a tunnel.
This is useful for websites host that have blocked telegram requests.
Currently, the telegram is filtered/blocked in Iran, Russia, and China.


### Hot to use:

Upload the `WPTPTunnel.php` file to another server that can send / receive requests from the telegram.

Make sure the `WPTPTunnel.php` file directory has read and write permission.

Activate [WP Telegram Pro](https://wordpress.org/plugins/wp-telegram-pro) plugin on your wordpress website.

Go to Settings page then Proxy tab, And select Tunnel option.

Then enter `WPTPTunnel.php` URL on input box, For example: `https://mydomain.tld/telegram-tunnel/WPTPTunnel.php`


<div dir='rtl' align='right'>
### راهنمای فارسی

با توجه به فیلتر بودن تلگرام در ایران، در صورتی که از سرویس‌های داخلی برای میزبانی سایت خود استفاده می‌کنید، احتمال دارد در دریافت یا ارسال درخواست به تلگرام با مشکل مواجه شوید. برای حل این موضوع می‌توانید از امکان PHP Tunnel Proxy در افزونه [WP Telegram Pro](https://wordpress.org/plugins/wp-telegram-pro) استفاده کنید.

برای استفاده از این امکان نیاز به این دارید فضای میزبانی (با فضای کم) خارج از ایران را به همراه دامنه اجاره کنید، و فایل `WPTPTunnel.php` را برروی فضای میزبانی آپلود کنید.

بعد از آپلود می‌توانید با وارد کردن آدرس فایل در تنظیمات » پروکسی » تونل، از این فایل به عنوان یک تونل بین وبسایت و تلگرام استفاده کنید.
برای نمونه: `https://mydomain.tld/telegram-tunnel/WPTPTunnel.php`
</div>