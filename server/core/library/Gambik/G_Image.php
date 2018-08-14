<?php

/**
 *
 *
 */

class G_Image {
	/**
	 * Error message to display, if any
	 *
	 * @var string
	 */
	private $errmsg;
	/**
	 * Whether or not there is an error
	 *
	 * @var boolean
	 */
	private $error;
	/**
	 * Format of the image file
	 *
	 * @var string
	 */
	private $format;
	/**
	 * File name and path of the image file
	 *
	 * @var string
	 */
	private $fileName;
	/**
	 * Image meta data if any is available (jpeg/tiff) via the exif library
	 *
	 * @var array
	 */
	public $imageMeta;
	/**
	 * Current dimensions of working image
	 *
	 * @var array
	 */
	private $currentDimensions;
	/**
	 * New dimensions of working image
	 *
	 * @var array
	 */
	private $newDimensions;
	/**
	 * Image resource for newly manipulated image
	 *
	 * @var resource
	 */
	private $newImage;
	/**
	 * Image resource for image before previous manipulation
	 *
	 * @var resource
	 */
	private $oldImage;
	/**
	 * Image resource for image being currently manipulated
	 *
	 * @var resource
	 */
	private $workingImage;
	/**
	 * Percentage to resize image by
	 *
	 * @var int
	 */
	private $percent;
	/**
	 * Maximum width of image during resize
	 *
	 * @var int
	 */
	private $maxWidth;
	/**
	 * Maximum height of image during resize
	 *
	 * @var int
	 */
	private $maxHeight;

	/**
	 * Class constructor
	 *
	 * @param string $fileName
	 * @return Thumbnail
	 */
	public function __construct($fileName) {
		//make sure the GD library is installed
		if(!function_exists("gd_info")) {
			echo 'You do not have the GD Library installed.  This class requires the GD library to function properly.' . "\n";
			echo 'visit http://us2.php.net/manual/en/ref.image.php for more information';
			exit;
		}
		//initialize variables
		$this->errmsg               = '';
		$this->error                = false;
		$this->currentDimensions    = array();
		$this->newDimensions        = array();
		$this->fileName             = $fileName;
		$this->imageMeta			= array();
		$this->percent              = 100;
		$this->maxWidth             = 0;
		$this->maxHeight            = 0;

		//check to see if file exists
		if(!file_exists($this->fileName)) {
			$this->errmsg = 'File not found';
			$this->error = true;
		}
		//check to see if file is readable
		elseif(!is_readable($this->fileName)) {
			$this->errmsg = 'File is not readable';
			$this->error = true;
		}




		if($this->error == false) {
			$FullSize = GetImageSize($this->fileName); //Zjištění původních rozměrů obrázku

			$imageType = $FullSize[2];
			switch ($imageType) {
				case 1: $FullPic = $this->format = 'GIF'; break;
				case 2: $FullPic = $this->format = 'JPG'; break; //Načtení původního obrázku ve formátu JPEG
				case 3: $FullPic = $this->format = 'PNG'; break;
				default: $this->errmsg = 'Unknown file format';$this->error = true;break;
			}
		}
		//if there are no errors, determine the file format
		/*
		   if($this->error == false) {
		   //check if gif
		   if(stristr(strtolower($this->fileName),'.gif')) $this->format = 'GIF';
		   //check if jpg
		   elseif(stristr(strtolower($this->fileName),'.jpg') || stristr(strtolower($this->fileName),'.jpeg')) $this->format = 'JPG';
		   //check if png
		   elseif(stristr(strtolower($this->fileName),'.png')) $this->format = 'PNG';
		   //unknown file format
		   else {
		   $this->errmsg = 'Unknown file format';
		   $this->error = true;
		   }
		   }
		*/
		//initialize resources if no errors
		if($this->error == false) {
			switch($this->format) {
				case 'GIF':
					$this->oldImage = ImageCreateFromGif($this->fileName);
					break;
				case 'JPG':
					$this->oldImage = ImageCreateFromJpeg($this->fileName);
					break;
				case 'PNG':
					$this->oldImage = ImageCreateFromPng($this->fileName);
					break;
			}

			$size = GetImageSize($this->fileName);
			$this->currentDimensions = array('width'=>$size[0],'height'=>$size[1]);
			$this->newImage = $this->oldImage;
			$this->gatherImageMeta();
		}

		if($this->error == true) {
		//	$this->showErrorImage();
			//break;
		}
	}

