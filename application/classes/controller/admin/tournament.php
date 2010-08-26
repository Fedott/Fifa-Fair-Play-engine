<?php defined('SYSPATH') OR die('No direct access allowed.');

	class Controller_Admin_Tournament extends Controller_Admin
	{
		public function action_index()
		{
			$this->template->title = __('Управление Турнирами');
			$this->template->content = new View('admin/tournament');
			$this->template->breadcrumb = HTML::anchor('admin', 'Админка')." > ";
		}

		public function action_listen()
		{
			$tournaments = Jelly::select('table')->execute();
			$view = new View('admin/tournaments_list');
			$view->tournaments = $tournaments;
			$view->i = 1;

			$this->template->title = __('Список турниров');
			$this->template->content = $view;
			$this->template->breadcrumb = HTML::anchor('admin', 'Админка')." > ".HTML::anchor('admin/tournament', 'Управление турнирами')." > ";
		}

		public function action_view($id)
		{
			$tournament = Jelly::select('table', $id);
			$view = new View('admin/tournament_view');
			$view->tournament = $tournament;

			$this->template->title = __('Турнир: :tname', array(':tname' => $tournament->name));
			$this->template->content = $view;
			$this->template->breadcrumb = HTML::anchor('admin', 'Админка')." > ".HTML::anchor('admin/tournament', 'Управление турнирами')." > ";
		}

		public function action_edit($id = NULL)
		{
			$tournament = Jelly::select('table', $id);
			$errors = array();
			$form = array(
				'name' => $tournament->name,
			);

			if($_POST)
			{
				try
				{
					$tournament->set(Arr::extract($_POST, $form));
					$tournament->save();

				} catch (Validate_Exception $exp) {
					$errors = $exp->array->errors('tournament_edit');
					$form = Arr::extract($_POST, $form);
				}
			}

			$view = new View('admin/tournament_edit');
			$view->form = $form;
			$view->errors = $errors;

			$this->template->title = __('Редактирование турнира, :name', array(':name' => $tournament->name));
			$this->template->content = $view;
			$this->template->breadcrumb = HTML::anchor('admin', 'Админка')." > ".HTML::anchor('admin/tournament', 'Управление турнирами')." > ";
		}
	}