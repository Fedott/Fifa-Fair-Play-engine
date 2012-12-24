<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_User extends Model_Auth_User
{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->fields(array(
			'icq' => new Jelly_Field_Integer(array(
				'unique' => TRUE,
				'rules' => array(
//					'min_length' => array(5),
					array('max_length', array(':value', 10)),
				),
				'default' => NULL,
				'null' => TRUE,
			)),
			'skype' => new Jelly_Field_String(array(
				'unique' => TRUE,
				'rules' => array(
//					'min_length' => array(6),
                    array('max_length', array(':value', 32)),
				),
				'default' => NULL,
				'null' => TRUE,
			)),
			'origin' => new Jelly_Field_String(array(
				'unique' => TRUE,
				'rules' => array(
					array('not_empty'),
                    array('max_length', array(':value', 32)),
				),
				'null' => TRUE,
				'default' => NULL,
			)),
			'email' => new Jelly_Field_Email(array(
				'unique' => TRUE,
				'rules' => array(
                    array('not_empty'),
				),
			)),
			'last_name' => new Jelly_Field_String(array(
				'rules' => array(
                    array('max_length', array(':value', 30)),
				),
			)),
			'first_name' => new Jelly_Field_String(array(
				'rules' => array(
                    array('max_length', array(':value', 30)),
				),
			)),
			'avatar' => new Jelly_Field_Image(array(
				'path' => 'media/avatars',
				'resize' => TRUE,
				'max_width' => 100,
			)),
			'posts' => new Jelly_Field_Integer(array(
				'default' => 0,
			)),
			'topics' => new Jelly_Field_Integer(array(
				'default' => 0,
			)),
			'matches' => new Jelly_Field_Integer(array(
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

	public function get_im($delimiter = ", ")
	{
		$return = array();
		if( ! empty($this->icq))
		{
			$return[] = "ICQ: ".$this->icq;
		}
		if( ! empty($this->skype))
		{
			$return[] = "Skype: ".$this->skype." <a href='skype:".$this->skype."?chat'>".html::image('templates/fifa/img/chat.png')."</a>";
		}
		if( ! empty($this->origin))
		{
			$return[] = "Origin: ".$this->origin;
		}

		return implode($delimiter, $return);
	}
}
