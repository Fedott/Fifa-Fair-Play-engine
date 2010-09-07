<?php defined('SYSPATH') OR die('No direct access allowed.');

	class Controller_Tournament extends Controller_Template
	{
		public function action_index()
		{
			$tournaments = Jelly::select('table')->visible()->execute();
			$view = new View('tournament');
			$view->tournaments = $tournaments;

			$this->template->title = __("Все турниры");
			$this->template->content = $view;
			$this->template->breadcrumb = HTML::anchor('', 'Главная')." > ";
		}

		public function action_view($url)
		{
			$tournament = Jelly::select('table', $url);
			$my_line = Jelly::select('line')
					->where('table_id', "=", $tournament->id)
					->and_where("user_id", "=", $this->user->id)
					->limit(1)
					->execute();

			$res = DB::select_array(array('goals.player_id', 'goals.line_id'))
					->select(array('SUM("count")', 'goals'))
					->from('goals')
					->group_by('player_id')
					->limit(10)
					->order_by('goals', 'DESC')
					->where('table_id', "=", $tournament->id)
					->execute();

			$goleodors = array();
			$players_like = array();
			foreach ($res as $row)
			{
				$players_like[] = $row['player_id'];
				$goleodors[$row['player_id']] = array('player_id' => $row['player_id'], 'goals' => $row['goals'], 'line_id' => $row['line_id']);
			}

			if(!empty($players_like))
			{
				$players_goals = Jelly::select('player')
						->with('club')
						->where(":primary_key", "IN", $players_like)
						->execute();

				foreach($players_goals as $player)
				{
					$goleodors[$player->id]['player'] = $player;
				}
			}
			
			$goals = Jelly::select('goal')
					->with("player")
					->group_by("player_id")
					->where("table_id", "=", $tournament->id)->execute();

			$view = new View('tournament_view');
			$view->tournament = $tournament;
			$view->user = $this->user;
			$view->goleodors = $goleodors;
			$view->my_line = $my_line;
			$view->uchastie = (bool) $my_line->loaded();

			$this->template->title = __("Турнир: :name", array(":name" => $tournament->name));
			$this->template->content = $view;
			$this->template->breadcrumb = HTML::anchor('', 'Главная')." > "
					.HTML::anchor('tournament', "Все турниры")." > ";
		}
	}