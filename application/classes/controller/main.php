<?php defined('SYSPATH') OR die('No direct access allowed.');

	class Controller_Main extends Controller_Template
	{
		public $template = 'fifa';

		public function before()
		{
			$this->auth = Auth::instance();
			$this->user = $this->auth->get_user();

			parent::before();
		}

		public function action_index()
		{
			$this->auto_render = FALSE;
			$season = Jelly::select('table', 1);
			echo Kohana::debug($season->as_array());

//			$this->template->title = __('Поехали!');
//			$this->template->content = __('Начинаем всё с начала =)');
//			$this->template->content.= "<br>".$this->user;
		}

		public function action_login()
		{
			$errors = array();

			if($this->auth->logged_in('login'))
			{
				Request::instance()->redirect('main_index');
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
	}