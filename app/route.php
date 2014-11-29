<?php
/*
 * Codengine
 * FilePath: app/route.php
*/

// determine the routing mode
// seo enhanced (/welcome)
if($_CONFIG['route_enhanced_mode'] === true)
{
	$request    = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$request    = strip_tags(addslashes(str_replace($_CONFIG['url'], "", $request)));
	$params		= explode("/", $request);
	foreach ($params as $param) {
		if(!empty($param) && !ctype_alnum(str_replace([ "_","-"," ","&","?","/","=" ], "", $param)))
			die("HTTP Request param is not valid");
	}
}

// normal (index.php?page=welcome)
else if(isset($_GET['page']) && in_array($_GET['page'].'.controller.php', $controllers))
{
	$params    = explode("/", strip_tags(addslashes(str_replace($_CONFIG['url'], "", $_GET['page']))));
	foreach ($params as $param) {
		if(!empty($param) && !ctype_alnum(str_replace([ "_","-"," ","&","?","/","=" ], "", $param)))
			die("HTTP Request param is not valid");
	}
	array_unshift($params, "");
}

// push url parameters to the registry file
$registry->set("params", $params);

// if you have a user system you rely on you can deny access to all/specific controllers here.

// // check if user has credentials
// if(isset($_SESSION['username']) && isset($_SESSION['password']))
// 		$DB->make('select', "Users"); // ... continue according to your database
// else
// 	$user = false;


// if($user !== true) { ......

// now we need to include the controller based on the url's first parameter (welcome)
if(is_array($controllers) && in_array($params[1].".controller.php", $controllers))
{
	require_once 'app/controllers/'.$params[1].".controller.php";
	$new = 'controller_'.$params[1];
	$registry->set($params[1], new $new);
	$registry->get($params[1])->action_index();
}

else // 404 - controller not found - redirect to home page
{
	require_once 'app/controllers/'.$_CONFIG['route_controller_default'].".controller.php";
	$new = 'controller_'.$_CONFIG['route_controller_default'];
	$registry->set($_CONFIG['route_controller_default'], new $new);
	$registry->get($_CONFIG['route_controller_default'])->action_index();
}

?>