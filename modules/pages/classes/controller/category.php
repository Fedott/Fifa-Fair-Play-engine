<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Category extends Controller_Template
{
	public function action_index()
	{
		$this->action_list();
	}

	public function action_list()
	{
		$categories = Jelly::query('category')->execute();

		$view = new View('categories');
		$view->categories = $categories;

		$this->template->title = __("Категории");
		$this->template->content = $view;
	}

	public function action_view($id)
	{
		$category = Jelly::query('category', $id);

		$view = new View('category');
		$view->category = $category;

		$this->template->title = $category->name;
		$this->template->content = $view;
	}
}