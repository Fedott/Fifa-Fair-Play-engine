<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Page_Admin extends Controller_Admin
{
	public function action_index()
	{
		$view = new View('admin/pages');

		$this->template->title = __("Управление статьями");
		$this->template->content = $view;
	}

	public function action_edit($id = NULL)
	{
		if($id === NULL)
			$page = Jelly::factory ('page');
		else
			$page = Jelly::query ('page', $id);

		$errors = array();

		if($_POST)
		{
			try
			{
				$page->set(arr::extract($_POST, array('title', 'text', 'category')));
				$page->author = $this->user->id;
				$page->save();
				Request::instance()->redirect('page/view/'.$page->id);
			}
			catch (Validate_Exception $e)
			{
				$errors = $e->array->errors('page_edit');
			}
		}

		$view = new View('admin/page_edit');
		$view->page = $page;
		$view->errors = $errors;

		$this->template->title = ($page->loaded())?__("Редактирование"):__("Создание");
		$this->template->content = $view;
	}

	public function action_category_edit($id = NULL)
	{
		if($id === NULL)
			$category = Jelly::factory ('category');
		else
			$category = Jelly::query ('category', $id);

		$errors = array();

		if($_POST)
		{
			try
			{
				$category->set(arr::extract($_POST, array('name', 'description')));
				$category->save();
				Request::instance()->redirect('category/view/'.$category->id);
			}
			catch (Validate_Exception $e)
			{
				$errors = $e->array->errors('category_edit');
			}
		}

		$view = new View('admin/category_edit');
		$view->category = $category;
		$view->errors = $errors;

		$this->template->title = ($category->loaded())?__("Редактирование"):__("Создание");
		$this->template->content = $view;
	}
}