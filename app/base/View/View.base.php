<?php
/*
 * Codengine
 * FilePath: app/base/View/View.base.class
*/

define("URL", $_CONFIG['url']);
define("ROUTE_ENHANCED_MODE", $_CONFIG['route_enhanced_mode']);

class View
{
	public static function forge($location, $data = NULL, $template = true)
	{
		$location = $location.'.php';
		if($data != NULL)
			extract($data);
		if($template === true)
			REQUIRE_ONCE 'app/views/header.php';
		REQUIRE_ONCE 'app/views/'.$location;
		if($template === true)
			REQUIRE_ONCE 'app/views/footer.php';
	}

	public static function error($str)
	{
		$msg = <<<html

<div class="alert alert-danger">
	<h4>An error occurred</h4>
	{$str}
</div>

html;
		return $msg;
	}

	public static function success($str)
	{
		$msg = <<<html

<div class="alert alert-success">
	<h4>Success!</h4>
	{$str}
</div>
<meta http-equiv="refresh" content="3;" />

html;
		return $msg;
	}

	public static function display_menu($mode = 'li')
	{
		$items_old = scandir("app/controllers");
		$items_old = array_slice($items_old, 2);
		$items = array();
		foreach ($items_old as $val)
		{
			$item = explode('.', $val);
			$item = $item[0];
			array_push($items, $item);
		}

		if($mode == 'li')
		{
			$content = '';
			foreach ($items as $val)
			{
				if(ROUTE_ENHANCED_MODE === true)
					$href = "http://".URL.'/'.$val;
				else
					$href = "index.php?page={$val}";
				$val_capital = ucfirst($val);
				$content .= <<<html
	<li><a href="{$href}">{$val_capital}</a></li>

html;
			}
			return $content;
		}

		else
			return $items;
	}
}

?>