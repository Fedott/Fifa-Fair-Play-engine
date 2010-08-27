<?php defined('SYSPATH') OR die('No direct access allowed.');

	class Controller_Widget extends Controller
	{
		public function action_menu($type = NULL)
		{
			$view = View::factory('menu');
			echo $view->render();
		}
	}