<?php

class ProductVariantyWrapper extends G_Wrapper{

	public function __construct($radek)
	{
		parent::__construct($radek);

		$radek->link_delete = URL_HOME . "sortiment?do=ProductVariantyDelete&id=" . $radek->id;
/*
		$pravoText = "Prohl�en�";
		if ($radek->prava == 1) {
			$pravoText = "Z�pis";
		}
		$radek->prava = $pravoText;
		$radek->stredisko = '<a href="#" data-url="' . URL_HOME . 'strediska?do=StrediskoEdit&id=' . $radek->stredisko_id . '" class="modal-form">' . $radek->stredisko . '</a>';
		*/
	}
}