	/**
	 * Class destructor
	 *
	 */
	public function __destruct() {
		if(is_resource($this->newImage)) @ImageDestroy($this->newImage);
		if(is_resource($this->oldImage)) @ImageDestroy($this->oldImage);
		if(is_resource($this->workingImage)) @ImageDestroy($this->workingImage);
	}

	/**
	 * Returns the current width of the image
	 *
	 * @return int
	 */
	public function getCurrentWidth() {
		return $this->currentDimensions['width'];
	}

	/**
	 * Returns the current height of the image
	 *
	 * @return int
	 */
	public function getCurrentHeight() {
		return $this->currentDimensions['height'];
	}

	/**
	 * Calculates new image width
	 *
	 * @param int $width
	 * @param int $height
	 * @return array
	 */
	private function calcWidth($width,$height) {
		$newWp = (100 * $this->maxWidth) / $width;
		$newHeight = ($height * $newWp) / 100;
		return array('newWidth'=>intval($this->maxWidth),'newHeight'=>intval($newHeight));
	}

	/**
	 * Calculates new image height
	 *
	 * @param int $width
	 * @param int $height
	 * @return array
	 */
	private function calcHeight($width,$height) {
		$newHp = (100 * $this->maxHeight) / $height;
		$newWidth = ($width * $newHp) / 100;
		return array('newWidth'=>intval($newWidth),'newHeight'=>intval($this->maxHeight));
	}

	/**
	 * Calculates new image size based on percentage
	 *
	 * @param int $width
	 * @param int $height
	 * @return array
	 */
	private function calcPercent($width,$height) {
		$newWidth = ($width * $this->percent) / 100;
		$newHeight = ($height * $this->percent) / 100;
		return array('newWidth'=>intval($newWidth),'newHeight'=>intval($newHeight));
	}

	/**
	 * Calculates new image size based on width and height, while constraining to maxWidth and maxHeight
	 *
	 * @param int $width
	 * @param int $height
	 */
	private function calcImageSize($width,$height) {
		$newSize = array('newWidth'=>$width,'newHeight'=>$height);

		if($this->maxWidth > 0) {

			$newSize = $this->calcWidth($width,$height);

			if($this->maxHeight > 0 && $newSize['newHeight'] > $this->maxHeight) {
				$newSize = $this->calcHeight($newSize['newWidth'],$newSize['newHeight']);
			}

			//$this->newDimensions = $newSize;
		}

		if($this->maxHeight > 0) {
			$newSize = $this->calcHeight($width,$height);

			if($this->maxWidth > 0 && $newSize['newWidth'] > $this->maxWidth) {
				$newSize = $this->calcWidth($newSize['newWidth'],$newSize['newHeight']);
			}

			//$this->newDimensions = $newSize;
		}

		$this->newDimensions = $newSize;
	}

	/**
	 * Calculates new image size based percentage
	 *
	 * @param int $width
	 * @param int $height
	 */
	private function calcImageSizePercent($width,$height) {
		if($this->percent > 0) {
			$this->newDimensions = $this->calcPercent($width,$height);
		}
	}

	/**
	 * Displays error image
	 *
	 */
	private function showErrorImage() {
		//header('Content-type: image/png');
		print $this->errmsg;
		/*
		   $errImg = ImageCreate(220,25);
		   $bgColor = imagecolorallocate($errImg,0,0,0);
		   $fgColor1 = imagecolorallocate($errImg,255,255,255);
		   $fgColor2 = imagecolorallocate($errImg,255,0,0);
		   imagestring($errImg,3,6,6,'Error:',$fgColor2);
		   imagestring($errImg,3,55,6,$this->errmsg,$fgColor1);
		   imagepng($errImg);
		   imagedestroy($errImg);
		*/
	}

