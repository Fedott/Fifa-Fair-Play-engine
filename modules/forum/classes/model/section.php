<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Section extends Jelly_Model
{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->sorting(array('weight' => 'asc'))
			->fields(array(
				'id' => new Field_Primary,
				'name' => new Field_String(array(
					'rules' => array(
						'not_empty' => array(TRUE),
					),
				)),
				'weight' => new Field_Integer(array(
					'default' => 0,
				)),
				'forums' => new Field_HasMany,
			));
	}
}
