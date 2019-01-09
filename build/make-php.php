<?php

	ini_set('memory_limit', '128M');
	ini_set('max_execution_time', 300);

	include_once(__DIR__.'/../vendor/mvccore/packager/src/Packager/Php.php');


	// Remember: always follow instructions inside config file comments:


	// Pack PHP scripts, templates and all static files (CSS/JS/images/fonts):
	include_once(__DIR__.'/configs/php-with-composer-strict-package.php');


	// Pack PHP scripts and templates but without any static files:
	//include_once(__DIR__.'/configs/php-with-composer-preserve-package.php');


	// Pack PHP scripts and templates but without any static files:
	//include_once(__DIR__.'/configs/php-with-composer-preserve-hdd.php');


	// Pack only PHP scripts without any static files and any templates:
	//include_once(__DIR__.'/configs/php-with-composer-strict-hdd.php');
	


	Packager_Php::Create($config)
		->SetPhpFileSystemMode($phpFileSystemMode)
		->Run();
