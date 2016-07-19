<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

class ImageController extends G_Controller_Action
{
	private $path_image = null;
	public function __construct()
	{
		$this->path_image = PATH_IMG;
		parent::__construct();
	}

	public function setPathImage($path)
	{
		$this->path_image = $path;
	}
	public function resize($fileName, $width = null, $height = null, $watermark = null,$lite = false)
	{
		if ($width == null) {
			$width = 63;
		}

		if ($height == null) {
			$height = 53;
		}
		/*
		   $fileTmpDest = PATH_IMG . $fileName;
		   require_once(PATH_ROOT.'core/library/Gambik/G_Image.php');
		   $thumbNail = new G_Image($fileTmpDest);


		   //$thumbNail->resize($width, $height, false, true);
		   $thumbNail->resize($width, $height);

		   $width = $thumbNail->getCurrentWidth();
		   $height = $thumbNail->getCurrentHeight();
		*/
		$url= URL_IMG . $fileName;
	//	$p = explode(".", $fileName);

		if ($lite)
		{
			//return URL_IMG . "output/" . $p[0] . '_' . $width . 'x' . $height . '.jpg';
		}
		$fullFileName = $fileName;
		$fileName = substr($fileName,0,-4);



		$imagePatch = PATH_IMG . "big/";

	//	print $imagePatch . substr($fileName,0,-4) . '.jpg';
		//if(!file_exists($imagePatch . $p[0] . '_' . $width . 'x' . $height . '.jpg')) //Pokud byl náhled v minulosti už vytvořen
		if(!file_exists($imagePatch . $fileName . '.jpg')) //Pokud byl náhled v minulosti už vytvořen

		{
		//	print "neexistuje!";

			//$file_id = md5($fileTmpDest + rand()*microtime());

			$fileTmpDest = PATH_IMG . $fullFileName;
			require_once(PATH_ROOT.'core/library/Gambik/G_Image.php');
			$thumbNail = new G_Image($fileTmpDest);


			//$thumbNail->resize($width, $height, false, true);


			$width_max = $thumbNail->getCurrentWidth();
			$height_max = $thumbNail->getCurrentHeight();

			if ($width > $width_max) {
				$width = $width_max;
			}

			if ($height > $height_max) {
				$height = $height_max;
			}
			$thumbNail->resize($width, $height);



			if ($watermark != null) {
				//	print "" . $watermark;
				$thumbNail->watermark($watermark);
			}
			//$thumbNail->rotateImage();

			$thumbNail->save($imagePatch . $fileName . '.jpg');

			/*
			   if ($watermark != null) {
			   $fileTmpDest = $imagePatch.$p[0].'_' . $width . 'x' . $height . '.jpg';

			   $thumbNail = new G_Image($fileTmpDest);


			   $thumbNail->resize($width, $height);

			   $thumbNail->watermark($watermark);

			   $thumbNail->save($imagePatch.$p[0].'_' . $width . 'x' . $height . 'xxx.jpg');
			   }
			*/

			//$thumbNail->resize(262);

			//$thumbNail->thumbnail($width, $height);
			//$thumbNail->save($imagePatch.$p[0].'_' . $width . 'x' . $height . '.jpg');
			$PreviewUrl = URL_IMG . "big/" .$fileName . '.jpg';
		} else {
			$PreviewUrl = URL_IMG . "big/" . $fileName . '.jpg';
		}

		return $PreviewUrl;
	}
	public function resizeOld($fileName, $width = null, $height = null, $watermark = null,$lite = false)
	{
		if ($width == null) {
			$width = 63;
		}

		if ($height == null) {
			$height = 53;
		}
		/*
		$fileTmpDest = PATH_IMG . $fileName;
		require_once(PATH_ROOT.'core/library/Gambik/G_Image.php');
		$thumbNail = new G_Image($fileTmpDest);


		//$thumbNail->resize($width, $height, false, true);
		$thumbNail->resize($width, $height);

		$width = $thumbNail->getCurrentWidth();
		$height = $thumbNail->getCurrentHeight();
*/
		$url= URL_IMG . $fileName;
		$p = explode(".", $fileName);

		if ($lite)
		{
			//return URL_IMG . "output/" . $p[0] . '_' . $width . 'x' . $height . '.jpg';
		}


		$imagePatch = PATH_IMG . "big/";
		//if(!file_exists($imagePatch . $p[0] . '_' . $width . 'x' . $height . '.jpg')) //Pokud byl náhled v minulosti už vytvořen
		if(!file_exists($imagePatch . $p[0] . '.jpg')) //Pokud byl náhled v minulosti už vytvořen

		{

			//$file_id = md5($fileTmpDest + rand()*microtime());

			$fileTmpDest = PATH_IMG . $fileName;
			require_once(PATH_ROOT.'core/library/Gambik/G_Image.php');
			$thumbNail = new G_Image($fileTmpDest);


			//$thumbNail->resize($width, $height, false, true);
			$thumbNail->resize($width, $height);

			$width = $thumbNail->getCurrentWidth();
			$height = $thumbNail->getCurrentHeight();

			if ($watermark != null) {
				$thumbNail->watermark($watermark);
			}
			//$thumbNail->rotateImage();

			$thumbNail->save($imagePatch . $p[0] . '.jpg');

			/*
			if ($watermark != null) {
				$fileTmpDest = $imagePatch.$p[0].'_' . $width . 'x' . $height . '.jpg';

				$thumbNail = new G_Image($fileTmpDest);


				$thumbNail->resize($width, $height);

				$thumbNail->watermark($watermark);

				$thumbNail->save($imagePatch.$p[0].'_' . $width . 'x' . $height . 'xxx.jpg');
			}
		*/

			//$thumbNail->resize(262);

			//$thumbNail->thumbnail($width, $height);
			//$thumbNail->save($imagePatch.$p[0].'_' . $width . 'x' . $height . '.jpg');
			$PreviewUrl = URL_IMG . "big/" .$p[0] . '.jpg';
		} else {
			$PreviewUrl = URL_IMG . "big/" . $p[0] . '.jpg';
		}

		return $PreviewUrl;
	}

