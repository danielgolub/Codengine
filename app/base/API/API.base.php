<?php
/*
 * Codengine
 * FilePath: app/base/API/API.base.php
*/

class api
{
	public function transmit($arr)
	{
		if(is_array($arr)) {
			$url = $arr['url'];
			$data = $arr;
			unset($data['url']);
			if(array_key_exists("mode", $data)) {
				$mode = $arr['mode'];
				unset($data['mode']);
			}

			else
				$mode = 'get';

			switch ($mode) {
				case 'get':
					$content = file_get_contents($url);
					break;
				case 'post':
					if($data != 'none') {
						$options = array(
						    'http' => array(
						        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
						        'method'  => 'POST',
						        'content' => http_build_query($data),
						    ),
						);
						$context  = stream_context_create($options);
						$content = file_get_contents($url, false, $context);
					}
					else
						$content = 'data for a post request is missing';
					break;
			}

			return $content;
		}

		else
			return 'api transmit function requires an array';
	}
}