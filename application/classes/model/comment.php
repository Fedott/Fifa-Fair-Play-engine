<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Comment extends Jelly_Model
{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->load_with(array('author'))
			->fields(array(
				'id' => new Jelly_Field_Primary,
				'text' => new Jelly_Field_Wysiwyg(array(
					'rules' => array(
						'not_empty' => array(TRUE)
					)
				)),
				'date' => new Jelly_Field_Integer(array(
					'default' => time(),
				)),
				'author' => new Jelly_Field_BelongsTo(array(
					'column' => 'author_id',
					'foreign' => 'user.id',
				)),
				'match' => new Jelly_Field_BelongsTo,
			));
	}
	
	/**
	 * Возвращает ID матча без загрузки модели матча
	 */
	public function match_id()
	{
		return ($this->loaded())?$this->_original['match']:FALSE;
	}
}