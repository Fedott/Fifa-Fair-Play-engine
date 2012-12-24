<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Admin_News extends Controller_Admin
{
	public function action_edit($id = NULL)
	{
		if($id === NULL)
			$news = Jelly::factory('news');
		else
			$news = Jelly::query('news', $id)->execute();

		$errors = array();

		if($_POST)
		{
			try
			{
				$news->set(arr::extract($_POST, array('title', 'text', 'link')));
				$news->author = $this->user->id;
				$news->save();
				MISC::set_apply_message("Новость успешно создана");
				Request::current()->redirect('news/view/'.$news->url);
			}
			catch (Validation_Exception $e)
			{
				$errors = $e->array->errors('news_edit');
			}
		}

		$view = new View('admin/news_edit');
		$view->news = $news;
		$view->errors = $errors;

		if($news->loaded())
			$this->template->title = __("Редактировние, :title", array(":title" => $news->title));
		else
			$this->template->title = __("Создание");
		$this->template->content = $view;
		$this->template->breadcrumb = HTML::anchor('admin', 'Админка')." > ".
					HTML::anchor('admin/tournament', 'Управление турнирами')." > ";
	}
}