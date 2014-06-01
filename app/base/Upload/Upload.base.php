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
}

?>