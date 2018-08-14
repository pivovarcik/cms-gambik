<?php

/**
 * Funkce vrací počet dnů v měsíci
 * @return int
 */
function pocetDnuVMesici ($mesic, $rok)
{
	return cal_days_in_month(CAL_GREGORIAN, $mesic, $rok);
}
