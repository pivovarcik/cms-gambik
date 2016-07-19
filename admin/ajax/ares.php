<?php
class Ares{


public function handleLoadInfo($IC) {
	$this->payload->firma = array();
	// dá se vybrat hned z několika zdrojů dle potřeby http://wwwinfo.mfcr.cz/ares/ares_xml.html.cz#k3
	define('ARES','http://wwwinfo.mfcr.cz/cgi-bin/ares/darv_bas.cgi?ico=');
	$ico = intval($IC);
	// nemohl jsem použít kvůli omezení na serveru, nahradil jsem pomocí CURL
	//$file = @file_get_contents(ARES.$ico);
	if ($curl = curl_init(ARES.$ico)) {
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$content = curl_exec($curl);
		//$info = curl_getinfo($curl);
		curl_close($curl);
		$xml = @simplexml_load_string($content);
	}
	$a = array();
	if (isset($xml)) {
		$ns = $xml->getDocNamespaces();
		$data = $xml->children($ns['are']);
		$el = $data->children($ns['D'])->VBAS;
		if (strval($el->ICO) == $ico) {
			$a['ico'] 	= strval($el->ICO);
			$a['dic'] 	= strval($el->DIC);
			$a['firma'] = strval($el->OF);

			$a['ulice']	= strval($el->AD->UC); //.' '.strval($el->AA->CA);
			$co = strval($el->AA->CO);
			if (!empty($co)) {
				$a['ulice']	.= '/'.$co;
			}



			$a['mesto']	= strval($el->AA->N);

			$nco = strval($el->AA->NCO);
			if (!empty($nco)) {
				$a['mesto']	.= ' - '.$nco;
			}

			$a['psc']	= strval($el->AA->PSC);
			$a['stav'] 	= 'ok';
		} else {
			$a['stav'] 	= 'IČ firmy nebylo nalezeno';
		}
	} else {
		$a['stav'] 	= 'Databáze ARES není dostupná';
	}
	return $a;
//	print_r($a);
	//$this->payload->firma = $a;
	//$this->sendPayload();
}
}

$ares = new Ares();
$data = $ares->handleLoadInfo($_GET["ic"]);

$json = json_encode($data);
print_r($json);
