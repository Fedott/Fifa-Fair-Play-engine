<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Class Model_Table
 * @property $id
 * @property $name
 * @property $url
 * @property $type
 * @property $season
 * @property $active
 * @property $visible
 * @property $ended
 * @property Jelly_Collection $lines
 * @property $matches
 */
class Model_Table extends Jelly_Model
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
			'url' => new Field_String(array(
				'unique' => TRUE,
			)),
			'type' => new Field_Enum(array(
				'choices' => array('friendly', 'official'),
			)),
			'season' => new Field_Integer,
			'active' => new Field_Boolean(array(
				'default' => FALSE,
			)),
			'visible' => new Field_Boolean(array(
				'default' => FALSE,
			)),
			'ended' => new Field_Boolean(array(
				'default' => FALSE,
			)),
			'lines' => new Field_HasMany,
			'matches' => new Field_Integer(array(
				'default' => 2,
			)),
		));
	}
}