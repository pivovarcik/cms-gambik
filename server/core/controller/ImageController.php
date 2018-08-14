<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */

class ImageController extends G_Controller_Action
{
	private $disabled = false;
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

	public function printImg($imgresize)
	{
  $params = explode("/",$imgresize);
  
 //print_r($params);
  if (count($params) >= 3)
  {
    if (count($params) == 3)
    {
      $dir = "";
      $width = $params[0];
      $height = $params[1];
      $file = $params[2];
    }  
    if (count($params) == 5)
    {
    //  $type = $params[0];
      $dir = $params[0] . "/" . $params[1] . "/";
      $width = $params[2];
      $height = $params[3];
      $file = $params[4];
     } 
    //  $imageController = new ImageController();
        $p = explode(".", $file);
      
      $dest = $this->getPathImage() . "output/" .  $dir . $p[0] . "_" . $width . "x" . $height . ".jpg" ;   
     

      if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && 
          strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) >= filemtime($dest))
      {
          header('HTTP/1.0 304 Not Modified');
          exit;
      }
       $settings = G_Setting::instance();
       if ("1" == $settings->get("THUMB_CROP"))
        {
            $dest = $this->getThumbOriznoutOriginal($dir . $file,$width,$height);
        } else {
           $dest = $this->getZmensitOriginal($dir . $file,$width,$height);
        }
        if (empty($dest))
        {
               header("HTTP/1.0 404 Not Found");
               print "404 Not Found";
               //require_once PATH_PRG . '404.php';
          exit;
        
        }
       // print $dest;
        //exit;
      //$dest = $this->getZmensitOriginal($dir . $file,$width,$height);
      
      $dest = $this->getPathImage() . "output/" .  $dir . $p[0] . "_" . $width . "x" . $height . ".jpg" ;  
      $sec = 86400 * 360;
      header('Cache-Control: cache');
      header('Cache-Control: max-age='.$sec);
      
    
      header('Pragma: cache');
      header('Last-Modified: '.gmdate('D, d M Y H:i:s', filemtime($dest)).' GMT');
      header('Content-Length: '. filesize($dest));
      
      header('Expires: '. gmdate('D, d M Y H:i:s \G\M\T', time() + $sec));   
      header('Content-Type: image/jpg');
      
