<?php



class PlatceDane {
	
	const Ne = 0;
  const Ano = 1;

	static function getLabel($id){

		$labels = array();
		
		$labels[0] = "Není plátce daně";
    $labels[1] = "Je plátce daně";
		if (isset($labels[$id])) {
			return $labels[$id];
		}

	}
}