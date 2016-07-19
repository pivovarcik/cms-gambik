<?php
if (defined("USER_ROLE_ID") && USER_ROLE_ID == "2") {
	print $userController->userPanelRender();
}
?>
<div id="main">
	<header>


      <nav id="header_menu" class="navbar navbar-static-top affix-top">
        <div class="container">

          <div class="navbar-header ">
            <button type="button" class="menu navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only2">Menu</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <?php
            $logo_file = $settings->getLogoFile();
            if (!empty($logo_file)) {
            	$logo_file = URL_IMG . $logo_file; ?>
            	<a class="navbar-brand" href="<?php print URL_HOME; ?>"><img src="<?php print URL_IMG . $settings->getLogoFile(); ?>" /></a>
            <?php } else { ?>
            	<a class="navbar-brand" href="<?php print URL_HOME; ?>"><?php print SERVER_NAME; ?></a>
              <?php	} ?>
          </div>
          <div id="navbar" class="navbar-collapse collapse">

          <?php require_once(PATH_TEMPLE . 'language_panel.php');?>

					<?php
$start_uroven = 1;
$max_vnoreni = 1;
//print_r($cat);
$ignore_url = "";



$menuParams = array();
$menuParams["start_uroven"] = $start_uroven;
$menuParams["class_ul_root"] = "nav navbar-nav navbar-left";
//$menuParams["id_ul_root"] = "navmenu-h";
$menuParams["rozbalit_vse"] = false;
$menuParams["home"] = true;
$menuParams["home_label"] = ' <i class="fa fa-home"></i>';
$menuParams["is_menu"] = false;
$menuParams["rozbalit_dalsi"] = true;
$menuParams["ignore_parent"] = $ignore_parent;
$menuParams["selected_parent"] = explode("|",$settings->get("MENU_CATEGORY_LIST"));
$menuParams["select_uroven"] = PAGE_ID;
$menuParams["class_ul_selected"] = "aaa";
$menuParams["class_ul_noselected"] = "";
//$menuParams["class_li_selected"] = "sel";
//$menuParams["class_li_parent_selected"] = "sel";
$menuParams["max_vnoreni"] = $max_vnoreni;

//print_r($menuParams);
print $TreeMenu->getMenu($menuParams);
?>
				</div>
				</div>
			</nav>
	</header>
			<?php require_once(PATH_TEMPLE . 'bxSlider.php'); ?>