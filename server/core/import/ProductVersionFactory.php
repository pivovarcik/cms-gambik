<?php

class ProductVersionFactory{


	public function create($postdata)
	{

		$versionData = $postdata;

		$versionData["version"] = 0;
		$name = 'hl_mj';
		if (array_key_exists($name, $postdata) && $postdata[$name] > 0) {
			$versionData["hl_mj_id"] = $postdata[$name];
			$versionData["mj_id"] = $postdata[$name];
		}

		$name = 'title';
		if (array_key_exists($name, $postdata) && !empty($postdata[$name])) {
			
		} else {
        $versionData["title"] =  "(neuvedeno)";
    
    }
    
		$name = 'category';
		if (array_key_exists($name, $postdata) && $postdata[$name] > 0) {
			$versionData["category_id"] = $postdata[$name];
		}
		$name = 'category_id';
		if (array_key_exists($name, $postdata) && $postdata[$name] > 0) {
			$versionData["category_id"] = $postdata[$name];
		}

		$name = 'skupina';
		if (array_key_exists($name, $postdata) && $postdata[$name] >= 0) {
			//$versionData[$i]["skupina_id"] = $postdata[$name];
			$versionData["skupina_id"] = ($postdata[$name] == 0) ? NULL : $postdata[$name];
		}


		$name = 'vyrobce';
		if (array_key_exists($name, $postdata) && $postdata[$name] >= 0) {
			//	$versionData[$i]["vyrobce_id"] = $postdata[$name];
			$versionData["vyrobce_id"] = ($postdata[$name] == 0) ? NULL : $postdata[$name];
		}


		$entitaOut = new ProductVersionEntity(null,false);
		$entitaOut->naplnEntitu($versionData);

		return $entitaOut;
	}

}

?>