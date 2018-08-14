<?php
session_start();
include "image.php";
unset($_SESSION["captcha"]);
// generate captcha string
$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$captcha = '';
for ($i=0; $i < 4; $i++)
    $captcha .= substr($pool, mt_rand(0, strlen($pool) -1), 1);

// create white empty image, 210x70
$img = new Image(130, 30, Array(255,255,255));

$_SESSION["captcha"] = md5(strtolower($captcha));
// write text
$img->set_font("./verdana.ttf", 18, Array(0,0,0));
for ($i=0; $i<strlen($captcha); $i++)
    $img->write($captcha[$i], 10+$i*30, 25, -10+mt_rand(0,40));


// output image
$img->out_png();
exit;
?>
