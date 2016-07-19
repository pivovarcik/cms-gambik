<?php
function postToArray($postdata) {


	$serPole = array();
	foreach ($postdata as $key => $val)
	{
		if (is_array($val)) {
			for ($i=0;$i<count($val);$i++)
			{
				$serPole[$i]->$key = $val[$i];
			}

		}
	}
	return $serPole;
}