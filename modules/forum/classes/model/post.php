<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Post extends Jelly_Model
{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->sorting(array('date' => 'asc'))
			->load_with(array('author'))
			->fields(array(
				'id' => new Field_Primary,
				'title' => new Field_String,
				'text' => new Field_Wysiwyg(array(
					'rules' => array(
						'not_empty' => array(TRUE)
					),
				)),
				'date' => new Field_Integer(array(
					'default' => time(),
				)),
				'topic' => new Field_BelongsTo,
				'author' => new Field_BelongsTo(array(
					'column' => 'author_id',
					'foreign' => 'user.id',
				)),
			));
	}

	public function date()
	{
		if($this->loaded())
			return MISC::get_human_date ($this->date);
		else
			return NULL;
	}
}
