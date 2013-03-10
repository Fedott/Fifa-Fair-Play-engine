<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * @property $id
 * @property Model_Table $table
 * @property Model_Line $home
 * @property Model_Line $away
 * @property $home_goals
 * @property $away_goals
 * @property $round
 * @property $available
 * @property $available_after
 * @property $played
 * @property Model_Match $match
 */
class Model_Planned_Match extends Jelly_Model
{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->load_with(array('table', 'home', 'away', 'match'))
			->fields(array(
				'id' => new Field_Primary,
				'table' => new Field_BelongsTo,
				'home' => new Field_BelongsTo(array(
					'column' => 'home_id',
					'foreign' => 'line.id',
				)),
				'away' => new Field_BelongsTo(array(
					'column' => 'away_id',
					'foreign' => 'line.id',
				)),
				'round' => Jelly::field('integer'),
				'available' => Jelly::field('boolean', array(
					'default' => false,
				)),
				'available_after' => Jelly::field('integer'),
				'played' => Jelly::field('boolean', array(
					'default' => FALSE,
				)),
				'match' => Jelly::field('belongsto'),
			));
	}
}
