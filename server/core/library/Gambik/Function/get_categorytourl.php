<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2012
 */

function get_categorytourl($odkazy,$category_ID="",$oddelovac = "/")
{
	/*   */

	$category_ID = str_replace("||","" ,$category_ID);
	$odkazy = str_replace("||","" ,$odkazy);



	$odkazy_id =array();
	$odkazy_id_temp = explode("|",$category_ID);

	for($i=0;$i<count($odkazy_id_temp);$i++)
	{
		if(!empty($odkazy_id_temp[$i]))
		{
			array_push($odkazy_id,$odkazy_id_temp[$i]);
		}
	}
	$odkazy_pole = array();
	$odkazy_pole_temp = explode("|",$odkazy);

	$result = "";
	for ($i=0;$i<count($odkazy_pole_temp);$i++)
	{
		//print ":" .strtolower($odkazy_pole_temp[$i]) . ":<br />";
		if(!empty($odkazy_pole_temp[$i]) && strtolower($odkazy_pole_temp[$i])!="root")
		{
			$result .= $odkazy_pole_temp[$i] . $oddelovac;
		}
	}
	//print substr($result, -1);
	if (substr($result, -1) =="/") {
		$result = substr($result, 0, -1);
	}
	return strtolower($result);
}
?>