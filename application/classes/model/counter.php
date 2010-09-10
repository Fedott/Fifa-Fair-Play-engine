<?php defined('SYSPATH') OR die('No direct access allowed.');

	class Model_Counter extends Jelly_Model
	{
		public static function initialize(Jelly_Meta $meta)
		{
			$meta->fields(array(
				'id' => new Field_Primary,
				'user' => new Field_BelongsTo,
				'comments' => new Field_Integer,
				'posts' => new Field_Integer,
				'matches' => new Field_Integer,
			));
		}
	}