	/**
	 * Resizes image to maxWidth x maxHeight
	 *
	 * @param int $maxWidth
	 * @param int $maxHeight
	 */
	public function resize($maxWidth = 0, $maxHeight = 0) {
		$this->maxWidth = $maxWidth;
		$this->maxHeight = $maxHeight;

		$this->calcImageSize($this->currentDimensions['width'],$this->currentDimensions['height']);

		if(function_exists("ImageCreateTrueColor")) {
			$this->workingImage = ImageCreateTrueColor($this->newDimensions['newWidth'],$this->newDimensions['newHeight']);
		}
		else {
			$this->workingImage = ImageCreate($this->newDimensions['newWidth'],$this->newDimensions['newHeight']);
		}

		ImageCopyResampled(
			$this->workingImage,
			$this->oldImage,
			0,
			0,
			0,
			0,
			$this->newDimensions['newWidth'],
			$this->newDimensions['newHeight'],
			$this->currentDimensions['width'],
			$this->currentDimensions['height']
			);

		$this->oldImage = $this->workingImage;
		$this->newImage = $this->workingImage;
		$this->currentDimensions['width'] = $this->newDimensions['newWidth'];
		$this->currentDimensions['height'] = $this->newDimensions['newHeight'];
	}

	public function resizeToSquare ($target_width, $target_height) {

		$height = $this->getCurrentHeight();
		$width = $this->getCurrentWidth();
		$target_ratio = $target_width / $target_height;

		$img_ratio = $width / $height;

		if ($target_ratio > $img_ratio) {
			$new_height = $target_height;
			$new_width = $img_ratio * $target_height;
		} else {
			$new_height = $target_width / $img_ratio;
			$new_width = $target_width;
		}

		if ($new_height > $target_height) {
			$new_height = $target_height;
		}
		if ($new_width > $target_width) {
			$new_height = $target_width;
		}

		$new_img = ImageCreateTrueColor($target_width, $target_height);
		$color = imagecolorallocate($new_img, 255, 255, 255);
		if (!@imagefilledrectangle($new_img, 0, 0, $target_width-1, $target_height-1, $color)) {	// Fill the image black
			echo "ERROR:Could not fill new image";
			exit(0);
		}

		if (!@imagecopyresampled($new_img, $this->oldImage, ($target_width-$new_width)/2, ($target_height-$new_height)/2, 0, 0, $new_width, $new_height, $width, $height)) {
			return;
			echo "ERROR:Could not resize image";
			exit(0);
		}

		$this->workingImage = $new_img;
		$this->oldImage = $this->workingImage;
		$this->newImage = $this->workingImage;
		$this->currentDimensions['width'] = $target_width;
		$this->currentDimensions['height'] = $target_height;
	}

	public function thumbnail($target_width, $target_height, $crop = true) {

		$width = $this->getCurrentWidth();
		$height = $this->getCurrentHeight();

		if ($width <= $target_width
		&& $height <= $target_height) {


			$this->workingImage = $this->oldImage;
		} else {


			$dims = $this->_imageResizeDimensions($width, $height, $target_width, $target_height, $crop);
			if (!$dims)
				return $dims;
			list($dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h) = $dims;


			// vytvoří bílé plátno
			$this->workingImage = ImageCreateTrueColor($target_width, $target_height);
			$color = imagecolorallocate($this->workingImage, 255, 255, 255);
			if (!@imagefilledrectangle($this->workingImage, 0, 0, $target_width-1, $target_height-1, $color)) {	// Fill the image black
				echo "ERROR:Could not fill new image";
				exit(0);
			}


			//////

		//	$cropX = intval(($this->currentDimensions['width'] - $cropSize) / 2);
		//	print $dst_y;

			// centruj
			$dst_y = intval(($target_height - $dst_h) / 2);
			$dst_x = intval(($target_width - $dst_w) / 2);

			//////
			if (!@imagecopyresampled( $this->workingImage, $this->oldImage, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h)) {
				return;
				echo "ERROR:Could not resize image";
				exit(0);
			}
		}

		$this->oldImage = $this->workingImage;
		$this->newImage = $this->workingImage;
		$this->currentDimensions['width'] = $target_width;
		$this->currentDimensions['height'] = $target_height;
	}

