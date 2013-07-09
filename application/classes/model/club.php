<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * @property $id
 * @property $name
 * @property $url
 * @property $logo
 * @property $players
 * @property $lines
 */
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
			'logo' => new Field_File(array(
				'path' => 'media/logos',
				'default' => '',
			)),
			'players' => new Field_HasMany,
			'lines' => new Field_HasMany,
		));
	}

	public function logo()
	{
		return 'media/logos/'.$this->logo;
	}
}