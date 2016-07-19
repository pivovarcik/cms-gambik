<?php
$CategoryController = new CategoryController();

//$cat = $CategoryController->getCategory(34);

//$cat_aktual_link  = $cat_parent_link . $cat->url_friendly_cs;
//PRINT $cat->serial_cat_url;
//define('AKT_PAGE',$cat_aktual_link);
$cat = new stdClass();
$cat->link = "search";
$cat->title = "Vyhledávání v produktech";
define('AKT_PAGE',$cat->link);



/*
$params = array();
$params['gallery_id'] = (int) PAGE_ID;
$params['gallery_type'] = T_CATEGORY;
$fotoController = new FotoController();
$fotoGallery = $fotoController->fotoUmisteniList($params);
*/
$fotoGallery = array();
$params = array();
$params["odkazy"] = $cat->serial_cat_url;
$params["nazvy"] = $cat->serial_cat_title;
$params["ignore_url"] = array("eshop");
//$params["clanek"] = $main->title;
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

<?php
if ($G_HtmlPage->isLeftPanel()){ require_once(PATH_TEMPLE . 'left_panel.php');}
?>
		<div id="content" class="<?php print $G_HtmlPage->getContentClass(); ?>">
			<div class="content_in">
			<div id="breadcrumb"><?php print $Breadcrumb; ?></div>



				<?php require_once(PATH_TEMPLE . "ProductList.php");	 ?>

			<div class="description"><?php print $cat->description; ?></div>
			</div>
		</div>
<?php
if ($G_HtmlPage->isRightPanel()){ require_once(PATH_TEMPLE . 'right_panel.php');}
?>

	</div>
	</div>
</section>
<?php require_once(PATH_TEMPLE . 'body_footer.php');