<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2012
 */

function url_konecek($query,$prefix='',$perex=''){
	parse_str($_SERVER["QUERY_STRING"], $url_params);
	$ignore_list = array('pg', 'id', 'cat', 'url',);
	$konecek= $prefix . "";
	$ignore_list[] = $query;
	//print_r($ignore_list);
	foreach($url_params as $key=>$value)
	{
		//if($key !='pg' && $key !='id')
		if(!in_array($key, $ignore_list))
		{
			// pouze když je nějaká hodnota
			if (!empty($value))
			{
				if (!empty($konecek) && substr($konecek, -1) !="&"){
					$konecek .= "&" . $key . "=" . $value;
				} else {
					$konecek .= $key . "=" . $value;
				}
			}

		}
	}
	return $konecek;
}
?>