<?php defined('SYSPATH') OR die('No direct access allowed.');

	class Model_Trophy extends Jelly_Model
	{
		public static function initialize(Jelly_Meta $meta)
		{
			$meta->fields(array(
				'id' => new Field_Primary,
				'description' => new Field_String,
				'line' => new Field_BelongsTo,
				'user' => new Field_BelongsTo,
				'club' => new Field_BelongsTo,
				'table' => new Field_BelongsTo,
				'image' => new Field_File(array(
					'path' => 'media/trophy',
				)),
				'weight' => new Field_Integer,
				'player' => new Field_BelongsTo,
			));
		}
	}