<?php defined('SYSPATH') OR die('No direct access allowed.');

	abstract class Controller_Admin extends Controller_Template
	{
		public $template = 'fifa';

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
	}