<?php
$templateId = 1;
if (isset($_GET["id"])) {
	$templateId = (int) $_GET["id"];
}
$maxMidthPage = "1020px";
$product_tabsName = '.product_tabs';

//.product_tabs .ui-tabs
$res = '';

#region zakladní layout
$res .= '
body {
	color: #2e3d45;
	font-family: Arial,sans-serif;
}
html, body {
	height: 100%;
}
img {
    max-width: 100%;
}
';
$res .= 'body > #main {
	height: auto;
}
#main {
	background: none repeat scroll 0 0 #fff;
	height: 100%;

	min-height: 100%;
	position: relative;

}


section.page {
    padding-bottom: 230px;
    padding-top: 0;
}
.container {
position: relative;
}

#search-box, #productsNav, #kontakt_box {
    margin-bottom: 10px;
}
#kontakt_box {
    background: #fbf9fa none repeat scroll 0 0;
    border: 2px solid #eee;
    padding: 5px 15px;
}

.title  {
    font-size: 115%;
    }
';

$res .= 'footer {
	bottom: 0;
	height: 203px;
	left: 0;
	position: absolute;
	width: 100%;
}
footer .container {
	height: 201px;
}
footer {
	background: #222 none repeat scroll 0 0;
	border-top: 2px solid #000;
}

footer .logo {
    display: block;
    float: left;
    font-size: 2em;
    height: 100%;
    width: 20%;
}
footer .odkazy {
    float: left;
    width: 80%;
}

.copyright {
    bottom: 0;
    position: absolute;
    width: 100%;
}
.copyright, .copyright a {
    color: gray;
    font-size: 95%;
    text-align: right;
}

';

$res .= '.right {
	text-align: right;
}
';


$res .= '.productListBox{
	position: relative;
}
';
$res .= '#productList-overlay {
background: url("/admin/style/images/preload.png") no-repeat scroll 50% 150px #fff;
	display: none;
height: 100%;
opacity: 0.6;
position: absolute;
width: 100%;
z-index: 150;
}';



$res .= '
p.desc {
	clear:both;
}



.dodaci_adresa {
    clear: both;
    padding: 10px;
}
.dodaci_adresa_disabled {
	background: none repeat scroll 0 0 #F0F0F0;
	color: gray;
	display: none;
}

.dodaci_adresa_disabled .textbox {
	border-color: gray;
}


.udaje fieldset {
    margin-bottom: 5px;
    padding-top: 45px;
    position: relative;
}

.udaje legend {
    font-size: 18px;
    position: absolute;
    top: 18px;
}

.udaje legend label {
    float: none;
    font-size: 14px;
    font-weight: normal;
    padding: 0;
    width: auto;
}


.udaje fieldset.note {
    padding-top: 15px;
}
.udaje fieldset.note label {
    display:none;
}
';

$res .= 'input[type=number]::-webkit-outer-spin-button,
input[type=number]::-webkit-inner-spin-button {
	-webkit-appearance: none;
	margin: 0;
}

input[type=number] {
	-moz-appearance:textfield;
}
';
$res .= '.clearfix {
	clear: both;
}
';
$res .= '.text-right,.right {
	text-align: right;
}
';
$res .= '.fl-right {
	float: right;
}
';
$res .= '
fieldset {
	background: none repeat scroll 0 0 #fbf9fa;
	border: 2px solid #eeeaec;
	padding: 12px;
}
';


$res .= '
button.delete {
    background: none repeat scroll 0 0 transparent;
    border: 0 none;
    cursor: pointer;
}
.price {
    color: #2e3d45;
    font-size: 14px;
    font-weight: bold;
    text-decoration: none;
}

.basket .price {
    color: #2e3d45;
}
table.basket td.thumb img {
    max-height: 75px;
    max-width: 75px;
}
table.basket {
    border-collapse: separate;
    border-spacing: 0 8px;
}

