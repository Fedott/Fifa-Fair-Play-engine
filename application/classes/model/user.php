<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_User extends Model_Auth_User
{
	public static function initialize(Jelly_Meta $meta)
	{

		$meta->fields(array(
			'icq' => new Field_Integer(array(
				'unique' => TRUE,
				'rules' => array(
					'not_empty' => array(TRUE),
					'min_length' => array(5),
					'max_length' => array(10),
				),
			)),
			'email' => new Field_Email(array(
				'unique' => TRUE,
				'rules' => array(
					'not_empty' => array(TRUE),
				),
			)),
		));

		parent::initialize($meta);
	}

	public function get_avatar()
	{
		if(!empty($this->avatar))
		{
			return 'media/avatars/'.$this->avatar;
		}
		else
		{
			return 'media/avatars/noava.jpg';
		}
	}
}
