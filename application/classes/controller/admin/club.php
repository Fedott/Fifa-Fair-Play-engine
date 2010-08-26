<?php defined('SYSPATH') OR die('No direct access allowed.');

	class Controller_Admin_Club extends Controller_Admin
	{
		public function action_index()
		{
			$view = new View('admin/club');

			$this->template->title = __("Управление клубами");
			$this->template->content = $view;
			$this->template->breadcrumb = HTML::anchor('admin', 'Админка')." > ";
		}

		public function action_list()
		{
			$clubs = Jelly::select('club')->execute();

			$view = new View('admin/clubs_list');
			$view->clubs = $clubs;

			$this->template->title = __("Клубы");
			$this->template->content = $view;
			$this->template->breadcrumb = HTML::anchor('admin', 'Админка')." > ".HTML::anchor('admin/club', 'Управление командами')." > ";
		}

		public function action_edit($cid = NULL)
		{
			$club = Jelly::select('club', $cid);
			$errors = array();

			if($_POST)
			{
				try
				{
					$club->set(Arr::extract($_POST, array('name', 'logo')));
					$club->url = url::string_to_url($club->name);
					$club->save();
					Request::instance()->redirect('admin/club/view/'.$club->id);
				}
				catch (Validate_Exception $exp)
				{
					$errors = $exp->array->errors('club');
				}
			}

			$view = new View('admin/club_edit');
			$view->club = $club;
			$view->errors = $errors;

			$this->template->title = __("Редактирование команды :name", array($club->name));
			$this->template->content = $view;
			$this->template->breadcrumb = HTML::anchor('admin', 'Админка')." > ".HTML::anchor('admin/club', 'Управление командами')." > ";
		}
	}