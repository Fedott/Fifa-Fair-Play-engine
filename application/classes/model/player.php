<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Player extends Jelly_Model
{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->fields(array(
			'id' => new Field_Primary,
			'first_name' => new Field_String,
			'last_name' => new Field_String(array(
				'rules' => array(
					'not_empty' => array(TRUE),
				),
			)),
			'club' => new Field_BelongsTo,
			'year_of_birth' => new Field_Integer,
		));
	}
}