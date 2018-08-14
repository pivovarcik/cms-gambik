<?php
function categoryToUrl($odkazy,$category_ID="",$oddelovac = "/")
{
	/*   */
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
		if(!empty($odkazy_pole_temp[$i]) && $odkazy_pole_temp[$i]!="Public-site")
		{
			$result .= $odkazy_pole_temp[$i] . $oddelovac;
		}
	}

	return $result;
}