table.basket td.odebrat {
    border-right-width: 2px;
}
table.basket td.thumb {
	border-left-width: 2px;
	padding: 5px 10px 5px 5px;
}
table td.thumb {
	width: 50px;
}
table.basket td {
	-moz-border-bottom-colors: none;
	-moz-border-left-colors: none;
	-moz-border-right-colors: none;
	-moz-border-top-colors: none;
	background: none repeat scroll 0 0 #fff;
	border-color: #eeeaec;
	border-image: none;
	border-style: solid;
	border-width: 2px 0;
	height: 50px;
	vertical-align: middle;
}
';

$res .= '
.footer-fixed {
    background: none repeat scroll 0 0 #ffffcc;
    border-top: 1px solid #d7d700;
    bottom: 0;
    font-weight: bold;
    height: 30px;
    left: 0;
    line-height: 30px;
    min-width: 100%;
    position: fixed;
    z-index: 9;
}
';
#endregion

#region header

$res .= 'header .logo {
	display: inline-block;
}

header .logo span {
    font-size: 260%;
    line-height: 1;
}

';
$res .= '#userBox {
	position: absolute;
	right: 0;
	top: 0;
}
';
#endregion

$res .= ' .item {
	overflow: hidden;

	text-align: center;

}
.navbar-with-logo .navbar-brand {
	height: 100px;
	padding: 5px 15px;
}

.navbar-with-logo .navbar-nav {
    margin-top: 25px;
}

.navbar-brand > img {
    display: block;
    max-height:100%;
}

.item_in {
    background: #ffffff none repeat scroll 0 0;
    border: 1px solid #d4d4d4;
    margin: 4px;
    	position: relative;
    height: 220px;
    padding-bottom: 6px;
}

.item .description {
    display: none;
}
.item .dostupnost {
    color: green;
    display: block;
    font-size: 90%;
    font-weight: normal;
}

.item small	 {
    font-weight: normal;
    font-size:80%;
}

.item .novinka {
    background-color: orange;
    border-radius: 2px;
    color: #fff;
    font-size: 85%;
    padding: 2px 4px;
    position: absolute;
    top: 45px;
}

.itemsList .product_name {
    font-weight: normal;
    height: 38px;
    overflow: hidden;
    padding: 0 1px;
    position: absolute;
    text-align: center;
    text-transform: uppercase;
    top: 10px;
    width: 100%;
}
.item .price {

    text-align: center;
    width: 100%;
}
table.product_varianty_list {
    width: 100%;
}

.item_in .product_buy {
bottom: 25px;
position: absolute;
text-align: center;
width: 100%;
}
.product_image {
    height: 200px;
    overflow: hidden;
    padding: 25px 0;
    text-align: center;
}
';
#region Mnozstvi
$res .= '
.inp-text {
	background: none repeat scroll 0 0 padding-box #fff;
	border: 2px solid #eeeaec;
	box-shadow: 3px 4px 5px 0 rgba(0, 0, 0, 0.05) inset;
	box-sizing: border-box;
	color: #333;
	display: inline-block;
	font-size: 14px;
	height: 45px;
	line-height: 23px;
	margin: 0;
	outline: medium none;
	padding: 9px 12px;
	transition: border 500ms ease 0s, box-shadow 500ms ease 0s;
	vertical-align: top;
	width: 100%;
}
.inp-number .inp-text {
	width: 1.5em;
}
.inp-number .inp-text {
	background: none repeat scroll 0 0 rgba(0, 0, 0, 0);
	border: 0 none;
	box-shadow: none;
	font: bold 16px/27px "Open Sans","Helvetica Neue",Arial,Helvetica,sans-serif;
	height: 41px;
	margin: 0;
	overflow: visible;
	padding: 7px 0;
	position: relative;
	text-align: right;
	width: 1.3em;
	z-index: 1;
}
.inp-number .inp-number-btn {
	background: none repeat scroll 0 0 #fff;
	border: 2px solid #eeeaec;
	color: #d0c5cb;
	display: block;
	font: 32px/40px "Open Sans","Helvetica Neue",Arial,Helvetica,sans-serif;
	height: 41px;
	left: -2px;
	position: absolute;
	text-align: center;
	text-decoration: none;
	top: -2px;
	transition: border-color 300ms ease 0s, background-color 300ms ease 0s, color 300ms ease 0s;
	width: 43px;
	z-index: 2;
}
input[type="number"] {
	-moz-appearance: textfield;
}
.inp-number .inp-number-btn {
	font-size: 26px;
	height: 25px;
	left: auto;
	line-height: 18px;
	right: -2px;
}
.inp-number .inp-number-btn.inc {
	left: auto;
	right: -2px;
}
.inp-number .inp-number-btn.dec {
	bottom: -2px;
	height: 22px;
	top: auto;
}

