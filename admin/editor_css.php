<?php
header("Content-type: text/css");
include dirname(__FILE__) . "/../inc/init_spolecne.php";
print '@import"/js/bootstrap/bootstrap.min.css";';
print '@import"/style/font-awesome/css/font-awesome.min.css";';
print $settings->get("TINY_CSS");
exit;