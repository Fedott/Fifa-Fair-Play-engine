<?php defined('SYSPATH') OR die('No direct access allowed.');

	/**
	 * Class Controller_Admin
	 * @property Auth_Jelly $auth
	 * @property Model_User $user
	 */
	abstract class Controller_Admin extends Controller_Template
	{
		public function before()
		{
			parent::before();

			if(!$this->auth->logged_in('admin'))
			{
				MISC::set_error_message(__("У вас нет доступа к этой странице"));
				Request::instance()->redirect('main');
			}
		}
	}