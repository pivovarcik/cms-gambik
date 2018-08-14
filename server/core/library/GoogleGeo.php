<?php
define("GOOGLE_MAPS_KEY","ABQIAAAA-O3c-Om9OcvXMOJXreXHAxTPZYElJSBeBUeMSX5xXgq6lLjHthQK56gfyM5NBqKVAIOX7Pg8-ceW5A");
class GoogleGeo {
	public static function buildStaticMap($center, $markers=array(), $width=400, $height=400, $zoom=12, $directions=null) {
		$strMarkers = "";
		foreach($markers as $marker) {
			if (!empty($strMarkers)) $strMarkers .= '|';
			$strMarkers .= urlencode($marker);
		}
		if ($width > 640) $width = 640;
		if (!empty($center)) {
			$center = "&center=".$center;
		}
		if (!empty($strMarkers)) {
			$strMarkers = "&markers=".$strMarkers;
		}
		if ($zoom > 0) {
			$zoom = "&zoom=$zoom";
		}

		$steps = "";
		if (!empty($directions)) {
			foreach($directions['Directions']['Routes'][0]['Steps'] as $step) {
				$lat = $step['Point']['coordinates'][1];
				$lon = $step['Point']['coordinates'][0];
				if (!empty($steps)) $steps .= "|";
				$steps .= $lat.",".$lon;
			}
			if (!empty($steps)) {
				$steps .= "|".$directions['Directions']['Routes'][0]['End']['coordinates'][1].",".$directions['Directions']['Routes'][0]['End']['coordinates'][0];
				$steps = "&path=rgb:0x0000ff,weight:5|".$steps;
			}
		}

		$staticMap = "http://maps.google.com/staticmap?maptype=mobile&size=".$width."x$height&maptype=roadmap&key=".GOOGLE_MAPS_KEY."&sensor=false$strMarkers$center$zoom$steps";
		return $staticMap;
	}

	public static function retrieveDirections ($from, $to) {
		$params = array('key' => GOOGLE_MAPS_KEY, 'output' => 'json', 'q' => "from: $from to: $to");
		$url = "http://maps.google.com/maps/nav";
		//$result = HttpHelper::doGET($url, $params);
		$result = curl::get($url, $params);
		$result = json_decode($result, true);
		return $result;
	}
}
/* FROM and TO coordinates */
$markers = array("37.262568,-121.962232,redr", "37.229898,-121.971853,blueg");
/* Get the driving directions from google api */
$directions = GoogleGeo::retrieveDirections("485 Alberto Way, Suite 210. Los Gatos, CA 95032", "14109 Winchester Bl, Los Gatos, CA");
/* Create the map image url with the directions coordinates */
$staticMap = GoogleGeo::buildStaticMap(null, $markers, 640, 240, null, $directions);

class curl {

	public static function get($uri, $options=array()){


		$ch = curl_init();
		$sname = session_name();
		$sid = session_id();

		$strCookie = $sname.'=' . (array_key_exists($sname, $_COOKIE)?$_COOKIE[$sname] : $sid) . '; path=/';

		session_write_close();

		$curl_opts = array(
			CURLOPT_URL => $uri,
			CURLOPT_HEADER=> false,
			CURLOPT_COOKIE=>$strCookie,
			CURLOPT_RETURNTRANSFER=>true,
			CURLOPT_ENCODING =>"gzip"
		);

		if(count($options)){
			foreach($options as $k =>$o)$curl_opts[$k]=$o;
			//utility::print_d($curl_opts);
			//die();
		}

		curl_setopt_array(
			$ch,
			$curl_opts
		);
		$ret = curl_exec($ch);
		curl_close($ch);
		return $ret;
	}



}
?>