.inp-number {
	background: none repeat scroll 0 0 #fff;
	border: 2px solid #eeeaec;
	box-shadow: 3px 4px 5px 0 rgba(0, 0, 0, 0.05) inset;
	box-sizing: border-box;
	color: #666;
	cursor: text;
	display: inline-block;
	font: bold 16px/41px "Open Sans","Helvetica Neue",Arial,Helvetica,sans-serif;
	height: 45px;
	padding: 0 45px;
	position: relative;
	text-align: center;
	white-space: nowrap;
	width: 145px;
}
.inp-number {
	margin: 0;
	width: 109px;
}
.inp-number {
	padding: 0 45px 0 0;
	width: 110px;
}
';
#endregion

$res .= '
.tab-pane {
padding:15px;
}
#subcategory .thumbnail {
	margin-bottom:10px;
}

.subcategory-title {
	height:30px;
	overflow:hidden;
}
#basketBox .fa-shopping-basket {
    color: silver;
    font-size: 28px;
    padding-right: 20px;
    padding-top: 12px;
    vertical-align: baseline;
}

.kosik_count {
    background: silver none no-repeat scroll 0 0;
    border-radius: 30px;
    color: #ffffff;
    display: block;
    font-size: 12px;
    font-weight: 700;
    height: 23px;
    line-height: 23px;
    position: absolute;
    right: 3px;
    text-align: center;
    top: 2px;
    width: 23px;
}
.basket_preview_wrap {
	margin-top: 9px;
	min-height: 250px;
	padding: 10px 10px 90px;
	position: relative;
	border: 3px solid #2e3d45;
	box-shadow: 0 0 3px #000;
	margin-top: 9px;
	min-height: 250px;
}

#basketBox .product_name {
display: block;
font-size: 12px;
font-weight: bold;
height: auto;
overflow: hidden;
padding: 8px 3px 0;
text-align: left;
}
.basket_preview_wrap {
	background: #ffffff none repeat scroll 0 0;
	border: 1px solid #ededed;
	box-shadow: 0 0 3px #ededed;
	margin-top: 9px;
	min-height: 250px;
}
.basket-preview-footer {
	bottom: 10px;
	position: absolute;
	text-align: right;
	width: 280px;
}

#mezisoucet {
font-weight: bold;
overflow: hidden;
text-align: left;
}

#mezisoucet .price {
color: #222;
	float: right;
font-size: 16px;
padding: 0;
vertical-align: baseline;
}

#basketBox .kod {
color: gray;
float: left;
font-size: 12px;
}
.basket_preview {
	position: absolute;
	right: 0;
	top: 43px;
	width: 300px;
	z-index: 9998;
}
.basket_preview_wrap {
	border: 3px solid #2e3d45;
	box-shadow: 0 0 3px #000;
}
.basket_preview::after {
	-moz-border-bottom-colors: none;
	-moz-border-left-colors: none;
	-moz-border-right-colors: none;
	-moz-border-top-colors: none;
	border-image: none;
	border-style: solid;
	border-width: 12px;
	content: "";
	display: block;
	position: absolute;
	right: 25px;
	top: -10px;
	width: 0;
    border-color: transparent transparent #fff;
}
.basket_zobacek {
	-moz-border-bottom-colors: none;
	-moz-border-left-colors: none;
	-moz-border-right-colors: none;
	-moz-border-top-colors: none;
	border-color: transparent transparent #2e3d45;
	border-image: none;
	border-style: solid;
	border-width: 12px;
	content: "";
	display: block;
	position: absolute;
	right: 25px;
	top: -14px;
	width: 0;
}
';
#region basketHeader


