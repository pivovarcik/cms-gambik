<?php

$publishController = new PublishController();
$params = array();
$params["limit"] = 4;
$params["cat"] = 22;
$params["page"] = 1;
$newsList = $publishController->publishList($params);
?>
<div class="aktuality">
	<div class="aktuality_in">
		<div class="title">Zprávy - archiv</div>
		<div class="news_list">
		<?php for ($i=0;$i<count($newsList);$i++)
			/*
		$string = "Jmenuji se {JMENO}, {PRIJMENI} {URL_HOME}!";
		print $string . "=";
		print constToText($string);
			*/
		{ ?>
			<div class="news">
				<div class="news_in">
				<span class="new_date"><?php print date("j.n.Y",strtotime($newsList[$i]->PublicDate)); ?></span>

				<span class="description"><?php print truncateUtf8(strip_tags($newsList[$i]->description),200,true,true); ?></span><a class="more" href="<?php print $newsList[$i]->link; ?>"><span>více</span></a>
				</div>
				<div class="news_foot">
				</div>
			</div>
		<?php } ?>
		</div>
	</div>
</div>