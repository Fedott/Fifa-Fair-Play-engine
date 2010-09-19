<?php defined('SYSPATH') OR die('No direct access allowed.');

Route::set('forum/admin', 'forum/admin(/<action>(/<id>))')
		->defaults(array(
			'controller' => 'admin',
			'directory'  => 'forum',
			'action'     => 'index',
		));

Route::set('forum/topic/view', 'forum/topic/view/<id>(/<page>)')
		->defaults(array(
			'controller' => 'forum',
			'action'     => 'topic_view',
		));

Route::set('forum/topic/create', 'forum/topic/create/<forumid>')
		->defaults(array(
			'controller' => 'forum',
			'action'     => 'topic_create',
		));

Route::set('forum', 'forum(/<action>(/<id>))')
		->defaults(array(
			'controller' => 'forum',
			'action'     => 'index',
		));