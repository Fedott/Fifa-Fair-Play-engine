<?php defined('SYSPATH') OR die('No direct access allowed.');

	abstract class Controller_Admin extends Controller_Template
	{
		public function before()
		{
			parent::before();

			if(!$this->auth->logged_in('admin'))
			{
				Request::instance()->redirect('main');
			}
		}
	}