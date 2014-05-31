<?php
/*
 * Codengine
 * FilePath: app/start.php
*/

// Load app core files
$base = array(
	"Database/Database.base.php",
	"Security/Security.base.php",
	"View/View.base.php"
);

REQUIRE_ONCE 'config.php';

foreach ($base as $val)
{
	REQUIRE_ONCE 'base/'.$val;
}

$Sec = new Security;
$DB = new Database($_CONFIG['db']['host'], $_CONFIG['db']['username'], $_CONFIG['db']['password'], $_CONFIG['db']['dbname']);

$controllers = scandir('app/controllers');

REQUIRE_ONCE 'route.php';

?>