<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Goal extends Jelly_Model
{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->load_with(array('player'))
			->fields(array(
				'id' => new Jelly_Field_Primary,
				'match' => new Jelly_Field_BelongsTo,
				'player' => new Jelly_Field_BelongsTo,
				'table' => new Jelly_Field_BelongsTo,
				'line' => new Jelly_Field_BelongsTo,
				'count' => new Jelly_Field_Integer,
			));
	}
}