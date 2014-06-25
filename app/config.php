<?php
/*
 * Codengine
 * FilePath: app/config.php
*/

$_CONFIG = array(

	// First change the values below
	"url" => "localhost/codengine", # without http://, or final slash
	"route_controller_default" => "welcome", # without the prefix _controller
	"route_enhanced_mode" => true, # for a seo friendly url (like welcome/upload) instead of index.php?page=welcome&action=upload

	"db" => array(
		"enabled" => false,
		"hostname" => "localhost",
		"username" => "root",
		"password" => "",
		"dbname" => "test"
	),
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
	"api" => "enabled"
);

?>