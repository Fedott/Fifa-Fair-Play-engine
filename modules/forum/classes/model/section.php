<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Section extends Jelly_Model
{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->sorting(array('weight' => 'desc'))
			->fields(array(
				'id' => new Field_Primary,
				'name' => new Field_String(array(
					'rules' => array(
						'required' => array(TRUE),
					),
				)),
				'weight' => new Field_Integer(array(
					'default' => 0,
				)),
			));
	}
}