<?php


class FolderIteratorLog
{
	/**
	 * Vrací název logovacího souboru
	 *
	 * @return String
	 */
	private static function __logfile()
	{
		return PATH_IMG.'folder.log';
	}




	/**
	 * Vymaže všechny zprávy z logu
	 *
	 */
	public static function getLastIndex()
	{
		//@file_put_contents(self::__logfile(), '');
		if (!file_exists(self::__logfile())) {
			FolderIteratorLog::clear();
		}
		$file = file_get_contents(self::__logfile(),FILE_USE_INCLUDE_PATH);

		return $file;

		//$file = readfile(self::__logfile());
		//return $file;

	}

	/**
	 * Vymaže všechny zprávy z logu
	 *
	 */
	public static function clear()
	{
		@file_put_contents(self::__logfile(), '');
	}

	/**
	 * Zapíše text do logu
	 *
	 * @param String $text Zapisovaný text
	 */
	public static function write($text)
	{
		FolderIteratorLog::clear();
		@file_put_contents(self::__logfile(), $text, FILE_APPEND);
	}
}
class DirOrganizator {


	private $abeceda = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z");


	public function __construct()
	{





		$abeceda = array();

		foreach ($this->abeceda as $key=>$abc) {

			for ($i=1;$i<10;$i++)
			{
				array_push($abeceda,$abc . $i);
			}

		}

		$this->abeceda = $abeceda;
		//	PRINT_R($abeceda);
		return $abeceda;
	}
	private $limitFirstLevel = 999;
	private $limitSecondLevel = 100;

	private $abc;

	public function setLogCurrentFolder()
	{

			FolderIteratorLog::write($this->abc);
	}
	public function getPath()
	{
		$maxFilesFolder = 100;
		$abc = $this->getCurrentFolderFirstLevel();
		$folderA = PATH_IMG . $abc;
		if (!file_exists($folderA)) {
			mkdir($folderA, 0777, true);
		//	print "adresář založen - " .$abc;
		}

		// 2. krok zjistim kolik je adresaru v druhe urovni
		$count = $this->getCountFolder($folderA);

		if ($count == 0) {
			$count = 1;
		}
		if ($count >= $this->limitFirstLevel) {
			// zaloz nove pismeno
			$abc = $this->getNextFolderFirstLevel($abc);

			$folderA = PATH_IMG . $abc;
			if (!file_exists($folderA)) {
				mkdir($folderA, 0777, true);
			//	print "adresář založen - " .$abc;
			}

			$count = 1;
		}

		$folderLevel2 = $folderA . "/" . ($count);
		if (!file_exists($folderLevel2)) {
			mkdir($folderLevel2, 0777, true);
		//	print "adresář založen";
		}



		// pocet souboru a adresari druhe urovni
		$count2 = $this->getCountFolder($folderLevel2);



		// nastavím se na poadove cislo
		if ($count2 >= $this->limitSecondLevel) {
			// zalozit nove pismeno !!!
			$folderLevel2 = $folderA . "/" . ($count+1);

			if (!file_exists($folderLevel2)) {
				mkdir($folderLevel2, 0777, true);
		//		print "adresář založen";
			}

		}

		$this->abc = $abc;
		return $folderLevel2 . "/";

	}

	public function upload($file){

		$maxFilesFolder = 100;
		$abc = $this->getCurrentFolderFirstLevel();
		$folderA = PATH_IMG . $abc;
		if (!file_exists($folderA)) {
			mkdir($folderA, 0777, true);
			print "adresář založen - " .$abc;
		}

		// 2. krok zjistim kolik je adresaru v druhe urovni
		$count = $this->getCountFolder($folderA);

		if ($count == 0) {
			$count = 1;
		}
		if ($count >= $this->limitFirstLevel) {
			// zaloz nove pismeno
			$abc = $this->getNextFolderFirstLevel($abc);

			$folderA = PATH_IMG . $abc;
			if (!file_exists($folderA)) {
				mkdir($folderA, 0777, true);
				print "adresář založen - " .$abc;
			}

			$count = 1;
		}

		$folderLevel2 = $folderA . "/" . ($count);
		if (!file_exists($folderLevel2)) {
			mkdir($folderLevel2, 0777, true);
			print "adresář založen";
		}



		// pocet souboru a adresari druhe urovni
		$count2 = $this->getCountFolder($folderLevel2);



		// nastavím se na poadove cislo
		if ($count2 >= $this->limitSecondLevel) {
			// zalozit nove pismeno !!!
			$folderLevel2 = $folderA . "/" . ($count+1);

			if (!file_exists($folderLevel2)) {
				mkdir($folderLevel2, 0777, true);
				print "adresář založen";
			}

		}

		print $folderLevel2 . "/" .  $file . "<br />";
		file_put_contents($folderLevel2 . "/" . $file, '');
		$this->setLogCurrentFolder();




	}

	private function getNextFolderFirstLevel($abc)
	{
		for ($i=0;$i<count($this->abeceda);$i++) {
			if ($this->abeceda[$i] == $abc) {
				$abc = $this->abeceda[($i+1)];
				break;
			}
		}


		return $abc;
	}



	private function getCurrentFolderFirstLevel()
	{
		$lastFolder = FolderIteratorLog::getLastIndex();
		if (empty($lastFolder)) {
			$lastFolder = $this->abeceda[0];
		}

		return $lastFolder;

	}

	private function getCountFolder($folder)
	{
		$count1 = 0;
		if ($handle = opendir ($folder))
		{

			while (false !== ($file = readdir($handle)))
			{
				if (!in_array($file, array('.', '..')))
				{
					$count1++;
				}
				//print $file . "<br />";

			}
			//	closedir($folder);
		}
		return $count1;
	}

	private function getLastIndex()
	{

	}
}