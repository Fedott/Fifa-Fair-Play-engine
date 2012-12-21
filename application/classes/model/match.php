<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Match extends Jelly_Model
{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->sorting(array('date' => 'desc'))
			->load_with(array('table', 'home', 'away'))
			->fields(array(
				'id' => new Jelly_Field_Primary,
				'date' => new Jelly_Field_Integer(array(
					'default' => time(),
				)),
				'table' => new Jelly_Field_BelongsTo,
				'home' => new Jelly_Field_BelongsTo(array(
					'column' => 'home_id',
					'foreign' => 'line.id',
				)),
				'away' => new Jelly_Field_BelongsTo(array(
					'column' => 'away_id',
					'foreign' => 'line.id',
				)),
				'home_goals' => new Jelly_Field_Integer,
				'away_goals' => new Jelly_Field_Integer,
				'confirm' => new Jelly_Field_Boolean(array(
					'default' => 0,
				)),
				'comments' => new Jelly_Field_HasMany(),
			));
	}
}
