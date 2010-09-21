<?php defined('SYSPATH') or die('No direct script access.');

return array(

	'forum' => array(
		'current_page'   => array('source' => 'query_string', 'key' => 'page'), // source: "query_string" or "route"
		'items_per_page' => 20,
		'view'           => 'forum/pagination',
		'auto_hide'      => FALSE,
	),

);
