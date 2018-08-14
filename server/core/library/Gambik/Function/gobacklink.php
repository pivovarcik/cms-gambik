<?php
/**
 * Funkce vrací odkaz na poslední navštívenou stránku.
 * @return string
 */
function GoBackLink()
{
	// je pole?
	if(isset($_SESSION['BACK_URL']) && is_array($_SESSION['BACK_URL']))
	{

		/*
		   echo "<pre>";
		   var_dump($_SESSION['BACK_URL']); // pomoc při testování - echuje obsah session
		   echo "</pre>";
		*/


		// spočítá počet prvků v poli a vrátí nám klíč předposledního pole.
		$last = count($_SESSION['BACK_URL']) - 2;

		// pokud takový klíč pole existuje, vypíše odkaz zpět
		if(array_key_exists($last, $_SESSION['BACK_URL']))
		{
			// Spočítáme, kolik je v posledním odkazu otazníků. Do odkazu potřebujeme dát informaci, že se jedná o krok zpět.
			$question_mark  = substr_count($_SESSION['BACK_URL'][$last],"?");
			if($question_mark  >= 1){
				$QueryString = "&GoBack";
			}else{
				$QueryString = "?GoBack";
			}

			// Vrátíme odkaz na stránku zpět.
			return '<a class="goback" href="'.$_SESSION["BACK_URL"][$last].$QueryString.'"><i class="fa fa-arrow-circle-o-left fw"></i>Zpět</a>';
		}
	}
	return false;
} // GoBackLink