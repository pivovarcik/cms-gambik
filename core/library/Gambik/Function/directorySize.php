<?php

/**
 * Funkce vrací velikost adresáře
 * @return int;
 */

function directorySize($path)
{
	$totalsize = 0;
	$totalcount = 0;
	$dircount = 0;
	if ($handle = @opendir ($path))
	{
		while (false !== ($file = readdir($handle)))
		{
			$nextpath = $path . '/' . $file;
			if ($file != '.' && $file != '..' && !is_link ($nextpath))
			{
				if (is_dir ($nextpath))
				{
					$dircount++;
					$result = getDirectorySize($nextpath);
					$totalsize += $result['size'];
					$totalcount += $result['count'];
					$dircount += $result['dircount'];
				}
				elseif (is_file ($nextpath))
				{
					$totalsize += filesize ($nextpath);
					$totalcount++;
				}
			}
		}
	}
	@closedir ($handle);
	$total['size'] = $totalsize;
	$total['count'] = $totalcount;
	$total['dircount'] = $dircount;
	return $total;
}