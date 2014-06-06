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

	// FIXME: edit function almost done
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
}

?>