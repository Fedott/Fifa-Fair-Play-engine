<?php defined('SYSPATH') OR die('No direct access allowed.');

	class Controller_Widget extends Controller
	{
		public function action_menu($type = NULL)
		{
			$auth = Auth::instance();
			$user= $auth->get_user();

			$coach_menu = FALSE;
			$matches_not_apply_my = 0;
			$matches_not_apply_opponent = 0;
			if($auth->logged_in('coach'))
			{
				// Получаем инфу о неподтверждённых матчах
				$matches_not_apply_my = Jelly::select('match')
						->where('away.user_id', "=", $user->id)
						->where("confirm", "=", 0)
						->count();
				$matches_not_apply_opponent = Jelly::select('match')
						->where('home.user_id', "=", $user->id)
						->where("confirm", "=", 0)
						->count();
			}

			$view = View::factory('menus/main');
			$view->auth = $auth;
			$view->user = $auth->get_user();
			$view->coach_menu = $coach_menu;
			$view->matches_not_apply_my = $matches_not_apply_my;
			$view->matches_not_apply_opponent = $matches_not_apply_opponent;
			echo $view->render();
		}


		/**
		 * Контроллер проверки логина и пасса для phpBB3
		 */
		public function action_check_login_user()
		{
			$this->auto_render = FALSE;
			$username = Security::xss_clean($_POST['username']);
			$password = Security::xss_clean($_POST['password']);
			$check_string = $_POST['cs'];
			$sc = Kohana::config('auth.sc');
			if($sc != $check_string)
			{
				exit;
			}

			$user = Jelly::select("user")->where('username', '=', $username)->limit(1)->execute();
			if(!$user->loaded())
			{
				echo 0;
				exit;
			}

			$auth = Auth::instance();
			$userpassword = $user->password;
			$hash_password = $auth->hash_password($password, $auth->find_salt($user->password));
			if($userpassword === $hash_password)
			{
				echo 1;
			}
			else
			{
				echo 0;
			}
		}
	}