<?php
$CategoryController = new CategoryController();

$cat = $CategoryController->getCategory(1);

define('AKT_PAGE','/');
$GHtml->setPageTitle($cat->pagetitle);
$GHtml->setPageDescription($cat->pagedescription);
$GHtml->setPageKeywords($cat->pagekeywords);
$GHtml->printHtmlHeader();

require_once(PATH_TEMPLE . 'body_header.php');
?>
<section class="page<?php print $pageClass; ?>">
	<div class="container">
	<div class="row">

		<div id="content" class="">
			<div class="content_in">
				<?php require_once(PATH_TEMPLE . 'bxSlider.php');?>
				<?php if (LOGIN_STATUS == "ON") { ?><a class="edit" target="_blank" href="/admin/cat?id=<?php print $cat->id; ?>">[EDITACE]</a><?php } ?>
				<div class="desc"><?php print $cat->description; ?></div>
			</div>
		</div>
	</div>
	</div>
</section>
<?php require_once(PATH_TEMPLE . 'body_footer.php');