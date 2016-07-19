<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2012
 */

function getBreadcrumb($params = array())
{
	$print ='';
	$translator = G_Translator::instance();

	$homepage = (isset($params["homepage"])) ? $params["homepage"] : $translator->prelozitFrazy("home");
	//$homepage = $this->prelozit_frazy("Úvod");
	//$homepage = (isset($params["homepage"])) ? $params["homepage"] : "Úvod";
	$oddelovac = (isset($params["oddelovac"])) ? $params["oddelovac"] : " &rarr; ";
	$start_url = (isset($params["start"])) ? $params["start"] : "root";

	$ignore_array = (isset($params["ignore_url"])) ? $params["ignore_url"] : array();

	/*   */
	$pole_nazvy_temp =array();  // dočasné pole
	$pole_nazvy =array();
	$pole_nazvy_temp = explode("|",$params["nazvy"]);

	// musím odstanit prázdné názvy
	for($i=0;$i<count($pole_nazvy_temp);$i++)
	{
		if(!empty($pole_nazvy_temp[$i]))
		{
			array_push($pole_nazvy,$pole_nazvy_temp[$i]);
		}
	}

	$pole_nazvy_temp =array();  // vyprázdním dočasné pole

	$pole_odkazy_temp =array();  // dočasné pole
	$pole_odkazy =array();
	$pole_odkazy_temp = explode("|",$params["odkazy"]);

	// musím odstanit prázdné názvy ...  ||||katalog|zboží
	for($i=0;$i<count($pole_odkazy_temp);$i++)
	{
		if(!empty($pole_odkazy_temp[$i]))
		{
			array_push($pole_odkazy,$pole_odkazy_temp[$i]);
		}
	}
	/*
	   print_r($pole_odkazy);
	   print $start_url;   */
	//if (count($pole_odkazy)>0 && $pole_nazvy[0] !== $start_url)
	if (count($pole_odkazy)>0)
	{
		$print .= '<a title="Přejít na Hlavní stránku" href="' . URL_HOME . '">' . $homepage . '</a>' . $oddelovac;
	} else
	{
		$print .= $homepage;
	}
	$pricti_url = URL_HOME;
	for($i=0;$i<count($pole_odkazy);$i++)
	{
		if($pole_odkazy[$i] != $start_url)
		{
			$pricti_url .= $pole_odkazy[$i] . "/";

			if ($i+1<count($pole_odkazy)|| (isset($params["clanek"]) && !empty($params["clanek"])))
			{
			//	$update = substr($pricti_url, 0, -1);
				if (!in_array($pole_odkazy[$i],$ignore_array)) {
					$print .= '<a title="' . $pole_nazvy[$i] . '" href="' . substr($pricti_url, 0, -1) . '">' . $pole_nazvy[$i] . '</a>';
					$print .= $oddelovac . '';
				}

			} else
			{

				$print .= '<strong>' . $pole_nazvy[$i] . '</strong>';
			}

		}
	}

	if (isset($params["clanek"]) && !empty($params["clanek"]))
	{
		$print .= '' . $params["clanek"] . '';
	}
	return $print;
}
?>