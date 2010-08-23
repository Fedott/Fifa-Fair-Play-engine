<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Club extends Jelly_Model
{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->fields(array(
			'id' => new Field_Primary,
			'name' => new Field_String(array(
				'unique' => TRUE,
				'rules' => array(
					'not_empty' => array(TRUE),
				),
			)),
			'url' => new Field_String,
			'img' => new Field_File,
		));
	}
}