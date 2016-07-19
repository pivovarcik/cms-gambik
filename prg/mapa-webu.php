<?php

$pagetitle = "Mapa webu";

define('AKT_PAGE',URL_HOME . '');




$Breadcrumb = '<a href="' . URL_HOME . '" title="Přejít na Hlavní stránku">Úvod</a> › ' . $pagetitle . '';

$GHtml->setPageTitle($pagetitle);
$GHtml->setPageDescription($pagedescription);
$GHtml->setPageKeywords($pagekeywords);
$GHtml->printHtmlHeader();
require_once(PATH_TEMPLE . 'body_header.php');
?>
<section>
	<div class="container">
		<div id="content">
			<div class="content_in">
				<div id="breadcrumb"><?php print $Breadcrumb; ?></div>
				<h1><?php print $pagetitle; ?></h1>
				<div class="description"><?php print $cat->description; ?></div>
					<div id="site-map">
					<?php
					print $TreeMenu->getMenu(
					array(
						"start_uroven" => MENU_ROOT_ID,
						"rozbalit_vse" => true,
						"is_menu" => true,
						"rozbalit_dalsi" => true,
						"class_ul_selected" => "",
						"class_ul_noselected" => "",
						"max_vnoreni" => 100
						)
					);
					?>
					</div>
			</div>
		</div>
<?php
if ($eshopSettings->get("RIGHT_PANEL_ON") == "1"){ require_once(PATH_TEMPLE . 'right_panel.php');}
?>

		<div class="clearfix"> </div>
	</div>
</section>
<?php require_once(PATH_TEMPLE . 'body_footer.php');?>