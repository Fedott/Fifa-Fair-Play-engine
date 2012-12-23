<?php

class Model_Builder_Player extends Jelly_Builder
{
	public function order_by_goals($club_id)
	{
		return $this->select_column("*")
			->select_column('SUM("goals.count")', 'goals_count')
			->where('player.club:foreign_key', '=', $club_id)
			->order_by('goals_count', 'DESC')
			->order_by('last_name')
			->join('goals', 'LEFT OUTER')->on('player:primary_key', '=', 'goals.player_id')
			->group_by('players.id');
	}
}
