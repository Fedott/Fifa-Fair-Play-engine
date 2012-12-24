<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_News extends Jelly_Model
{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->load_with(array('author'))
			->sorting(array('date' => 'DESC'))
			->fields(array(
			'id' => new Jelly_Field_Primary,
			'title' => new Jelly_Field_String(array(
				'rules' => array(
					array('not_empty'),
				),
			)),
			'text' => new Jelly_Field_Wysiwyg(array(
				'rules' => array(
					array('not_empty'),
				)
			)),
			'link' => new Jelly_Field_String,
			'url' => new Jelly_Field_Slug(array(
				'unique' => TRUE,
			)),
			'date' => new Jelly_Field_Integer(array(
				'default' => time(),
			)),
			'author' => new Jelly_Field_BelongsTo(array(
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

	public function save($key = NULL)
	{
		$this->url = URL::string_to_url($this->title);

		parent::save($key);
	}
}