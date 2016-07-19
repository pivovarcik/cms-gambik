<?php

$color1 = "#f0eeeb";
$color2 = "#222";



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
$res .= '#productsNav > ul > li > a.navSelected2, #productsNav > ul > li > a.navSelected,#productsNav > ul > li:hover > a {
color: #222;
}
';
$res .= '#productsNav > ul > li.navSelected2::after {
border-bottom: 16px solid transparent;
border-left: 16px solid ' . $color1 . ';
    border-top: 16px solid transparent;
content: "";
display: inline-block;
position: absolute;
right: -16px;
top: 0;
}
';
$res .= '#productsNav ul > li:hover, #productsNav > ul > li.navSelected2, #productsNav > ul > li > a.navSelected {
background: ' . $color1 . ' none repeat scroll 0 0;
margin-right: 0;
position: relative;
}
';


$res .= '#header_menu {
	background-color: ' . $color1 . ';
}
';
$res .= '.navbar-nav > li > a {

	color: #fff;
}
.navbar-nav > li > a:hover, .navbar-nav > li > a.navSelected2 {
    background-color: #a0b07f;
}

.navbar-toggle {
border-color: silver;
}
.navbar-toggle .icon-bar {
    background-color: #fff;
}
footer {
    background: #222 none repeat scroll 0 0;
    border-top: 2px solid #000;
}


#WizardForm {
    background: #f4f4f4 none repeat scroll 0 0;
    padding: 5px;
}

.ui-slider .ui-slider-range {
    background: #a0b07f url("images/pricefilter-range.png") repeat-x scroll 0 0;
}

';

$res .= '.kosik_count {
	background-color: #d82d02;
}
';

//header("Content-Type: text/css");
//print $res;


