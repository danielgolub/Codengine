<?php
/*
 * Codengine
 * FilePath: app/route.php
*/

$controller_default_name = 'controller_'.$_CONFIG['route_controller_default'];

foreach ($controllers as $val)
{
	if($i != 0 && $i != 1 && $val != $controller_default_name.'.php')
	{
		$name = array();
		$name = explode(".", $val);
		$name_before = $name[0];
		$name = 'controller_'.$name[0];
		if($_GET['page'] == $name_before)
		{
			REQUIRE_ONCE 'controllers/'.$val;
			${$name} = new $name(array( "Sec" => $Sec,"DB" => $DB ));
			${$name}->action_index();
		}

		else if(!$_GET)
		{
			REQUIRE_ONCE 'controllers/'.$_CONFIG['route_controller_default'].'.controller.php';
			${$controller_default_name} = new $controller_default_name(array( "Sec" => $Sec,"DB" => $DB ));
			${$controller_default_name}->action_index();
		}
	}
	$i++;
}

?>