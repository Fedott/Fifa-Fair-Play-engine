<?php defined('SYSPATH') OR die('No direct access allowed.');

return array(
	'icq' => array(
		'unique' => 'Пользователь с таким номером ICQ уже зарегистрирован.',
	),
	'email' => array(
		'unique' => 'Пользователь с таким E-mail уже зарегистрирован на сайте',
		'not_empty' => 'E-mail обязательн для заполнения',
	),
	'password' => array(
		'not_empty' => 'Вы не указали пароль',
	),
	'password_confirm' => array(
		'matches' => 'Пароли не совпадают',
		'not_empty' => 'Пароли не совпадают',
	),
	'username' => array(
		'not_empty' => 'Вы не указали Логин',
		'unique' => 'Такой логин кже используется',
	),
	
);