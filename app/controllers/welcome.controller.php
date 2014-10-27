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
		// $sec = new Security;
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
			// transfer file to remote address (ftp)
			// $this->upload->remote_transfer(array(
			// 	"file" => "assets/img/test/index.html",
			// 	"ftp_server" => "remotehost.com",
			// 	"ftp_username" => "daniel",
			// 	"ftp_password" => "123123",
			// 	"ftp_destination" => "/public_html/index.html"
			// ));

			if(isset($_POST['submit']))
			{
				// to securely get post value, use:
				// $this->sec->_("name");
				// $check = $this->sec->check(array(
				// 	$name => "text",
				// 	$something => "email",
				// ));

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
			// Remove below
			// $data['error'] = $this->upload->edit("assets/img/test/Codengine_3878ae98a6b55412eebb87d783dcc99aMDJJbmQ=.jpg", "grayscale");
			View::forge('welcome/upload', $data);
		}

		else
		{
			$data['title'] = 'Codengine &raquo; Welcome :)';
			$data['strings'] = $this->language->getString('hi', 'en');
			View::forge('welcome/index', $data);
		}
	}
}

?>