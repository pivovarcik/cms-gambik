
 <?php
   /**
* Generovani unikatniho jmena souboru
*/
$code = "123456";
$filename="barcode_".$sid.".png";
/**
* URL pro generovani caroveho kodu
*/
$url=$config->barlib."barcode.php?code=".$input[croom]."&encoding=128B&scale=1&mode=png&filename=".$filename;
$logger->debug($url);
/**
* Curl inicializace
*/
$ch = curl_init();
/**
*  Set URL and other appropriate options
*/
curl_setopt($ch, CURLOPT_URL, $url);
/**
* Vypinani kontroly certifikatu u SSL spojeni
* Stejne pozor ! u IE7 je nutny bezproblemovy certifikat, jinak muze byt problem se stahnutim PDF
*/
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
// grab URL and pass it to the browser
$res=curl_exec($ch);
// close cURL resource, and free up system resources
curl_close($ch);
/**
* Konec generovani PNG pro barcode
*/

?>