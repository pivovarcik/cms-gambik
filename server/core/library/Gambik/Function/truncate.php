<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2012
 */
function truncate($string, $limit=400,$znak =" ..." )
{
	$length = 0; $tags = array(); // dosud neuzavřené značky
	for ($i=0; $i < strlen($string) && $length < $limit; $i++)
	{
		switch ($string{$i})
		{ case '<':
			// načtení značky
			$stringtart = $i+1;
			while ($i < strlen($string) && $string{$i} != '>' && !ctype_space($string{$i}))
			{
				$i++;
			}
			$tag = substr($string, $stringtart, $i - $stringtart);
			// přeskočení případných atributů
			while ($i < strlen($string) && $string{$i} != '>')
			{
				$i++;
			}
			if ($string{$stringtart} == '/')
			{
				// uzavírací značka
				array_shift($tags);
				// v XHTML dokumentu musí být vždy uzavřena poslední neuzavřená značka
			}
			elseif ($string{$i-1} != '/')
			{
				// otevírací značka
				array_unshift($tags, $tag);
			}
			break;
		case '&':
			$length++;
			while ($i < strlen($string) && $string{$i} != ';') { $i++; }
			break;
		default:
			$length++;
		}
	}
	$konecek ="";
	if(strlen($string) > $limit)
	{
		//$konecek = "<br />»»»";
		$konecek = $znak;
	}
	$string = substr($string, 0, $i);
	if ($tags) {
		$string .= $konecek . "</" . implode("></", $tags) . ">";
	}
	return $string;
}

?>