<?php

include dirname(__FILE__) . "/../inc/init_spolecne.php";
$path = "/www/doc/www.papiroverucniky.cz/www/logo.gif";

$path = PATH_WATERMARK;
if (is_readable($path)) {
	$info = getimagesize($path);
	if ($info !== FALSE) {
		header("Content-type: {$info['mime']}");
		readfile($path);
		exit();
	}
}