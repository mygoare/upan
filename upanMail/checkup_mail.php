<?php
$auth_code = $_GET['auth_code'];
$send_to = $_GET['send_to'];
$subject  = "=?UTF-8?B?" . base64_encode($_GET["subject"]) . "?=";
$message= "您正在 云U盘 进行邮箱验证，请在网站填写入下面的验证码 \n
	验证码为：".$auth_code." \n
	请不要回复此邮件，谢谢使用云U盘(upan.us)！
";

$send_mail = mail($send_to, $subject, $message, "From: 云U盘 <no-reply@upan.us>", "-f no-reply@upan.us");

if($send_mail){
echo 1;
} else {
echo 0;
}
