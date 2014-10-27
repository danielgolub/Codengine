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

// if you have a user system you rely on you can deny access to all/specific controllers here.

// // check if user has credentials
// if(isset($_SESSION['username']) && isset($_SESSION['password']))
// 		$DB->make('select', "Users"); // ... continue according to your database
// else
// 	$user = false;


// if($user !== true) { ......

// now we need to include the controller based on the url's first parameter (welcome)
if(in_array($params[1].".controller.php", $controllers))
{
	REQUIRE_ONCE 'controllers/'.$params[1].".controller.php";

	// default classes to pass to the controller
	$load = array(
		"sec" => $Sec, // security
		"db" => $DB, // database
		"params" => $params, // url parameters
	);

	// additional classes to pass to the controller only if they are enabled in /app/config.php
	if($_CONFIG['language']['enabled'] == true)
		$load['language'] = $Language;
	if($_CONFIG['upload']['enabled'] === true)
		$load['upload'] = $Upload;
	if($_CONFIG['api'] == 'enabled')
		$load['api'] = $API;

	// then run the controller and initiate action_index
	$name = "controller_".$params[1];
	$$name = new $name($load);
	$$name->action_index();
}

else // 404 - controller not found - redirect to home page
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

	$default = 'controller_'.$_CONFIG['route_controller_default'];
	$$default = new $default($load);
	$$default->action_index();
}

?>