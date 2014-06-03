<?php
/*
 * Codengine
 * FilePath: app/config.php
*/

$_CONFIG = array(
	"db" => array(
		"enabled" => true,
		"hostname" => "localhost",
		"username" => "root",
		"password" => "",
		"dbname" => "test"
	),
	"url" => "localhost/codengine",
	"route_controller_default" => "welcome",
	"route_enhanced_mode" => true,
	"upload" => array(
		"enabled" => true,
		"limits" => array(
			"size"  => 2048, // [MB]
			"types" => array(
				"png",
				"gif",
				"jpg",
				"jpeg",
			)
		),
	),
	"language" => array(
		"enabled" => true,
		"default" => "en"
	),
);

?>