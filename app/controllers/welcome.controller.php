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
		if($this->params[2] == 'upload')
		{
			if(isset($_POST['submit']))
			{
				// to securely get post value, use:
				// $this->Sec->_("name");

				// Make sure img/test has 777 permission (chmod)
				$newimg = $this->upload->generate($_FILES['img'], 'assets/img/test/', true);
				if($newimg == 'file type is not acceptable')
					$data['error'] = View::error(ucfirst($newimg));
				else if($newimg == 'size limit exceeded')
					$data['error'] = View::error(ucfirst($newimg));
				else if($newimg == 'error')
					$data['error'] = View::error('Unknown error occured');
				else
					$data['error'] = View::success("File successfully uploaded!");
			}
			$data['title'] = 'Codengine &raquo; Upload file';
			View::forge('welcome/upload', $data);
		}

		else
		{
			$data['title'] = 'Codengine &raquo; Welcome :)';
			$data['strings'] = $this->language->getString('hi', 'default');
			View::forge('welcome/index', $data);
		}
	}
}

?>