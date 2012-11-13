<?php
/**
 * User: fedot
 * Date: 13.11.12
 * Time: 12:46
 */
class Controller_Cron extends Controller
{
	public function before()
	{
		if( ! Kohana::$is_cli)
		{
			throw new Kohana_Request_Exception("Данный котроллер можно запускать только из консоли");
		}
	}

	public function action_parse_football_world()
	{
		Model_Pro_Player::parse_eafoolballworld();
	}
}