      readfile($dest);
      exit;
	}
  }  
  public function getPathImage()
	{
		return $this->path_image;
	}
	public function resize($fileName, $width = null, $height = null, $watermark = null,$lite = false)
	{

		if ($this->disabled) {
			return;
		}

		if ($width == null) {
			$width = 63;
		}

		if ($height == null) {
			$height = 53;
		}


	//	$url= URL_IMG . $fileName;
	//	$p = explode(".", $fileName);

		if ($lite)
		{
			//return URL_IMG . "output/" . $p[0] . '_' . $width . 'x' . $height . '.jpg';
		}
		//$fullFileName = $fileName;
	//	$fileName = substr($fileName,0,-4);


		$dir = $this->getDir($fileName);
		$fileName = $this->getFile($fileName);
		$p = explode(".", $fileName);


		$folder = PATH_IMG . "big/" . $dir;
		if(!is_dir($folder . "/") && !file_exists($folder)) {
			mkdir($folder, 0777, true);
		}

		$dir .="/";

	//	$imagePatch = PATH_IMG . "big/";

		$imagePatch = $folder . "/";

	//	print $imagePatch . substr($fileName,0,-4) . '.jpg';
		//if(!file_exists($imagePatch . $p[0] . '_' . $width . 'x' . $height . '.jpg')) //Pokud byl náhled v minulosti už vytvořen
		if(!file_exists($imagePatch . $p[0] . '.jpg')) //Pokud byl náhled v minulosti už vytvořen

		{
		//	print "neexistuje!";

			//$file_id = md5($fileTmpDest + rand()*microtime());

		//	$fileTmpDest = PATH_IMG . $fullFileName;

			$fileTmpDest = $this->path_image . $dir . $fileName;

			require_once(PATH_CORE.'library/Gambik/G_Image.php');
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
		//	$PreviewUrl = URL_IMG . "big/" .$fileName . '.jpg';

			$PreviewUrl = URL_IMG . "big" .  $dir . "" .$p[0].'.jpg';
		} else {
		//	$PreviewUrl = URL_IMG . "big/" . $fileName . '.jpg';
			$PreviewUrl = URL_IMG . "big" .  $dir . "" .$p[0].'.jpg';
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
			require_once(PATH_CORE.'library/Gambik/G_Image.php');
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
		if ($this->disabled) {
			return;
		}
		if ($width == null) {
			$width = 63;
		}

		if ($height == null) {
			$height = 53;
		}


		$dir = $this->getDir($fileName);
		$fileName = $this->getFile($fileName);

		$folder = PATH_IMG . "output/" . $dir;
	/*	if(!is_dir($folder . "/") && !file_exists($folder)) {
			mkdir($folder, 0777, true);
		}  */

		$dir .="/";

		$url= URL_IMG . $dir . $fileName;
		$p = explode(".", $fileName);



    if(!file_exists(PATH_IMG . "" . $dir . $fileName)) //Pokud byl náhled v minulosti už vytvořen
		{
       return "";
		}
    

		if ($lite)
		{
			return $folder . $p[0] . '_' . $width . 'x' . $height . '.jpg';
		}

		//	$imagePatch = PATH_IMG . "output/";
		$imagePatch = $folder . "/";

    //   print $imagePatch . $p[0] . '_' . $width . 'x' . $height . '.jpg';
   //exit;
		if(!file_exists($imagePatch . $p[0] . '_' . $width . 'x' . $height . '.jpg')) //Pokud byl náhled v minulosti už vytvořen
		{
       if(!is_dir($folder . "/") && !file_exists($folder)) {
			mkdir($folder, 0777, true);
		} 
			//$file_id = md5($fileTmpDest + rand()*microtime());


			//$fileTmpDest = $this->path_image . $fullFileName;
			$fileTmpDest = $this->path_image . $dir . $fileName;

			require_once(PATH_CORE.'library/Gambik/G_Image.php');
			$thumbNail = new G_Image($fileTmpDest);




			$thumbNail->thumbnail($width, $height,$crop);

			//	$thumbNail->resizeToSquare($width, $height);



			$width = $thumbNail->getCurrentWidth();
			$height = $thumbNail->getCurrentHeight();

			if ($watermark != null) {
				$thumbNail->watermark($watermark);
			}

			//$thumbNail->rotateImage();

		//	$thumbNail->save($imagePatch. $fileName .'_' . $width . 'x' . $height . '.jpg');
			$thumbNail->save($imagePatch.$p[0].'_' . $width . 'x' . $height . '.jpg');
			//$thumbNail->resize(262);

			//$thumbNail->thumbnail($width, $height);
			//$thumbNail->save($imagePatch.$p[0].'_' . $width . 'x' . $height . '.jpg');
			$PreviewUrl = URL_IMG . "output" .  $dir . "" .$p[0].'_' . $width . 'x' . $height . '.jpg';
		} else {
			$PreviewUrl = URL_IMG  . "output" .  $dir .  "" . $p[0] . '_' . $width . 'x' . $height . '.jpg';
      
      $this->img_src = $imagePatch . $fileName . '_' . $width . 'x' . $height . '.jpg';
      
      
		}

		return $PreviewUrl;
	}

	private function getDir($fileName)
	{
		$dir = "";
		if (strpos($fileName, "/") !== false) {
			$fileName2 = $fileName;

			$fileName = StrRChr($fileName, "/");
			$fileName = substr($fileName,1,strlen($fileName));


			$dir = "/" . substr($fileName2,0,strLen($fileName2)-strLen(StrRChr($fileName2, "/")));
		}

		return $dir;
	}

	private function getFile($fileName)
	{
		if (strpos($fileName, "/") !== false) {
			$fileName2 = $fileName;

			$fileName = StrRChr($fileName, "/");
			$fileName = substr($fileName,1,strlen($fileName));
		}

		return $fileName;
	}
  
  public function getFileUrl($file,$thumb_width,$thumb_height)
  {
      		$dir = $this->getDir($file);
		$fileName = $this->getFile($file);

		$folder = URL_IMG . "thumb" . $dir . "/" . $thumb_width . "/" . $thumb_height . "/" . $fileName;
    
      return $folder;
      //http://www.raptorfishing.cz/public/foto/output/a1/26/190/200/4KPcbHrP2rt952c.jpg
  }
	public function get_thumb($fileName, $width = null, $height = null, $watermark = null,$lite = false, $crop = true)
	{
		if ($this->disabled) {
			return;
		}
		if ($width == null) {
			$width = 63;
		}

		if ($height == null) {
			$height = 53;
		}

		$dir = $this->getDir($fileName);
		$fileName = $this->getFile($fileName);

		$folder = PATH_IMG . "output/" . $dir;
		if(!is_dir($folder . "/") && !file_exists($folder)) {
			mkdir($folder, 0777, true);
		}

		$dir .="/";

		$url= URL_IMG . $dir . $fileName;
		$p = explode(".", $fileName);

		if ($lite)
		{
			return $folder . $p[0] . '_' . $width . 'x' . $height . '.jpg';
		}

	//	$imagePatch = PATH_IMG . "output/";
		$imagePatch = $folder . "/";


		//$PreviewUrl = URL_IMG . "output/" . $p[0] . '_' . $width . 'x' . $height . '.jpg';
		//return $PreviewUrl;


//		$stopky = new GStopky();
	//	$stopky->start();

		$exituje = file_exists($imagePatch . $p[0] . '_' . $width . 'x' . $height . '.jpg');
	//	print $stopky->konec();


		if(!$exituje) //Pokud byl náhled v minulosti už vytvořen
		{

			//$file_id = md5($fileTmpDest + rand()*microtime());

			$fileTmpDest = $this->path_image . $dir . $fileName;

			require_once(PATH_CORE.'library/Gambik/G_Image.php');
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
			$PreviewUrl = URL_IMG . "output" .  $dir . "" .$p[0].'_' . $width . 'x' . $height . '.jpg';
		} else {
			$PreviewUrl = URL_IMG  . "output" .  $dir .  "" . $p[0] . '_' . $width . 'x' . $height . '.jpg';
		//	$PreviewUrl = $imagePatch . $p[0] . '_' . $width . 'x' . $height . '.jpg';
		}

		return $PreviewUrl;
	}

	public function getWidthHeight($fileName)
	{

		require_once(PATH_CORE.'library/Gambik/G_Image.php');

		$fileTmpDest = $this->path_image . $fileName;

		$thumbNail = new G_Image($fileTmpDest);

		$obj = new stdClass();
		$obj->width = $thumbNail->getCurrentWidth();
		$obj->height = $thumbNail->getCurrentHeight();

		return $obj;

	}
}