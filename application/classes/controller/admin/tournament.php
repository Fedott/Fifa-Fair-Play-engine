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

			if($_POST)
			{
				try
				{
					$tournament->set(Arr::extract($_POST, array('name', 'active', 'type', 'visible', 'ended')));
					$tournament->url = URL::string_to_url($tournament->name);
					$tournament->save();
					Request::instance()->redirect('admin/tournament/view/'.$tournament->id);

				} catch (Validate_Exception $exp) {
					$errors = $exp->array->errors('tournament_edit');
				}
			}

			$view = new View('admin/tournament_edit');
			$view->errors = $errors;
			$view->tournament = $tournament;

			$this->template->title = __('Редактирование турнира, :name', array(':name' => $tournament->name));
			$this->template->content = $view;
			$this->template->breadcrumb = HTML::anchor('admin', 'Админка')." > ".HTML::anchor('admin/tournament', 'Управление турнирами')." > ";
		}

		public function action_edit_lines($tid)
		{
			$tournament = Jelly::select('table', $tid);
			$clubs = Jelly::select('club')
					->join('lines')
					->on('lines.club_id', "=", "clubs.id")
					->where('lines.table_id', "!=", $tournament->id)
					->execute();

			$view = new View('admin/tournament_edit_lines');
			$view->tournament = $tournament;
			$view->clubs = $clubs;

			$this->template->title = __('Редактирование команд в турнире');
			$this->template->content = $view;
			$this->template->breadcrumb = HTML::anchor('admin', 'Админка')." > ".HTML::anchor('admin/tournament', 'Управление турнирами')." > ";
		}
	}