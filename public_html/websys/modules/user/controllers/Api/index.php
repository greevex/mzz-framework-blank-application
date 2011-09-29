<?php
include('Base.php');
include('UserApi.php');
include('RegistrarApi.php');
$token = 'c793ac5d6f4d25c333dabb6a71c30c5f742f3d48650ecf5a1b6cc23b';

$api = new Yandex_Mail_UserApi($token, null, false);
$name = 'asdar';
$xml = $api->createUser($name, substr(md5(microtime(true)), 0, 8));
if(isset($xml->ok)) {
	$userInfo = $api->getUserInfo($name);
	echo $userInfo->domain->user->login . "@" . $userInfo->domain->name;
}