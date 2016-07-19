<?php




$product_tabsName = '.product_tabs';
$color1 = "#265599";
$color2 = "#008fd2";



$res .= 'a {
	color: #008fd2;
}
';
$res .= '.product_title {
	border-color:' . $color2 . ';
}
';
$res .= $product_tabsName. ' ul.ui-tabs-nav {
	border-color:' . $color1 . ';
}
';


$res .= $product_tabsName. ' .ui-tabs-nav li.ui-tabs-selected a {
	background-color: ' . $color1 . ';
}
';
//header("Content-Type: text/css");
//print $res;

