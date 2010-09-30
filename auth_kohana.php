<?php
/**
 *
 * Пример плагина авторизации для phpBB3
 *
 */
/**
 * @ignore
 */
if (!defined('IN_PHPBB'))
{
	exit;
}

/**
 * Функция, отвечающая за авторизацию.
 */
function login_kohana(&$username, &$password)
{
	global $db, $config;

// Запрещаем пустой пароль.
	if (!$password)
	{
		return array(
			'status' => LOGIN_ERROR_PASSWORD,
			'error_msg' => 'NO_PASSWORD_SUPPLIED',
			'user_row' => array('user_id' => ANONYMOUS),
		);
	}

// Запрещаем пустое имя пользователя.
	if (!$username) {
		return array(
			'status' => LOGIN_ERROR_USERNAME,
			'error_msg' => 'LOGIN_ERROR_USERNAME',
			'user_row' => array('user_id' => ANONYMOUS),
		);
	}

// Получаем ответ от коханы
	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => 'http://'.$_SERVER['SERVER_NAME'].'/widget/check_login_user',
		CURLOPT_POST => 1,
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_FOLLOWLOCATION => 1,
		CURLOPT_POSTFIELDS => "username=$username&password=$password&cs=sljkhasdfASFasjkfhasfkj23214jkawrASD124lasd@!#4jsad",
	));
	$logintrue = curl_exec($curl);
	curl_close($curl);

// Обычная проверка на правильность.
	if ($logintrue)
	{
// Сообщаем, что авторизация прошла успешно.
		$sql = 'SELECT user_id, username, user_email, user_type, user_login_attempts
		FROM ' . USERS_TABLE . "
			WHERE username_clean = '" . $db->sql_escape($username) . "'";
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);
		return array(
			'status' => LOGIN_SUCCESS,
			'error_msg' => false,
			'user_row' => $row,
		);
	}

// Возвращаем ошибку авторизации.
	return array(
		'status' => LOGIN_ERROR_PASSWORD,
		'error_msg' => 'LOGIN_ERROR_PASSWORD',
		'user_row' => array('user_id' => ANONYMOUS),
	);
}

?>