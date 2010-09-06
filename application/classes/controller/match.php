<?php defined('SYSPATH') OR die('No direct access allowed.');

	class Controller_Match extends Controller_Template
	{
		public $template = 'fifa';
		
		public function before()
		{
			$this->auth = Auth::instance();
			$this->auth->logged_in();
			$this->user = $this->auth->get_user();

			return parent::before();
		}

		public function action_index()
		{
			$this->action_list();
		}

		public function action_list($tableid = NULL)
		{
			$tournament = Jelly::select('table', $tableid);
			
			if($tableid == NULL)
			{
				$count = Jelly::select('match')->count();
				$tournament = Jelly::factory('table');
			}
			else
			{
				$count = Jelly::select('match')
						->where('table_id', '=', $tableid)
						->count();
				$tournament = Jelly::select('table', $tableid);
			}

			$pagination = Pagination::factory(array(
				'total_items' => $count,
			));

			$matches = Jelly::select('match')
					->with('home')
					->with('away')
					->with('table')
					->offset($pagination->offset)
					->limit($pagination->items_per_page)
					->execute();

			$view = new View('matches_list');
			$view->matches = $matches;
			$view->tourn = $tournament;
			$view->pagination = $pagination;
			$view->user = $this->user;

			if($tournament->loaded())
			{
				$this->template->title = __('Матчи');
				$this->template->breadcrumb = HTML::anchor('', 'Главная')." > "
						.HTML::anchor('tournament/view/'.$tournament->id, 'Турнир: '.$tournament->name)." > ";
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
				Request::instance()->redirect('/');
			}
			if(!Jelly::select('line')->where('user_id', "=", $this->user->id)->and_where("table_id", "=", $tourn)->count())
			{
				Request::instance()->redirect('/');
			}
			
			$tournament = Jelly::select('table', $tourn);
			$myline = Jelly::select('line')
					->where('table_id', "=", $tournament->id)
					->and_where("user_id", "=", $this->user->id)
					->limit(1)
					->execute();
			$match = Jelly::factory('match');
			$comment = Jelly::factory('comment');
			$errors = array();
			$my_players = $myline->club->players->as_array('id', 'last_name');

			foreach ($myline->club->players as $player)
			{

			}
			
			if($_POST)
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

						Request::instance()->redirect('match/view/'.$match->id);
					}
					else
					{
						$errors[] = __('Количество забитых мячей не соответствует указанным бомбардирам');
					}
				}
				catch (Validate_Exception $exp)
				{
					$errors = $exp->array->errors('match');
				}
			}

			// Клубы с которыми не сыграны все матчи в турнире
			$clubs = array();
			$max_matches = $tournament->matches;
			$matches = Jelly::select('match')
					->where("table_id", "=", $tournament->id)
					->where_open()->where("home_id", "=", $myline->id)
					->or_where("away_id", "=", $myline->id)
					->where_close()
					->execute();
			$skip_lines = array($myline->id);
			$count_matches_tmp = array();
			foreach ($matches as $mmatch)
			{
				if($mmatch->home_id == $myline->id)
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

			$lines = Jelly::select('line')->with('club')->where("id", "NOT IN", $skip_lines)->and_where('table_id', "=", $tournament->id)->execute();
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
					.HTML::anchor('tournament/view/'.$tournament->id, 'Турнир: '.$tournament->name)." > ";
		}

		public function action_get_away_club_players($cid)
		{
			if($cid == "NULL")
				exit;

			$this->auto_render = FALSE;

			$players = Jelly::select('player')->where("club_id", "=", $cid)->execute();
			$view = new View('match_away_club_players');
			$view->players = $players->as_array('id', 'last_name');

			echo $view;
		}

		public function action_view($mid)
		{
			$match = Jelly::select('match')
					->with('home')
					->with('away')
					->with('table')
					->where("id", "=", $mid)
					->limit(1)
					->execute();
			
			$home_goals = Jelly::select('goal')
					->where("match_id", "=", $match->id)
					->where("line_id", "=", $match->home->id)
					->execute();
			$away_goals = Jelly::select('goal')
					->where("match_id", "=", $match->id)
					->where("line_id", "=", $match->away->id)
					->execute();
			$comments = Jelly::select('comment')
					->where("match_id", "=", $match->id)
					->execute();

			$view = new View("match_view");
			$view->home_goals = $home_goals;
			$view->away_goals = $away_goals;
			$view->match = $match;
			$view->comments = $comments;

			$this->template->title = __('Просмотр матча');
			$this->template->content = $view;
			$this->template->breadcrumb = HTML::anchor('', 'Главная')." > "
					.HTML::anchor('tournament/view/'.$match->table->id, 'Турнир: '.$match->table->name)." > ";
		}

		public function action_confirm($mid)
		{
			$match = Jelly::select('match')
					->with('home')
					->with('away')
					->with('table')
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
				Request::instance()->redirect('match/view/'.$match->id);
			}

			$home_goals = Jelly::select('goal')->where("match_id", "=", $match->id)->where("line_id", "=", $match->home->id)->execute();
			$away_goals = Jelly::select('goal')->where("match_id", "=", $match->id)->where("line_id", "=", $match->away->id)->execute();

			$view = new View('match_confirm');
			$view->match = $match;
			$view->home_goals = $home_goals;
			$view->away_goals = $away_goals;
			$view->comment = $comment;

			$this->template->title = __('Подтверждение результата матча');
			$this->template->content = $view;
			$this->template->breadcrumb = HTML::anchor('', 'Главная')." > "
					.HTML::anchor('tournament/view/'.$match->table->id, 'Турнир: '.$match->table->name)." > ";
		}

		public function action_my()
		{
			if(!$this->auth->logged_in('coach'))
				throw new Kohana_Exception ("permitdenided");

			$uncmatches = Jelly::select('match')
					->with('home')
					->with('away')
					->with('table')
					->where('away.user_id', "=", $this->user->id)
					->where("confirm", "=", 0)
					->execute();
			$uncymatches = Jelly::select('match')
					->with('home')
					->with('away')
					->with('table')
					->where('home.user_id', "=", $this->user->id)
					->where("confirm", "=", 0)
					->execute();
			$matches = Jelly::select('match')
					->with('home')->with('away')
					->with('table')
					->where_open()
					->where('home.user_id', "=", $this->user->id)
					->or_where("away.user_id", "=", $this->user->id)
					->where_close()
					->where("confirm", "=", 1)
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
			$match = Jelly::select('match', $mid);
			if($match->home->user->id != $this->user->id)
			{
				MISC::set_error_message(__("Вы не можете удалить матч, который вносили не вы"));
				Request::instance()->redirect('match/my');
			}
			if($match->confirm == TRUE)
			{
				MISC::set_error_message(__("Невозможно удалить матч, так как он уже подтверждён"));
				Request::instance()->redirect('match/my');
			}
		}
	}