	private function _imageResizeDimensions($orig_w, $orig_h, $dest_w, $dest_h, $crop) {


		if ($orig_w <= 0 || $orig_h <= 0)
			return false;
		// at least one of dest_w or dest_h must be specific
		if ($dest_w <= 0 && $dest_h <= 0)
			return false;

		if ( $crop ) {
			// crop the largest possible portion of the original image that we can size to $dest_w x $dest_h
			$aspect_ratio = $orig_w / $orig_h;
			$new_w = min($dest_w, $orig_w);
			$new_h = min($dest_h, $orig_h);
			if (!$new_w) {
				$new_w = intval($new_h * $aspect_ratio);
			}
			if (!$new_h) {
				$new_h = intval($new_w / $aspect_ratio);
			}

			$size_ratio = max($new_w / $orig_w, $new_h / $orig_h);

			$crop_w = ceil($new_w / $size_ratio);
			$crop_h = ceil($new_h / $size_ratio);

			$s_x = floor(($orig_w - $crop_w)/2);
			$s_y = floor(($orig_h - $crop_h)/2);

		}
		else {
			// don't crop, just resize using $dest_w x $dest_h as a maximum bounding box
			$crop_w = $orig_w;
			$crop_h = $orig_h;

			$s_x = 0;
			$s_y = 0;


			list( $new_w, $new_h ) = $this->_constrainDimensions( $orig_w, $orig_h, $dest_w, $dest_h );
		}

		// if the resulting image would be the same size or larger we don't want to resize it
		if ($new_w >= $orig_w && $new_h >= $orig_h)
			return false;

		// the return array matches the parameters to imagecopyresampled()
		// int dst_x, int dst_y, int src_x, int src_y, int dst_w, int dst_h, int src_w, int src_h
		return array(0, 0, $s_x, $s_y, $new_w, $new_h, $crop_w, $crop_h);
	}

	private function _constrainDimensions( $current_width, $current_height, $max_width=0, $max_height=0 ) {
		if ( !$max_width and !$max_height )
			return array( $current_width, $current_height );

		$width_ratio = $height_ratio = 1.0;

		if ( $max_width > 0 && $current_width > $max_width )
			$width_ratio = $max_width / $current_width;

		if ( $max_height > 0 && $current_height > $max_height )
			$height_ratio = $max_height / $current_height;

		// the smaller ratio is the one we need to fit it to the constraining box
		$ratio = min( $width_ratio, $height_ratio );

		return array( intval($current_width * $ratio), intval($current_height * $ratio) );
	}

	/**
	 * Resizes the image by $percent percent
	 *
	 * @param int $percent
	 */
	public function resizePercent($percent = 0) {
		$this->percent = $percent;

		$this->calcImageSizePercent($this->currentDimensions['width'],$this->currentDimensions['height']);

		if(function_exists("ImageCreateTrueColor")) {
			$this->workingImage = ImageCreateTrueColor($this->newDimensions['newWidth'],$this->newDimensions['newHeight']);
		}
		else {
			$this->workingImage = ImageCreate($this->newDimensions['newWidth'],$this->newDimensions['newHeight']);
		}

		ImageCopyResampled(
			$this->workingImage,
			$this->oldImage,
			0,
			0,
			0,
			0,
			$this->newDimensions['newWidth'],
			$this->newDimensions['newHeight'],
			$this->currentDimensions['width'],
			$this->currentDimensions['height']
			);

		$this->oldImage = $this->workingImage;
		$this->newImage = $this->workingImage;
		$this->currentDimensions['width'] = $this->newDimensions['newWidth'];
		$this->currentDimensions['height'] = $this->newDimensions['newHeight'];
	}

	/**
	 * Crops the image from calculated center in a square of $cropSize pixels
	 *
	 * @param int $cropSize
	 */
	public function cropFromCenter($cropSize) {
		if($cropSize > $this->currentDimensions['width']) $cropSize = $this->currentDimensions['width'];
		if($cropSize > $this->currentDimensions['height']) $cropSize = $this->currentDimensions['height'];

		$cropX = intval(($this->currentDimensions['width'] - $cropSize) / 2);
		$cropY = intval(($this->currentDimensions['height'] - $cropSize) / 2);

		if(function_exists("ImageCreateTrueColor")) {
			$this->workingImage = ImageCreateTrueColor($cropSize,$cropSize);
		}
		else {
			$this->workingImage = ImageCreate($cropSize,$cropSize);
		}

		imagecopyresampled(
			$this->workingImage,
			$this->oldImage,
			0,
			0,
			$cropX,
			$cropY,
			$cropSize,
			$cropSize,
			$cropSize,
			$cropSize
			);

		$this->oldImage = $this->workingImage;
		$this->newImage = $this->workingImage;
		$this->currentDimensions['width'] = $cropSize;
		$this->currentDimensions['height'] = $cropSize;
	}

