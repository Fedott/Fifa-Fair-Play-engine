<?php defined('SYSPATH') OR die('No direct access allowed.');

	class Controller_Template extends Kohana_Controller_Template
	{
		public $template = 'fifa';

		public function before()
		{
			$this->auth = Auth::instance();
			$this->auth->logged_in();
			$this->user = $this->auth->get_user();

			parent::before();
		}
	}