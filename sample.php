<?php
/*
IN THE NAME OF ALLAH

Sample Name		:	Bot Authentication with Email
Coder			:	Amir Hossein Yeganeh [Sir.4m1R]
Coder Telegram		:	@Sir4m1R
GitHub Address		:	https://github.com/iNeoTeam/bot-authentication-with-email
Telegram Channel	:	@iNeoTeam
*/
error_reporting(0);
$api = "https://api.ineo-team.ir";
$fromMail = "verify@gmail.com";
$cancelButton = json_encode(['keyboard' => [
[['tex' => "لغو عملیات"]],
],
'resize_keyboard' => true]);
if($text == "/email"){
	file_put_contents("data/$chat_id/step.txt", "getEmail");
	bot('sendMessage', [
		'chat_id' => $chat_id,
		'text' => "آدرس ایمیل خود را ارسال کنید.",
		'parse_mode' => "MarkDown",
		'disable_web_page_preview' => true,
		'reply_marup' => $cancelButton,
	]);
}elseif(isset($message->text) && $step == "getEmail"){
	$email = $update->message->text;
	$p = json_decode(file_get_contents($api."/password.php?mode=0"));
	$code = $p->result->code;
	file_put_contents("data/$chat_id/verify.txt", $code);
	file_put_contents("data/$chat_id/step.txt", "getVerifyCode");
	$subject = "احراز هویت";
	$message = "کد احراز هویت شما: $code";
	$apiSendMail = $api."/smail.php?to=$email&from=$fromMail&subject=".urlencode($subject)."&message=".urlencode($message);
	$sendMail = file_get_contents($apiSendMail);
	bot('sendMessage', [
		'chat_id' => $chat_id,
		'text' => "کدی جهت احراز هویت به آدرس ایمیل $email ارسال شد.

لطفا کد را ارسال کنید.",
		'parse_mode' => "MarkDown",
		'disable_web_page_preview' => true,
		'reply_marup' => $cancelButton,
	]);
}elseif(isset($message->text) && $step == "getVerifyCode"){
	$code = $update->message->text;
	$code2 = file_get_contents("data/$chat_id/verify.txt");
	if($code === $code2){
		file_put_contents("data/$chat_id/step.txt", "none");
		$message = "کد وارد شده درست میباشد.

احراز هویت با موفقیت انجام شد.";
		$button = json_encode(['inline_keyboard' => [
		[['tex' => "گروه ربات سازی آی نئو", 'url' => "https://T.me/iNeoTeam"]],
		]]);
	}else{
		file_put_contents("data/$chat_id/step.txt", "getVerifyCode");
		$message = "کد وارد شده اشتباه است.

کد را بررسی و مجددا ارسال کنید";
		$button = $cancelButton;
	}
	bot('sendMessage', [
		'chat_id' => $chat_id,
		'text' => $message,
		'parse_mode' => "MarkDown",
		'disable_web_page_preview' => true,
		'reply_marup' => $button,
	]);
}
unlink("error_log");
/*
Sample Name		:	Bot Authentication with Email
Coder			:	Amir Hossein Yeganeh [Sir.4m1R]
Coder Telegram		:	@Sir4m1R
GitHub Address		:	https://github.com/iNeoTeam/bot-authentication-with-email
Telegram Channel	:	@iNeoTeam
*/
?>