	/**
	 * Advanced cropping function that crops an image using $startX and $startY as the upper-left hand corner.
	 *
	 * @param int $startX
	 * @param int $startY
	 * @param int $width
	 * @param int $height
	 */
	public function crop($startX,$startY,$width,$height) {
		//make sure the cropped area is not greater than the size of the image
		if($width > $this->currentDimensions['width']) $width = $this->currentDimensions['width'];
		if($height > $this->currentDimensions['height']) $height = $this->currentDimensions['height'];
		//make sure not starting outside the image
		if(($startX + $width) > $this->currentDimensions['width']) $startX = ($this->currentDimensions['width'] - $width);
		if(($startY + $height) > $this->currentDimensions['height']) $startY = ($this->currentDimensions['height'] - $height);
		if($startX < 0) $startX = 0;
		if($startY < 0) $startY = 0;

		if(function_exists("ImageCreateTrueColor")) {
			$this->workingImage = ImageCreateTrueColor($width,$height);
		}
		else {
			$this->workingImage = ImageCreate($width,$height);
		}

		imagecopyresampled(
			$this->workingImage,
			$this->oldImage,
			0,
			0,
			$startX,
			$startY,
			$width,
			$height,
			$width,
			$height
			);

		$this->oldImage = $this->workingImage;
		$this->newImage = $this->workingImage;
		$this->currentDimensions['width'] = $width;
		$this->currentDimensions['height'] = $height;
	}

	/**
	 * Outputs the image to the screen, or saves to $name if supplied.  Quality of JPEG images can be controlled with the $quality variable
	 *
	 * @param int $quality
	 * @param string $name
	 */
	public function show($quality=100,$name = '') {
		switch($this->format) {
			case 'GIF':
				if($name != '') {
					ImageGif($this->newImage,$name);
				}
				else {
					header('Content-type: image/gif');
					ImageGif($this->newImage);
				}
				break;
			case 'JPG':
				if($name != '') {
					ImageJpeg($this->newImage,$name,$quality);
				}
				else {
					header('Content-type: image/jpeg');
					ImageJpeg($this->newImage,'',$quality);
				}
				break;
			case 'PNG':
				if($name != '') {
					ImagePng($this->newImage,$name);
				}
				else {
					header('Content-type: image/png');
					ImagePng($this->newImage);
				}
				break;
		}
	}

	/**
	 * Saves image as $name (can include file path), with quality of # percent if file is a jpeg
	 *
	 * @param string $name
	 * @param int $quality
	 */
	public function save($name,$quality=100) {
		$this->show($quality,$name);
	}

