<?php defined('SYSPATH') OR die('No direct access allowed.');

	class Model_Builder_Line extends Jelly_Builder
	{
		public function by_user($value)
		{
			return $this->where('user_id', "=", $value);
		}
	}