<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Category extends Jelly_Model
{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->fields(array(
				'id' => new Field_Primary,
				'name' => new Field_String(array(
					'rules' => array(
						'not_empty' => array(TRUE),
					),
				)),
				'description' => new Field_String,
				'pages' => new Field_HasMany,
			));
	}
}