$res .= '
#basketBox {
    background: none no-repeat scroll 0 0 #fff;
    height: 58px;
    position: absolute;
    right: 5px;
    text-align: right;
    top: 35px;
    width: 108px;
    z-index:1001;
}


#basket-trigger {
    display: block;
    height: 58px;
    width: 108px;
}

.kosik_count {
	background: none no-repeat scroll 0 0 silver;
	border-radius: 30px;
	color: #FFFFFF;
	display: block;
	font-size: 12px;
	font-weight: 700;
	height: 23px;
	line-height: 23px;
	position: absolute;
	right: 3px;
	text-align: center;
	top: 2px;
	width: 23px;
}
.kosik-label {
    bottom: 40%;
    font-size: 12px;
    font-weight: bold;
    left: 0;
    position: absolute;
    text-align: right;
    width: 50%;
}

.kosik-label-empty {
    bottom: 15px;
    text-align: center;
}



input[type="checkbox"]:checked {
    font-weight: bold;
}
.checkbox-group .checkbox {
    display: inline-block;
    margin-right: 10px;
}
label input[type="checkbox"]:checked::before {
    color: #f00;
    font-style: normal;
}
.checkbox-group label {
    border: 1px solid #c3c3c3;
    border-radius: 8px;
    color: #333333;
    cursor: pointer;
    display: inline-block;
    padding: 4px 6px;
    text-align: center;
}
.checkbox-group .checkbox input[type="checkbox"] {
    display: none;
    margin: 0;
}
.checkbox-group input[type="checkbox"]:checked + label, .checkbox-group label:hover {
    background-color: #808080;
    color: #ffffff;
}
';


#endregion

#region basketFooter
$res .= '

#WizardPreload {
    background: url("images/preload.png") no-repeat scroll center center #000000;
    left: 0;
    opacity: 0.3;
    position: absolute;
    top: 0;
    z-index: 3;
}

.cart_bottom_buttons {
    clear: both;
    overflow: hidden;
    padding: 15px 0;
}

.cart_bottom_price {
    float: right;
    font-size: 14px;
    line-height: 25px;
    text-align: right;
    white-space: nowrap;
    width: 90px;
}


.cenasdph, .price_total {
    font-size: 18px;
    font-weight: bold;
    line-height: 45px;
}

.cart_bottom_text {
	float: left;
	font-size: 12px;
	height: 25px;
	line-height: 25px;
	text-align: right;
	vertical-align: middle;
}
';

$res .= '
.total_row .cart_bottom_text {
	font-size: 18px;
	line-height: 45px;

}
';

$res .= '.cart_bottom_text {
	width: 76%;
}
';
#endregion

#region transferList
$res .= '.transferList .selected_row, .paymentList .selected_row {
	border-color: #2e3d45;
}

.transferList .row, .paymentList .row {
    border: 2px solid #eeeaec;
    padding: 8px 4px;
    position: relative;
    margin: 0 0 4px 0;
}
';
$res .= '
.row .price_value {
    font-weight: bold;
    padding: 8px 8px 0 0;
    position: absolute;
    right: 0;
    top: 0;
}
';

$res .= '.row .name {
	font-size: 18px;
	margin-left: -25px;
	padding-left: 25px;
}
';


$res .= '.disabled_row {
	color:silver;
}


.row .texy {
	padding-left: 25px;
	padding-right: 80px;
	font-weight: normal;
}
';

#endregion

