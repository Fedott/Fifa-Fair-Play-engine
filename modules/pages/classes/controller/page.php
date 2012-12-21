<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Page extends Controller_Template
{
	public function action_view($id)
	{
		$page = Jelly::query('page', $id);

		$view = new View('page');
		$view->page = $page;

		$this->template->title = $page->title;
		$this->template->content = $view;
	}
}