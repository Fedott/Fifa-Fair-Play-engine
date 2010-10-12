<?php defined('SYSPATH') or die('No direct script access.');

//-- Environment setup --------------------------------------------------------

/**
 * Set the default time zone.
 *
 * @see  http://kohanaframework.org/guide/using.configuration
 * @see  http://php.net/timezones
 */
date_default_timezone_set('Europe/Moscow');

/**
 * Set the default locale.
 *
 * @see  http://kohanaframework.org/guide/using.configuration
 * @see  http://php.net/setlocale
 */
setlocale(LC_ALL, 'ru_RU.utf-8');

/**
 * Enable the Kohana auto-loader.
 *
 * @see  http://kohanaframework.org/guide/using.autoloading
 * @see  http://php.net/spl_autoload_register
 */
spl_autoload_register(array('Kohana', 'auto_load'));

/**
 * Enable the Kohana auto-loader for unserialization.
 *
 * @see  http://php.net/spl_autoload_call
 * @see  http://php.net/manual/var.configuration.php#unserialize-callback-func
 */
ini_set('unserialize_callback_func', 'spl_autoload_call');

//-- Configuration and initialization -----------------------------------------

/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url    path, and optionally domain, of your application   NULL
 * - string   index_file  name of your index file, usually "index.php"       index.php
 * - string   charset     internal character set used for input and output   utf-8
 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
 * - boolean  errors      enable or disable error handling                   TRUE
 * - boolean  profile     enable or disable internal profiling               TRUE
 * - boolean  caching     enable or disable internal caching                 FALSE
 */
Kohana::init(array(
	'base_url'   => '/',
	'index_file' => FALSE,
));

/**
 * Attach the file write to logging. Multiple writers are supported.
 */
Kohana::$log->attach(new Kohana_Log_File(APPPATH.'logs'));

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Kohana_Config_File);

/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */
Kohana::modules(array(
	'database'   => MODPATH.'database',   // Database access
	'pagination' => MODPATH.'pagination', // Paging of results
	'jelly'      => MODPATH.'jelly',      // Улучшеный ОРМ
	'jelly-auth' => MODPATH.'jelly-auth', // Драйвер Jelly для Auth
	'auth'       => MODPATH.'auth',       // Basic authentication
	'userguide'  => MODPATH.'userguide',  // Модуль свтроенной доки
	'image'      => MODPATH.'image',      // Модуль работы с изображениями
	'purifier'   => MODPATH.'purifier',   // Модуль HTML Purifier
//	'forum'      => MODPATH.'forum',      // Модуль Форума от Федота
	'kohana-curl'=> MODPATH.'kohana-curl',// Модуль Curl
	'pages'      => MODPATH.'pages',      // Модуль страниц от Федота
));

/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */
Route::set('login', 'login')
		->defaults(array(
			'controller' => 'main',
			'action' => 'login',
		));
Route::set('logout', 'logout')
		->defaults(array(
			'controller' => 'main',
			'action' => 'logout',
		));
Route::set('register', 'register')
		->defaults(array(
			'controller' => 'main',
			'action' => 'register',
		));
Route::set('reg', 'reg')
		->defaults(array(
			'controller' => 'main',
			'action' => 'register',
		));
Route::set('profile', 'profile(/<id>)')
		->defaults(array(
			'controller' => 'main',
			'action'     => 'profile',
		));
Route::set('widget', 'widget/<action>(/<param1>(/<param2>(/<param3>)))')
		->defaults(array(
			'controller' => 'widget',
		));
Route::set('admin', 'admin(/<controller>(/<action>(/<id>)))')
	->defaults(array(
		'directory'  => 'admin',
		'controller' => 'main',
		'action'     => 'index',
	));
Route::set('default', '(<controller>(/<action>(/<id>)))')
	->defaults(array(
		'controller' => 'main',
		'action'     => 'index',
	));

/**
 * Execute the main request. A source of the URI can be passed, eg: $_SERVER['PATH_INFO'].
 * If no source is specified, the URI will be automatically detected.
 */
echo Request::instance()
	->execute()
	->send_headers()
	->response;
