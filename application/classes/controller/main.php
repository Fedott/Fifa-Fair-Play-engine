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
			$this->template->breadcrumb = HTML::anchor('main/index', 'Главная страница')." > ";
		}

		public function action_logout()
		{
			$this->auth->logout();
			Request::instance()->redirect('');
		}

		public function action_register()
		{
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
					$this->auth->login($user, $post['password']);
					url::redirect('');
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
	}