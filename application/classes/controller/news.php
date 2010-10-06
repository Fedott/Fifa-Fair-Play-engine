<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_News extends Controller_Template
{
	public function action_index()
	{
		$this->action_list();
	}

	public function action_list()
	{
		$count = Jelly::select('news')->count();
		$pagination = Pagination::factory(array(
			'total_items' => $count,
		));

		$News = Jelly::select('news')
				->offset($pagination->offset)
				->limit($pagination->items_per_page)
				->execute();

		$view = new View('news_list');
		$view->News = $News;
		$view->pagination = $pagination;

		$this->template->title = __("Новости");
		$this->template->content = $view;
		$this->template->breadcrumb = HTML::anchor('main/index', __("Главная"))." > ";
	}

	public function action_view($id)
	{
		$news = Jelly::select('news', $id);

		$view = new View('news_view');
		$view->news = $news;

		$this->template->title = $news->title;
		$this->template->content = $view;
		$this->template->breadcrumb = HTML::anchor('main/index', __("Главная"))." > "
				.HTML::anchor('news', __("Новости"))." > ";
	}
}