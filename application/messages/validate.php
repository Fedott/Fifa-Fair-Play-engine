<?php defined('SYSPATH') or die('No direct script access.');

return array(
	'not_empty'    => ':field не должно быть пустым',
	'matches'      => ':field должен быть одинаковым с :param1',
	'regex'        => ':field не соответствует нужному формату',
	'exact_length' => ':field должно быть ровно :param1 символов',
	'min_length'   => ':field не должно быть меньше :param1 символов',
	'max_length'   => ':field не должно быть больше :param1 символов',
	'in_array'     => ':field must be one of the available options',
	'digit'        => ':field значение должно быть числовым',
	'decimal'      => ':field must be a decimal with :param1 places',
	'range'        => ':field must be within the range of :param1 to :param2',
);