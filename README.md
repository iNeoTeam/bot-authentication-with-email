# قطعه کد احراز هویت با استفاده از آدرس ایمیل در ربات تلگرام
با استفاده از این قطعه کد میتوانید یک کد برای ایمیل کاربران خود ارسال کنید تا مراحل احراز هویت تکمیل شود.

------------------------

# متغیرهای مورد نیاز
دقت داشته باشید که متغیر های زیر را باید به سورس خود اضافه کنید.

```
$text = $update->message->text;
$message = $update->message;
$chat_id = $update->message->chat->id;
$api = "https://api.ineotm.ir";
$fromMail = "verify@gmail.com";
$step = file_get_contents("data/$chat_id/step.txt");

$cancelButton = json_encode(['keyboard' => [
[['tex' => "لغو عملیات"]],
],
```
