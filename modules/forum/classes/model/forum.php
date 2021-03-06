<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Forum extends Jelly_Model
{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->sorting(array('weight' => 'asc'))
			->load_with(array('role'))
			->fields(array(
				'id' => new Field_Primary,
				'name' => new Field_String(array(
					'rules' => array(
						'not_empty' => array(TRUE),
					),
				)),
				'description' => new Field_Wysiwyg,
				'role' => new Field_BelongsTo,
				'section' => new Field_BelongsTo,
				'weight' => new Field_Integer(array(
					'default' => 0,
				)),
				'count_topics' => new Field_Integer(array(
					'default' => 0,
				)),
				'count_posts' => new Field_Integer(array(
					'default' => 0,
				)),
				'topics' => new Field_HasMany,
			));
	}
}
