<?php

function urovenCategory($serial_cat_id){
	$a = explode("|",$serial_cat_id);

	$i = -1;
	foreach ($a as $id) {
		if (!empty($id)) {
			$i++;
		}
	}

	return $i;
}

?>