<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2012
 */

function youtube_player($url,$auto=false,$width = 480,$height = 295)
{
	$auto_text = ($auto)? "&autoplay=1":"&autoplay=0";


	$url = trim($url);

	$urlArray = explode("&",$url);
	if (strLen($urlArray[0]) == 11) {
		$url = '//www.youtube.com/embed/' . $urlArray[0] . '?rel=0';
	} else {

		$parseUrl = parse_url($url);

		$parseUrl["query"];
		$queryArray = explode("&",$parseUrl["query"]);

		foreach ($queryArray as $key => $val) {

		//	print strtolower(substr($val,0,2));
			if (strtolower(substr($val,0,2)) == "v=") {
				$url = '//www.youtube.com/embed/' . str_replace("v=","" , $val). '?rel=0';
				break;
			}
		}

	//	http://www.youtube.com/watch?v=cUhPA5qIxDQ
	}
	//if (!isUrl($url)) {
	if (strPos($url,"youtube.com") === FALSE)
	{
	//	$url = '//www.youtube.com/embed/' . $url . '?rel=0';
		//	$url = 'http://www.youtube.com/v/' . $url . '&hl=cs&fs=1&rel=0' . $auto_text . '';
	}

	$url .= "&autohide=1&showinfo=0&controls=1";
	$flashPlayer = '<object width="' . $width . '" height="' . $height . '">';
	$flashPlayer .= '<param name="movie" value="' . $url . '">';
	$flashPlayer .= '</param>';
	$flashPlayer .= '<param name="allowFullScreen" value="true"></param>';
	$flashPlayer .= '<param name="allowscriptaccess" value="always"></param>';
	$flashPlayer .= '<embed src="' . $url . '" type="';
	$flashPlayer .= 'application/x-shockwave-flash" wmode="transparent" allowscriptaccess="always" allowfullscreen="true" ';
	$flashPlayer .= 'width="' . $width . '" height="' . $height . '"></embed>';
	$flashPlayer .= '</object>';




	$flashPlayer = '<iframe width="' . $width . '" height="' . $height . '" src="' . $url . '" frameborder="0"></iframe>';

	return $flashPlayer;
}