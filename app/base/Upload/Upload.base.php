<?php
/*
 * Codengine
 * FilePath: app/base/Upload/Upload.base.class
*/

class Upload
{
	public function __construct($config)
	{
		$this->config = $config;
	}

	public function generate($file, $path, $rename = false)
	{
		$ext = explode(".", $file['name']);
		$ext = end($ext);
		$ext = strtolower($ext);
		if(in_array($ext, $this->config['upload']['limits']['types']))
		{
			$size = $file['size'];
			if($size <= $this->config['upload']['limits']['size'] * 1024)
			{
				if($rename === true)
					$newname = 'Codengine_'.md5(time()).base64_encode(substr(basename($file['name']), 0, 5)).'.'.$ext;
				else
					$newname = basename($file['name']);
				$newname = $path.$newname;
				# Upload process
				if(move_uploaded_file($file['tmp_name'], $newname))
				{
					return 'success';
				}

				else
				{
					return 'error';
				}
			}

			else
				return 'size limit exceeded';
		}

		else
			return 'file type is not acceptable';
	}

	public function delete($file)
	{
		if(file_exists($file))
		{
			unlink($file);
			return 'success';
		}
		
		else
			return 'error';
	}

	// FIXME: edit function, some tuning still needed.
	/*public function edit($file, $mode, $volume = 100)
	{
		$gd_ext = extension_loaded('gd');
		$gd_func = function_exists('gd_info');
		if($gd_ext == 1 && $gd_func == 1)
		{
			if(file_exists($file))
			{
				// var_dump(function_exists('imagecreatefrompng'));
				$info = gd_info();
				$ext = explode('.', $file);
				$ext = end($ext);
				if($ext == 'jpg')
					$ext = 'jpeg';
				if(function_exists("imagecreatefrom".$ext))
				{
					$name = "imagecreatefrom".$ext;
					$im = $name($file);
					switch ($mode) {
						case 'grayscale':
							if($im && imagefilter($im, IMG_FILTER_GRAYSCALE))
							{
								return 'ok';
								$image_func = "image".$ext;
								$image_func($im, $file);
							}

							else
								return 'error';
							break;
						case 'brightness':
							if($im && imagefilter($im, IMG_FILTER_BRIGHTNESS, $volume))
							{
								return 'ok';
								$image_func = "image".$ext;
								$image_func($im, $file);
							}

							else
								return 'error';
							break;
					}
					imagedestroy($im);
				}

				else
					return 'gd function imagecreatefrom*ext* not supported';
			}

			else
				return 'file not exists';
		}

		else
			return 'gd not installed';
	}*/

	public function remote_transfer($details) {
		if(is_array($details)) {
			$file = $details['file'];
			$server = $details['ftp_server'];
			$username = $details['ftp_username'];
			$password = $details['ftp_password'];
			$destination = $details['ftp_destination'];

			// set up basic connection
			$conn_id = ftp_connect($server);
			ftp_pasv($conn_id, true);

			// login with username and password
			$login_result = ftp_login($conn_id, $username, $password);

			// check connection
			if((!$conn_id) || (!$login_result)) {
				return 'connection failed';
			}

			else
			{
				// upload the file
				$upload = ftp_put($conn_id, $destination, $file, FTP_BINARY);

				// check upload status
				if(!$upload)
					return 'upload failed';
				else
					return 'success';
			}

			// close the FTP stream
			ftp_close($conn_id);
		}

		else
			return 'details is not an array';
	}
}

?>