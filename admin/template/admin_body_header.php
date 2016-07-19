<?php
//print $settings->get("INSTALL_DATE");

GoBackHandler();
$Breadcrumb = "";
//print_r($settings);
if (isset($cat)) {


	$params = array();
	$params["odkazy"] = $cat->serial_cat_url;
	$params["nazvy"] = $cat->serial_cat_title;
	$params["homepage"] = '<i class="fa fa-home fa-fc"></i> Přehled';
	//$params["clanek"] = $main->title;
	//$params["ignore_url"] = array("admin");
	$params["oddelovac"] = '<i class="fa fa-angle-right fa-fc"></i>';
	$Breadcrumb =  getBreadcrumb($params);
}
$start = date("Y-m-d H:i:s",strtotime($settings->get("INSTALL_DATE")));
//print $start;
$date_diff = diff(date("Y-m-d H:i:s"), date("Y-m-d H:i:s",strtotime($settings->get("INSTALL_DATE"))+(365 * 24 * 3600)) );
//print_r($date_diff);
$expirate_system = "";
$licence_info = "";


if ($date_diff["day"] < 60  && $date_diff["day"] > 0) {
	//print
	$expirate_system = (date("j.n.Y",strtotime($settings->get("INSTALL_DATE"))+(365 * 24 * 3600)));
	//	$licence_info = 'Blíží se vypršení licence (' . $expirate_system . ') k užívání systému. Zbývá <strong>' . $date_diff["day"] . ' dnů.</strong>';
} else {
	//$licence_info = 'Licence do: ' . $expirate_system . ', (zbývá ' . $date_diff["day"] . 'dnů)<a href="' . URL_HOME . '" title="O aplikaci">v' . VERSION_RS . '</a>';
}

$style_main = '';
if ($date_diff["day"] <= 0) {
	define("disabled_cms","1");
	$licence_info = '<blink>POZOR! Licence k používání CMS systému již vypršela. Užívání systému je nyní omezené!</blink>';
	$style_main=' style="background-color:#AA1600;"';
} elseif($date_diff["day"] <= 30) {
	$licence_info = '<blink>POZOR! Licence k používání CMS systému brzy vyprší. Užívání systému bude omezeno! Kontaktujte obchodníka</blink>';
	//	$style_main=' style="background-color:#AA1600;"';
}
//print $GAuth->getJmeno();
//print_r($GAauth);

$logouUrl = "/logout.php?redirect=";
?>
<div id="main">
<header>
	<div class="wrapper">
		<a href="<?php print URL_HOME;?>" class="logo"><span><?php print SERVER_TITLE;?></span></a>

			<span style="color: #fff; padding-left: 10px;"><?php print $licence_info; ?></span>
		<div id="header_user_panel">
			<a href="/admin/profil"><span class="<?php print $GAuth->getSex(); ?>"><?php print "<strong>" .$GAuth->getJmeno() . " " . $GAuth->getPrijmeni() . "</strong>, " .$GAuth->getNickName(); ?></span></a>  | <span id="msgstatus">zprávy(<?php print 0; ?>)</span> | <a href="/"><span>WEB</span></a> | <a title="Odhlásit se" href="<?php print $logouUrl; ?>"><i class="fa  fa-power-off fa-fw"></i><span>odhlásit</span></a>
		</div>
		<div class="sidebar-toggler"><i class="fa fa-bars"></i></div>
	</div>
</header>

<div id="hpanel"<?php print $style_main; ?>>




			<nav id="mainMenu">
		<?php


$params = array();
$params["start_uroven"] = 1;
$params["class_ul_root"] = "aaa";
$params["rozbalit_vse"] = false;
$params["is_menu"] = true;
$params["rozbalit_dalsi"] = true;
//$params["ignore_url"] = $ignore_url;
$params["select_uroven"] = PAGE_ID;
$params["class_ul_selected"] = "aaa";
$params["class_ul_noselected"] = "";
$params["max_vnoreni"] = 2;
if ($settings->get("MODUL_ESHOP") == "0")
{
	$params["ignore_parent"] =  array("6");
}


print $TreeMenu->getMenu($params); ?>
		<div class="clearfix"><!-- IE --></div>
	</nav>


	<div class="clearfix"> </div>
</div>
<section id="page">
	<div id="contentheader">

		<div class="page-sidebar">
		<div class="sidebar-toggler"><i class="fa fa-bars"></i></div>
		<?php if (isset($leftPanel)) {print $leftPanel;}?>
		<nav id="sideMenu" class="page-sidebar-menu">
			<div class="scrollDiv">
				<div class="title">Hlavní nabídka</div>
			<?php
$start_uroven = PAGE_ID;
if (isset($cat->serial_cat_id)) {
	$cat_ids = explode("|", $cat->serial_cat_id);

	if ($cat_ids[(count($cat_ids)-1)] == PAGE_ID) {
		$start_uroven = 1;
	}
}

$params = array();
$params["start_uroven"] = $start_uroven;
$params["class_ul_root"] = "aaa";
$params["rozbalit_vse"] = false;
$params["is_menu"] = true;
$params["rozbalit_dalsi"] = true;
//	$params["ignore_url"] = $ignore_url;
$params["select_uroven"] = PAGE_ID;
$params["class_ul_selected"] = "aaa";
$params["class_ul_noselected"] = "";
$params["max_vnoreni"] = 3;

if ($settings->get("MODUL_ESHOP") == "0")
{
	$params["ignore_parent"] =  array("6");
}
print $TreeMenu->getMenu($params); ?>
			<div class="clearfix"><!-- IE --></div>
			</div>
		</nav>
		</div>
		<div class="clearfix"></div>
	</div>
	<section class="page-content">
		<div class="wraper">


