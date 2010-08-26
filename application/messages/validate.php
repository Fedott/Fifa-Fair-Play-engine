<?php defined('SYSPATH') or die('No direct script access.');

return array(
	'not_empty'    => ':field не должно быть пустым',
	'matches'      => ':field должен быть одинаковым с :param1',
	'regex'        => ':field не соответствует нужному формату',
	'exact_length' => ':field must be exactly :param1 characters long',
	'min_length'   => ':field must be at least :param1 characters long',
	'max_length'   => ':field must be less than :param1 characters long',
	'in_array'     => ':field must be one of the available options',
	'digit'        => ':field must be a digit',
	'decimal'      => ':field must be a decimal with :param1 places',
	'range'        => ':field must be within the range of :param1 to :param2',
);