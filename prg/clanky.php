<?php
if (PAGE_ID == 1 && !empty($_GET["url"]))
{
	//print "Stránka neexistuje";
	require_once PATH_PRG . '404.php';
	exit;
}



$CategoryController = new CategoryController();

$cat = $CategoryController->getCategory(PAGE_ID);




//print_r($podcategoryList);
define('AKT_PAGE',$cat->link);

if (empty($cat->id))
{
	//print "Stránka neexistuje";
	require_once PATH_PRG . '404.php';
	exit;
}
$params = new ListArgs();
//$params->id_cat = 3;
$params->cat = $cat->id;
$params->limit = 100;
$params->page = 1;
$params->stop_search = 1;
$params->order = "p.Level DESC";
$podcategoryList = $CategoryController->categoryList($params);

$args = new FotoPlacesListArgs();
$args->gallery_id = (int) PAGE_ID;
$args->gallery_type = T_CATEGORY;
$model = new models_FotoPlaces();
$fotoGallery = $model->getList($args);


$params = array();
$params["odkazy"] = $cat->serial_cat_url;
$params["nazvy"] = $cat->serial_cat_title;
//$params["clanek"] = $main->title;
$params["ignore_url"] = array("eshop");
$params["oddelovac"] = " &#155; ";
$Breadcrumb =  getBreadcrumb($params);

$GHtml->setPageTitle($cat->pagetitle);
$GHtml->setPageDescription($cat->pagedescription);
$GHtml->setPageKeywords($cat->pagekeywords);
$GHtml->printHtmlHeader();

require_once(PATH_TEMPLE . 'body_header.php');
?>
<section class="page<?php print $pageClass; ?>">
	<div class="container">
	<div class="row">


		<div id="content" class="col-xs-12">
			<div class="content_in">
<?php if (PAGE_ID != 35) { ?>
<div id="breadcrumb"><?php print $Breadcrumb; ?><?php if (LOGIN_STATUS == "ON") { ?><a class="edit" target="_blank" href="/admin/cat?id=<?php print $cat->id; ?>">[EDITACE]</a><?php } ?></div>
<?php } ?>




				<?php //require_once(PATH_TEMPLE . 'PodcategoryList.php'); ?>



				<div class="description"><?php print $cat->description; ?></div>

				<?php // require_once(PATH_TEMPLE . 'Forum.php'); ?>
				<?php require_once(PATH_TEMPLE . "gallery.php"); ?>
				<?php require_once(PATH_TEMPLE . "clankyList.php"); ?>

			</div>
		</div>


	</div>
	</div>
</section>
<?php require_once(PATH_TEMPLE . 'body_footer.php');