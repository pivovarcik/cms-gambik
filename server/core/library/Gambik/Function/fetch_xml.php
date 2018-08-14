<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2012
 */

function fetch_xml($xml){
	/*
	   if(is_file($xml)){
	   $xml_data = file_get_contents($xml);
	   print "je soubor";
	   }
	   else{
	   $xml_data = $xml;
	   print "není soubor";
	   }
	*/
	$xml_data = file_get_contents($xml);

	$parser = xml_parser_create();
	xml_parse_into_struct($parser, $xml_data, $assoc_arr, $idx_arr);
	xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
	xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
	//$root_tag = $assoc_arr[0]['tag'];
	$root_tag = "Weather";
	$base_tag =strtolower("day");
	//$base_tag = strtolower($assoc_arr[1]['tag']);
	//print $base_tag;
	// print $assoc_arr[0]['tag'];
	$i = 0;
	foreach($assoc_arr as $key => $element){
		if($element['tag'] != $root_tag){
			if(!preg_match('/^\s+$/', $element['value'])){
				$tag = strtolower($element['tag']);
				$items[$i][$tag] = $element['value'];
				if($tag == $base_tag){
					$i++;
				}
			}
			elseif(isset($element['attributes'])){
				$items[$i]['id'] = $element['attributes']['ID'];
			}
		}
	}

	return $items;
}
?>