#region Button
$res .= '
.btn-default:hover, .btn-default:focus, .btn-default.focus, .btn-default:active, .btn-default.active, .open > .dropdown-toggle.btn-default {
	background-color: #e6e6e6;
	border-color: #adadad;
	color: #333;
	}
	.btn-success {
		background-color: #5cb85c;
		border-color: #4cae4c;
		color: #fff;
	}
	.btn {
		-moz-user-select: none;
		background-image: none;
		border: 1px solid transparent;
		cursor: pointer;
		display: inline-block;
		text-align: center;
		text-decoration: none;
		vertical-align: middle;
		white-space: nowrap;
	}
	.btn {
		-moz-user-select: none;
		background-image: none;
		border: 1px solid transparent;
		border-radius: 4px;
		cursor: pointer;
		display: inline-block;
		font-size: 14px;
		font-weight: 400;
		line-height: 1.42857;
		margin-bottom: 0;
		padding: 6px 12px;
		text-align: center;
		vertical-align: middle;
		white-space: nowrap;
	}
	.btn-warning {
		background-color: #f0ad4e;
		border-color: #eea236;
		color: #fff;
	}
	.btn-default {
	background-color: #fff;
	border-color: #ccc;
	color: #333;
	}
	.btn-lg, .btn-group-lg > .btn {
		border-radius: 6px;
		font-size: 18px;
		line-height: 1.33;
		padding: 10px 16px;
	}
	.btn-xs, .btn-group-xs > .btn {
		border-radius: 3px;
		font-size: 12px;
		line-height: 1.5;
		padding: 1px 5px;
	}
	.btn-lg, .btn-group-lg > .btn {
		border-radius: 6px;
		font-size: 18px;
		font-weight: 400;
		line-height: 1.33;
		padding: 10px 16px;
	}
	.btn-sm, .btn-group-sm > .btn {
		border-radius: 3px;
		font-size: 12px;
		line-height: 1.5;
		padding: 5px 10px;
	}
	.btn-success:hover, .btn-success:focus, .btn-success.focus, .btn-success:active, .btn-success.active, .open > .dropdown-toggle.btn-success {
		background-color: #449d44;
		border-color: #398439;
		color: #fff;
	}
';
#endregion

#region Alert

$res .= '.alert-danger {
	background-color: #f2dede;
	border-color: #ebccd1;
	color: #a94442;
}

.alert-warning {
	background-color: #fcf8e3;
	border-color: #faebcc;
	color: #8a6d3b;
}

.alert-success {
	background-color: #dff0d8;
	border-color: #d6e9c6;
	color: #3c763d;
}

.alert {
	border: 1px solid transparent;
	border-radius: 4px;
	margin-bottom: 20px;
	padding: 15px;
}

input.err, textarea.err {
    background-color: #ffcccc;
    border: 1px solid #aa1600;
}
';
#endregion

#region Paging

$res .= '.itemsList-footer {
	overflow:hidden;
}
';

$res .= '

.transferList ul,.paymentList ul,  .PruvodceKosik ul {
	list-style: outside none none;
	padding-left: 0;
}
.itemsList-footer .itemCount {
    display: block;
    float: left;
    height: 45px;
    line-height: 45px;
}
';

$res .= '.itemsList-footer .paging {
	float:right;
}
';


$res .= '.paging {
/*	height: 45px;
	padding: 0 10px;*/
}
.pglist {
/*	display: inline;*/
	float: right;
/*	list-style-type: none;
	margin: 5px 0;
	padding: 0;*/
}
/*
.pglist li {
	display: inline;
	float: left;
	margin: 0 0 0 5px;
	padding: 0;
}
.pglist li a, .pglist li span {
	display: block;
	padding: 5px 9px 6px;
}
.pglist li.nxt a {
	padding: 5px 0 6px 2px;
	text-decoration: underline;
}
.pglist li.prvs a {
	padding: 5px 2px 6px 0;
	text-decoration: underline;
}
.pglist li.pgnum a {
	background-color: #ffffff;
}
.pglist li.pgnum a:hover {
	text-decoration: none;
}
.pglist li.slctpgnum span {

	border: 1px solid #727272;
}
*/
';
#endregion

#region Product - varianty
$res .= 'table.product_varianty_list {
	margin:8px 0;
}
';
$res .= '.product_varianty_list td {
	padding:4px 0;
}
';

#endregion

$res .= '.item .product_code {
	font-size: 11px;
	line-height: 18px;
	text-align: center;
}
';

#region Slider


