<?php defined('SYSPATH') OR die('No direct access allowed.');

	class Controller_Admin_Main extends Controller_Admin
	{
		public function before()
		{
			$this->auth = Auth::instance();
			$this->user = $this->auth->get_user();

			if(!$this->auth->logged_in('admin'))
			{
				Request::instance()->redirect('main');
			}

			parent::before();
		}

		public function action_index()
		{
			$this->template->title = __('Административный раздел');
			$this->template->content = View::factory('admin/main');
		}

		public function action_tournament()
		{
			$this->template->title = __('Управление Турнирами');
			$this->template->content = new View('admin/tournament');
		}
	}