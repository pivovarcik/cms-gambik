<?php
function jeRubrikaEshop($serial_cat_id){
	$serial_cat_id = $serial_cat_id."|";
	$eshopSettings = G_EshopSetting::instance();
	$ostatniCat = explode("|",$eshopSettings->get("ESHOP_CATEGORY_LIST"));
//	$ostatniCat = array(8);
//print $serial_cat_id;
	foreach ($ostatniCat as $cat_id) {
	//	print $cat_id;
		if (strpos($serial_cat_id,"|" . $cat_id ."|")) {
			return true;
		}
	}

	return FALSE;
}