<?php defined('SYSPATH') OR die('No direct access allowed.');

	class Model_Builder_Match extends Jelly_Builder
	{
		public function line($value)
		{
			return $this->where_open()
					->where("home_id", "=", $value)
					->or_where("away_id", "=", $value)
					->where_close();
		}
	}