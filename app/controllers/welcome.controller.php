<?php
/*
 * Codengine
 * FilePath: app/controllers/welcome.controller.php
*/

class controller_welcome
{
	public function __construct($params)
	{
		// Setup what we need for this controller
		// $Sec = new Security;
		foreach ($params as $key => $val)
		{
			$this->{$key} = $val;
		}
	}

	public function action_index()
	{
		$data = array();
		$data['title'] = 'Codengine &raquo; Welcome :)';
		View::forge('welcome/index', $data);
	}
}

?>