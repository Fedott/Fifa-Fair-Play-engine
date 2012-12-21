<?php

/**
 * @author fedot
 *
 * @property Request $request
 * @property View $template
 */
class Controller_Pro_Club extends Controller_Template
{
	public function action_index()
	{
		
	}

	public function action_stats()
	{
		$start = $this->request->param('start_date', date('d-m-Y', strtotime('monday previous week')));
		$end = $this->request->param('end_date', date('d-m-Y', strtotime("monday this week")));

		$pro_players = Jelly::query("pro_player")
				->where('date', '<=', strtotime($end))
				->and_where('date', '>=', strtotime($start))
				->execute();

		$start_values = array();
		$end_values = array();
		foreach ($pro_players as $pro_player)
		{
			/** @var $pro_player Model_Pro_Player */
			if( ! isset($start_values[$pro_player->nick]))
			{
				$start_values[$pro_player->nick] = $pro_player->as_array();
			}
			else
			{
				$end_values[$pro_player->nick] = $pro_player;
			}
		}

		$view = View::factory('pro/stats');
		$view->start_values = $start_values;
		$view->end_values = $end_values;
		$view->start_day = $start;
		$view->end_day = $end;

		$this->template->title = "Статистика клуба FifaFairPlay";
		$this->template->content = $view;
	}
}
