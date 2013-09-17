<?php defined('SYSPATH') OR die('No direct access allowed.');

	class Controller_Main extends Controller_Template
	{
		public function action_index()
		{
			/** @var $table Model_Table */
			$table = Jelly::select('table')->limit(1)->visible()->execute();
			$last_matches = Jelly::select('match')
					->where('table', '=', $table->id)
					->limit(10)
					->execute();

			if($this->user->loaded())
			{
				$my_line = Jelly::select('line')
						->where('table_id', "=", $table->id)
						->and_where("user_id", "=", $this->user->id)
						->limit(1)
						->execute();
			}
			else
				$my_line = Jelly::factory ('line');

			$my_matches = Jelly::select('match')
					->line($my_line->id)
					->tournament($table->id)
					->limit(10)
					->execute();

			$planned_matches = Jelly::select('planned_match')
				->tournament($table->id)
				->line($my_line->id)
				->available()
				->not_played()
				->execute();

			// TODO:: Переписать к чертям. А то быдлокод
			$res = DB::select_array(array('goals.player_id', 'goals.line_id'))
						->select(array('SUM("count")', 'goals'))
						->from('goals')
						->group_by('player_id')
						->limit(10)
						->order_by('goals', 'DESC')
						->where('table_id', "=", $table->id)
						->execute();
			$goleodors = array();
			$players_like = array();
			foreach ($res as $row)
			{
				$players_like[] = $row['player_id'];
				$goleodors[$row['player_id']] = array('player_id' => $row['player_id'], 'goals' => $row['goals'], 'line_id' => $row['line_id']);
			}

			if(!empty($players_like))
			{
				$players_goals = Jelly::select('player')
						->with('club')
						->where(":primary_key", "IN", $players_like)
						->execute();

				foreach($players_goals as $player)
				{
					$goleodors[$player->id]['player'] = $player;
				}
			}

			$lines_arr = array();
			$my_line_in = false;
			foreach($table->lines as $pos => $line)
			{
				++$pos;
				if( ! $my_line->loaded() OR $line->id == $my_line->id OR $my_line_in OR count($lines_arr) < 9)
				{
					$lines_arr[$pos] = $line;
				}

				if($line->id == $my_line->id)
				{
					$my_line_in = true;
				}

				if(count($lines_arr) == 10)
				{
					break;
				}
			}

			$view = View::factory('main');
			$view->table = $table;
			$view->last_matches = $last_matches;
			$view->goleodors = $goleodors;
			$view->my_line = $my_line;
			$view->lines = $lines_arr;
			$view->uchastie = (bool) $my_line->loaded();
			$view->my_matches = $my_matches;
			$view->planned_matches = $planned_matches;

			$this->template->title = __('Главная');
			$this->template->content = $view;
		}

		public function action_login()
		{
			$errors = array();

			if($this->auth->logged_in('login'))
			{
				Request::instance()->redirect('/');
			}
			if($_POST)
			{
				$username = $_POST['username'];
				$password = $_POST['password'];
				$remember = (isset($_POST['remember']))?TRUE:FALSE;

				if($this->auth->login($username, $password, $remember))
				{
					Request::instance()->redirect('');
				}
				else
				{
					$errors = array(__('Неверный логин или пароль.'));
				}
			}

			$view = new View('login');
			$view->errors = $errors;

			$this->template->title = __('Авторизация пользователя');
			$this->template->content = $view;
			$this->template->breadcrumb = HTML::anchor('main/index', __("Главная"))." > ";
		}

		public function action_logout()
		{
			$this->auth->logout();
			Request::instance()->redirect('');
		}

		public function action_register()
		{
			$captcha = Captcha::instance();
			if($this->auth->logged_in())
			{
				MISC::set_error_message(__("Вы уже авторизированы."));
				Request::instance()->redirect('');
			}
			$form = array(
				'username'	=> '',
				'email'		=> '',
				'icq'		=> '',
				'skype'     => '',
				'origin'    => '',
			);

			$errors = array();

			if($_POST)
			{
				$post = Arr::extract($_POST, array('username','email','icq', 'skype','origin','password','password_confirm'));
				$user = Jelly::factory('user');

				try
				{
					$user->set($post);
					$user->validate();
					$cv = Validate::factory($_POST)
							->rule('chelovechnost','Captcha::valid')
							->rule('chelovechnost', 'not_empty');
					if( ! $cv->check())
					{
						throw new Validate_Exception($cv, 'Bad captcha');
					}
					$user->add('roles', 1);
					$user->save();
					$data = array(
						'row' => serialize(array(
							'username'      => $user->username,
							'user_email'    => $user->email,
							'user_icq'      => $user->icq,
						)),
						'sc' => Kohana::config('auth.sc'),
						'other_fields' => serialize(array(
							'pf_origin'        => $user->origin,
							'pf_skype'         => $user->skype,
						)),
					);
					Curl::post('http://'.$_SERVER['SERVER_NAME']."/forum/kohana_user_add.php", $data);
					$this->auth->login($user, $post['password']);
					Request::instance()->redirect('');
				}
				catch (Validate_Exception $exp)
				{
					$form = $post;
					$errors = $exp->array->errors('register_form');
				}
			}

			$this->template->title = "Регистрация";
			$this->template->content = new View('regform');
			$this->template->content->form = $form;
			$this->template->content->errors = $errors;
			$this->template->content->captcha = $captcha;
		}

		public function action_profile_edit()
		{
			if(!$this->auth->logged_in())
			{
				MISC::set_error_message(__("Вы не авторизированы на сайте"));
				Request::instance()->redirect("login");
			}

			/** @var $user Model_User */
			$user = Jelly::select('user', $this->user->id);
			$errors = array();
			if($_POST)
			{
				try
				{
					$user->set(arr::extract($_POST, array('icq', 'first_name', 'last_name', 'skype', 'origin')));
					if($_POST['password'])
					{
						$user->set(arr::extract($_POST, array('password', 'password_confirm')));
					}
					if(isset($_FILES) AND arr::path($_FILES, 'avatar.size', FALSE))
					{
						$user->avatar = $_FILES['avatar'];
					}
					$user->save();

					// Обновление информации на форуме
					$data = array(
						'row' => serialize(array(
							'username'      => $user->username,
							'user_email'    => $user->email,
							'user_icq'      => $user->icq,
						)),
						'sc' => Kohana::config('auth.sc'),
						'other_fields' => serialize(array(
							'pf_origin'        => $user->origin,
							'pf_skype'         => $user->skype,
						)),
					);
					Curl::post('http://'.$_SERVER['SERVER_NAME']."/forum/kohana_user_update.php", $data);
					// Конец обновления информации на форуме

					MISC::set_apply_message(__("Данные профиля успешно изменены"));
					Request::instance()->redirect("main/profile");
				}
				catch (Validate_Exception $exp)
				{
					$errors = $exp->array->errors('register_form');
				}
			}

			$view = new View('profile_edit');
			$view->user = $user;
			$view->errors = $errors;

			$this->template->title = __("Редактрование профиля");
			$this->template->content = $view;
			$this->template->breadcrumb = HTML::anchor('main/index', __("Главная"))." > ";
		}

		public function action_profile($id = NULL)
		{
			if($id == NULL)
			{
				if(!$this->auth->logged_in())
				{
					MISC::set_error_message("Вы не авторизированы на сайте");
					Request::instance()->redirect("login");
				}

				$id = $this->user->id;
			}

			$user = Jelly::select('user', $id);

			if(!$user->loaded())
			{
				MISC::set_error_message(__("Такого пользователя не существует"));
				Request::instance()->redirect('');
			}

			$coach = $user->has_role('coach');
			if($coach)
			{
				$coach = array();
				$coach['lines'] = Jelly::select('line')
						->by_user($user->id)
						->execute();
			}

			$view = new View('profile_new');
			$view->user = $user;
			$view->coach = $coach;
			$view->my_profile = ($user->id == $this->user->id)?true:false;

			if($user->id == $this->user->id)
				$this->template->title = __("Мой профиль");
			else
				$this->template->title = __("Пользователь :name", array(":name" => $user->username));
			$this->template->content = $view;
			$this->template->breadcrumb = HTML::anchor('main/index', __("Главная"))." > ";
		}
	}