$res .= '
#slider {
	border: 1px solid #d4d4d4;
    border-radius: 5px;
	height: 179px;
	margin-bottom: 15px;
	max-width: 100%;
	overflow: hidden;
	position: relative;
}
#slider .slide {
	height: 179px;
	width: 100%;
}
#slider .slide img {
	max-width: 100%;
}
#slider .description_bg {
    background: silver none repeat scroll 0 0;
    bottom: 0;
    height: 50px;
    opacity: 0.4;
    position: absolute;
    width: 100%;
}

#slider .description {
    bottom: 0;
    height: 50px;
    padding: 0;
    position: absolute;
    width: 100%;
}
#slider .nad1 {
    color: #008fd2;
    font-size: 18px;
    font-weight: bold;
    padding: 10px 15px 5px;
}

#slider .nad2 {
    color: #fff;
    font-size: 14px;
    font-weight: normal;
    padding: 0 15px;
}

#slider .pagination {
    left: 15px;
    position: absolute;
    top: 15px;
    z-index: 5;
}



/*
#slider .pagination li {
    float: left;
    height: 36px;
    list-style: outside none none;
    width: 20px;
}
*/
';
#endregion

#region Product - detail
$res .= '.product_top_info_row {
	padding: 5px 0;
}
';
$res .= '.product_title {
	border-width: 0 0 3px 0;
	border-style:solid;
	font-size: 24px;
	font-weight: normal;
	margin-bottom: 10px;
	padding-bottom: 1px;
}
';


$res .= '.product_top_img {
   /* float: left;
    margin: 0;
    overflow: visible;
    padding: 0;*/
    position: relative;
  /*  width: 50%;*/
}
';
$res .= '
.product_mainimage img {
	max-height: 100%;
	max-width: 100%;
	vertical-align: middle;
}
';

$res .= '.product_top_info {
/*	float: right;*/
	line-height: 1.6;
/*	margin: 0;
	overflow: hidden;
	padding: 0;
	width: 420px;*/
}
';
$res .= '
.product_price label {
	display: inline-block;
	height: 30px;
	line-height: 30px;
	padding-top: 5px;
}
';
/*
$res .= '.product_value {
	float: right;
	width: 240px;
}
';
*/
$res .= '.product_price {
	color: #d82d02;
	padding: 8px 0;
}
';




#endregion


#region Product tabs
$res .= $product_tabsName. '
{
	margin-top: 18px;
	margin-bottom: 20px;
	padding: 0.2em;
	position: relative;
}
';
$res .= $product_tabsName. ' ul.ui-tabs-nav {
	border-width: 0 0 3px 0;
	border-style:solid;
	height: 34px;
	margin: 0;
	padding: 0;
	width: 100%;
}
';
$res .= $product_tabsName. ' .ui-tabs-nav li {
	border-bottom-width: 0;
	float: left;
	list-style: outside none none;
	margin: 1px 0.2em 0 0;
	padding: 0;
	position: relative;
	top: 0;
	white-space: nowrap;
}
';
$res .= $product_tabsName. ' .ui-tabs-nav li a {
    background: none repeat scroll 0 0 #d4d4d4;
    color: #000000;
    float: left;
    font-size: 12px;
    font-weight: normal;
    height: 30px;
    margin-right: 3px;
    padding: 10px 15px 0;
    text-align: center;
    text-decoration: none;
}
';


$res .= $product_tabsName. ' .ui-tabs-nav li.ui-tabs-selected a {
   background: none repeat scroll 0 0 tranparent;
   color: #ffffff;
   font-weight: bold;
   height: 30px;
}
';
$res .= $product_tabsName. ' .ui-tabs-panel {
	background: none repeat scroll 0 0 #f5f5f5;
	border-width: 0;
	padding: 1em 1.4em;
}';


$res .= $product_tabsName. ' .ui-tabs-hide {
	display: none;
}';
#endregion



$res .= '
.filter-box ul {
	list-style: outside none none;
	margin: 0;
	padding: 0;
}
.filter-box {
    margin-bottom: 10px;
}
.filter-item {
    margin: 0 0 10px;
    padding: 5px 10px;
}
.filtr_name {
    float: left;
    font-weight: bold;
    margin: 0;
    padding-top: 3px;
    position: relative;
    width: 90px;
}

