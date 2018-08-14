<?php
/*
* Převede konstanty na hodnoty v textu
*/
function constToText($string){

	return preg_replace_callback('/\{([A-Z|\_]*)\}/i',
	create_function('$matches', 'return (defined($matches[1]) ? constant( $matches[1]) : "{".$matches[1]."}");'),
	 $string);
}

function propertyToText($string, $property = array()){

  $res = "";
  foreach ($property as $key => $val )
  {
     
     $string = str_replace("{" . $key . "}",$val,$string);
    // $res .= sprintf($string,$val);
  
  }
/*s
	return preg_replace_callback('/\{([A-Z|\_]*)\}/i',
		function($matches) use (&$property) {
			return (isset($property[$matches[1]]) ? $property[$matches[1]] : "{".$matches[1]."}");
		},
		$string);

*/
  return $string;

}

