<?php defined('SYSPATH') OR die('No direct access allowed.');

	class Controller_Match extends Controller_Template
	{
		public function action_index()
		{
			$this->action_list();
		}

		public function action_list($tableid = NULL)
		{	
			if($tableid == NULL)
			{
				$count = Jelly::query('match')->count();
				$tournament = Jelly::factory('table');
			}
			else
			{
				$tournament = Jelly::query('table', $tableid)->execute();
				$count = Jelly::query('match')
						->tournament($tournament->id)
						->count();
			}

			$pagination = Pagination::factory(array(
				'total_items' => $count,
			));

			if($tournament->loaded())
			{
				$matches = Jelly::query('match')
						->tournament($tournament->id)
						->offset($pagination->offset)
						->limit($pagination->items_per_page)
						->execute();
			}
			else
			{
				$matches = Jelly::query('match')
						->offset($pagination->offset)
						->limit($pagination->items_per_page)
						->execute();
			}

			// Для оптимизации за счёт уменьшения количества запросов выбираем
			// клубы сейчас, чтобы потом дёргать их из массива
			// Так же делаем с комментами
			$clubs_like = array();
			$clubs_arr = array();
			$matches_ids = array();
			$comments_arr = array();
			foreach($matches as $match)
			{
				$clubs_like[$match->home->club_id()] = $match->home->club_id();
				$clubs_like[$match->away->club_id()] = $match->away->club_id();
				$matches_ids[] = $match->id;
			}

			if(count($clubs_like))
			{
				$clubs = Jelly::query('club')
						->where("id", "IN", $clubs_like)
						->execute();
				foreach($clubs as $club)
				{
					$clubs_arr[$club->id] = $club;
				}
			}
			
			if(count($matches_ids))
			{
				$comments = Jelly::query('comment')
						->where('match_id', 'IN', $matches_ids)
						->execute();
				foreach($comments as $comment)
				{
					$comments_arr[$comment->match_id()][] = $comment;
				}
			}

			$view = new View('matches_list');
			$view->matches = $matches;
			$view->tourn = $tournament;
			$view->pagination = $pagination;
			$view->user = $this->user;
			$view->clubs_arr = $clubs_arr;
			$view->comments_arr = $comments_arr;

			if($tournament->loaded())
			{
				$this->template->title = __('Матчи');
				$this->template->breadcrumb = HTML::anchor('', 'Главная')." > "
						.HTML::anchor('tournament', "Турниры")." > "
						.HTML::anchor('tournament/view/'.$tournament->id, $tournament->name)." > ";
			}
			else
			{
				$this->template->title = __('Все матчи');
				$this->template->breadcrumb = HTML::anchor('', 'Главная')." > ";
			}
			$this->template->content = $view;
		}

		public function action_reg($tourn)
		{
			if(!$this->auth->logged_in('coach'))
			{
				MISC::set_error_message(__("У вас нет прав тренера"));
				Request::current()->redirect('');
			}
			if(!Jelly::query('line')->where('user_id', "=", $this->user->id)->and_where("table_id", "=", $tourn)->count())
			{
				MISC::set_error_message(__("Вы не являетесь тренером команды в этом турнире"));
				Request::current()->redirect('');
			}
			
			$tournament = Jelly::query('table', $tourn)->execute();
			// Проверяем активность и не законченность турнира
			if($tournament->ended)
			{
				MISC::set_error_message(__("Регистрация матчей в турнире, :name, завершена. Турнир закончен.", array(':name' => $tournament->name)));
				Request::current()->redirect('tournament/view/'.$tournament->id);
			}
			if( ! $tournament->active)
			{
				MISC::set_error_message(__("Турнир, :name, в данный момент не активен", array(':name' => $tournament->name)));
				Request::current()->redirect('tournament/view/'.$tournament->id);
			}

			$myline = Jelly::query('line')
					->where('table_id', "=", $tournament->id)
					->and_where("user_id", "=", $this->user->id)
					->limit(1)
					->execute();
			$match = Jelly::factory('match');
			$comment = Jelly::factory('comment');
			$errors = array();
			$my_players = array();
			$mplayers = Jelly::query('player')
					->order_by_goals($myline->club->id)
					->execute();
			
			foreach($mplayers as $my_player)
			{
				$my_players[$my_player->id] = $my_player->player_name(true, true);
			}
			$my_players[0] = __("Автогол");
			
			if($_POST AND MISC::not_duplicate_send('register_match'))
			{
				try
				{
					$match->set(arr::extract($_POST, array('away', 'home_goals', 'away_goals')));
					$match->date = time();
					$match->table = $tournament->id;
					$match->home = $myline->id;

					$away_goals = array();
					$away_goals_count = 0;
					$home_goals = array();
					$home_goals_count = 0;
					foreach($_POST['goals_h'] as $goal)
					{
						if(!empty($goal[1]))
						{
							$home_goals[] = Jelly::factory('goal', array(
								'player' => $goal[0],
								'count' => $goal[1],
								'table' => $tournament->id,
								'line' => $match->home->id,
							));
							$home_goals_count += $goal[1];
						}
					}
					foreach($_POST['goals_a'] as $goal)
					{
						if(!empty($goal[1]))
						{
							$away_goals[] = Jelly::factory('goal', array(
								'player' => $goal[0],
								'count' => $goal[1],
								'table' => $tournament->id,
								'line' => $match->away->id,
							));
							$away_goals_count += $goal[1];
						}
					}

					if(!empty($_POST['text']))
					{
						$comment->text = $_POST['text'];
						$comment->date = time();
						$comment->author = $this->user->id;
					}

					if($match->home_goals == $home_goals_count AND $match->away_goals == $away_goals_count)
					{
						MISC::duplicate_send_time_set('register_match');
						$match->save();
						foreach($home_goals as $goal)
						{
							$goal->match = $match->id;
							$goal->save();
						}
						foreach($away_goals as $goal)
						{
							$goal->match = $match->id;
							$goal->save();
						}
						if(!empty($_POST['text']))
						{
							$comment->match = $match->id;
							$comment->save();
						}

						Request::current()->redirect('match/view/'.$match->id);
					}
					else
					{
						$errors[] = __('Количество забитых мячей не соответствует указанным бомбардирам');
					}
				}
				catch (Jelly_Validation_Exception $exp)
				{
					$errors = $exp->errors();
				}
			}
			elseif ( ! MISC::not_duplicate_send('register_match'))
			{
				$last_match = Jelly::query('match')
						->where('table_id', '=', $tournament->id)
						->where('home_id', '=', $myline->id)
						->limit(1)
						->execute();

				Request::current()->redirect('match/view/'.$last_match->id);
			}

			// Клубы с которыми не сыграны все матчи в турнире
			$clubs = array();
			$max_matches = $tournament->matches;
			$matches = Jelly::query('match')
					->where("matches.table_id", "=", $tournament->id)
					->where_open()
					->where("home_id", "=", $myline->id)
					->or_where("away_id", "=", $myline->id)
					->where_close()
					->execute();
			$skip_lines = array($myline->id);
			$count_matches_tmp = array();
			foreach ($matches as $mmatch)
			{
				if($mmatch->home->id == $myline->id)
				{
					if(isset($count_matches_tmp[$mmatch->away->id]))
					{
						$count_matches_tmp[$mmatch->away->id]++;
						if($count_matches_tmp[$mmatch->away->id] == $max_matches)
						{
							$skip_lines[] = $mmatch->away->id;
						}
					}
					else
						$count_matches_tmp[$mmatch->away->id] = 1;
				}
				else
				{
					if(isset($count_matches_tmp[$mmatch->home->id]))
					{
						$count_matches_tmp[$mmatch->home->id]++;
						if($count_matches_tmp[$mmatch->home->id] == $max_matches)
						{
							$skip_lines[] = $mmatch->home->id;
						}
					}
					else
						$count_matches_tmp[$mmatch->home->id] = 1;
				}
			}

			$lines = Jelly::query('line')->where("id", "NOT IN", $skip_lines)->and_where('table_id', "=", $tournament->id)->execute();
			$clubs = array('NULL' => 'Выберете команду соперника');
			foreach($lines as $line)
			{
				$clubs[$line->id] = $line->club->name." ({$line->user->username})";
			}

			$view = new View('match_reg');
			$view->match = $match;
			$view->errors = $errors;
			$view->comment = $comment;
			$view->my_players = $my_players;
			$view->clubs = $clubs;

			$this->template->title = __('Регистрация матча');
			$this->template->content = $view;
			$this->template->breadcrumb = HTML::anchor('', 'Главная')." > "
					.HTML::anchor('tournament', "Турниры")." > "
					.HTML::anchor('tournament/view/'.$tournament->id, $tournament->name)." > ";
		}

		public function action_get_away_club_players($line_id)
		{
			if($line_id == "NULL")
				exit;

			$line = Jelly::query('line', $line_id)->execute();

			$this->auto_render = FALSE;

			$players = Jelly::query('player')
					->order_by_goals($line->club->id)
					->execute();
			$players_arr = array();
			foreach($players as $player)
			{
				$players_arr[$player->id] = $player->player_name(true, true);
			}
			$players_arr[0] = __("Автогол");

			$view = new View('match_away_club_players');
			$view->players = $players_arr;

			echo $view;
		}

		public function action_view($mid)
		{
			$match = Jelly::query('match')
					->where("id", "=", $mid)
					->limit(1)
					->execute();
			
			$home_goals = Jelly::query('goal')
					->where("match_id", "=", $match->id)
					->where("line_id", "=", $match->home->id)
					->execute();
			$away_goals = Jelly::query('goal')
					->where("match_id", "=", $match->id)
					->where("line_id", "=", $match->away->id)
					->execute();
			$comments = Jelly::query('comment')
					->where("match_id", "=", $match->id)
					->execute();
			
			$comments_array = array();
			foreach($comments as $comment)
			{
				$comments_array[] = array(
					'avatar_url' => url::site($comment->author->get_avatar()),
					'username'   => $comment->author->username,
					'date'       => misc::get_human_date($comment->date),
					'text'       => $comment->text,
				);
			}

			$view = new View("match_view");
			$view->home_goals = $home_goals;
			$view->away_goals = $away_goals;
			$view->match = $match;
			$view->comments = $comments_array;

			$this->template->title = __('Просмотр матча');
			$this->template->content = $view;
			$this->template->breadcrumb = HTML::anchor('', 'Главная')." > "
					.HTML::anchor('tournament', __('Турниры'))." > "
					.HTML::anchor('tournament/view/'.$match->table->id, $match->table->name)." > ";
		}

		public function action_confirm($mid)
		{
			$match = Jelly::query('match')
					->where("id", "=", $mid)
					->limit(1)
					->execute();

			if($match->away->user->id != $this->user->id)
			{
				echo "Ошибка сообщите Администратору";
				exit;
			}

			$comment = Jelly::factory('comment');

			if($_POST)
			{
				if(isset($_POST['text']) AND !empty($_POST['text']))
				{
					$comment->text = $_POST['text'];
					$comment->author = $this->user->id;
					$comment->match = $match->id;
					$comment->save();
				}

				$home = $match->home;
				$away = $match->away;
				$home->goals += $match->home_goals;
				$away->goals += $match->away_goals;
				$home->passed_goals += $match->away_goals;
				$away->passed_goals += $match->home_goals;
				if($match->home_goals == $match->away_goals)
				{
					$home->points += 1;
					$away->points += 1;
					$home->drawn++;
					$away->drawn++;
				}
				elseif ($match->home_goals > $match->away_goals)
				{
					$home->points += 3;
					$home->win++;
					$away->lose++;
				}
				elseif ($match->home_goals < $match->away_goals)
				{
					$away->points += 3;
					$home->lose++;
					$away->win++;
				}
				$home->games++;
				$away->games++;
				$home->save();
				$away->save();
				$match->confirm = 1;
				$match->save();
				Request::current()->redirect('match/view/'.$match->id);
			}

			$home_goals = Jelly::query('goal')->where("match_id", "=", $match->id)->where("line_id", "=", $match->home->id)->execute();
			$away_goals = Jelly::query('goal')->where("match_id", "=", $match->id)->where("line_id", "=", $match->away->id)->execute();

			$view = new View('match_confirm');
			$view->match = $match;
			$view->home_goals = $home_goals;
			$view->away_goals = $away_goals;
			$view->comment = $comment;

			$this->template->title = __('Подтверждение результата матча');
			$this->template->content = $view;
			$this->template->breadcrumb = HTML::anchor('', 'Главная')." > "
					.HTML::anchor('tournament', __('Турниры'))." > "
					.HTML::anchor('tournament/view/'.$match->table->id, $match->table->name)." > ";
		}

		public function action_my()
		{
			if(!$this->auth->logged_in('coach'))
				throw new Kohana_Exception ("permitdenided");

			$uncmatches = Jelly::query('match')
					->where('away.user_id', "=", $this->user->id)
					->where("confirm", "=", 0)
					->execute();
			$uncymatches = Jelly::query('match')
					->where('home.user_id', "=", $this->user->id)
					->where("confirm", "=", 0)
					->execute();
			$matches = Jelly::query('match')
					->where_open()
					->where('home.user_id', "=", $this->user->id)
					->or_where("away.user_id", "=", $this->user->id)
					->where_close()
					->where("confirm", "=", 1)
					->where("table.visible", "=", 1)
					->execute();

			$view = new View('match_my');
			$view->uncmatches = $uncmatches;
			$view->uncymatches = $uncymatches;
			$view->matches = $matches;

			$this->template->title = "Ваши матчи";
			$this->template->content = $view;
			$this->template->breadcrumb = HTML::anchor('', 'Главная')." > ";
		}

		public function action_delete($mid)
		{
			$match = Jelly::query('match', $mid)->execute();
			if($match->home->user->id != $this->user->id)
			{
				MISC::set_error_message(__("Вы не можете удалить матч, который вносили не вы"));
				Request::current()->redirect('match/my');
			}
			if($match->confirm == TRUE)
			{
				MISC::set_error_message(__("Невозможно удалить матч, так как он уже подтверждён"));
				Request::current()->redirect('match/my');
			}

			$match->delete();
			MISC::set_apply_message(__("Матч успешно удалён"));
			Request::current()->redirect('match/my');
		}
	}