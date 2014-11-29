<?php
/*
 * Codengine
 * FilePath: index.php
*/

session_start();

require_once 'app/registry.php';

try {
	// get the instance of the registry
	$registry = Registry::getInstance();

	// ... load the Codengine configuration and extensions
	require_once 'app/config.php';
	$registry->set("config", $_CONFIG);
	require_once 'app/base/View/View.base.php';
	$registry->set("view", $_CONFIG);

	// than execute all other Codengine extenstions
	$_CONFIG = $registry->get("config");
	$_CONFIG = $registry->get("view");

	// basic classes
	require_once 'app/base/Security/Security.base.php';
	$registry->set("sec", new Security()); // security

	if($_CONFIG['db']['enabled'] === true) { // load db if enabled
		require_once 'app/base/Database/Database.base.php';
		$registry->set("db", new Database($_CONFIG['db']['hostname'], $_CONFIG['db']['username'], $_CONFIG['db']['password'], $_CONFIG['db']['dbname']));
        $DB = $registry->get("db");
	}

	if($_CONFIG['upload']['enabled'] === true) { // load file uploading if enabled
		require_once 'app/base/Upload/Upload.base.php';
		$registry->set("upload", new Upload());
	}

	if($_CONFIG['language']['enabled'] === true) { // load language stacks if enabled
		require_once 'app/base/Language/Language.base.php';
		$registry->set("language", new Language($_CONFIG));
	}

	if($_CONFIG['api'] === true || $_CONFIG['api'] == 'enabled') { // load api communication if enabled. 'enabled' for backward compatibility.
		require_once 'app/base/API/API.base.php';
		$registry->set("api", new API());
	}

	$controllers = array_filter(scandir('app/controllers'), function($item) {
		return !is_dir('app/controllers/' . $item);
	});

	// now load the routing system
	require_once 'app/route.php';
} catch(Exception $e) {
	echo $e->getMessage();
}

?>