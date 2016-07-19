<?php
$publishController = new models_Publish();
$params = new ListArgs();
$params->limit = 10;
$params->cat = 1;
$params->page = 1;
$params->order = "p.PublicDate DESC";
$l = $publishController->getList($params);


$width = 748;
$height = 225;
if (count($l) > 0) {
?>


	<div id="slider">
		<div class="slides_container">


			<?php
			for($i=0;$i<count($l);$i++)
			{

			if (!empty($l[$i]->file)) {
				$PreviewUrl = '<img height="'.$height.'" width="100%" alt="'.$l[$i]->title.'" title="" src="' . $imageController->get_thumb($l[$i]->file,$width,$height)  . '">';
			} else {
				$PreviewUrl = '';
			}

			?>
			<div class="slide">
				<a href="<?php print $l[$i]->link; ?>">
				<div class="preview">
				<?php print $PreviewUrl; ?>
				</div>
				<div class="description_bg"></div>
				<div class="description">
					<div class="nad1"><span><?php print $l[$i]->title; ?></span></div>
					<div class="nad2"><span><?php print $l[$i]->perex; ?></span></div>
				</div>
				</a>
			</div>


			<?php } ?>

		</div>
	</div>
			<?php } ?>