<?php
/*
 * Codengine
 * FilePath: app/controllers/welcome.controller.php
*/

class controller_example
{
	public function action_index()
	{
		$data = array();
		$data['title'] = 'Codengine &raquo; Example';
		View::forge("example/index", $data, false);
	}
}

?>