Codengine
================
MVC framework for creating easy, fast and efficient web apps.

## Introduction
Please first edit your config (app/config.php). Give chmod 777 permission to 'assets/img/test'.
____________
All your app's controllers are located in 'app/controllers/'. Your controller name has to match the filename. For example, [welcome.controller.php] will include a class named controller_welcome.Every controller will be loaded once user asks the page for index.php?page=[controllername].
____________
To load a view, please use: 'View::forge("welcome/index", $data);', while $data is an array which will contain anything you want to pass to the view.
____________
Database usage documentation is located in: http://db.danielgolub.com