<?php

	ini_set('memory_limit', '128M');
	ini_set('max_execution_time', 300);

	include_once(__DIR__.'/../vendor/autoload.php');

	include_once(__DIR__.'/configs/phar-with-composer.php');

	Packager_Phar::Create($config)->Run();
