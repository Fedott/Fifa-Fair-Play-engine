<?php
/**
*
* @package phpBB3 fifafairplay user add
* @version $Id$
* @copyright Fedot (fedotru@gmail.com)
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
* Minimum Requirement: PHP 4.3.3
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

require "$phpbb_root_path". 'includes/functions_user.' . $phpEx;
$row = unserialize(stripslashes($_POST['row']));
$cp_data = unserialize(stripslashes($_POST['other_fields']));
// Добавляем страндартные поля
$row['user_type'] = USER_NORMAL;
$row['group_id'] = 2;
echo user_add($row, $cp_data);
exit;