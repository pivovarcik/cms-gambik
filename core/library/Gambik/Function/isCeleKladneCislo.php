<?php


function isCeleKladneCislo($val)
{
	//print $val * 1;
	if (is_numeric($val) && $val * 1 == $val) {

		if (($val * 1) > 0) {
			return true;
		}

	}
	return false;
}