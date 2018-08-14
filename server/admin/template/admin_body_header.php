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

$logouUrl = URL_HOME_SITE .  "logout.php?redirect=";
?>
<div id="main">
<header>
	<div class="wrapper">
		<nav class="navbar navbar-default navbar-top navbar-fixed-top">
        <div class="container-fluid">


		  <div class="navbar-header">
            <a href="<?php print URL_HOME;?>" class="navbar-brand"><?php print truncateUtf8(SERVER_TITLE,22,false,true);?></a>
          </div>


	<div class="navbar-collapse collapse" id="navbar">
		<ul class="nav navbar-nav navbar-left">
	         <!-- START Alert menu-->
	            <?php /* ?>
	         <li class="dropdown dropdown-list" dropdown="">
	            <a dropdown-toggle="" aria-haspopup="true" aria-expanded="false" href="/admin/message" id="zadosti-trigger">
	               <i class="fa fa-bell"></i>

	               <span id="msgstatus" class="label label-danger item-count"></span>
	            </a>
	         </li>
	         <?php */ ?>

	        <li class="dropdown">
				<a id="zadosti-trigger" class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">	               <i class="fa fa-bell"></i>

	               <span id="msgstatus" class="label label-danger item-count"></span></a>
                 
				<ul id="msgslist" class="dropdown-menu" data-turbolinks="false">
        
				<li><a class="" data-turbolinks="true" href="/admin/message">Zobrazit zprávy</a></li>
				<li><a class="modal-form" data-url="message?do=MsgChat" data-turbolinks="true" href="#">chat</a></li>
					<li><a class="modal-form" data-url="message?do=MsgCreate" data-turbolinks="true" href="#">Napsat zprávu</a></li>

				</ul>
        

  
  
			</li>



         </ul>


<?php


         $start_uroven = 1;
$max_vnoreni = 1;
//print_r($cat);
$ignore_url = "";

/*

$menuParams = array();
$menuParams["start_uroven"] = $start_uroven;
$menuParams["class_ul_root"] = "nav navbar-nav navbar-left";
//$menuParams["id_ul_root"] = "navmenu-h";
$menuParams["rozbalit_vse"] = false;
$menuParams["home"] = true;
$menuParams["home_label"] = ' <i class="fa fa-home"></i>';
$menuParams["is_menu"] = false;
$menuParams["rozbalit_dalsi"] = true;
//$menuParams["ignore_parent"] = $ignore_parent;
$menuParams["selected_parent"] = explode("|",$settings->get("MENU_CATEGORY_LIST"));
$menuParams["select_uroven"] = PAGE_ID;
$menuParams["class_ul_selected"] = "aaa";
$menuParams["class_ul_noselected"] = "";
//$menuParams["class_li_selected"] = "sel";
//$menuParams["class_li_parent_selected"] = "sel";
$menuParams["max_vnoreni"] = $max_vnoreni;

//print_r($menuParams);
*/

$params = array();
$params["start_uroven"] = 1;
$params["class_ul_root"] = "nav navbar-nav navbar-left";
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
$sidebarMenu =  $TreeMenu->getMenu($params);

//print $TreeMenu->getMenu($params);
//$BootstrapNavbar = new BootstrapNavbar();
//print $BootstrapNavbar->printMenu($TreeMenu->completeStructureSite(),1,$params);


$attribs = new stdClass();
//$attribs->path = array("1","6","22");
$attribs->path = $TreeMenu->pathA;
$BootstrapNavbar = new BootstrapNavbar($TreeMenu->getcompleteStructureSiteObj(), 1, $attribs);
$BootstrapNavbar->ulRootClass = "nav navbar-nav navbar-left";
print $BootstrapNavbar->printMenu();

?>


		<ul class="nav navbar-nav navbar-right">
    




			<li>
				<a href="<?php print URL_HOME_SITE; ?>" class="top-web"><i class="fa fa-globe"></i> <span>Web</span></a>
	        </li>
	        <?php /*  ?>
	           	<?php */ ?>
           	<li class="dropdown">
				<a class="dropdown-toggle top-profil" data-toggle="dropdown" href="#" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i> <span>Nastavení</span><b class="caret"></b></a>
				<ul class="dropdown-menu" data-turbolinks="false">
					<li><a data-turbolinks="true" href="/admin/profil">Účet</a></li>
				</ul>
			</li>

			<li>
				<a href="<?php print $logouUrl; ?>" class="top-logout"><i class="fa fa-power-off icon"></i><span> Odhlásit</span></a>
	         </li>
           </ul>
         </div><!--/.nav-collapse -->
       </div><!--/.container-fluid -->
     </nav>

		<?php /* ?>

		<div id="header_user_panel">
			<a href="/admin/profil"><span class="<?php print $GAuth->getSex(); ?>"><?php print "<strong>" .$GAuth->getJmeno() . " " . $GAuth->getPrijmeni() . "</strong>, " .$GAuth->getNickName(); ?></span></a>  | <span id="msgstatus">zprávy(<?php print 0; ?>)</span> | <a href="<?php print URL_HOME_SITE; ?>"><span>WEB</span></a> | <a title="Odhlásit se" href="<?php print $logouUrl; ?>"><i class="fa  fa-power-off fa-fw"></i><span>odhlásit</span></a>
		</div>

		<?php */ ?>
		<div class="sidebar-toggler"><i class="fa fa-bars"></i></div>
	</div>
</header>

<section id="page">
	<div id="contentheader">

		<div class="page-sidebar">
		<div class="sidebar-toggler"><i class="fa fa-bars"></i></div>
		<?php if (isset($leftPanel)) {print $leftPanel;}?>
		<nav id="sideMenu" class="page-sidebar-menu">
			<div class="scrollDiv">
				<div class="title">Hlavní nabídka</div>
			<?php
			/*
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
print $TreeMenu->getMenu($params);*/
print $sidebarMenu;
 ?>
			<div class="clearfix"><!-- IE --></div>
			</div>
		</nav>
		</div>
		<div class="clearfix"></div>
	</div>
	<section class="page-content">
		<div class="wraper">


