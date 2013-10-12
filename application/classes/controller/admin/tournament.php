<?php defined('SYSPATH') OR die('No direct access allowed.');

	class Controller_Admin_Tournament extends Controller_Admin
	{
		public function action_index()
		{
			$this->action_listen();
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
					$tournament->set(Arr::extract($_POST, array('name', 'active', 'type', 'visible', 'ended', 'matches', 'scheduled')));
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

		public function action_line_delete($id)
		{
			/** @var $line Model_Line */
			$line = Jelly::select('line', $id);
			if($line->drawn + $line->lose + $line->win == 0)
			{
				$line->delete();
				MISC::set_apply_message('Команда успешно удалена из турнира');
				Request::instance()->redirect(Request::$referrer);
			}

			MISC::set_error_message('Команда не может быть удалена из турнира, атк ак у неё имеються сыгранные матчи');
			Request::instance()->redirect(Request::$referrer);
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
					HTML::anchor('admin/tournament/line_view/'.$line->id, 'Команда '.$line->club->name)." > ";
		}

		public function action_line_matches($line_id)
		{
			$line = Jelly::select('line', $line_id);

			$matches_asc = Jelly::select('match')
				->line($line->id)
				->order_by('date', 'asc')
				->execute();

			$played_matches = array();
			foreach ($matches_asc as $match)
			{
				if($match->home->id == $line->id)
				{
					if(!isset($played_matches[$match->away->id]['count']))
						$played_matches[$match->away->id]['count'] = 1;
					else
						$played_matches[$match->away->id]['count']++;
					$played_matches[$match->away->id][$played_matches[$match->away->id]['count']] = $match;
				}
				else
				{
					if(!isset($played_matches[$match->home->id]['count']))
						$played_matches[$match->home->id]['count'] = 1;
					else
						$played_matches[$match->home->id]['count']++;
					$played_matches[$match->home->id][$played_matches[$match->home->id]['count']] = $match;
				}
			}

			$view = View::factory('admin/line_matches');
			$view->line = $line;
			$view->played_matches = $played_matches;

			$this->template->title = __('Матчи');
			$this->template->content = $view;
			$this->template->breadcrumb = HTML::anchor('admin', 'Админка')." > ".
				HTML::anchor('admin/tournament', 'Управление турнирами')." > ".
				HTML::anchor('admin/tournament/view/'.$line->table->id, 'Турнир '.$line->table->name)." > ".
				HTML::anchor('admin/tournament/line_view/'.$line->id, 'Команда '.$line->club->name)." > ";
		}

		public function action_line_new_tech_lose($home_id, $away_id)
		{
			/** @var $line Model_Line */
			/** @var $home Model_Line */
			$line = $home = Jelly::select('line', $home_id);
			/** @var $away Model_Line */
			$away = Jelly::select('line', $away_id);
			/** @var $comment Model_Comment */
			$comment = Jelly::factory('comment');
			$errors = array();

			if($_POST)
			{
				try
				{
					$comment->set(arr::extract($_POST, array('text')));
					$comment->validate();

					/** @var $match Model_Match */
					$match = Jelly::factory('match');
					$match->home = $home;
					$match->away = $away;
					$match->home_goals = 0;
					$match->away_goals = 3;
					$match->table = $home->table;
					$match->tech = true;
					$match->save();

					if($match->table->scheduled)
					{
						/** @var $planned_match Model_Planned_Match */
						$planned_match = Jelly::select('planned_match')
							->where_open()
							->where_open()
							->where('home', '=', $match->home->id())
							->or_where('away', '=', $match->away->id())
							->where_close()
							->or_where_open()
							->where('home', '=', $match->away->id())
							->or_where('away', '=', $match->home->id())
							->or_where_close()
							->where_close()
							->and_where('table', '=', $match->table->id)
							->and_where('played', '=', false)
							->limit(1)
							->execute();

						$planned_match->played = true;
						$planned_match->match = $match;
						$planned_match->save();
					}

					$match->commit();

					$comment->text = "Техническое поражение.<br/>Причина:<br/>" . $comment->text;
					$comment->match = $match;
					$comment->author = $this->user;
					$comment->save();

					MISC::set_apply_message('Техническое поражение засчитано');
					Request::instance()->redirect('admin/tournament/line_matches/'.$line->id);
				}
				catch (Validate_Exception $exp) {
					$errors = $exp->array->errors('new_tech_lose');
				}
			}

			$view = View::factory('admin/line_new_tech_lose');
			$view->home = $home;
			$view->away = $away;
			$view->comment = $comment;
			$view->errors = $errors;

			$this->template->title = __('Назначение технического поражения');
			$this->template->content = $view;
			$this->template->breadcrumb = HTML::anchor('admin', 'Админка')." > ".
				HTML::anchor('admin/tournament', 'Управление турнирами')." > ".
				HTML::anchor('admin/tournament/view/'.$line->table->id, 'Турнир '.$line->table->name)." > ".
				HTML::anchor('admin/tournament/line_view/'.$line->id, 'Команда '.$line->club->name)." > ".
				HTML::anchor('admin/tournament/line_matches/'.$line->club->id, 'Матчи ') .' > ';
		}

		public function action_line_delete_force($line_id)
		{
			/** @var $line Model_Line */
			$line = Jelly::select('line', $line_id);

			if( ! $line->loaded())
				throw new Kohana_Request_Exception('Страница не найдена', array($line_id), 404);

			if($_POST)
			{
				$matches = Jelly::select('match')
					->line($line->id)
					->execute();

				/** @var $match Model_Match */
				foreach($matches as $match)
				{
					$match->as_array();
					$match->rollback();
					$match->delete();
				}

				$planned_matches = Jelly::select('planned_match')
					->line($line->id)
					->execute();

				/** @var $match Model_Planned_Match */
				foreach ($planned_matches as $match)
				{
					$match->delete();
				}

				$table_id = $line->table->id;
				$line->delete();
				MISC::set_apply_message('Команда успешно выпилена из турнира. Все результаты игр анулированы');
				Request::instance()->redirect('admin/tournament/view/'.$table_id);
			}

			$view = View::factory('admin/line_delete_force');
			$view->line = $line;

			$this->template->title = __("Полное удаление команды из турнира");
			$this->template->content = $view;
			$this->template->breadcrumb = HTML::anchor('admin', 'Админка')." > ".
				HTML::anchor('admin/tournament', 'Управление турнирами')." > ".
				HTML::anchor('admin/tournament/view/'.$line->table->id, 'Турнир '.$line->table->name)." > ".
				HTML::anchor('admin/tournament/line_view/'.$line->id, 'Команда '.$line->club->name)." > ";
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

		public function action_make_schedule($table_id)
		{
			/** @var $table Model_Table */
			$table = Jelly::select('table', $table_id);
			if( ! $table->scheduled)
			{
				MISC::set_error_message('Этот турнир проводиться без расписания');
				$this->request->redirect('admin/tournament/view/'.$table->id);
			}
			if(Jelly::select('planned_matches')->where('table_id', '=', $table->id)->count())
			{
				MISC::set_error_message('Расписание для этого турнира уже существует');
				$this->request->redirect('admin/tournament/view/'.$table->id);
			}

			$table->make_schedule(TRUE);

			MISC::set_apply_message('Расписание успешно сгенерированно');
			$this->request->redirect('admin/tournament/view/'.$table->id);
		}

		public function action_open_tours($table_id, $tour)
		{

			/** @var $table Model_Table */
			$table = Jelly::select('table', $table_id);
			if( ! $table->scheduled)
			{
				MISC::set_error_message('Этот турнир проводиться без расписания');
				$this->request->redirect('admin/tournament/view/'.$table->id);
			}

			if(Validate::numeric($tour))
			{
				Jelly::update('planned_match')
					->where('table', '=', $table->id)
					->where('round', '<=', $tour)
					->set(array('available' => true))
					->execute();

				MISC::set_apply_message("Туры по $tour помечены как активные");
			}
			else
			{
				MISC::set_error_message('Номер тура должен быть числом');
			}

			$this->request->redirect('admin/tournament/view/'.$table->id);
		}

		public function action_active_match($match)
		{
			/** @var $match Model_Planned_Match */
			$match = Jelly::select('planned_match', $match);
			if($match->loaded())
			{
				if( ! $match->available AND ! $match->played)
				{
					$match->available = true;
					$match->save();

					MISC::set_apply_message('Матч активирован');
				}
				else
				{
					MISC::set_error_message('Матч уже активирован или сыгран');
				}

				$this->request->redirect('tournament/schedule/'.$match->table->id);
			}
			else
			{
				MISC::set_error_message('Матч не существует');

				$this->request->redirect('tournament');
			}
		}

		public function action_deactivate_match($match)
		{
			/** @var $match Model_Planned_Match */
			$match = Jelly::select('planned_match', $match);
			if($match->loaded())
			{
				if($match->available AND ! $match->played)
				{
					$match->available = false;
					$match->save();

					MISC::set_apply_message('Матч деактивирован');
				}
				else
				{
					MISC::set_error_message('Матч уже деактивирован или сыгран');
				}

				$this->request->redirect('tournament/schedule/'.$match->table->id);
			}
			else
			{
				MISC::set_error_message('Матч не существует');

				$this->request->redirect('tournament');
			}
		}
	}