	/**
	 * Creates Apple-style reflection under image, optionally adding a border to main image
	 *
	 * @param int $percent
	 * @param int $reflection
	 * @param int $white
	 * @param bool $border
	 * @param string $borderColor
	 */
	public function createReflection($percent,$reflection,$white,$border = true,$borderColor = '#a4a4a4') {
		$width = $this->currentDimensions['width'];
		$height = $this->currentDimensions['height'];

		$reflectionHeight = intval($height * ($reflection / 100));
		$newHeight = $height + $reflectionHeight;
		$reflectedPart = $height * ($percent / 100);

		$this->workingImage = ImageCreateTrueColor($width,$newHeight);

		ImageAlphaBlending($this->workingImage,true);

		$colorToPaint = ImageColorAllocateAlpha($this->workingImage,255,255,255,0);
		ImageFilledRectangle($this->workingImage,0,0,$width,$newHeight,$colorToPaint);

		imagecopyresampled(
		                    $this->workingImage,
		                    $this->newImage,
		                    0,
		                    0,
		                    0,
		                    $reflectedPart,
		                    $width,
		                    $reflectionHeight,
		                    $width,
		                    ($height - $reflectedPart));
		$this->imageFlipVertical();

		imagecopy($this->workingImage,$this->newImage,0,0,0,0,$width,$height);

		imagealphablending($this->workingImage,true);

		for($i=0;$i<$reflectionHeight;$i++) {
			$colorToPaint = imagecolorallocatealpha($this->workingImage,255,255,255,($i/$reflectionHeight*-1+1)*$white);
			imagefilledrectangle($this->workingImage,0,$height+$i,$width,$height+$i,$colorToPaint);
		}

		if($border == true) {
			$rgb = $this->hex2rgb($borderColor,false);
			$colorToPaint = imagecolorallocate($this->workingImage,$rgb[0],$rgb[1],$rgb[2]);
			imageline($this->workingImage,0,0,$width,0,$colorToPaint); //top line
			imageline($this->workingImage,0,$height,$width,$height,$colorToPaint); //bottom line
			imageline($this->workingImage,0,0,0,$height,$colorToPaint); //left line
			imageline($this->workingImage,$width-1,0,$width-1,$height,$colorToPaint); //right line
		}

		$this->oldImage = $this->workingImage;
		$this->newImage = $this->workingImage;
		$this->currentDimensions['width'] = $width;
		$this->currentDimensions['height'] = $newHeight;
	}

	/**
	 * Inverts working image, used by reflection function
	 *
	 */
	private function imageFlipVertical() {
		$x_i = imagesx($this->workingImage);
		$y_i = imagesy($this->workingImage);

		for($x = 0; $x < $x_i; $x++) {
			for($y = 0; $y < $y_i; $y++) {
				imagecopy($this->workingImage,$this->workingImage,$x,$y_i - $y - 1, $x, $y, 1, 1);
			}
		}
	}

	/**
	 * Converts hexidecimal color value to rgb values and returns as array/string
	 *
	 * @param string $hex
	 * @param bool $asString
	 * @return array|string
	 */
	private function hex2rgb($hex, $asString = false) {
		// strip off any leading #
		if (0 === strpos($hex, '#')) {
			$hex = substr($hex, 1);
		} else if (0 === strpos($hex, '&H')) {
			$hex = substr($hex, 2);
		}

		// break into hex 3-tuple
		$cutpoint = ceil(strlen($hex) / 2)-1;
		$rgb = explode(':', wordwrap($hex, $cutpoint, ':', $cutpoint), 3);

		// convert each tuple to decimal
		$rgb[0] = (isset($rgb[0]) ? hexdec($rgb[0]) : 0);
		$rgb[1] = (isset($rgb[1]) ? hexdec($rgb[1]) : 0);
		$rgb[2] = (isset($rgb[2]) ? hexdec($rgb[2]) : 0);

		return ($asString ? "{$rgb[0]} {$rgb[1]} {$rgb[2]}" : $rgb);
	}

	/**
	 * Reads selected exif meta data from jpg images and populates $this->imageMeta with appropriate values if found
	 *
	 */
	private function gatherImageMeta() {
		//only attempt to retrieve info if exif exists
		if(function_exists("exif_read_data") && $this->format == 'JPG') {
			$imageData = @exif_read_data($this->fileName);
			if(isset($imageData['Make']))
				$this->imageMeta['make'] = ucwords(strtolower($imageData['Make']));
			if(isset($imageData['Model']))
				$this->imageMeta['model'] = $imageData['Model'];
			if(isset($imageData['COMPUTED']['ApertureFNumber'])) {
				$this->imageMeta['aperture'] = $imageData['COMPUTED']['ApertureFNumber'];
				$this->imageMeta['aperture'] = str_replace('/','',$this->imageMeta['aperture']);
			}
			if(isset($imageData['ExposureTime'])) {
				$exposure = explode('/',$imageData['ExposureTime']);
				$exposure = round($exposure[1]/$exposure[0],-1);
				$this->imageMeta['exposure'] = '1/' . $exposure . ' second';
			}
			if(isset($imageData['Flash'])) {
				if($imageData['Flash'] > 0) {
					$this->imageMeta['flash'] = 'Yes';
				}
				else {
					$this->imageMeta['flash'] = 'No';
				}
			}
			if(isset($imageData['FocalLength'])) {
				$focus = explode('/',$imageData['FocalLength']);
				$this->imageMeta['focalLength'] = round($focus[0]/$focus[1],2) . ' mm';
			}
			if(isset($imageData['DateTime'])) {
				$date = $imageData['DateTime'];
				$date = explode(' ',$date);
				if (count($date) == 2) {
					$date = str_replace(':','-',$date[0]) . ' ' . $date[1];
					$this->imageMeta['dateTaken'] = date('m/d/Y g:i A',strtotime($date));
				}

			}
		}
	}

