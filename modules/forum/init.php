<?php defined('SYSPATH') OR die('No direct access allowed.');

Route::set('forum/admin', 'forum/admin(/<action>(/<id>))')
		->defaults(array(
			'controller' => 'admin',
			'directory'  => 'forum',
			'action'     => 'index',
		));

Route::set('forum', 'forum(/<action>(/<id>))')
		->defaults(array(
			'controller' => 'forum',
			'action'     => 'index',
		));