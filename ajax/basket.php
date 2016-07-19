<?php
/**
 * Add song my favorite
 * */
session_start();
header("Content-type: text/html; charset=utf-8");
header("Cache-Control: no-cache");
header("Pragma: nocache");
define('PATH_ROOT2', dirname(__FILE__));
define('PATH_TEMP', PATH_ROOT2 . '/../template/');

require_once PATH_ROOT2.'/../inc/init_spolecne.php';


if (!$GAuth->islogIn())
{
	define('LOGIN_STATUS', 'OFF');
} else {
	define('LOGIN_STATUS', 'ON');
}

$data =array();
$data["status"] = "wrong";

//print_r($_SESSION["platba_id"]);


if (isset($_GET["do"])) {
//	require_once PATH_ROOT2.'/../inc/init_spolecne.php';
	$action = $_GET["do"];

	$data = array();
/*
	$basketController = new BasketController();
//	$basketController->delProduct();
	if ($basketController->addProduct() === true) {

	}*/
/*
	if ($basketController->status["status"] == "ok") {
		$data["status"] = "success";
		$json = json_encode($data);
		print_r($json);
		exit;
	}*/

	switch ($action) {

		case "changeQtyProductAjax":
		//	print "tudy";
			$basketController = new BasketController();

			if ($basketController->changeQtyProductAjax() === true) {
				$data["status"] = "success";
				$json = json_encode($data);
				print_r($json);
				exit;

			}
			exit;
			break;

		case "ProductBasketDelete":
			$basketController = new BasketController();

			if ($basketController->deleteAjaxAction() === true) {
				$data["status"] = "success";
				$json = json_encode($data);
				print_r($json);
				exit;

			}


			$formName = "Application_Form_ProductBasketDeleteConfirm";

			$form = new $formName();
			$modalForm = new BootrapModalForm("myModal",$form);

			$body .= $form->getElement("action")->render();
			$modalForm->setBody($body);;

			$data["html"] = $modalForm->render();

			$data["control"] = $name;
			$data["action"] = $action;
			$json = json_encode($data);
			print_r($json);
			exit;
			break;
		case "addBasket":
		$basketController = new BasketController();

			$basketController = new BasketController();
			//	$basketController->delProduct();
			if ($basketController->addProduct() === true) {

			}

			if ($basketController->status["status"] == "ok") {
				$data["status"] = "success";
				$json = json_encode($data);
				print_r($json);
				exit;
			}


			$formName = "Application_Form_ProductBasketCreate";
			$form = new $formName();
			//Nová sms zpráva
			$modalForm = new BootrapModalForm("myModal",$form);


			$res .= '<div class="col-xs-12">';
			$res .= '<label for="message-text" class="control-label">' . $form->product->title . '</label>';
			$res .= $form->getElement("product_id")->render();
			$res .= $form->getElement("qty")->render();
			$res .= '</div>';


			$res .= '<div class="form-group">';
			//	$res .= '<label for="message-text" class="control-label">Zpráva:</label>';
			//	$res .= $form->getElement("message")->render();
			$res .= $form->getElement("add_product_basket")->render();

			$res .= '</div>';


			//	$res .= '<p class="text-warning"><small>K odeslání SMS je nutné mít dostatečný kredit</small></p>';
			$modalForm->setBody($res);


			//	print_r($modalForm);
			$data["html"] = $modalForm->render();
			$data["control"] = $name;
			$data["action"] = $action;
			$json = json_encode($data);
			print_r($json);
			exit;
			break;
	}
/*

	if ($action == "addBasket") {




		$formName = "Application_Form_ProductBasketCreate";
		$form = new $formName();
		//Nová sms zpráva
		$modalForm = new BootrapModalForm("myModal",$form);


		$res .= '<div class="col-xs-12">';
		$res .= '<label for="message-text" class="control-label">' . $form->product->title . '</label>';
		$res .= $form->getElement("product_id")->render();
		$res .= $form->getElement("qty")->render();
		$res .= '</div>';


		$res .= '<div class="form-group">';
	//	$res .= '<label for="message-text" class="control-label">Zpráva:</label>';
	//	$res .= $form->getElement("message")->render();
		$res .= $form->getElement("add_product_basket")->render();

		$res .= '</div>';


	//	$res .= '<p class="text-warning"><small>K odeslání SMS je nutné mít dostatečný kredit</small></p>';
		$modalForm->setBody($res);


	//	print_r($modalForm);
		$data["html"] = $modalForm->render();
		$data["control"] = $name;
		$data["action"] = $action;
		$json = json_encode($data);
		print_r($json);
		exit;

	}*/
}


if (isset($_POST["order_to_basket"])) {

	require_once PATH_ROOT2.'/../inc/init_spolecne.php';
	$basketController = new BasketController();

}
/*
if (isset($_POST["product_id"])) {

	$basketController = new BasketController();
	$basketController->delProduct();
	$basketController->addProduct();
	$data = $basketController->status;

	$basketlist = $basketController->basketList();

}
*/

if (isset($_POST["id"])) {
	require_once PATH_ROOT2.'/../inc/init_spolecne.php';
	$basketController = new BasketController();
	if ($basketController->setDopravaAjax() == true) {
		$data["status"] = "ok";
	};
	if ($basketController->setPlatbaAjax() == true) {
		$data["status"] = "ok";
	};
	//$basketController->setPlatbaAjax();
}


if (isset($_POST["info"])) {
	require_once PATH_ROOT2.'/../inc/init_spolecne.php';

	if (!$GAuth->islogIn())
	{
		define('LOGIN_STATUS', 'OFF');
	} else {
		define('LOGIN_STATUS', 'ON');
	}
	$basketController = new BasketController();
	$data = $basketController->getBasketInfo();
}

$json = json_encode($data);
print_r($json);
//print "hotovo";
?>