<?php
/*
 * Codengine
 * FilePath: app/route.php
*/

$controller_default_name = 'controller_'.$_CONFIG['route_controller_default'];

$loaded = 0;

foreach ($controllers as $val)
{
	if($i != 0 && $i != 1 && $val != $controller_default_name.'.php')
	{
		$name = array();
		$name = explode(".", $val);
		$name_before = $name[0];
		$name = 'controller_'.$name[0];
		if($_CONFIG['route_enhanced_mode'] === true)
		{
			$request    = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			$request    = str_replace($_CONFIG['url'], "", $request);
			$params		= split("/", $request);
			// print_r($params);
			$safe_pages_old = scandir("app/controllers");
			$safe_pages_old = array_slice($safe_pages_old, 2);
			$safe_pages = array();
			foreach ($safe_pages_old as $value_pages)
			{
				$value_pages_new = explode('.', $value_pages);
				array_push($safe_pages, $value_pages_new[0]);
			}			if(in_array($params[1], $safe_pages) && $params[1] == $name_before)
			{
				REQUIRE_ONCE 'controllers/'.$val;
				if($_CONFIG['upload']['enable'] === true)
					${$name} = new $name(array( "Sec" => $Sec,"DB" => $DB,"params" => $params,"upload" => $Upload ));
				else
				{
					${$name} = new $name(array( "Sec" => $Sec,"DB" => $DB,"params" => $params ));
				}

				${$name}->action_index();
				$loaded++;
			}
		}

		else
		{
			if($_GET['page'] == $name_before)
			{
				$params_old = $_GET;
				$params = array();
				foreach ($params_old as $k => $v)
				{
					array_push($params, $v);
				}
				array_unshift($params, "");
				REQUIRE_ONCE 'controllers/'.$val;
				if($_CONFIG['upload']['enable'] === true)
					${$name} = new $name(array( "Sec" => $Sec,"DB" => $DB,"params" => $params,"upload" => $Upload ));
				else
				{
					${$name} = new $name(array( "Sec" => $Sec,"DB" => $DB,"params" => $params ));
				}

				${$name}->action_index();
				$loaded++;
			}
		}
	}
	$i++;
}

if($loaded == 0)
{
	REQUIRE_ONCE 'controllers/'.$_CONFIG['route_controller_default'].'.controller.php';
	${$controller_default_name} = new $controller_default_name(array( "Sec" => $Sec,"DB" => $DB ));
	${$controller_default_name}->action_index();
}

?>
