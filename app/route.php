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
			$request    = strip_tags(addslashes(str_replace($_CONFIG['url'], "", $request)));
			$params		= explode("/", $request);
			foreach ($params as $param) {
				if(!empty($param) && !ctype_alnum(str_replace([ "_","-"," " ], "", $param)))
					die("HTTP Request param is not valid");
			}
			// print_r($params);
			$safe_pages_old = scandir("app/controllers");
			$safe_pages_old = array_slice($safe_pages_old, 2);
			$safe_pages = array();
			foreach ($safe_pages_old as $value_pages)
			{
				$value_pages_new = explode('.', $value_pages);
				array_push($safe_pages, $value_pages_new[0]);
			}
			if(in_array($params[1], $safe_pages) && $params[1] == $name_before)
			{
				REQUIRE_ONCE 'controllers/'.$val;

				$load = array(
					"sec" => $Sec,
					"db" => $DB,
					"params" => $params,
				);

				if($_CONFIG['language']['enabled'] == true)
					$load['language'] = $Language;
				if($_CONFIG['upload']['enabled'] === true)
					$load['upload'] = $Upload;
				if($_CONFIG['api'] == 'enabled')
					$load['api'] = $API;

				${$name} = new $name($load);
				${$name}->action_index();
				$loaded++;
			}
		}

		else
		{
			if($_GET['page'] == $name_before)
			{
				$params_old    = strip_tags(addslashes(str_replace($_CONFIG['url'], "", $_GET)));
				$params_old	   = explode("/", $params_old);
				foreach ($params_old as $param) {
					if(!empty($param) && !ctype_alnum(str_replace([ "_","-"," " ], "", $param)))
						die("HTTP Request param is not valid");
				}
				// $params_old = $_GET;
				$params = array();
				foreach ($params_old as $k => $v)
				{
					array_push($params, $v);
				}
				array_unshift($params, "");
				REQUIRE_ONCE 'controllers/'.$val;
				
				$load = array(
					"sec" => $Sec,
					"db" => $DB,
					"params" => $params,
				);

				if($_CONFIG['language']['enabled'] == true)
					$load['language'] = $Language;
				if($_CONFIG['upload']['enabled'] === true)
					$load['upload'] = $Upload;
				if($_CONFIG['api'] == 'enabled')
					$load['api'] = $API;

				${$name} = new $name($load);
				// if($_CONFIG['upload']['enabled'] === true && $_CONFIG['language']['enabled'] === true)
				// 	${$name} = new $name(array( "Sec" => $Sec,"DB" => $DB,"params" => $params,"upload" => $Upload,"language" => $Language ));
				// else if($_CONFIG['upload']['enabled'] === true)
				// 	${$name} = new $name(array( "Sec" => $Sec,"DB" => $DB,"params" => $params,"upload" => $Upload ));
				// else
				// 	${$name} = new $name(array( "Sec" => $Sec,"DB" => $DB,"params" => $params ));

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
	
	$load = array(
		"sec" => $Sec,
		"db" => $DB,
		"params" => $params,
	);

	if($_CONFIG['language']['enabled'] == true)
		$load['language'] = $Language;
	if($_CONFIG['upload']['enabled'] === true)
		$load['upload'] = $Upload;
	if($_CONFIG['api'] == 'enabled')
		$load['api'] = $API;

	${$controller_default_name} = new $controller_default_name($load);
	// if($_CONFIG['upload']['enabled'] === true && $_CONFIG['language']['enabled'] === true)
	// 	${$controller_default_name} = new $controller_default_name(array( "Sec" => $Sec,"DB" => $DB,"params" => $params,"upload" => $Upload,"language" => $Language, "date" => date('d/m/Y G:i'), "ip" => $_SERVER['REMOTE_ADDR'] ));
	// else if($_CONFIG['upload']['enabled'] === true)
	// 	${$controller_default_name} = new $controller_default_name(array( "Sec" => $Sec,"DB" => $DB,"params" => $params,"upload" => $Upload, "date" => date('d/m/Y G:i'), "ip" => $_SERVER['REMOTE_ADDR'] ));
	// else
	// 	${$controller_default_name} = new $controller_default_name(array( "Sec" => $Sec,"DB" => $DB,"params" => $params, "date" => date('d/m/Y G:i'), "ip" => $_SERVER['REMOTE_ADDR'] ));
	${$controller_default_name}->action_index();
}

?>