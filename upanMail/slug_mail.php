<?php
$slug_val = $_GET['slug_val'];
$file_name = $_GET['file_name'];
$send_to = $_GET['send_to'];
$subject  = "=?UTF-8?B?" . base64_encode($_GET["subject"]) . "?=";
$message= "您上传的文件名为：".$file_name." \n
	提取码为：".$slug_val." \n
	请不要回复此邮件，谢谢使用云U盘(upan.us)！
";

$send_mail = mail($send_to, $subject, $message, "From: 云U盘 <no-reply@upan.us>", "-f no-reply@upan.us");

if($send_mail){
echo 1;
} else {
echo 0;
}
