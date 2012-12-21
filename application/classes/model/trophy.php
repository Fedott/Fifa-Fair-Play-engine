<?php defined('SYSPATH') OR die('No direct access allowed.');

	class Model_Trophy extends Jelly_Model
	{
		public static function initialize(Jelly_Meta $meta)
		{
			$meta->fields(array(
				'id' => new Jelly_Field_Primary,
				'description' => new Jelly_Field_String,
				'line' => new Jelly_Field_BelongsTo,
				'user' => new Jelly_Field_BelongsTo,
				'club' => new Jelly_Field_BelongsTo,
				'table' => new Jelly_Field_BelongsTo,
				'image' => new Jelly_Field_File(array(
					'path' => 'media/trophy',
				)),
				'weight' => new Jelly_Field_Integer,
				'player' => new Jelly_Field_BelongsTo,
			));
		}
	}