<?php

class ProductFactory {

	public function create($postdata = array())
	{
		$data = $postdata;
		$eshopController = new EshopController();
		if ($eshopController->setting["PRODUCT_NEXTID_AUTO"] == "0") {
			$name = 'cislo';
			if (array_key_exists($name, $postdata) && !empty($postdata[$name])) {
				$data[$name] = $postdata[$name];
			} else {
				$nextIdModel = new models_NextId();
				$data[$name] = $nextIdModel->vrat_nextid(array(
					"tabulka"=>T_SHOP_PRODUCT,
					"polozka"=>"cislo",
				));
			}
		} else {
			$nextIdModel = new models_NextId();
			$data[$name] = $nextIdModel->vrat_nextid(array(
			"tabulka"=>T_SHOP_PRODUCT,
			"polozka"=>"cislo",
		));
		}

		$name = 'hl_mj';
		if (array_key_exists($name, $postdata) && $postdata[$name] > 0) {
			$data["hl_mj_id"] = $postdata[$name];
			$data["mj_id"] = $postdata[$name];
		}

		$name = 'dph_id';
		if (array_key_exists($name, $postdata) && $postdata[$name] >= 0) {


			$data[$name] = ($postdata[$name] == 0) ? NULL : $postdata[$name];
		}

		$name = 'category';
		if (array_key_exists($name, $postdata) && $postdata[$name] > 0) {
			$data["category_id"] = $postdata[$name];
		}

		$name = 'skupina';
		if (array_key_exists($name, $postdata) && $postdata[$name] >= 0) {
			//	$data["skupina_id"] = $postdata[$name];
			$data["skupina_id"] = ($postdata[$name] == 0) ? NULL : $postdata[$name];
		}
		$name = 'skupina_id';
		if (array_key_exists($name, $postdata) && $postdata[$name] >= 0) {
			//	$data["skupina_id"] = $postdata[$name];
			$data[$name] = ($postdata[$name] == 0) ? NULL : $postdata[$name];
		}

		$name = 'vyrobce';
		if (array_key_exists($name, $postdata) && $postdata[$name] > 0) {
			$data["vyrobce_id"] = $postdata[$name];
		}

		$name = 'vyrobce_id';
		if (array_key_exists($name, $postdata) && $postdata[$name] > 0) {
			$data["vyrobce_id"] = $postdata[$name];
		}

		$name = 'dostupnost_id';
		if (array_key_exists($name, $postdata) && $postdata[$name] >= 0) {
			//	$data["skupina_id"] = $postdata[$name];
			$data[$name] = ($postdata[$name] == 0) ? NULL : $postdata[$name];
		}


		$entitaOut = new ProductEntity();
		$entitaOut->naplnEntitu($data);


		return $entitaOut;
	}

}

?>