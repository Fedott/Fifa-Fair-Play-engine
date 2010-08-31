<?php defined('SYSPATH') OR die('No direct access allowed.');

	class Controller_Admin_Tournament extends Controller_Admin
	{
		public function action_index()
		{
			$this->template->title = __('Управление турнирами');
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
			$this->template->breadcrumb = HTML::anchor('admin', 'Админка')." > ".
					HTML::anchor('admin/tournament', 'Управление турнирами')." > ";
		}

		public function action_view($id)
		{
			$tournament = Jelly::select('table', $id);
			$view = new View('admin/tournament_view');
			$view->tournament = $tournament;

			$this->template->title = __('Турнир :tname', array(':tname' => $tournament->name));
			$this->template->content = $view;
			$this->template->breadcrumb = HTML::anchor('admin', 'Админка')." > ".
					HTML::anchor('admin/tournament', 'Управление турнирами')." > ";
		}

		public function action_edit($id = NULL)
		{
			if($id === NULL)
				$tournament = Jelly::factory ('table');
			else
				$tournament = Jelly::select('table', $id);
			$errors = array();

			if($_POST)
			{
				try
				{
					$tournament->set(Arr::extract($_POST, array('name', 'active', 'type', 'visible', 'ended', 'matches')));
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

			$this->template->title = __('Редактирование турнира :name', array(':name' => $tournament->name));
			$this->template->content = $view;
			$this->template->breadcrumb = HTML::anchor('admin', 'Админка')." > ".
					HTML::anchor('admin/tournament', 'Управление турнирами')." > ".
					HTML::anchor('admin/tournament/view/'.$tournament->id, 'Турнир '.$tournament->name)." > ";
		}

		public function action_edit_lines($tid)
		{
			$tournament = Jelly::select('table', $tid);

			if($_POST)
			{
				foreach ($_POST['clubs'] as $club_id)
				{
					$line = Jelly::factory('line');
					$line->club = $club_id;
					$line->table = $tournament->id;
					$line->save();
				}

				Request::instance()->redirect('admin/tournament/view/'.$tournament->id);
			}

			$club_in_tournament = array();
			foreach($tournament->lines as $line)
			{
				$club_in_tournament[] = $line->club->id;
			}
			if(count($club_in_tournament))
			{
				$clubs = Jelly::select('club')
						->where('id', 'NOT IN', $club_in_tournament)
						->execute();
			}
			else
			{
				$clubs = Jelly::select('club')
						->execute();
			}

			$view = new View('admin/tournament_edit_lines');
			$view->tournament = $tournament;
			$view->clubs = $clubs;

			$this->template->title = __('Добавление команд');
			$this->template->content = $view;
			$this->template->breadcrumb = HTML::anchor('admin', 'Админка')." > ".
					HTML::anchor('admin/tournament', 'Управление турнирами')." > ".
					HTML::anchor('admin/tournament/view/'.$tournament->id, 'Турнир '.$tournament->name)." > ";
		}

		public function action_line_view($lid)
		{
			$line = Jelly::select('line', $lid);

			$view = new View('admin/line_view');
			$view->line = $line;

			$this->template->title = __("Команда :name", array(':name' => $line->club->name));
			$this->template->content = $view;
			$this->template->breadcrumb = HTML::anchor('admin', 'Админка')." > ".
					HTML::anchor('admin/tournament', 'Управление турнирами')." > ".
					HTML::anchor('admin/tournament/view/'.$line->table->id, 'Турнир '.$line->table->name)." > ";
		}

		public function action_line_coach($lid)
		{
			$line = Jelly::select('line', $lid);

			if($_POST)
			{
				$line->user = $_POST['user_id'];
				$line->save();
				Request::instance()->redirect('admin/tournament/view/'.$line->table->id);
			}

			$users_in_tournament = array();
			foreach($line->table->lines as $lu)
			{
				if($lu->user->id)
					$users_in_tournament[] = $lu->user->id;
			}

			if(count($users_in_tournament))
			{
				$users = Jelly::select('user')
						->where('id', '=', $line->user->id)
						->or_where('id', 'NOT IN', $users_in_tournament)
						->execute();
			}
			else
			{
				$users = Jelly::select('user')
						->execute();
			}

			$users_arr = array('NULL' => 'Не назначен');
			foreach($users as $user)
			{
				$users_arr[$user->id] = $user->username;
			}

			$view = new View('admin/line_coach');
			$view->line = $line;
			$view->users = $users_arr;

			$this->template->title = __('Назначение тренера');
			$this->template->content = $view;
			$this->template->breadcrumb = HTML::anchor('admin', 'Админка')." > ".
					HTML::anchor('admin/tournament', 'Управление турнирами')." > ".
					HTML::anchor('admin/tournament/view/'.$line->table->id, 'Турнир '.$line->table->name)." > ".
					HTML::anchor('admin/tournament/line_view/'.$line->club->id, 'Команда '.$line->club->name)." > ";
		}

		public function action_trophy_edit($id = NULL)
		{
			if($id == NULL)
				$trophy = Jelly::factory('trophy');
			else
				$trophy = Jelly::select ('trophy', $id);

			$errors = array();

			if($_POST)
			{
				try
				{
					$trophy->set(arr::extract($_POST, array('description', 'line', 'table', 'club', 'user', 'player', 'weight')));
					if(isset($_FILES))
						$trophy->image = $_FILES['image'];
					$trophy->save();
					Request::instance()->redirect('admin/tournament/');
				}
				catch (Validate_Exception $exp)
				{
					$errors = $exp->array->errors('trophy');
				}
			}

			$view = new View('admin/trophy_edit');
			$view->trophy = $trophy;
			$view->errors = $errors;

			$this->template->title = __('Редактирование трофея');
			$this->template->content = $view;
			$this->template->breadcrumb = HTML::anchor('admin', 'Админка')." > ".
					HTML::anchor('admin/tournament', 'Управление турнирами')." > ".
					HTML::anchor('admin/tournament/view/'.$trophy->table->id, 'Турнир '.$trophy->table->name)." > ";
		}
	}