<?php
function diff($date1_in_sec,$date2_in_sec) {
	$date1_in_sec = strtotime($date1_in_sec);
	$date2_in_sec = strtotime($date2_in_sec);

	$sec = $date2_in_sec - $date1_in_sec;

	$min = floor($sec/60); // celistve minuty
	$sec = $sec % 60;      // zbytek jsou sekundy

	$hod = floor($min/60); // celistve hodiny
	$min = $min % 60;      // zbytek jsou minuty

	$dni = floor($hod/24); // celistve dny
	$hod = $hod % 24;      // zbytek jsou hodiny

	//echo "Rozdíl: $dni dni, $hod hodin, $min minut a $sec sekund.";

	$data = array();
	$data["day"] = $dni;
	$data["hour"] = $hod;
	$data["min"] = $min;
	$data["sec"] = $sec;
	return $data;
}