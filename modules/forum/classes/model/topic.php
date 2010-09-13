<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Topic extends Jelly_Model
{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->sorting(array('date' => 'desc'))
			->fields(array(
				'id' => new Field_Primary,
				'title' => new Field_String(array(
					'rules' => array(
						'required' => array(TRUE),
					),
				)),
				'description' => new Field_String,
				'count_posts' => new Field_Integer(array(
					'default' => 0,
				)),
				'count_views' => new Field_Integer(array(
					'default' => 0,
				)),
				'date' => new Field_Integer(array(
					'default' => time(),
				)),
				'author' => new Field_BelongsTo(array(
					'column' => 'author_id',
					'foreign' => 'users.id',
				)),
				'forum' => new Field_BelongsTo,
			));
	}
}
