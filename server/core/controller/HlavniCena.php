<?php



class HlavniCena {
	
	const BezDane = 0;
  const SDani = 1;

	static function getLabel($id){

		$labels = array();
		
		$labels[0] = "Bez daně";
    $labels[1] = "S daní";
		if (isset($labels[$id])) {
			return $labels[$id];
		}

	}
}