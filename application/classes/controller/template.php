<?php defined('SYSPATH') OR die('No direct access allowed.');

	/**
	 * @property $user
	 */
	class Controller_Template extends Kohana_Controller_Template
	{
		public $template = 'ux';

		public function before()
		{
			$this->auth = Auth::instance();
			if($this->auth->logged_in())
				$this->user = $this->auth->get_user();
			else
				$this->user = Jelly::factory ('user');
                
            View::bind_global('active_user', $this->user);
            View::bind_global('auth', $this->auth);

			parent::before();
		}
	}