<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $title; ?></title>
		<meta name="author" content="Daniel Golub - www.DanielGolub.com" />
		<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
		<link rel="stylesheet" type="text/css" href="http://<?php echo URL; ?>/assets/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="http://<?php echo URL; ?>/assets/css/base.css" />
	</head>
	<body>
		<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#">Codengine</a>
				</div>
				<div class="navbar-collapse collapse">
					<ul class="nav navbar-nav navbar-left">
						<?php echo View::display_menu(); ?>
					</ul>
				</div>
			</div>
		</div>

		<div class="container theme-showcase" role="main">
