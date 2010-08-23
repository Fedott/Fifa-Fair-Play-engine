<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Goal extends Jelly_Model
{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->fields(array(
			'id' => new Field_Primary,
			'match' => new Field_BelongsTo,
			'palyer' => new Field_BelongsTo,
			'table' => new Field_BelongsTo,
			'line' => new Field_BelongsTo,
			'count' => new Field_Integer,
		));
	}
}