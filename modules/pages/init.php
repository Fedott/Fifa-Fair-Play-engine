<?php defined('SYSPATH') OR die('No direct access allowed.');

Route::set('admin/page', 'admin/page(/<action>(/<id>))')
		->defaults(array(
			'controller' => 'admin',
			'directory'  => 'page',
			'action'     => 'index',
		));