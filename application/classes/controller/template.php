<?php defined('SYSPATH') OR die('No direct access allowed.');

	/**
	 * @property $user
	 */
	class Controller_Template extends Kohana_Controller_Template
	{
		public $template = 'fifa';

		public function before()
		{
			$this->auth = Auth::instance();
			if($this->auth->logged_in())
				$this->user = $this->auth->get_user();
			else
				$this->user = Jelly::factory ('user');

			parent::before();
		}
	}