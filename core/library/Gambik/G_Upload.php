<?php

/**
 *
 *
 */

interface IUploadAdapter
{
	public function move();
}
class G_Upload implements IUploadAdapter {

	public $filename;
	public $message;
	private $prefix = '';
	private $save_path = PATH_IMG;
	public $file_extension = '';
	public $file_size = 0;
	public $upload_name = "Filedata";
	public $extension_whitelist = array("jpg", "jpeg", "gif", "png");	// Allowed file extensions
	public function __construct() {

	}

	public function setPrefixFilename($prefix)
	{
		$this->prefix = $prefix;
	}
	public function setSavePath($path)
	{
		$this->save_path = $path;
	}

	public function rename($puvodni_nazev, $novy_nazev)
	{
		 return rename($puvodni_nazev, $novy_nazev);
	}
	public function move()
	{


		$POST_MAX_SIZE = ini_get('post_max_size');
		$unit = strtoupper(substr($POST_MAX_SIZE, -1));
		$multiplier = ($unit == 'M' ? 1048576 : ($unit == 'K' ? 1024 : ($unit == 'G' ? 1073741824 : 1)));

		if ((int)$_SERVER['CONTENT_LENGTH'] > $multiplier*(int)$POST_MAX_SIZE && $POST_MAX_SIZE) {
			header("HTTP/1.1 500 Internal Server Error"); // This will trigger an uploadError event in SWFUpload
			echo "POST exceeded maximum allowed size.";
			exit(0);
		}

		// Settings
		//$save_path = getcwd() . "/uploads/";				// The path were we will save the file (getcwd() may not be reliable and should be tested in your environment)
		//$save_path = PATH_IMG;				// The path were we will save the file (getcwd() may not be reliable and should be tested in your environment)




		$max_file_size_in_bytes = 2147483647;				// 2GB in bytes

		$valid_chars_regex = '.A-Z0-9_ !@#$%^&()+={}\[\]\',~`-';				// Characters allowed in the file name (in a Regular Expression format)

		// Other variables
		$MAX_FILENAME_LENGTH = 260;
		$file_name = "";
		$this->file_extension = "";
		$uploadErrors = array(
	        0=>"There is no error, the file uploaded with success",
	        1=>"The uploaded file exceeds the upload_max_filesize directive in php.ini",
	        2=>"The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form",
	        3=>"The uploaded file was only partially uploaded",
	        4=>"No file was uploaded",
	        6=>"Missing a temporary folder"
		);


		// Validate the upload
		if (!isset($_FILES[$this->upload_name])) {
			$this->HandleError("No upload found in \$_FILES for " . $this->upload_name);
			return false;
		} else if (isset($_FILES[$this->upload_name]["error"]) && $_FILES[$this->upload_name]["error"] != 0) {
			$this->HandleError($uploadErrors[$_FILES[$this->upload_name]["error"]]);
			return false;
		} else if (!isset($_FILES[$this->upload_name]["tmp_name"]) || !@is_uploaded_file($_FILES[$this->upload_name]["tmp_name"])) {
			$this->HandleError("Upload failed is_uploaded_file test.");
			return false;
		} else if (!isset($_FILES[$this->upload_name]['name'])) {
			$this->HandleError("File has no name.");
			return false;
		}

		// Validate the file size (Warning: the largest files supported by this code is 2GB)
		$this->file_size = @filesize($_FILES[$this->upload_name]["tmp_name"]);
		if (!$this->file_size || $this->file_size > $max_file_size_in_bytes) {
			$this->HandleError("File exceeds the maximum allowed size");
			return false;
		}

		if ($this->file_size <= 0) {
			$this->HandleError("File size outside allowed lower bound");
			return false;
		}


		// Validate file name (for our purposes we'll just remove invalid characters)
		$file_name = preg_replace('/[^'.$valid_chars_regex.']|\.+$/i', "", basename($_FILES[$this->upload_name]['name']));
		if (strlen($file_name) == 0 || strlen($this->prefix . $file_name) > $MAX_FILENAME_LENGTH) {
			$this->HandleError("Invalid file name");
			return false;
		}

		// Validate file extension
		$path_info = pathinfo($_FILES[$this->upload_name]['name']);
		$this->file_extension = strtolower($path_info["extension"]);

		if (empty($this->filename)) {
			$this->filename = strtolower($this->prefix . $file_name);
		} else {
			$this->filename = $this->filename . ".". $this->file_extension;
		}

		$this->filename = autoFileName($this->filename, $this->file_extension, $this->save_path);

		// Validate that we won't over-write an existing file
		if (file_exists($this->save_path . $this->filename)) {
			$this->HandleError("Soubor s tímto názvem již existuje");
			return false;
		}


		$is_valid_extension = false;
		foreach ($this->extension_whitelist as $extension) {
			if (strcasecmp($this->file_extension, $extension) == 0) {
				$is_valid_extension = true;
				break;
			}
		}
		if (!$is_valid_extension) {
			$this->HandleError("Nepovolený typ souboru!");
			return false;
		}

		// Validate file contents (extension and mime-type can't be trusted)
		/*
		   Validating the file contents is OS and web server configuration dependant.  Also, it may not be reliable.
		   See the comments on this page: http://us2.php.net/fileinfo

		   Also see http://72.14.253.104/search?q=cache:3YGZfcnKDrYJ:www.scanit.be/uploads/php-file-upload.pdf+php+file+command&hl=en&ct=clnk&cd=8&gl=us&client=firefox-a
		   which describes how a PHP script can be embedded within a GIF image file.

		   Therefore, no sample code will be provided here.  Research the issue, decide how much security is
		   needed, and implement a solution that meets the needs.
		*/


		// Process the file
		/*
		   At this point we are ready to process the valid file. This sample code shows how to save the file. Other tasks
		   could be done such as creating an entry in a database or generating a thumbnail.

		   Depending on your server OS and needs you may need to set the Security Permissions on the file after it has
		   been saved.
		*/
		if (!@move_uploaded_file($_FILES[$this->upload_name]["tmp_name"], $this->save_path.$this->filename)) {
			$this->HandleError("File could not be saved.");
			return false;
		}

		return true;
	}
	/* Handles the error output. This error message will be sent to the uploadSuccess event handler.  The event handler
	   will have to check for any error messages and react as needed. */
	public function HandleError($message) {
		$this->message = $message;
		//echo $message;
	}
	/**
	 * Class destructor
	 *
	 */
	public function __destruct() {
	}

}