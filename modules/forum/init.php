<?php defined('SYSPATH') OR die('No direct access allowed.');

Route::set('forum', 'forum(/<action>(/<id>))', array(
	'controller' => 'forum',
));