<?php
/*
 * Codengine
 * FilePath: app/base/Language/Language.base.class
*/

class Language
{
	private $config;

	public function __construct($param)
	{
		$this->config = $param;
	}

	public function getString($str = 'all', $language = 'default')
	{
		if($language == 'default')
		{
			REQUIRE_ONCE "Stack/".$this->config['language']['default'].".stack.php";
			return ( ($str != 'all') ) ? ${"_strings_".$this->config['language']['default']}[$str] : ${"_strings_".$this->config['language']['default']};
		}

		else if($language != 'all' && $language != '*') {
			REQUIRE_ONCE 'app/base/Language/Stack/'.$language.".stack.php";
			return ( $str == 'all' || $str == '*' ) ? ${"_strings_".$language} : ${"_strings_".$language}[$str];
		}

		else
		{
			$languages = array_filter(scandir("app/base/Language/Stack"), function($item) {
				return !is_dir('app/base/Language/Stack/' . $item);
			});
			$arr = array();
			foreach ($languages as $val)
			{
				REQUIRE_ONCE "Stack/".$val;
				$name = reset(explode(".", $val));
				$arr[$name] = ( $str == 'all' || $str == '*' ) ? ${"_strings_".$name} : ${"_strings_".$name}[$str];
			}
			return $arr;
		}
	}
}

?>