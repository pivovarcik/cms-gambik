<?php



/**/

	$publishController = new models_Publish();
$params = new ListArgs();
$params->page = 1;
$params->limit = 1;
$params->cat = (int) PAGE_ID;
$params->orderBy = "p.PublicDate DESC";
$params->tags = "banner";
$params->lang = LANG_TRANSLATOR;
$bannerList = $publishController->getList($params);

$args = new FotoPlacesListArgs();
$args->gallery_id = (int) $bannerList[0]->page_id;
$args->gallery_type = T_CLANKY;
$model = new models_FotoPlaces();
$fotoGalleryBanner = $model->getList($args);

if (count($fotoGalleryBanner) == 0) {
	$args = new FotoPlacesListArgs();
	$args->gallery_id =  61;
	$args->gallery_type = T_CLANKY;
	$model = new models_FotoPlaces();
	$fotoGalleryBanner = $model->getList($args);
}



$width = 1500;
$height = 600;

if (count($fotoGalleryBanner) > 0) {
	?>

	<div class="bxslider2 max-container">
		<a class="logo  hidden-xs" href="<?php print URL_HOME; ?>"><img alt="<?php print SERVER_TITLE; ?>" src="/public/style/images/logo.png" /></a>
		<ul class="bxslider">
<?php
	for($i=0;$i<count($fotoGalleryBanner);$i++)
	{
		if (!empty($fotoGalleryBanner[$i]->file)) {

			$PreviewUrl = '<img alt="'.$fotoGalleryBanner[$i]->title.'" src="' .$imageController->getZmensitOriginal($fotoGalleryBanner[$i]->file,$width,$height)  . '" />';
			$PreviewUrl = '<img alt="'.$fotoGalleryBanner[$i]->title.'" src="' .URL_IMG . $fotoGalleryBanner[$i]->file  . '" />';
		} else {
			$PreviewUrl = '';
		}
?>
			<li><?php print $PreviewUrl; ?></li>
<?php } ?>
		</ul>
	</div>
<?php
}
$fotoGalleryBanner = array();
