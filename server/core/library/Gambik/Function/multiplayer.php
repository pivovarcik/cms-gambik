<?php
// nový multiplayer
function multiPlayer3($file){
$player = '
<script type="text/javascript" src="mp5.9/jwplayer.js"></script>
<div id="mediaplayer3"></div>
<script type="text/javascript">
jwplayer("mediaplayer3").setup({
	flashplayer: "mp5.9/player.swf",
	allowscriptaccess : "always",
	file: "' . $file . '",
	autostart: true,
	backcolor : "404040",
	frontcolor : "ffffff",
	height : "22",
	width : "270",
	controlbar : "bottom",
});
</script>';
	return $player;
}
function multiPlayer2($file,$plugin=""){

	//$flashplayer = "http://api.zippyshare.com/api/mediaplayer/mediaplayer.swf";
	$ampersand = '&amp;';
	$ampersand = '&';
	$zippydown="404040";
	$zippyfront="ffffff";
	$zippyback="404040";
	$zippylight="f0ab09";
	$zippywidth=278;
	$zippyauto=true;
	$zippyvol=100;

	switch($plugin){
		case "zippy":
			$flashplayer = "http://www.musicmania.cz/public/jwplayer2/player.swf";
			break;
		case "4shared":
			$flashplayer = "http://static.4shared.com/flash/player.swf";
			break;
		case "nukeshare":
			$flashplayer = "http://www.nukeshare.com/player/player.swf";
			break;
		case "hulkshare":
			$flashplayer = "http://on.hulkcdn.com/static/embed.swf";
			$flashplayer = "http://beta.musicmania.cz/public/jwplayer2/player.swf";
			break;
		default:
			$flashplayer = "http://www.musicmania.cz/public/jwplayer/player.swf";
			break;
	}
	//		'so.addVariable(\'bordercolor\',\'404040\');' .
	$player = '<script type="text/javascript">' .
		'var so = new SWFObject(\'' . $flashplayer . '\',\'playerID\',\'270\',\'20\',\'1\');' .
		'so.addParam(\'allowfullscreen\',\'true\');' .
		'so.addParam(\'allowscriptaccess\',\'always\');' .
		'so.addVariable(\'file\', \'' . $file . '\');' .
		'so.addVariable(\'controlbar\', \'bottom\');' .
		'so.addVariable(\'backcolor\',\'404040\');' .
		'so.addVariable(\'screencolor\',\'404040\');' .
		'so.addVariable(\'lightcolor\',\'ffffff\');' .
		'so.addVariable(\'frontcolor\',\'ffffff\');' .
		'so.addVariable(\'autostart\',\'true\');' .
		'so.write(\'mediaplayer\');' .
		'</script>';
	return $player;
}

function multiPlayer($file,$type="mp3"){

	//$flashplayer = "http://api.zippyshare.com/api/mediaplayer/mediaplayer.swf";
	$ampersand = '&amp;';
	//$ampersand = '&';
	$zippydown="404040";
	$zippyfront="ffffff";
	$zippyback="404040";
	$zippylight="ffffff";
	$zippywidth=278;
	$zippyauto=true;
	$zippyvol=100;

	$flashplayer = "http://www.musicmania.cz/player/mediaplayer.swf";
	//$flashplayer = "http://charts3.musicmania.cz/flash/mediaplayer.swf";
	$player = '<script type="text/javascript">
	document.write(\'<div style="width: '
	. $zippywidth . 'px;"><div><object id=mpl classid=clsid:D27CDB6E-AE6D-11cf-96B8-444553540000 width="'
	. $zippywidth . '" height=20><param name="flashvars" value="height=20' . $ampersand .
	'width=' . $zippywidth . $ampersand .
	'file=' . $file . $ampersand .
	'volume=' . $zippyvol . $ampersand .
	'autostart=' . $zippyauto . $ampersand .
	'frontcolor=0x' . $zippyfront . $ampersand .
	'backcolor=0x' . $zippyback . $ampersand .
	'lightcolor=0x' . $zippylight . $ampersand .
	'type=' . $type . '"></param><param name="src" value="'
		. $flashplayer . '"></param><embed width="'
	. $zippywidth . '" height="20" flashvars="height=20' . $ampersand .
	'width=' . $zippywidth . $ampersand .
	'file=' . $file . $ampersand .
	'volume=' . $zippyvol . $ampersand .
	'autostart=' . $zippyauto . $ampersand .
	'frontcolor=0x' . $zippyfront . $ampersand .
	'backcolor=0x' . $zippyback . $ampersand .
	'lightcolor=0x' . $zippylight . $ampersand .
	'type=' . $type . '" allowfullscreen="false" quality="high" name="mpl" id="mpl" style="" src="'
	. $flashplayer . '" type="application/x-shockwave-flash"></object></div></div>\');
</script>';
	return $player;
}