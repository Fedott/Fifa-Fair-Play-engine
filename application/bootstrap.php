<?php defined('SYSPATH') OR die('No direct script access.');

// -- Environment setup --------------------------------------------------------

// Load the core Kohana class
require SYSPATH.'classes/kohana/core'.EXT;

if (is_file(APPPATH.'classes/kohana'.EXT))
{
	// Application extends the core
	require APPPATH.'classes/kohana'.EXT;
}
else
{
	// Load empty core extension
	require SYSPATH.'classes/kohana'.EXT;
}

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

// -- Configuration and initialization -----------------------------------------

/**
 * Set the default language
 */
I18n::lang('ru-ru');

/**
 * Set Kohana::$environment if a 'KOHANA_ENV' environment variable has been supplied.
 *
 * Note: If you supply an invalid environment name, a PHP warning will be thrown
 * saying "Couldn't find constant Kohana::<INVALID_ENV_NAME>"
 */
if (isset($_SERVER['KOHANA_ENV']))
{
	Kohana::$environment = constant('Kohana::'.strtoupper($_SERVER['KOHANA_ENV']));
}

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
 * Cookie salt set
 */
Cookie::$salt = 'sfdhsd@FE2fhfsdf$%#52fd';

/**
 * Attach the file write to logging. Multiple writers are supported.
 */
Kohana::$log->attach(new Log_File(APPPATH.'logs'));

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Config_File);

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
	'captcha'    => MODPATH.'captcha',    // Капча для коханы
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
Route::set('ajax', 'ajax(/<controller>(/<action>(/<id>)))')
	->defaults(array(
		'directory'  => 'ajax',
		'controller' => 'main',
		'action'     => 'index',
	));
Route::set('pro_stats', 'pro(/<controller>(/<action>(/<start_date>(/<end_date>))))')
	->defaults(array(
		'directory'  => 'pro',
		'controller' => 'main',
		'action'     => 'index',
	));
Route::set('pro', 'pro(/<controller>(/<action>(/<id>)))')
	->defaults(array(
		'directory'  => 'pro',
		'controller' => 'main',
		'action'     => 'index',
	));
Route::set('default', '(<controller>(/<action>(/<id>)))')
	->defaults(array(
		'controller' => 'main',
		'action'     => 'index',
	));
