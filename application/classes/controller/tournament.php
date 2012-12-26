<?php defined('SYSPATH') OR die('No direct access allowed.');

	class Controller_Tournament extends Controller_Template
	{
		public function action_index()
		{
			$tournaments = Jelly::select('table')->visible()->execute();
			$view = new View('tournament');
			$view->tournaments = $tournaments;

			$this->template->title = __("Турниры");
			$this->template->content = $view;
			$this->template->breadcrumb = HTML::anchor('', __("Главная"))." > ";
		}

		public function action_view($url)
		{
			$tournament = Jelly::select('table', $url);
			if($this->user->loaded())
			{
				$my_line = Jelly::select('line')
						->where('table_id', "=", $tournament->id)
						->and_where("user_id", "=", $this->user->id)
						->limit(1)
						->execute();
			}
			else
				$my_line = Jelly::factory ('line');

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

			$view = new View('tournament_view');
			$view->tournament = $tournament;
			$view->user = $this->user;
			$view->goleodors = $goleodors;
			$view->my_line = $my_line;
			$view->uchastie = (bool) $my_line->loaded();

			$this->template->title = __(":name", array(":name" => $tournament->name));
			$this->template->content = $view;
			$this->template->breadcrumb = HTML::anchor('', __("Главная"))." > "
					.HTML::anchor('tournament', __("Турниры"))." > ";
		}

		public function action_club($id)
		{
			$line = Jelly::select('line', $id);

			$tournament = $line->table;
			if($this->user->loaded())
			{
				$my_line = Jelly::select('line')
						->where('table_id', "=", $tournament->id)
						->and_where("user_id", "=", $this->user->id)
						->limit(1)
						->execute();
			}
			else
				$my_line = Jelly::factory ('line');

			$res = DB::select_array(array('goals.player_id', 'goals.line_id'))
					->select(array('SUM("count")', 'goals'))
					->from('goals')
					->group_by('player_id')
					->order_by('goals', 'DESC')
					->where('table_id', "=", $tournament->id)
					->where("line_id", "=", $line->id)
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
					$player_id = (int) $player->id;
					$goleodors[$player_id]['player'] = $player;
				}
			}

			$matches = Jelly::select('match')
					->line($line->id)
					->execute();

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

			// Поскольку клубы уже загружены в линиях, мы просто пробегаемся по ним и засовываем каждый клуб в массив
			$clubs_arr = array();
			foreach($tournament->lines as $tline)
			{
				$clubs_arr[$tline->club->id] = $tline->club;
			}

			$view = new View('tournament_club_view');
			$view->matches = $matches;
			$view->line = $line;
			$view->goleodors = $goleodors;
			$view->played_matches = $played_matches;
			$view->tournament = $tournament;
			$view->user = $this->user;
			$view->my_line = $my_line;
			$view->clubs_arr = $clubs_arr;

			$this->template->title = __("Клуб: :name", array(":name" => $line->club->name));
			$this->template->content = $view;
			$this->template->breadcrumb = HTML::anchor('', __("Главная"))." > "
					.HTML::anchor('tournament', __("Турниры"))." > "
					.HTML::anchor('tournament/view/'.$tournament->url, __(":name", array(':name' => $tournament->name)))." > ";
		}
	}