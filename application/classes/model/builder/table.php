<?php defined('SYSPATH') OR die('No direct access allowed.');

	class Model_Builder_Table extends Jelly_Builder
	{
		public function unique_key($id)
		{
			if ( ! empty($id) AND is_string($id) AND ! ctype_digit($id))
			{
				return 'url';
			}
			return parent::unique_key($id);
		}

		public function visible($value = 1)
		{
			return $this->where('visible', "=", $value);
		}

		public function active($value = 1)
		{
			return $this->where('active', "=", $value);
		}

		public function ended($value = 1)
		{
			return $this->where('ended', "=", $value);
		}
	}