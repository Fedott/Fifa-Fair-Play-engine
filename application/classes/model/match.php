<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Match extends Jelly_Model
{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->fields(array(
			'id' => new Field_Primary,
			'date' => new Field_Timestamp,
			'table' => new Field_BelongsTo(),
			'home' => new Field_BelongsTo(array(
				'column' => 'home_id',
				'foreigh' => 'line.id',
			)),
			'away' => new Field_BelongsTo(array(
				'column' => 'away_id',
				'foreigh' => 'line.id',
			)),
			'home_goals' => new Field_Integer(array(
				'rules' => array(
					'not_empty' => array(TRUE),
				)
			)),
			'away_goals' => new Field_Integer(array(
				'rules' => array(
					'not_empty' => array(TRUE),
				)
			)),
			'confirm' => new Field_Boolean(array(
				'default' => 0,
			)),
		));
	}
}