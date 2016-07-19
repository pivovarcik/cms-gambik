<?php


class KurzController extends CiselnikBase
{

	private $cnb_link = "http://www.cnb.cz/cs/financni_trhy/devizovy_trh/kurzy_devizoveho_trhu/denni_kurz.txt";

	private $cnb_link2 = "https://www.cnb.cz/cs/financni_trhy/devizovy_trh/kurzy_ostatnich_men/kurzy.txt";
	function __construct()
	{
		parent::__construct("Kurz");
	}


	function zjistiKurz($mena, $datum, $kurzy) {
		// vstupnim parametrem je tripismenny kod meny, jejiz kurz chceme zjistit
		foreach ($kurzy as $v) {
			$h = explode("|", $v);
			if ((count($h) >= 5) && ($h[3] == $mena)) {

				$kurz = new KurzEntity();

				$kurz->name = $h[0];
				$kurz->mnozstvi = $h[2];
				$kurz->kod = $h[3];
				$kurz->kurz = $h[4];
				$kurz->datum = $datum;

				//	print_r($kurz);
				return $kurz;
				//return $h[2]." ".$h[3]." = ".$h[4]." CZK";
			}
		}
		return false;
	}

	function zjistiDatum($kurzy){
		foreach ($kurzy as $v) {
			$h = explode("#", $v);
			if ((count($h) == 2)) {
				return date("Ymd",strtotime(trim($h[0])));
			}
		}
	}
	public function kurzyImport()
	{
		//	error_reporting(E_ALL);
		$settings = G_Setting::instance();
		$kurzyList = explode("|",$settings->get("KURZY_IMPORT_LIST") );

		if (count($kurzyList) > 0) {
			$kurzy = file($this->cnb_link);


			//print_r($kurzy);
			$datum = $this->zjistiDatum($kurzy);


			$kurzy2 = file($this->cnb_link2);
			$datum2 = $this->zjistiDatum($kurzy2);

			$model = new models_Kurz();
			$args = new ListArgs();
			$args->date_presne = $datum;
			$args->limit = 1;
			$saveData = new SaveEntity();
			foreach ($kurzyList as $mena) {
				//		print $mena;

				$args->kod = $mena;
				$list = $model->getList($args);
				//	print 	$model->getLastQuery();
				//	print_r($list);

				if (count($list) == 0) {
					//	print $mena;
					$kurz = $this->zjistiKurz($mena,$datum,$kurzy);

					//	print_r($kurz);
					if (!$kurz) {

						$kurz = $this->zjistiKurz($mena,$datum,$kurzy2);
						if (!$kurz) {
							print "nenašel";
						}
						else {
							$saveData->addSaveEntity($kurz);
						}

					} else {
						$saveData->addSaveEntity($kurz);
					}

				}


			}
			$saveData->save();
		}


		//	$mena = "PLN";
		//	print $this->zjistiKurz($mena,$datum,$kurzy);
	}

	public function kurzyImportAction()
	{
		if(self::$getRequest->isPost() && false !== self::$getRequest->getPost('import_kurzy', false))
		{
			$this->kurzyImport();

			self::$getRequest->goBackRef();

		}
	}
}