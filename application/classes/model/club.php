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
			'id' => new Jelly_Field_Primary,
			'name' => new Jelly_Field_String(array(
				'unique' => TRUE,
				'rules' => array(
					array('not_empty'),
				),
			)),
			'url' => new Jelly_Field_String,
			'logo' => new Jelly_Field_File(array(
				'path' => 'media/logos',
			)),
			'players' => new Jelly_Field_HasMany,
			'lines' => new Jelly_Field_HasMany,
		));
	}

	public function logo()
	{
		return 'media/logos/'.$this->logo;
	}
}