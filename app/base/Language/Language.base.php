<?php
/*
 * Codengine
 * FilePath: app/base/Language/Language.base.class
*/

class Language
{
	public function __construct($_CONFIG)
	{
		$this->config = $_CONFIG;
	}

	public function getString($str = 'all', $language = 'default')
	{
		if($language == 'default')
		{
			REQUIRE_ONCE 'Stack/'.$this->config['language']['default'].'.stack.php';
			$default_lang = "_strings_".$this->config['language']['default'];
			if($str != 'all')
				return ${$default_lang}[$str];
			else
				return ${$default_lang};
		}

		else
		{
			$languages = scandir("app/base/Language/Stack");
			$languages = array_slice($languages, 2);
			$arr = array();
			foreach ($languages as $val)
			{
				$value = explode('.', $val);
				$value = $value[0];
				if($value == $language) {
					REQUIRE_ONCE 'Stack/'.$value.'.stack.php';
					$newstrval = "_strings_".$value;
					if($str == 'all')
						$arr = $$newstrval;
					else
						array_push($arr, ${$newstrval}[$str]);
				}
			}
			return $arr;
		}
	}

	public function setString()
	{

	}
}

?>