.filtr_values {
    float: left;
    font-size: 12px;
    margin: 0;
    position: relative;
    width: auto;
}
#WizardForm .prodCount {
font-style: normal;
font-weight: normal;
}

.WizardParametersAjax {
    padding: 5px 10px;
    text-align: right;
}



#subcategory {
    list-style: outside none none;
    margin-bottom:15px;
    padding: 15px 10px;
    background: #eee none repeat scroll 0 0;
}
#subcategory a {
    background: transparent none repeat scroll 0 0;
    display: block;
    margin: 4px 0;
}
.item .price {
    position: absolute;
    text-align: center;
    top: 175px;
    width: 100%;
}

';
#region Slider-range
$res .= '
.slider-range-box {
	height: 17px;
	padding: 8px 90px 2px;
	position: relative;
}
.ui-slider .ui-slider-range {
	background: url("images/pricefilter-range.png") repeat-x scroll 0 0 transparent;
}
.ui-slider-horizontal {
	height: 9px;
}
.ui-widget-content {
	background: url("images/ui-bg_inset-soft_25_000000_1x100.png") repeat-x scroll 50% bottom #000;
	border: 0 none;
	color: #fff;
}
.min-price, .max-price {
    height: 25px;
    line-height: 25px;
    position: absolute;
    top: 0;
    white-space: nowrap;
    width: 74px;
}


.min-price {
    height: 25px;
    left: 0;
    line-height: 25px;
   /* padding-right: 25px;*/
    position: absolute;
    text-align: right;
    top: 0;
    width: 74px;
}


.max-price {
    height: 25px;
    line-height: 25px;
   /* padding-left: 25px;*/
    position: absolute;
    right: 0;
    top: 0;
	text-align: left;
}



footer .container {
    padding-top: 25px;
}
';
#endregion




$res .= '

table.basket {
width: 100%;
}
.PruvodceKosik li.selected {
	color: #ffffff;
}

.PruvodceKosik span {
    display: inline-block;
}
.PruvodceKosik li.selected span.numStep, .PruvodceKosik li.selected a {
    background: transparent none repeat scroll 0 0;
    color: #008fd2;
}

.PruvodceKosik, .PruvodceKosik li.selected span.numStep {
    border-color: #008fd2;
}
.PruvodceKosik li.selected span.numStep, .PruvodceKosik li.selected a {
    background: transparent none repeat scroll 0 0;
    color: #008fd2;
}

.PruvodceKosik {
    background-color: #fbf9fa;
    border: 2px solid #eeeaec;
    border-radius: 0;
    opacity: 1;
    overflow: hidden;
    margin-bottom: 15px;
}
.PruvodceKosik li {
	float: left;
	font-weight: normal;
	height: 45px;
	line-height: 45px;
	text-align: left;
	width: 25%;
}

.PruvodceKosik span.numStep {
    background: transparent none repeat scroll 0 0;
    border: 3px solid #eeeaec;
    border-radius: 18px;
    color: #eeeaec;
    display: inline-block;
    font-weight: bold;
    height: 30px;
    line-height: 30px;
    margin-bottom: 5px;
    margin-right: 5px;
    margin-top: 5px;
    width: 30px;
    text-align:center;
}

.filtr_values li {
    float: left;
    height: 25px;
    line-height: 25px;
    white-space: nowrap;
}

.serviceList {
    list-style: outside none none;
    margin: 0;
    padding: 0;
    text-align: center;
}
.serviceList i {
    color: #265599;
    display: block;
    font-size: 60px;
}
#slider-box {
    background: transparent url("/public/js/images/overlay.png") repeat scroll 0 0;
    display: none;
    height: 500px;
    left: 0;
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 90;
}

#basket-box {
    background: #fff none repeat scroll 0 0;
    border: 3px solid #222;
    border-radius: 15px;
    box-shadow: 0 0 30px rgba(0, 0, 0, 0.6);
    color: #222;
    display: block;
    height: 140px;
    left: 0;
    position: fixed;
    text-align: center;
    text-transform: uppercase;
    width: 620px;
    z-index: 99999;
}

