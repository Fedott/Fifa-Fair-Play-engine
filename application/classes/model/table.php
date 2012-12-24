<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Table extends Jelly_Model
{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->fields(array(
			'id' => new Jelly_Field_Primary,
			'name' => new Jelly_Field_String(array(
				'rules' => array(
					array('not_empty'),
				),
			)),
			'url' => new Jelly_Field_String(array(
				'unique' => TRUE,
			)),
			'type' => new Jelly_Field_Enum(array(
				'choices' => array('friendly', 'official'),
			)),
			'season' => new Jelly_Field_Integer,
			'active' => new Jelly_Field_Boolean(array(
				'default' => FALSE,
			)),
			'visible' => new Jelly_Field_Boolean(array(
				'default' => FALSE,
			)),
			'ended' => new Jelly_Field_Boolean(array(
				'default' => FALSE,
			)),
			'lines' => new Jelly_Field_HasMany,
			'matches' => new Jelly_Field_Integer(array(
				'default' => 2,
			)),
		));
	}
}