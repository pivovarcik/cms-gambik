<?php

class G_UploadUrl implements IUploadAdapter{

	public $extension_whitelist;
	public $filename;
	public $file_size;
	public $file_extension;
	public $from_url;
	private $save_path = PATH_IMG;
	public function setSavePath($path)
	{
		$this->save_path = $path;
	}

	public function copy($from, $to)
	{

		return file_put_contents($to, @file_get_contents($from));

	}

	public function move()
	{


		// Validate file extension
		$path_info = pathinfo($this->from_url);
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
		//	$this->HandleError("Nepovolený typ souboru!");
			return false;
		}


		$to = $this->save_path . $this->filename;
		if ($this->copy($this->from_url, $to)) {
			//$data =array();
			//$data["file"] = $upload_filename;

			$this->file_size = @filesize($to);
			$path_info = pathinfo($to);
			//$this->file_extension =  strtolower($path_info["extension"]);
		}



		return true;
	}

	public function __destruct() {
	}

}