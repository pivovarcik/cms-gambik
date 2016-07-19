<?php

$publishController = new models_Publish();
$params = new ListArgs();
$params->limit = 20;
$params->cat = PAGE_ID;
$params->page = 1;
$params->order = "p.PublicDate DESC";
$clankyList = $publishController->getList($params);
?>
<div class="desc">
<ul class="clanky_list">
<?php
$thumb_width=270;
$thumb_height=110;
for ($i=0;$i<count($clankyList);$i++) {
	if (!empty($clankyList[$i]->file)) {
		$PreviewUrl = '<img  title="'.$clankyList[$i]->title.'" src="' . $imageController->get_thumb($clankyList[$i]->file,$thumb_width,$thumb_height,null,false,false) . '" class="thumb">';
	} else {
		$PreviewUrl = '<div style="width:93px;height:78px;"> Bez náhledu</div>';
	}
	?>
	<li>
		<a class="new_img" href="<?php print $clankyList[$i]->link; ?>"><span class=""><?php print $PreviewUrl; ?></span></a>
		<a class="" href="<?php print $clankyList[$i]->link; ?>"><span class="title"><?php print $clankyList[$i]->title; ?></span></a>
		<span class="new_date"><?php print date("j.n.Y",strtotime($clankyList[$i]->PublicDate)); ?></span>
		<span class="description"><?php print truncateUtf8(strip_tags($clankyList[$i]->description),300,true,true); ?></span>
		<div class="clearfix"></div>
	</li>
<?php } ?>
</ul>
</div>

