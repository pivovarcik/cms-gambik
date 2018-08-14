<?php

/**
 * Obecná obálka pro ukládání Entit v transakci
 * automaticky dohledává cizí klíče z uložených entit, není nutné do uložení posílat svazané klíče!
 * přidána podpora ukládání kolekce entit
 * auto doplnění USER_ID
 * **/
class GCalender{

	private $mesic;
	private $rok;
	private $predchoziMesic;
	private $predchoziRok;
	private $nasledujiciMesic;
	private $nasledujiciRok;
	private $pocetDnuPredchoziMesic;

	// celkový počet záznamů zobrazených dnů v kalendáři
	private $pocetZobrazenychDnu = 42;

	// zobrazí pouze aktuální měsíc bez napojení na předchozí a následující měsíc
	private $zobrazitPouzeMesic = false;
	public function __construct($mesic, $rok)
	{
		$this->mesic = $mesic;
		$this->rok = $rok;
		$this->ZpracujObdobi();
	}


	public function pocetZobrazenychDnuPredchozihoMesice()
	{

		if ($this->zobrazitPouzeMesic) {
			return 0;
		}

		$prvniDenVMesici = "1.".$this->mesic. "." . $this->rok;
		$cisloPrvniDne = date("w",strtotime($prvniDenVMesici));
		if ($cisloPrvniDne == 0) {
			$cisloPrvniDne = 7;
		}

		//	print $cisloPrvniDne - 1;

		return $cisloPrvniDne - 1;
	}

	public function getPrvniZobrazenyDatum()
	{
		$pocetDnuZPredchozihoMesice = $this->pocetZobrazenychDnuPredchozihoMesice();

		//	print $pocetDnuZPredchozihoMesice;
		if ($pocetDnuZPredchozihoMesice > 0) {
			$den = ($this->pocetDnuPredchoziMesic - $pocetDnuZPredchozihoMesice+1);
			//return date("Y-m-d", strToTime("1.".$this->mesic. "." . $this->rok));
		} else {
			$den = ($this->pocetDnuPredchoziMesic - $pocetDnuZPredchozihoMesice);
		}
		//	print $this->pocetDnuPredchoziMesic . " - " . $pocetDnuZPredchozihoMesice . "+1" . ".".$this->predchoziMesic. "." . $this->predchoziRok;
		//	print ($this->pocetDnuPredchoziMesic - $pocetDnuZPredchozihoMesice+1) . ".".$this->predchoziMesic. "." . $this->predchoziRok;
		//	exit;
		return date("Y-m-d",strtotime(($den) . ".".$this->predchoziMesic. "." . $this->predchoziRok));
		// Kalendář začíná vždy od pondělí

	}


	public function getPosledniZobrazenyDatum()
	{

		$cisloDneNasledujicihoMesice = $this->pocetZobrazenychDnu - $this->pocetZobrazenychDnuPredchozihoMesice() - days_in_month($this->mesic, $this->rok);

		if ($cisloDneNasledujicihoMesice > 0) {
			return date("Y-m-d",strtotime(($cisloDneNasledujicihoMesice) . ".".$this->nasledujiciMesic. "." . $this->nasledujiciRok));
		}
		return date("Y-m-d",days_in_month($this->mesic, $this->rok) . ".".$this->mesic. "." . $this->rok);

		// Kalendář začíná vždy od pondělí

	}

	public function getNasledujiciMesic()
	{
		return $this->nasledujiciMesic;
	}
	public function getNasledujiciRok()
	{
		return $this->nasledujiciRok;
	}

	public function getPredchoziMesic()
	{
		return $this->predchoziMesic;
	}
	public function getPredchoziRok()
	{
		return $this->predchoziRok;
	}

	private function ZpracujObdobi()
	{
		if ($this->mesic - 1 == 0) {

			$this->predchoziMesic = 12;
			$this->predchoziRok = $this->rok-1;

			$this->nasledujiciMesic = $this->mesic+1;
			$this->nasledujiciRok = $this->rok;

		} elseif ($this->mesic == 12) {
			$this->nasledujiciMesic = 1;
			$this->nasledujiciRok = $this->rok+1;

			$this->predchoziMesic = $this->mesic-1;
			$this->predchoziRok = $this->rok;
		} else {

			$this->nasledujiciMesic = $this->mesic+1;
			$this->nasledujiciRok = $this->rok;

			$this->predchoziMesic = $this->mesic-1;
			$this->predchoziRok = $this->rok;

		}
		$this->pocetDnuPredchoziMesic = days_in_month($this->predchoziMesic, $this->predchoziRok);
	}


