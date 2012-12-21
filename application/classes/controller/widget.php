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
				$lines = Jelly::query('line')
						->where("user_id", "=", $user->id)
						->where("_table:table.visible", "=", 1)
						->execute();

				$tables = array();
				foreach($lines as $line)
				{
					$tables[] = $line->table;
					if(count($tables) == 3)
						break;
				}

				$tables_with_lines = array();
				foreach($tables as $table)
				{
					$tables_with_lines[]['table'] = $table;
					$number = count($tables_with_lines)-1;
					$tables_with_lines[$number]['lines'] = array();
					foreach($table->lines as $key => $line)
					{
						if($line->user->id == $user->id)
						{
							$position = $key + 1;
							if($key == 0)
							{
								$tables_with_lines[$number]['lines'][] = array('line' => $table->lines[$key], 'position' => $position);
								$tables_with_lines[$number]['lines'][] = array('line' => $table->lines[$key + 1], 'position' => $position + 1);
								$tables_with_lines[$number]['lines'][] = array('line' => $table->lines[$key + 2], 'position' => $position + 2);
							}
							elseif($key == count($table->lines) - 1)
							{
								$tables_with_lines[$number]['lines'][] = array('line' => $table->lines[$key - 2], 'position' => $position - 2);
								$tables_with_lines[$number]['lines'][] = array('line' => $table->lines[$key - 1], 'position' => $position - 1);
								$tables_with_lines[$number]['lines'][] = array('line' => $table->lines[$key], 'position' => $position);
							}
							else
							{
								$tables_with_lines[$number]['lines'][] = array('line' => $table->lines[$key - 1], 'position' => $position - 1);
								$tables_with_lines[$number]['lines'][] = array('line' => $table->lines[$key], 'position' => $position);
								$tables_with_lines[$number]['lines'][] = array('line' => $table->lines[$key + 1], 'position' => $position + 1);
							}
						}
					}
				}

				$coach_menu = new View('menus/coach_menu');
				$coach_menu->lines = $lines;
				$coach_menu->tables_with_lines = $tables_with_lines;
				$coach_menu->user = $user;

				// Получаем инфу о неподтверждённых матчах
				$matches_not_apply_my = Jelly::query('match')
						->where('away.user_id', "=", $user->id)
						->where("confirm", "=", 0)
						->count();
				$matches_not_apply_opponent = Jelly::query('match')
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
			$sc = Kohana::config('auth.php.sc');
			if($sc != $check_string)
			{
				exit;
			}

			$user = Jelly::query("user")->where('username', '=', $username)->limit(1)->execute();
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