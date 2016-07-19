<?php
if ($eshopSettings->get("PAGE_PODCATEGORY") == "0") {
	return;
}
if (count($podcategoryList)>0) { ?>
<ul id="subcategory" class="row">
<?php for($i=0;$i<count($podcategoryList);$i++) { ?>

<li class="col-xs-12 col-sm-6 col-md-4"><a class="<?php print $podcategoryList[$i]->url; ?>" href="<?php print $podcategoryList[$i]->link; ?>" title="<?php print trim($podcategoryList[$i]->title); ?>"><?php print truncateUtf8(trim($podcategoryList[$i]->title),30,false,true); ?></a></li>
<?php } ?>
</ul>

<?php } ?>