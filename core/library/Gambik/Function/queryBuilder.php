<?php

/**
 * Funkce sestaví požadované query
 * @return array;
 */

function queryBuilder($query, $registerQuery){

	$querys = array();

	foreach ($registerQuery as $key => $val){
	//	print $val;
		if ($val != $query && isset($_GET[$val])) {

			if (is_array($_GET[$val])) {
				foreach ($_GET[$val] as $key2 => $val2){
				//	print $key2 . "<br />";
					$querys[] = $val . "[" . $key2 . "]=";
				}
			} else {
				$querys[$val] = $val."=".$_GET[$val];
			}


		}
	}
	$result = implode("&amp;", $querys);
	if (!empty($result)) {
		return "&amp;" . $result; //implode("&", $querys);
	}
	return '';

}