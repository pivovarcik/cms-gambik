<?php

include dirname(__FILE__) . "/../../inc/init_admin_ajax.php";

$result = array();
$result["status"] = "wrong";
if (isset($_POST["gallery_type"])) {

	$myClass = $_POST["gallery_type"] . "Controller";

	if (class_exists($myClass)) {
		$catalogController = new $myClass();
		$catalog_id = (int) $_POST["gallery_id"];
		$foto_id = (int) $_POST["foto_id"];
		$fotoGallery = $catalogController->setMainFoto($catalog_id, $foto_id);
		if ($catalogController->setMainFoto($catalog_id, $foto_id)) {
			$result["status"] = "ok";
		}
	//	return;
	}

}

$result = json_encode($result);
print_r($result);
exit;
/*
if ($_POST["gallery_type"] == "mm_catalog_divky") {
	$catalogController = new CatalogDivekController();
	$catalog_id = (int) $_POST["gallery_id"];
	$foto_id = (int) $_POST["foto_id"];
	$fotoGallery = $catalogController->setMainFoto($catalog_id, $foto_id);

}

if ($_POST["gallery_type"] == "catalog") {
	$catalogController = new CatalogController();
	//$params["divka"] = (int) $_POST["id"];
	$catalog_id = (int) $_POST["gallery_id"];
	$foto_id = (int) $_POST["foto_id"];
	$fotoGallery = $catalogController->setMainFoto($catalog_id, $foto_id);
}

if ($_POST["gallery_type"] == "mm_catalog_firem") {
	$catalogController = new CatalogController();
	//$params["divka"] = (int) $_POST["id"];
	$catalog_id = (int) $_POST["gallery_id"];
	$foto_id = (int) $_POST["foto_id"];
	$fotoGallery = $catalogController->setMainFoto($catalog_id, $foto_id);
}

if ($_POST["gallery_type"] == T_CATALOG_STAVEB) {
	$catalogController = new CatalogStavebController();
	//$params["divka"] = (int) $_POST["id"];
	$catalog_id = (int) $_POST["gallery_id"];
	$foto_id = (int) $_POST["foto_id"];
	$fotoGallery = $catalogController->setMainFoto($catalog_id, $foto_id);
}

if ($_POST["gallery_type"] == T_CATEGORY) {
	$catalogController = new CategoryController();
	//$params["divka"] = (int) $_POST["id"];
	$catalog_id = (int) $_POST["gallery_id"];
	$foto_id = (int) $_POST["foto_id"];
	$fotoGallery = $catalogController->setMainFoto($catalog_id, $foto_id);
}

if ($_POST["gallery_type"] == T_CLANKY) {
	$catalogController = new PublishController();
	//$params["divka"] = (int) $_POST["id"];
	$catalog_id = (int) $_POST["gallery_id"];
	$foto_id = (int) $_POST["foto_id"];
	$fotoGallery = $catalogController->setMainFoto($catalog_id, $foto_id);
}


if ($_POST["gallery_type"] == T_SHOP_PRODUCT) {
	$productController = new ProductController();
	//$params["divka"] = (int) $_POST["id"];
	$catalog_id = (int) $_POST["gallery_id"];
	$foto_id = (int) $_POST["foto_id"];
	$fotoGallery = $productController->setMainFoto($catalog_id, $foto_id);
}

if ($_POST["gallery_type"] == "game") {
	$catalogController = new CatalogGameController();
	//$params["divka"] = (int) $_POST["id"];
	$catalog_id = (int) $_POST["gallery_id"];
	$foto_id = (int) $_POST["foto_id"];
	$fotoGallery = $catalogController->setMainFoto($catalog_id, $foto_id);
}
$foto_id = (int) $_POST["foto_id"];
$fotoController = new FotoController();
$fotoDetail = $fotoController->getFoto($foto_id);
$imageController = new ImageController();

$PreviewUrl = $imageController->get_thumb($fotoDetail->file, 262,262);

$res = '<img src="'. $PreviewUrl.'"/>';
print $res;*/
?>