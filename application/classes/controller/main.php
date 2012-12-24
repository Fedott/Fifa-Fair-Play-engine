<?php defined('SYSPATH') OR die('No direct access allowed.');

	class Controller_Main extends Controller_Template
	{
		public function action_index()
		{
			$count = Jelly::query('news')->count();
			$pagination = Pagination::factory(array(
				'total_items' => $count,
			));

			$News = Jelly::query('news')
					->offset($pagination->offset)
					->limit($pagination->items_per_page)
					->execute();

			$view = new View('news_list');
			$view->News = $News;
			$view->pagination = $pagination;

			$this->template->title = __('Главная');
			$this->template->content = $view;
		}

		public function action_login()
		{
			$errors = array();

			if($this->auth->logged_in('login'))
			{
				Request::current()->redirect('/');
			}
			if($_POST)
			{
				$username = $_POST['username'];
				$password = $_POST['password'];
				$remember = (isset($_POST['remember']))?TRUE:FALSE;

				$res = $this->auth->login($username, $password, $remember);
				if($res)
				{
					Request::current()->redirect('');
				}
				else
				{
					$errors = array(__('Неверный логин или пароль.'));
				}
			}

			$view = View::factory('login');
			$view->errors = $errors;

			$this->template->title = __('Авторизация пользователя');
			$this->template->content = $view;
			$this->template->breadcrumb = HTML::anchor('main/index', __("Главная"))." > ";
		}

		public function action_logout()
		{
			$this->auth->logout();
			Request::current()->redirect('');
		}

		public function action_register()
		{
			$captcha = Captcha::instance();
			if($this->auth->logged_in())
			{
				MISC::set_error_message(__("Вы уже авторизированы."));
				Request::current()->redirect('');
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
					$cv = Validation::factory($_POST)
							->rule('chelovechnost','Captcha::valid')
							->rule('chelovechnost', 'not_empty');
					if( ! $cv->check())
					{
						throw new Validation_Exception($cv, 'Bad captcha');
					}
					$user->add('roles', 1);
					$user->save();
					$data = array(
						'row' => serialize(array(
							'username'      => $user->username,
							'user_email'    => $user->email,
							'user_icq'      => $user->icq,
						)),
						'sc' => Kohana::config('auth.php.sc'),
						'other_fields' => serialize(array(
							'pf_origin'        => $user->origin,
							'pf_skype'         => $user->skype,
						)),
					);
					Curl::post('http://'.$_SERVER['SERVER_NAME']."/forum/kohana_user_add.php", $data);
					$this->auth->login($user, $post['password']);
					Request::current()->redirect('');
				}
				catch (Validation_Exception $exp)
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
				Request::current()->redirect("login");
			}

			/** @var $user Model_User */
			$user = Jelly::query('user', $this->user->id);
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
						'sc' => Kohana::config('auth.php.sc'),
						'other_fields' => serialize(array(
							'pf_origin'        => $user->origin,
							'pf_skype'         => $user->skype,
						)),
					);
					Curl::post('http://'.$_SERVER['SERVER_NAME']."/forum/kohana_user_update.php", $data);
					// Конец обновления информации на форуме

					MISC::set_apply_message(__("Данные профиля успешно изменены"));
					Request::current()->redirect("main/profile");
				}
				catch (Validation_Exception $exp)
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
					Request::current()->redirect("login");
				}

				$id = $this->user->id;
			}

			$user = Jelly::query('user', $id)->execute();

			if(!$user->loaded())
			{
				MISC::set_error_message(__("Такого пользователя не существует"));
				Request::current()->redirect('');
			}

			$coach = $user->has_role('coach');
			if($coach)
			{
				$coach = array();
				$coach['lines'] = Jelly::query('line')
						->by_user($user->id)
						->execute();
			}

			$view = new View('profile');
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