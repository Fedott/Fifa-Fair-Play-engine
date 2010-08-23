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
	}