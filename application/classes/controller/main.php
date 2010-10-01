<?php defined('SYSPATH') OR die('No direct access allowed.');

	class Controller_Main extends Controller_Template
	{
		public function action_index()
		{
			$this->template->title = __('Главная');
			$this->template->content = __('Начинаем всё с начала =)');
		}

		public function action_login()
		{
			$errors = array();

			if($this->auth->logged_in('login'))
			{
				Request::instance()->redirect();
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
			if($this->auth->logged_in())
			{
				MISC::set_error_message(__("Вы уже авторизированы."));
				Request::instance()->redirect('');
			}
			$form = array(
				'username'	=> '',
				'email'		=> '',
				'icq'		=> '',
			);

			$errors = array();

			if($_POST)
			{
				$post = Arr::extract($_POST, array('username','email','icq','password','password_confirm'));
				$user = Jelly::factory('user');

				try
				{
					$user->set($post);
					$user->add('roles', 1);
					$user->save();
					$data = array(
						'row' => serialize(array(
							'username'      => $user->username,
							'user_email'    => $user->email,
							'user_icq'      => $user->icq,
						)),
						'sc' => Kohana::config('auth.sc'),
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
		}

		public function action_profile_edit()
		{
			if(!$this->auth->logged_in())
			{
				MISC::set_error_message(__("Вы не авторизированы на сайте"));
				Request::instance()->redirect("login");
			}

			$user = Jelly::select('user', $this->user->id);
			$errors = array();
			if($_POST)
			{
				try
				{
					$user->set(arr::extract($_POST, array('icq', 'first_name', 'last_name')));
					if($_POST['password'])
					{
						$user->set(arr::extract($_POST, array('password', 'password_confirm')));
					}
					if(isset($_FILES))
					{
						$user->avatar = $_FILES['avatar'];
					}
					$user->save();
					Request::instance()->redirect("");
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
				$id = $this->user->id;

			$user = Jelly::select('user', $id);
			$coach = $user->has_role('coach');
			if($coach)
			{
				$coach = array();
				$coach['lines'] = Jelly::select('line')
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