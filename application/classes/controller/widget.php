<?php defined('SYSPATH') OR die('No direct access allowed.');

	class Controller_Widget extends Controller
	{
		public function action_menu($type = NULL)
		{
			$auth = Auth::instance();
			$view = View::factory('menu');
			$view->auth = $auth;
			$view->user = $auth->get_user();
			echo $view->render();
		}
	}