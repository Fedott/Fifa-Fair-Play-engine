<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Forum extends Controller_Template
{
	public function action_index()
	{
		$sections = Jelly::select('section')->execute();

		$view = new View('forum/index');
		
	}
}