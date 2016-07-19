<?php

function vypocetCelkoveCenyRadkuDokladu($radek){

	$vyse_slevy = 0;
	if ($radek->sleva <> 0 && $radek->price <> 0) {
		if ($radek->typ_slevy == "%") {
			$vyse_slevy = $radek->price * $radek->sleva / 100;
			$znak_slevy = "%";
		} else {
			$vyse_slevy = $radek->price + $radek->sleva;
			$znak_slevy = "";
		}
	}

	return ($radek->price+$vyse_slevy) * $radek->qty;

}

function vypocetCelkoveCenyRadkuDokladuSDani($radek){

	$vyse_slevy = 0;
	if ($radek->sleva <> 0 && $radek->price_sdani <> 0) {
		if ($radek->typ_slevy == "%") {
			$vyse_slevy = $radek->price_sdani * $radek->sleva / 100;
			$znak_slevy = "%";
		} else {
			$vyse_slevy = $radek->price_sdani + $radek->sleva;
			$znak_slevy = "";
		}
	}

	return ($radek->price_sdani+$vyse_slevy) * $radek->qty;
}


?>