<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */



class ProductCenikController extends CiselnikBase
{

	function __construct()
	{
		parent::__construct("ProductCenik");
	}

	public function cenikyKatalog($cenik_id)
	{
		$modelCenik = new models_ProductCenik();

		$cenikDetal = $modelCenik->getDetailById($cenik_id);

		$html = '<h1>' . $cenikDetal->name .'</h1>';

		$filename = $cenikDetal->name;
		return $this->createPDF($html, $filename);

		$model = new models_ProductCena();

		$args = new ListArgs();

		$args->cenik_id = (int) $cenik_id;

		$list = $model->getList($args);

		for ($i=0;$i<count($list);$i++)
		{

		}
	}

	public function createPDF($html, $filename)
	{

		$return_data="F";
		require_once(PATH_ROOT. "plugins/mpdf60/mpdf.php");
	//	require_once(dirname(__FILE__) . "/../library/mpdf60/mpdf.php");
		//	exit;
		$mpdf=new mPDF('utf-8','A4');
		//$mpdf=new mPDF('','A5');
		//$mpdf=new mPDF('en-GB-x','A4','','',10,10,10,10,6,3);
		$mpdf->SetDisplayMode('fullpage');
		$mpdf->SetMargins(0,0,4);

		$mpdf->SetTitle($filename);
		$subject = "";
		$mpdf->SetSubject($subject);
		$author = "CMS Gambik - pivovarcik.cz";
		$mpdf->SetAuthor($author);
		$keywords = "";
		$mpdf->SetKeywords($keywords);
		//$stylesheet = file_get_contents('/style/print.css');
		//$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text

		//	print $html;
		//return;
		$mpdf->WriteHTML($html);
		//$mpdf->Output($orders->order_code.".pdf","D");
		$url_file = dirname(__FILE__) . "/../../public/data/" . $filename . ".pdf";

		if ($return_data == "D" || $return_data == "I") {
			$url_file = $filename.".pdf";
		}


		$mpdf->Output($url_file, $return_data);
		return $url_file;
	}
}