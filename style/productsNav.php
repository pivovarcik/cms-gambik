<?php

$product_NavName = '.productsNav';


#region Product Nav

$res .= $product_NavName. ' .title
{
	display:none;
}';

$res .= $product_NavName. '
{
padding-bottom: 5px;
padding-top: 5px;
}';



$res .= $product_NavName. ' ul {
	list-style: outside none none;
	padding:0;
	margin:0;
}';

$res .= $product_NavName. ' ul > li > a {
color: #222;
	display: block;
padding:8px 5px 8px 12px;
text-decoration: underline;
}
';

$res .= $product_NavName. ' > ul > li > a {
    font-size: 110%;
    font-weight: bold;
}
';

$res .= $product_NavName. ' ul > li > ul a  {
padding-left:28px;
color: #007bc8;
}
';

$res .= $product_NavName. ' ul {
}
';
$res .= $product_NavName. ' > ul > li {
border-bottom: 1px solid #ddd;
}
';



/*
   $res .= $product_NavName. ' .title {
   display: none;
   }';
*/

/*
$res .= $product_NavName. ' > ul > li {
border-bottom: 1px solid #e3e3e3;
}';
$res .= $product_NavName. ' > ul > li:last-child {
border-bottom: 0 none;
}';

$res .= $product_NavName. ' ul > li > a {
padding-left: 18px;
}';
$res .= $product_NavName. ' ul > li:hover {
margin-left: -10px;
position: relative;
}';
$res .= $product_NavName. ' > ul > li.navSelected2::after {
border-bottom: 16px solid transparent;
border-left: 16px solid #537113;
	border-top: 16px solid transparent;
content: "";
display: inline-block;
position: absolute;
right: -16px;
top: 0;
}';



$res .= $product_NavName. ' ul > li:hover, ' . $product_NavName. ' > ul > li.navSelected2, ' . $product_NavName. ' > ul > li > a.navSelected {
background: #537113 none repeat scroll 0 0;
	border-radius: 10px 0 0 10px;
margin-left: -10px;
margin-right: 0;
position: relative;
}';
$res .= $product_NavName. ' > ul > li > a.navSelected2, ' . $product_NavName. ' > ul > li > a.navSelected {
color: #fff;
}';
$res .= $product_NavName. ' ul > li > a:hover, ' . $product_NavName. ' ul > li > a.navSelected2 {
}';
$res .= $product_NavName. ' ul > li > ul {
background: #ffffff none repeat scroll 0 0;
	border: 5px solid #537113;
	border-radius: 15px;
box-shadow: 0 0 30px rgba(0, 0, 0, 0.6);
color: #000000;
	display: none;
left: 210px;
opacity: 0.95;
padding: 10px;
position: absolute;
top: 0;
width: 695px;
z-index: 9;
}';
$res .= $product_NavName. ' ul > li > ul a {
color: #000;
}';
$res .= $product_NavName. ' ul > li:hover > a {
color: #fff;
}';
$res .= $product_NavName. ' ul > li > ul > li {
color: #000000;
	float: left;
margin-left: 0;
padding-left: 0;
position: relative;
width: 33%;
}';
$res .= $product_NavName. ' ul > li > ul > li a:hover {
text-decoration: underline;
}';
$res .= $product_NavName. ' ul > li > ul > li:hover {
background-color: transparent;
border-radius: 5px;
margin-left: 0;
margin-right: 0;
padding: 0;
}';
$res .= $product_NavName. ' ul > li > ul > li > a {
border: 0 none;
color: #265599;
	display: block;
font-size: 18px;
font-weight: normal;
height: 20px;
margin: 4px 4px 8px;
padding: 80px 5px 8px;
text-align: center;
text-decoration: none;
text-shadow: none;
}';
$res .= $product_NavName. ' ul > li > ul > li > a:hover {
color: #265599;
}';

*/

#endregion