	public function calenderBuilder($mesic,$rok){

		$dnyTydne = array("Po", "Út", "St", "Čt", "Pá", "So", "Ne");
		$nazvyDnuTedny = array("0" => "po", "1" => "ut", "2" => "st", "3" => "ct", "4" => "pa", "5" => "so", "6" => "ne");


		$prvniDenVMesici = "1.".$mesic. "." . $rok;
		$days_in_month = days_in_month($mesic,$rok);



		if ($mesic-1 == 0) {
			$predchoziMesic = 12;
			$predchoziRok = $rok-1;

			$nasledujiciMesic = $mesic+1;
			$nasledujiciRok = $rok;
			$pocetDnuPredchoziMesic = days_in_month($predchoziMesic, $predchoziRok);

		} else {

			$nasledujiciMesic = $mesic+1;
			$nasledujiciRok = $rok;

			$predchoziMesic = $mesic-1;
			$predchoziRok = $rok;
			$pocetDnuPredchoziMesic = days_in_month($predchoziMesic, $predchoziRok);
		}

		//	print $pocetDnuPredchoziMesic;

		//$days_in_month = date('t', $prvniDenVMesici);
		$cisloPrvniDne = date("w",strtotime($prvniDenVMesici));
		//	print $cisloPrvniDne;

		if ($cisloPrvniDne == 0) {
			$cisloPrvniDne = 7;
		}
		$denVTydnu = 0;
		$cisloTydne = 0;

		$rows = array();
		$row = createRowCalender();

		//print $days_in_month;
		//	print ($days_in_month + $cisloPrvniDne);
		for($i= 1; $i <= $days_in_month + $cisloPrvniDne; $i++)
		{

			$cisloDneVMesici = $i - $cisloPrvniDne;
			$cisloDneVMesici = ($cisloDneVMesici >0) ? $cisloDneVMesici : "";

			$pristupny = false;
			//	print strtotime($cisloDneVMesici . ".".$mesic. "." . $rok) . "(" . date("Ymd",strtotime($cisloDneVMesici . ".".$mesic. "." . $rok)) . ") >= " . (date("Ymd")) . "<br />";
			if ($cisloDneVMesici >0 && date("Ymd",strtotime($cisloDneVMesici . ".".$mesic. "." . $rok)) >= date("Ymd") ) {
				$pristupny = true;
			}

			if ($denVTydnu > 0) {
				$klicDne = $nazvyDnuTedny[($denVTydnu-1)];
				//	print $klicDne;
				if ($cisloDneVMesici > 0)
					$row->$klicDne = date("Y-m-d",strtotime($cisloDneVMesici . ".".$mesic. "." . $rok));
				else {
					// pro zobrazení předchozího měsíce
					$row->$klicDne = date("Y-m-d",strtotime(($pocetDnuPredchoziMesic+1-$cisloPrvniDne+$denVTydnu) . ".".$predchoziMesic. "." . $predchoziRok));
				}
				//print $row->$klicDne . "<br />";
				$row->$klicDne = createTdCalender($row->$klicDne);
			} else {
				//print $denVTydnu . "<br />";
			}

			//	print $denVTydnu . "<br />";
			if ($denVTydnu == 7) {
				//print $cisloTydne;
				$denVTydnu = 0;
				$cisloTydne++;
				$rows[$cisloTydne] = $row;
				$row = createRowCalender();
			}
			$denVTydnu++;
		}
		$denVTydnu--;
		// necelý týden
		if ($denVTydnu > 0) {
			$cisloTydne++;
			$zbyvaDnu = 7 - $denVTydnu;

			for ($i= 1; $i <= $zbyvaDnu; $i++)
			{
				$klicDne = $nazvyDnuTedny[($denVTydnu+$i-1)];

				//print $klicDne;
				$row->$klicDne = date("Y-m-d",strtotime(($i) . ".".$nasledujiciMesic. "." . $nasledujiciRok));
				$row->$klicDne = createTdCalender($row->$klicDne);
			}
			//print $nasledujiciMesic;
			//print_r($row);
			$rows[$cisloTydne] = $row;
		}

		//print_R($rows);
		return $rows;
	}
}