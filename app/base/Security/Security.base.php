<?php
/*
 * Codengine
 * FilePath: app/base/Security/Security.base.class
*/

class Security
{
	public function _($str)
	{
		return strip_tags(htmlspecialchars(trim($_POST[$str])));
	}

	public function password($str)
	{
		$first = md5(substr($str, strlen($str)/3));
		$second = base64_encode(substr($str, strlen($str)/2));
		$final = 'DanielGolub_HASH_'.$first.$second.md5('dasn2455643NSDGJ3qSJ4123SJD314');
		$final = strip_tags(htmlspecialchars(trim($final)));
		return $final;
	}

	public function generate_session($arr)
	{
		if(is_array($arr))
		{
			foreach ($arr as $key => $val)
			{
				$_SESSION[$key] = $val;
			}

			echo <<<html
<meta http-equiv="refresh" content="0;" />
html;
		}

		else
			die("Function generate_session requires an array");
	}

	public function destroy_session($arr)
	{
		if(is_array($arr))
		{
			foreach ($arr as $key)
			{
				unset($_SESSION[$key]);
			}

			echo <<<html
<meta http-equiv="refresh" content="0;" />
html;
		}

		else
			die("Function destroy_session requires an array");
	}

	public function validate($str, $mode)
	{
		switch ($mode) {
			case 'email':
				if(filter_var($str, FILTER_VALIDATE_EMAIL))
					return true;
				else
					return false;
				break;

			case 'int':
				if(filter_var($str, FILTER_VALIDATE_INT))
					return true;
				else
					return false;
				break;

			case 'phone':
				if(preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $str))
					return true;
				else
					return false;
				break;

			case 'ip':
				if(filter_var($str, FILTER_VALIDATE_IP))
					return true;
				else
					return false;
				break;

			case 'url':
				if(filter_var($str, FILTER_VALIDATE_URL))
					return true;
				else
					return false;
				break;
		}
	}
}

?>