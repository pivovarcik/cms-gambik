<?php

//print_r($_GET);
$publishController = new PublishController();
$main = $publishController->getPublish();
//$main = $g->get_clanek(array('url_frendly'=>$_GET['item']));

//print_r($main);
//exit;
if (empty($main->id))
{
	//print "Stránka neexistuje";
	require_once PATH_PRG . '404.php';
	exit;
}

define('AKT_PAGE',$main->link);


$args = new FotoPlacesListArgs();
$args->gallery_id = (int) $main->id;
$args->gallery_type = T_CLANKY;
$model = new models_FotoPlaces();
$fotoGallery = $model->getList($args);

$params = array();
$params["odkazy"] = $main->serial_cat_url;
$params["nazvy"] = $main->serial_cat_title;
$params["clanek"] = $main->title;
$params["oddelovac"] = " &#155; ";
$Breadcrumb =  getBreadcrumb($params);


$GHtml->setPageTitle($main->pagetitle);
$GHtml->setPageDescription($main->pagedescription);
$GHtml->setPageKeywords($main->pagekeywords);
$GHtml->printHtmlHeader();




include PATH_TEMP . "body_header.php";
?>

<section>
	<div class="wrapper">
		<div id="content">
			<div class="content_in">
				<div id="breadcrumb"><?php print $Breadcrumb; ?></div>
				<h1><?php print $main->title; ?></h1>
				<div class="description"><?php print $main->description; ?></div>


				<?php //require_once(PATH_TEMPLE . 'slider.php'); ?>

				<div class="clearfix"><!-- IE --></div>

				<?php require_once(PATH_TEMPLE . "gallery.php"); ?>
			</div>
		</div>
		<?php require_once(PATH_TEMPLE . 'right_panel.php'); ?>
		<div class="clearfix"><!-- IE --></div>
	</div>
</section>
<?php
require_once(PATH_TEMPLE . 'body_footer.php');
?>