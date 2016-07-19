<?php


function gpsDistance($lat1,$lng1,$lat2,$lng2){

	$lat1 = $lat1 * pi() / 180;
	$lng1 = $lng1 * pi() / 180;
	$lat2 = $lat2 * pi() / 180;
	$lng2 = $lng2 * pi() / 180;


	return acos
	(   cos($lat1)*cos($lng1)*cos($lat2)*cos($lng2)
	  + cos($lat1)*sin($lng1)*cos($lat2)*sin($lng2)
	  + sin($lat1)*sin($lat2)
	) * 6372.795;
}



?>