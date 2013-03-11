<?php defined('SYSPATH') OR die('No direct access allowed.');

	class Model_Builder_Planned_Match extends Jelly_Builder
	{
		public function line($value)
		{
			return $this->where_open()
					->where("home", "=", $value)
					->or_where("away", "=", $value)
					->where_close();
		}
		
		public function tournament($tournament_id)
		{
			return $this->where("table", "=", $tournament_id);
		}

		public function available()
		{
			return $this->where('available', '=', true);
		}
	}