	/**
	 * Rotates image either 90 degrees clockwise or counter-clockwise
	 *
	 * @param string $direction
	 */
	public function rotateImage($direction = 'CW') {
		if($direction == 'CW') {
			$this->workingImage = imagerotate($this->workingImage,-90,0);
		}
		else {
			$this->workingImage = imagerotate($this->workingImage,90,0);
		}
		$newWidth = $this->currentDimensions['height'];
		$newHeight = $this->currentDimensions['width'];
		$this->oldImage = $this->workingImage;
		$this->newImage = $this->workingImage;
		$this->currentDimensions['width'] = $newWidth;
		$this->currentDimensions['height'] = $newHeight;
	}

	public function watermark($imagesource){
		$pathinfo = pathinfo($imagesource);
		//	print_r($pathinfo);
		$var1 = $pathinfo['extension'];
		$var2 = 'png';
		$var3 = 'jpeg';
		$var4 = 'jpg';
		$var5 = 'gif';

		if(strcasecmp($var1, $var2) == 0){
			$watermark = @imagecreatefrompng($imagesource);
			$black = ImageColorAllocate($watermark,   0,   0, 0);
			ImageColorTransparent($watermark, $black);
		}elseif((strcasecmp($var1, $var3) == 0) || (strcasecmp($var1, $var4) == 0)){
			$watermark = @imagecreatefromjpeg($imagesource);
		}elseif(strcasecmp($var1, $var5) == 0){
			$watermark = @imagecreatefromgif($imagesource);
		}

		$watermarkwidth = imagesx($watermark);
		$watermarkheight = imagesy($watermark);


		$startwidth = (($this->currentDimensions['width'] - $watermarkwidth)/2);
		//$startwidth = (20);
		$startheight = (($this->currentDimensions['height'] - $watermarkheight)/2);


		if (defined("WATERMARK_POS")) {

			switch(WATERMARK_POS)
			{
				case 1:
					//levá horní
					$startwidth = 10;
					//$startwidth = (20);
					$startheight = 10;
					break;
				case 2:
				//levá spodní
					$startwidth = 10;
					//$startwidth = (20);
					$startheight = ($this->currentDimensions['height'] - $watermarkheight)-10;
					break;
				case 3:
					//pravá horní
					$startwidth = ($this->currentDimensions['width'] - $watermarkwidth)-10;
					//$startwidth = (20);
					$startheight = 10;
					break;
				case 4:
					//pravá spodní
					$startwidth = ($this->currentDimensions['width'] - $watermarkwidth)-10;
					//$startwidth = (20);
					$startheight = ($this->currentDimensions['height'] - $watermarkheight)-10;
					break;
				default:
					//center
					$startwidth = (($this->currentDimensions['width'] - $watermarkwidth)/2);
					//$startwidth = (20);
					$startheight = (($this->currentDimensions['height'] - $watermarkheight)/2);
					break;
			}
		}

		//$startwidth = ($this->currentDimensions['width'] - $watermarkwidth);
		//$startheight = ($this->currentDimensions['height'] - $watermarkheight);
		//print $watermarkwidth;

		//$startheight = (($this->currentDimensions['height'] - $watermarkheight)-20);
		imagecopymerge($this->workingImage, $watermark, $startwidth, $startheight, 0, 0, $watermarkwidth, $watermarkheight, 60);
		//imagecopy($this->workingImage, $watermark, $startwidth, $startheight, 0, 0, $watermarkwidth, $watermarkheight, 30);
	}
}