	// provede přesný výřez
	public function getThumbOriznoutOriginal($fileName, $width = null, $height = null)
	{
		return $this->_get_thumb($fileName, $width, $height, null,false, true);
	}

	// provede přesný výřez
	public function getZmensitOriginal($fileName, $width = null, $height = null)
	{
		return $this->_get_thumb($fileName, $width, $height, null,false, false);
	}

	private function _get_thumb($fileName, $width = null, $height = null, $watermark = null,$lite = false, $crop = true)
	{
		if ($width == null) {
			$width = 63;
		}

		if ($height == null) {
			$height = 53;
		}




		$url= URL_IMG . $fileName;
		$p = explode(".", $fileName);

		$fullFileName = $fileName;
		$fileName = substr($fileName,0,-4);


		if ($lite)
		{
			return URL_IMG . "output/" . $fileName . '_' . $width . 'x' . $height . '.jpg';
		}

		$imagePatch = PATH_IMG . "output/";
		if(!file_exists($imagePatch . $fileName . '_' . $width . 'x' . $height . '.jpg')) //Pokud byl náhled v minulosti už vytvořen
		{

			//$file_id = md5($fileTmpDest + rand()*microtime());


			$fileTmpDest = $this->path_image . $fullFileName;
			require_once(PATH_ROOT.'core/library/Gambik/G_Image.php');
			$thumbNail = new G_Image($fileTmpDest);


			//	$width = $thumbNail->getCurrentWidth();
			//	$height = $thumbNail->getCurrentHeight();

			/*
			   if ($width > $width_max) {
			   $width = $width_max;
			   }

			   if ($height > $height_max) {
			   $height = $height_max;
			   }
			*/

			//	print $fileTmpDest;
			//	$thumbNail->resize($width, $height, false, true);
			//$crop = false;
		//	$thumbNail->cropFromCenter($width);

			$thumbNail->thumbnail($width, $height,$crop);

			//	$thumbNail->resizeToSquare($width, $height);



			$width = $thumbNail->getCurrentWidth();
			$height = $thumbNail->getCurrentHeight();

			if ($watermark != null) {
				$thumbNail->watermark($watermark);
			}

			//$thumbNail->rotateImage();

			$thumbNail->save($imagePatch. $fileName .'_' . $width . 'x' . $height . '.jpg');
			//$thumbNail->resize(262);

			//$thumbNail->thumbnail($width, $height);
			//$thumbNail->save($imagePatch.$p[0].'_' . $width . 'x' . $height . '.jpg');
			$PreviewUrl = URL_IMG . "output/" . $fileName .'_' . $width . 'x' . $height . '.jpg';
		} else {
			$PreviewUrl = URL_IMG . "output/" . $fileName . '_' . $width . 'x' . $height . '.jpg';
		}

		return $PreviewUrl;
	}

	public function get_thumb($fileName, $width = null, $height = null, $watermark = null,$lite = false, $crop = true)
	{
		if ($width == null) {
			$width = 63;
		}

		if ($height == null) {
			$height = 53;
		}




		$url= URL_IMG . $fileName;
		$p = explode(".", $fileName);

		if ($lite)
		{
			return URL_IMG . "output/" . $p[0] . '_' . $width . 'x' . $height . '.jpg';
		}

		$imagePatch = PATH_IMG . "output/";


		//$PreviewUrl = URL_IMG . "output/" . $p[0] . '_' . $width . 'x' . $height . '.jpg';
		//return $PreviewUrl;


//		$stopky = new GStopky();
	//	$stopky->start();

		$exituje = file_exists($imagePatch . $p[0] . '_' . $width . 'x' . $height . '.jpg');
	//	print $stopky->konec();
		if(!$exituje) //Pokud byl náhled v minulosti už vytvořen
		{

			//$file_id = md5($fileTmpDest + rand()*microtime());

			$fileTmpDest = $this->path_image . $fileName;

			require_once(PATH_ROOT.'core/library/Gambik/G_Image.php');
			$thumbNail = new G_Image($fileTmpDest);


		//	$width = $thumbNail->getCurrentWidth();
		//	$height = $thumbNail->getCurrentHeight();

			/*
			if ($width > $width_max) {
				$width = $width_max;
			}

			if ($height > $height_max) {
				$height = $height_max;
			}
			*/

		//	print $fileTmpDest;
		//	$thumbNail->resize($width, $height, false, true);
			//$crop = false;
			$thumbNail->thumbnail($width, $height,$crop);

		//	$thumbNail->resizeToSquare($width, $height);



			$width = $thumbNail->getCurrentWidth();
			$height = $thumbNail->getCurrentHeight();

			if ($watermark != null) {
				$thumbNail->watermark($watermark);
			}

			//$thumbNail->rotateImage();

			$thumbNail->save($imagePatch.$p[0].'_' . $width . 'x' . $height . '.jpg');
			//$thumbNail->resize(262);

			//$thumbNail->thumbnail($width, $height);
			//$thumbNail->save($imagePatch.$p[0].'_' . $width . 'x' . $height . '.jpg');
			$PreviewUrl = URL_IMG . "output/" .$p[0].'_' . $width . 'x' . $height . '.jpg';
		} else {
			$PreviewUrl = URL_IMG . "output/" . $p[0] . '_' . $width . 'x' . $height . '.jpg';
		}

		return $PreviewUrl;
	}

}