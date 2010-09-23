<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Topic extends Jelly_Model
{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->sorting(array('date' => 'desc'))
			->load_with(array('role'))
			->fields(array(
				'id' => new Field_Primary,
				'title' => new Field_String(array(
					'rules' => array(
						'not_empty' => array(TRUE),
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
				'posts' => new Field_HasMany,
			));
	}

	public function views_increment()
	{
		$this->count_views++;
		return $this->save();
	}

	public function date()
	{
		if($this->loaded())
			return MISC::get_human_date ($this->date);
		else
			return NULL;
	}
}
