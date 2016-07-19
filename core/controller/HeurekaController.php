<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

class HeurekaController extends G_Controller_Action
{
	public $order_details = array();
	private $heureka_id = "";

	private $heureka_enabled = false;
	function __construct()
	{

		parent::__construct();
		$eshopSettings = G_EshopSetting::instance();
		$this->heureka_id = $eshopSettings->get("HEUREKA_CODE");


	//	$eshopController = new EshopController();
	//	$this->heureka_id = $eshopController->setting["HEUREKA_CODE"];

		//$isEnabled = ($eshopController->setting["HEUREKA_ENABLED"] == "1") ? true : false;
		$isEnabled = ($eshopSettings->get("HEUREKA_ENABLED") == "1") ? true : false;
		if (!empty($this->heureka_id) && $isEnabled) {
			$this->heureka_enabled = true;
		}


	}
	public function getOrder($id)
	{
		$orderController = new OrderController();
		$order = $orderController->getOrder($id,false);

		$this->order_details = $orderController->order_details;
		return $order;
	}

	public function postRequestHeureka($id)
	{


	//	print "tudy" . $id;
		if (!$this->heureka_enabled) {

		//	print "Heureka je neaktivní";
			return;
		}

	//	exit;
		$order = $this->getOrder($id);

		//print_r($order);
		if ($order) {

			if ($order->heureka == 1) {
				// doatzník už byl odeslán
			//	print "dotazník už byl odeslán";
				return false;
			}
			$radky = $this->order_details;

			$produkty = array();
			for ($i=0; $i<count($radky);$i++)
			{
				// jen řádky s produkty bez dopravy a dalších položek
				if ($radky[$i]->product_id > 0) {
					$produkty[] = $radky[$i]->product_name;
				}

			}

		//	print_r($produkty);
		//	exit;
			$url = $this->getUrlRequest($order->code, $order->shipping_email, $produkty);

			$contents = $this->sendRequest($url);

		//	print $url;
		//	print_r($contents);
		//	exit;
			if (false === $contents) {
				throw new Exception ('Nepodarilo se odeslat pozadavek');
			} elseif ("ok" == $contents) {
				$model = new models_Orders();
				$data = array();
				$data["heureka"] = 1;
				$data["heurekaTimeStamp"] = date("Y-m-d H:i:s");
				$model->updateRecords($model->getTableName(),$data , "id=".$id);
				return true;
			} else {
				throw new Exception ($contents);
			}

			/*
			ob_start();
			//	ob_start(null, 4096, true);
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			$res = curl_exec($ch);
			curl_close($ch);
			print $url;
			*/

		}


	}

	public function getUrlRequest($order_code, $email, $produkty = array())
	{
		$url = "http://www.heureka.cz/direct/dotaznik/objednavka.php?id=" . $this->heureka_id;

		$url .= "&email=" . $email;

		foreach ($produkty as $key => $val){
			$url .= "&produkt[]=" . urlencode($val);
		}


		$url .= "&orderid=" . $order_code;

		return $url;
	}


	private function sendRequest ($url) {
		$parsed = parse_url($url);
		$fp = fsockopen($parsed['host'], 80, $errno, $errstr, 5);
		if (!$fp) {
			throw new Exception ($errstr . ' (' . $errno . ')');
		} else {
			$return = '';
			$out = "GET " . $parsed['path'] . "?" . $parsed['query'] . " HTTP/1.1\r\n" .
			    "Host: " . $parsed['host'] . "\r\n" .
			    "Connection: Close\r\n\r\n";
			fputs($fp, $out);
			while (!feof($fp)) {
				$return .= fgets($fp, 128);
			}
			fclose($fp);
			$returnParsed = explode("\r\n\r\n", $return);

			return empty($returnParsed[1]) ? '' : trim($returnParsed[1]);
		}
	}


	public function getDotaznikReport()
	{

		if (!$this->heureka_enabled) {
			return;
		}

		$url = "http://www.heureka.cz/direct/dotaznik/export-review.php?key=" . $this->heureka_id;


		$items = simplexml_load_file($url);

		$reviews = $items->review;
		//print_r($reviews);
		//foreach ($reviews as $key => $value) {

		$model = new models_Orders();
		$model->deleteRecords(T_HEUREKA_REPORT);
		for($i=0;$i<count($reviews);$i++){

			$data = array();

			$data["rating_id"] = $reviews[$i]->rating_id;
			$data["name"] 		= isset($reviews[$i]->name) ? $reviews[$i]->name : NULL;
			$data["plus"] = $reviews[$i]->pros;
			$data["minus"] = $reviews[$i]->cons;
			$data["summary"] = $reviews[$i]->summary;
			$data["report_timestamp"] = date("Y-m-d H:i:s",trim($reviews[$i]->unix_timestamp));
			$data["order_code"] = $reviews[$i]->order_id;

			$obj = $model->getDetailByCode($reviews[$i]->order_id);
			if ($obj) {
				$data["order_id"] = $obj->id;
			}

			$data["total_rating"] = $reviews[$i]->total_rating;
			$data["delivery_time"] = $reviews[$i]->delivery_time;
			$data["transport_quality"] = $reviews[$i]->transport_quality;
			$data["web_usability"] = $reviews[$i]->web_usability;
			$data["communication"] = $reviews[$i]->communication;



			$model->insertRecords(T_HEUREKA_REPORT,$data);



			//	print ($reviews[$i]->unix_timestamp) . "-" .date("Y U",$reviews[$i]->unix_timestamp) . "<br />";

			//print date("Y-m-d H:i:s",strtotime($reviews[$i]->unix_timestamp)) . "<br />";

			//print_r($reviews[$i]->rating_id);
		}
	}

	public function getRecenzeList($params = array())
	{
		$model = new models_HeurekaReport();

		$list = $model->getList($params);
		return $list;
	}

}