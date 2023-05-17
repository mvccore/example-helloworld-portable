<?php

/**
 * Instructions before application packing:
 * - Remove all CSS and JS assets in `/Var/Tmp` directory.
 * - Generate CSS and JS assets into `/Var/Tmp` directory before packing process
 *   with uncommented line 22 in `/App/Bootstrap.php`.
 */

$phpFileSystemMode = Packager_Php::FS_MODE_STRICT_HDD;

$config = [
	'sourcesDir'				=> __DIR__ . '/../../development',
	'releaseDir'				=> __DIR__ . '/../../release',
	// define statically copied files and folders (exclude patterns doesn't exclude anything from static copies):
	'staticCopies'				=> [
		'/.htaccess',			'/web.config',
		'/static/fonts',		'/static/img',	'/Var/Tmp',
		'/App/Views/Layouts',	'/App/Views/Scripts'
	],
	// do not include script or file, where it's relative path from sourceDir match any of these rules:
	'excludePatterns'			=> [

		// Common excludes for every \MvcCore app using composer:
		"#/\.#",										// Everything started with '.' (.git, .htaccess ...)
		"#^/web\.config#",								// Microsoft IIS .rewrite rules
		"#^/Var/Logs/.*#",								// App development logs
		"#(composer|installed)\.((dev\.)?)(json|lock)#",// composer.json, installed.json, composer.lock, ...
		"#LICEN(C|S)E(\.(txt|md))?#i",					// libraries licence files
		"#\.(bak|bat|cmd|sh|md|phpt|neon|dummy|phpproj|phpproj\.user)$#i",

		// Exclude specific PHP libraries
		"#^/vendor/composer/.*#",						// composer itself
		"#^/vendor/autoload\.php$#",					// composer autoload file
		"#^/vendor/mvccore/mvccore/src/startup\.php$#",	// mvccore autoload file
		"#^/vendor/tracy/.*#",							// tracy library (https://tracy.nette.org/)
		"#^/vendor/mvccore/ext-debug-tracy.*#",			// mvccore tracy adapter and all tracy panel extensions
		"#^/vendor/bin/.*#",							// CLI tools
		"#^/vendor/tedivm/.*#",							// JS minify library
		"#^/vendor/tubalmartin/.*#",					// CSS minify library

		// Exclude everything from '/static/...' and '/Var/Tmp' directory:
		// If you want to use this config, you need to copy manualy everything 'from' => 'to':
		// - '/development/static/fonts'	=> '/release/static/fonts'
		// - '/development/static/img'		=> '/release/static/img'
		// - '/development/Var/Tmp'			=> '/release/Var/Tmp'
		"#^/static/.*#",
		"#^/Var/Tmp/.*#",
		"#^/App/Views/Layouts/.*#",
		"#^/App/Views/Scripts/.*#",
	],
	// include all scripts or files, where it's relative path from sourceDir match any of these rules:
	// (include patterns always overrides exclude patterns)
	'includePatterns'		=> [],
	// process simple strings replacements on all read PHP scripts before saving into result package:
	// (replacements are executed before configured minification in RAM, they don't affect anything on hard drive)
	'stringReplacements'	=> [
		// Switch \MvcCore application back from SFU mode to automatic compile mode detection
		'->SetCompiled(\MvcCore\Application::COMPILED_SFU)'	=> '',
		// Remove tracy debug library:
		"class_exists('\MvcCore\Ext\Debugs\Tracy')"			=> 'FALSE',
	],
	'minifyTemplates'		=> 1,// Remove non-conditional comments and white spaces
	'minifyPhp'				=> 1,// Remove comments and white spaces
];
