<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Forum_Admin extends Controller_Template
{
	public function action_index()
	{
		$this->template->title = __("Управление");
		$this->template->content = new View('forum/admin/index');
		$this->template->breadcrumb = HTML::anchor('', __("Главная"))." > "
				.HTML::anchor('forum', __("Форум"))." > ";
	}

	public function action_sections()
	{
		$sections = Jelly::query('section')->execute();
		
		$view = new View('forum/admin/sections');
		$view->sections = $sections;

		$this->template->title = __("Разделы");
		$this->template->content = $view;
		$this->template->breadcrumb = HTML::anchor('', __("Главная"))." > "
				.HTML::anchor('forum', __("Форум"))." > "
				.HTML::anchor('forum/admin', __("Управление"))." > ";
	}

	public function action_section_edit($id = NULL)
	{
		if($id === NULL)
			$section = Jelly::factory('section');
		else
			$section = Jelly::query('section', $id)->execute();

		$errors = array();

		if($_POST)
		{
			try
			{
				$section->set(arr::extract($_POST, array('name', 'weight')));
				$section->save();
				Request::instance()->redirect('forum/admin/sections');
			}
			catch (Jelly_Validation_Exception $e)
			{
				$errors = $e->errors();
			}
		}

		$view = new View('forum/admin/section_edit');
		$view->errors = $errors;
		$view->section = $section;

		if($section->loaded())
			$this->template->title = __("Редактирование \":name\"", array(':name' => $section->name));
		else
			$this->template->title = __("Создание");
		$this->template->content = $view;
		$this->template->breadcrumb = HTML::anchor('', __("Главная"))." > "
				.HTML::anchor('forum', __("Форум"))." > "
				.HTML::anchor('forum/admin', __("Управление"))." > "
				.HTML::anchor('forum/admin/sections', __("Разделы"))." > ";
	}

	public function action_forums()
	{
		$forums = Jelly::query('forum')->execute();

		$view = new View('forum/admin/forums');
		$view->forums = $forums;

		$this->template->title = __("Форумы");
		$this->template->content = $view;
		$this->template->breadcrumb = HTML::anchor('', __("Главная"))." > "
				.HTML::anchor('forum', __("Форум"))." > "
				.HTML::anchor('forum/admin', __("Управление"))." > ";
	}

	public function action_forum_edit($id = NULL)
	{
		if($id === NULL)
			$forum = Jelly::factory('forum');
		else
			$forum = Jelly::query('forum', $id)->execute();

		$errors = array();

		if($_POST)
		{
			try
			{
				$forum->set(arr::extract($_POST, array('name', 'weight', 'description', 'role', 'section')));
				$forum->save();
				Request::instance()->redirect('forum/admin/forums');
			}
			catch (Jelly_Validation_Exception $e)
			{
				$errors = $e->errors();
			}
		}

		$view = new View('forum/admin/forum_edit');
		$view->errors = $errors;
		$view->forum = $forum;

		if($forum->loaded())
			$this->template->title = __("Редактирование \":name\"", array(':name' => $forum->name));
		else
			$this->template->title = __("Создание");
		$this->template->content = $view;
		$this->template->breadcrumb = HTML::anchor('', __("Главная"))." > "
				.HTML::anchor('forum', __("Форум"))." > "
				.HTML::anchor('forum/admin', __("Управление"))." > "
				.HTML::anchor('forum/admin/forums', __("Форумы"))." > ";
	}
}