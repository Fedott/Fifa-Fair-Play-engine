<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_User extends Model_Auth_User
{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->fields(array(
			'icq' => new Field_Integer(array(
				'unique' => TRUE,
				'rules' => array(
//					'min_length' => array(5),
					'max_length' => array(10),
				),
				'default' => NULL,
				'null' => TRUE,
			)),
			'skype' => new Field_String(array(
				'unique' => TRUE,
				'rules' => array(
//					'min_length' => array(6),
					'max_length' => array(32),
				),
				'default' => NULL,
				'null' => TRUE,
			)),
			'email' => new Field_Email(array(
				'unique' => TRUE,
				'rules' => array(
					'not_empty' => array(TRUE),
				),
			)),
			'last_name' => new Field_String(array(
				'rules' => array(
					'max_length' => array(30),
				),
			)),
			'first_name' => new Field_String(array(
				'rules' => array(
					'max_length' => array(30),
				),
			)),
			'avatar' => new Field_Image(array(
				'path' => 'media/avatars',
				'resize' => TRUE,
				'max_width' => 100,
			)),
			'posts' => new Field_Integer(array(
				'default' => 0,
			)),
			'topics' => new Field_Integer(array(
				'default' => 0,
			)),
			'matches' => new Field_Integer(array(
				'default' => 0,
			))
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