#basket-box form {
    padding: 25px 10px 0 15px;
}

.text-right {
    float: right;
    text-align: right;
}

.product_top_img span {
    bottom: 5px;
    opacity: 0.4;
    position: absolute;
    right: 5px;
    text-align: right;
    width: 100%;
}

.product_top_img span i {
    color: silver;
    font-size: 46px;
}
.navbar-toggle {

    color: #fff;
}

.sr-only2 {

    display: block;
    float: right;
    line-height: 1;
    padding-left: 35px;
}

.nav-basket i {
	font-size:18px;
	padding-right:14px;
}

	.productsNav .navbar-nav > li, .productsNav .navbar-nav  {

	float:none;
	}
@media (max-width: 400px) {
	.item {
	    width: 100%;
	}
}

header .productsNav {
    border: 0 none;
    min-height: 0;
    padding: 0;
}

.container {
    padding-left: 10px;
    padding-right: 10px;
}
.row {
    margin-left: -10px;
    margin-right: -10px;
}
.col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12 {
    padding-left: 10px;
    padding-right: 10px;
}
.col-xs-13 {
    width: 80%;
    float: left;
}
.col-xs-13,
.col-sm-13,
.col-md-13,
.col-lg-13,
.col-xs-15,
.col-sm-15,
.col-md-15,
.col-lg-15 {
    position: relative;
    min-height: 1px;
    padding-right: 5px;
    padding-left: 5px;
}

.col-xs-15 {
    width: 20%;
    float: left;
}
@media (max-width: 480px) {

	section.page {
		padding-bottom:10px;
	}
}

@media (min-width: 768px) {
	.col-sm-15 {
        width: 20%;
        float: left;
    }
    .col-sm-13 {
	    width: 80%;
	    float: left;
	}
}
@media (min-width: 992px) {
    .col-md-15 {
        width: 20%;
        float: left;
    }
    .col-md-13 {
	    width: 80%;
	    float: left;
	}

}

/*
@media (max-width: 950px) {
    .navbar-header {
        float: none;
    }
    .navbar-toggle {
        display: block;
    }
    .navbar-collapse {
        border-top: 1px solid transparent;
        box-shadow: inset 0 1px 0 rgba(255,255,255,0.1);
    }
    .navbar-collapse.collapse {
        display: none!important;
    }
    .navbar-nav {
        float: none!important;
        margin: 7.5px -15px;
    }
    .navbar-nav>li {
        float: none;
    }
    .navbar-nav>li>a {
        padding-top: 10px;
        padding-bottom: 10px;
    }
}*/

@media (min-width: 1200px) {
    .col-lg-15 {
        width: 20%;
        float: left;
    }
    .col-md-13 {
	    width: 80%;
	    float: left;
	}
}
';

#region Reponsive
$res .= '

@media(max-width:980px){
	#main, .wrapper {
		max-width: 100%;
	}

	header .logo {
		float:none;
	}
.slogan {
		display:none;
}
	header .searchBox {
		position:relative;
		left:0;
		width:100%;
		top:0;
	}

	#header_menu {

	}



		.searchBox {
	display:none;
	}

	.content_in {
    	padding: 5px;
	}
	footer .logo {
		display:none;
	}

	footer .odkazy {
		padding-left:0;
	}
	.product_top_img , .product_top_info {
		width:auto;
		float:none;
	}
	.product_top_img {

		text-align:center;
	}
	#basket-box {
		max-width:98%;
		width:auto;
	}
	.filtr_values {
		width:auto;
	}

		.item {
	width: 50%;
	}


}
/* Landscape phones and portrait tablets */

@media (max-width: 767px) {
	footer, footer .container {
	height:auto;
	}

	footer {position:static; }
}
@media (max-width: 530px) {

}
@media (max-width: 480px) {
			.item {
	width: 100%;
	}

	#basketBox {
	display:none;
	}
}

';


#endregion
header("Content-Type: text/css");


include("productsNav.php");

include("template" . $templateId. ".php");
print $res;
