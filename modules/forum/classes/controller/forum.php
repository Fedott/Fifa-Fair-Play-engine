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
		$this->template->breadcrumb = HTML::anchor('', __("Главная"))." > ";
	}
	
	public function action_section($id )
	{
		$sections = array(0 => Jelly::select('section', $id));

		$view = new View('forum/index');
		$view->sections = $sections;

		$this->template->title = $sections[0]->name;
		$this->template->content = $view;
		$this->template->breadcrumb = HTML::anchor('', __("Главная"))." > "
				.HTML::anchor("forum", __("Форум"))." > ";
	}

	public function action_view($id)
	{
		$forum = Jelly::select('forum', $id);

		$view = new View('forum/forum_view');
		$view->forum = $forum;

		$this->template->title = $forum->name;
		$this->template->content = $view;
		$this->template->breadcrumb = HTML::anchor('', __("Главная"))." > "
				.HTML::anchor("forum", __("Форум"))." > "
				.HTML::anchor("forum/section/".$forum->section->id, $forum->section->name)." > ";
	}
}