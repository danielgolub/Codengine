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
			$request    = $_SERVER['REQUEST_URI'];
			$params		= split("/", $request);
			$safe_pages = array("example", "welcome");
			if(in_array(end($params), $safe_pages) && end($params) == $name_before)
			{
				REQUIRE_ONCE 'controllers/'.$val;
				${$name} = new $name(array( "Sec" => $Sec,"DB" => $DB ));
				${$name}->action_index();
				$loaded++;
			}
		}

		else
		{
			if($_GET['page'] == $name_before)
			{
				REQUIRE_ONCE 'controllers/'.$val;
				${$name} = new $name(array( "Sec" => $Sec,"DB" => $DB ));
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