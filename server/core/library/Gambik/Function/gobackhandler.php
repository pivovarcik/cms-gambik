<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2012
 */
/**
 * Správa session, zaznamenávání historie navštívených stránek.
 */
function GoBackHandler()
{

	if(isset($_SESSION['BACK_URL']) && is_array($_SESSION['BACK_URL']))
	{
		// spočítáme počet klíčů v poli
		$pocet = count($_SESSION['BACK_URL']);

		// pokud není poslední položka stejná jako aktuální stránka budeme pokračovat
		if($_SESSION['BACK_URL'][$pocet - 1] != $_SERVER['REQUEST_URI'])
		{
			// pokud se nejedná o krok zpět, přidáme aktuální stránku do session
			if(!isset($_GET['GoBack']))
			{
				if (!isset($_GET['do'])) {
				//	$_SESSION['BACK_URL'][] = $_SERVER['REQUEST_URI'];
				}

			}
			else
			{
				// jedná se o krok zpět, poslední položku v poli tedy chceme smazat.
				if(is_array($_SESSION['BACK_URL']))
				{
					// smažeme poslední položku v poli.
					array_pop($_SESSION['BACK_URL']);
				}
			}
		}
	}

}// GoBackHandler