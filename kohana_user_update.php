<?php
/**
 * User: fedot
 * Date: 15.11.12
 * Time: 18:34
 */

define('IN_PHPBB', true);
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($phpbb_root_path . 'common.' . $phpEx);

$sc = 'sljkhasdfASFasjkfhasfkj23214jkawrASD124lasd@!#4jsad';
$check_code = $_POST['sc'];
if($check_code != $sc)
{
	exit;
}

require 'includes/functions_user.php';
require "includes/functions_profile_fields.php";

$row = unserialize(stripslashes($_POST['row']));
$other_fields = unserialize(stripslashes($_POST['other_fields']));
$sql = 'SELECT user_id
				FROM ' . USERS_TABLE . "
				WHERE username_clean = '" . $db->sql_escape(utf8_clean_string($row['username'])) . "'";
$result = $db->sql_query($sql);
$user_id = (int) $db->sql_fetchfield('user_id');
$db->sql_freeresult($result);

if (!$user_id)
{
	trigger_error($user->lang['NO_USER'] . adm_back_link($this->u_action), E_USER_WARNING);
}

custom_profile::update_profile_field_data($user_id, $other_fields);