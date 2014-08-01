<?php
/*
 * Codengine
 * FilePath: app/start.php
*/

// Load app core files
$base = array(
	"Database/Database.base.php",
	"Security/Security.base.php",
	"View/View.base.php",
);

REQUIRE_ONCE 'config.php';

if($_CONFIG['upload']['enabled'] === true)
	array_push($base, "Upload/Upload.base.php");

if($_CONFIG['language']['enabled'] === true)
	array_push($base, "Language/Language.base.php");

if($_CONFIG['api'] == 'enabled')
	array_push($base, "API/API.base.php");

foreach ($base as $val)
{
	REQUIRE_ONCE 'base/'.$val;
}

if($_CONFIG['db']['enabled'] === true)
{
	$DB = new Database($_CONFIG['db']['hostname'], $_CONFIG['db']['username'], $_CONFIG['db']['password'], $_CONFIG['db']['dbname']);
	$Sec = new Security(array( "db" => $DB ));
}
else
	$Sec = new Security;
if($_CONFIG['upload']['enabled'] === true)
	$Upload = new Upload($_CONFIG);
if($_CONFIG['language']['enabled'] === true)
	$Language = new Language($_CONFIG);
if($_CONFIG['api'] == 'enabled')
	$API = new API;

$controllers = scandir('app/controllers');

REQUIRE_ONCE 'route.php';

?>