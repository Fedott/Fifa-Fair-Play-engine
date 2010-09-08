<?php defined('SYSPATH') OR die('No direct access allowed.');

	class Model_Comment extends Jelly_Model
	{
		public static function initialize(Jelly_Meta $meta)
		{
			$meta->load_with(array('author'))
				->fields(array(
					'id' => new Field_Primary,
					'text' => new Field_Text,
					'date' => new Field_Integer(array(
						'default' => time(),
					)),
					'author' => new Field_BelongsTo(array(
						'column' => 'author_id',
						'foreign' => 'user.id',
					)),
					'match' => new Field_BelongsTo,
				));
		}
	}