<?php

/**
 * Funkce vrátí první volný název souboru
 * @return array;
 */
function autoFileName($filename, $extension, $path = PATH_DATA){

	//strlen($extension);
  $filename = str_replace(" ", "_",$filename);
	$filename = substr($filename,0,strlen($filename)-strlen($extension)-1);
	$file = $filename . "." . $extension;
	if (file_exists($path . $file)) {

		for ($i=1; $i<1000; $i++)
		{
			$filenametest = $filename . "(" . $i . ")";
			if (!file_exists($path . $filenametest . "." . $extension)) {
				//if (!in_array($filenametest . $extension, $files)) {

				return $filenametest . "." . $extension;
				break;
			}
		//	print $i;
		}
	}
	return $file;
}