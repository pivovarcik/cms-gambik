<?php

$res .= $product_NavName. ' > ul > li > a {
    background: #ddd none repeat scroll 0 0;
}
';

$res .= $product_NavName. ' ul {
background: #eee none repeat scroll 0 0;
}

.nav > li {
    margin-left: 1px;
}

';


$res .= 'header .logo {
display: inline-block;
}
';
$res .= '
.item_in {
    background: #ffffff none repeat scroll 0 0;
    border: 1px solid #eee;
    height: 380px;
    margin: 0 0 10px;
    padding: 9px 9px 14px;
}

.itemsList .product_name {
    font-weight: normal;
    height: 50px;
    left: 0;
    overflow: hidden;
    padding: 4px 0;
    text-transform: none;
    top: 0;
}

.itemsList .product_name a {
    color: #222;
    font-size: 16px;
    line-height: 22px;
    padding: 0 5px;
    text-decoration: none;
}
.item .qty {
    width: 25px;
}
.btn-sm, .btn-group-sm > .btn {
    border-radius: 3px;
    font-size: 12px;
    line-height: 1.5;
    padding: 5px 10px;
}
.btn-buy {
    background: #007bc8 none repeat scroll 0 0;
    color: #fff;
}
.btn-buy:hover {
    background-color: #265599;
    color: #fff;
}


.item .product_image {
    max-height: 100%;
    max-width: 100%;
}
.price {
    color: #222;
    font-size: 18px;
}
.item .varianty_id {
    margin-bottom: 3px;
}
.item_in:hover {
    box-shadow: 0 0 13px rgba(0, 0, 0, 0.17);
}

.item .product_image img {
	max-height:100%;
}
.item .product_image {
    height: 200px;
    margin: 45px 0 0;
    overflow: hidden;
    padding: 0;
    text-align: center;
}

.item .price {
    bottom: 90px;
    display: block;
    left: 0;
    position: absolute;
    text-align: center;
    top: auto;
    width: 100%;
}
.item .price small, .item .price_label, .item .bezna_cena {
    display: none;
}


#header_menu {
    background: #222 none repeat scroll 0 0;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
}
#header_menu a {
	color:#fff;
}

#header_menu a:hover, #header_menu a:focus {
	background-color:#414141;
}

#header_menu .dropdown-menu{
  background-color: #222;
  border-color: #080808;
  &>li>a{
    color: #999;
    &:hover{
      color: #fff;
      background-color: #000;
    }
  }
  &>.divider {
    background-color: #000;
  }
}

.nav-category .navbar-nav > li > a {
    font-size: 110%;
   /* font-weight: bold;*/
    text-decoration:none;
    color:#222;
}
.kosik_count {background: #007bc8 none no-repeat scroll 0 0; }

.bx-wrapper .bx-viewport {
    background: #fff none repeat scroll 0 0;
    border: 0 none;
    box-shadow: none;
    left: 0;
    transform: translateZ(0px);
}
.bx-wrapper img {
    width: 100%;
}
/*
.bx-wrapper {
    margin: 0 auto;
}
.bx-wrapper .bx-pager, .bx-wrapper .bx-controls-auto {
    bottom: 20px;
}
*/
.bx-wrapper .bx-pager.bx-default-pager a {
    background: rgba(220, 220, 220, 0.8) none repeat scroll 0 0;
    border-radius: 7px;
    height: 15px;
    width: 15px;
}
.copyright, .copyright a {
	text-align:center;
	padding-bottom:15px;
}
.productsNav ul > li > ul li {
	position:relative;
}
.productsNav ul > li > ul a::before {
    color: #d4d4d4;
    content: "";
    display: inline-block;
    font-family: "fontawesome";
    font-size: 16px;
    height: 45px;
    left: 15px;
    line-height: 22px;
    position: absolute;
    text-align: left;
    top: 20%;
    transition: all 200ms linear 0s;
    width: 32px;
}

.productsNav ul > li > ul a.navSelected2::before {
    color: #25a8de !important;
}

.itemsList .product_code {
	display:none;
}


.logo img {
	padding: 20px 0 0;
}
#subcategory {
    background: #fff none repeat scroll 0 0;
    list-style: outside none none;
    padding: 15px 0;
}

#subcategory .thumbnail {

	border: 1px solid #222;
	border-radius: 0;
	padding: 0;
}
#subcategory .thumbnail > img {
	width: 100%;
}

#subcategory a {
	background: #3c3c3c none repeat scroll 0 0;
	color: #fff;
	display: block;
	font-size: 18px;
	margin: 4px 0;
	text-align: center;
	text-transform: uppercase;
}

#userBox {
	display: none;
}

.btn-buy {
	background: #009fe0 none repeat scroll 0 0;
}

a {
	color: #009fe0;
}

#content .title, #product .title {
	border-bottom: 2px solid #222;
	font-size: 20px;
	    margin-bottom: 12px;
    padding: 4px 6px;
}

.kosik_count {
	background: #222 none no-repeat scroll 0 0;
}

#header_menu {
    background: #f8f8f8 none repeat scroll 0 0;
    box-shadow: none;
}
#header_menu a {
    color: #222;
    font-size: 16px;
}
#header_menu {
    border-color: #222;
}
#header_menu a:hover, #header_menu a:focus, #header_menu a.navSelected2 {
	color: #fff;
	background-color: #222;
}


#header_menu .navbar-inverse .navbar-nav > .open > a, #header_menu .navbar-inverse .navbar-nav > .open > a:hover, #header_menu .navbar-inverse .navbar-nav > .open > a:focus, #header_menu  .open > a {
	background-color: #222;
    color: #fff;
}

#header_menu .dropdown-menu {
	background-color: #222;
    color: #fff;
}
.navbar-inverse .navbar-toggle {
    background: #009fe0 none repeat scroll 0 0;
    border-color: #eee;
}

';


