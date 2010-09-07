<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Line extends Jelly_Model
{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->sorting(array('points' => 'desc', 'win' => 'desc', 'games' => 'asc', 'goals' => 'desc', 'passed_goals' => 'asc'))
			->load_with(array('club', 'user', 'table'))
			->fields(array(
			'id' => new Field_Primary,
			'table' => new Field_BelongsTo,
			'club' => new Field_BelongsTo,
			'user' => new Field_BelongsTo,
			'games' => new Field_Integer(array(
				'default' => 0,
			)),
			'win' => new Field_Integer(array(
				'default' => 0,
			)),
			'drawn' => new Field_Integer(array(
				'default' => 0,
			)),
			'lose' => new Field_Integer(array(
				'default' => 0,
			)),
			'goals' => new Field_Integer(array(
				'default' => 0,
			)),
			'passed_goals' => new Field_Integer(array(
				'default' => 0,
			)),
			'points' => new Field_Integer(array(
				'default' => 0,
			)),
		));
	}
}