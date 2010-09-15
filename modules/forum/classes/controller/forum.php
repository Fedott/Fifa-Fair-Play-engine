<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Forum extends Controller_Template
{
	public function action_index()
	{
		$sections = Jelly::select('section')->execute();

		$view = new View('forum/index');
		$view->sections = $sections;

		$this->template->title = __("Форум");
		$this->template->content = $view;
		$this->template->breadcrumb = HTML::anchor('', 'Главная')." > ";
	}
}