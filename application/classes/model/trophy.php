<?php defined('SYSPATH') OR die('No direct access allowed.');

	class Model_Trophy extends Jelly_Model
	{
		public function initialize(Jelly_Meta $meta)
		{
			$meta->fields(array(
				'id' => new Field_Primary,
				
			));
		}
	}