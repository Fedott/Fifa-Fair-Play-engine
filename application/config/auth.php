<?php defined('SYSPATH') OR die('No direct access allowed.');

return array
(
	'driver' => 'Jelly',
	'hash_method' => 'sha1',
//	'salt_pattern' => '1, 3, 5, 9, 14, 15, 20, 21, 28, 30',
	'salt_pattern' => '1, 4, 6, 7, 14, 17, 20, 24, 28, 29',
	'lifetime' => 1209600,
	'session_key' => 'auth_user',
	'sc' => 'sljkhasdfASFasjkfhasfkj23214jkawrASD124lasd@!#4jsad',
);
