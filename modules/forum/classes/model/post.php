<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Post extends Jelly_Model
{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->sorting(array('date' => 'desc'))
			->fields(array(
				'id' => new Field_Primary,
				'title' => new Field_String,
				'text' => new Field_Wysiwyg(array(
					'rules' => array(
						'required' => array(TRUE)
					),
				)),
				'date' => new Field_Integer(array(
					'default' => time(),
				)),
				'topic' => new Field_BelongsTo,
				'author' => new Field_BelongsTo(array(
					'column' => 'author_id',
					'foreign' => 'users.id',
				)),
			));
	}
}
