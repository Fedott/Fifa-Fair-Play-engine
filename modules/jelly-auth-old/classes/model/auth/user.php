<?php defined('SYSPATH') or die ('No direct script access.');
/**
 * Jelly Auth User Model
 * @package Jelly Auth
 * @author	Israel Canasa
 */
class Model_Auth_User extends Jelly_Model
{
	public static function initialize(Jelly_Meta $meta)
    {
		$meta->name_key('username')
			->sorting(array('username' => 'ASC'))
			->fields(array(
			'id' => new Jelly_Field_Primary,
			'username' => new Jelly_Field_String(array(
				'unique' => TRUE,
				'rules' => array(
						array('not_empty'),
						array('max_length', array(':value', 32)),
						array('min_length', array(':value', 3)),
						array('regex', array(':value', '/^[\pL_.-]+$/ui'))
					)
				)),
			'password' => new Jelly_Field_Password(array(
				'hash_with' => array(Auth::instance(), 'hash_password'),
				'rules' => array(
                    array('not_empty'),
                    array('max_length', array(':value', 50)),
                    array('min_length', array(':value', 6)),
				)
			)),
			'password_confirm' => new Jelly_Field_Password(array(
				'in_db' => FALSE,
				'callbacks' => array(
                    array(array(':model', '_check_password_matches'), array(':validate', ':field')),
				),
				'rules' => array(
                    array('not_empty'),
                    array('max_length', array(':value', 50)),
                    array('min_length', array(':value', 6)),
				)
			)),
			'email' => new Jelly_Field_Email(array(
				'unique' => TRUE
			)),
			'logins' => new Jelly_Field_Integer(array(
				'default' => 0
			)),
			'last_login' => new Jelly_Field_Timestamp,
			'tokens' => new Jelly_Field_HasMany(array(
				'foreign' => 'user_token'
			)),
			'roles' => new Jelly_Field_ManyToMany
		));
    }

	/**
	 * Validate callback wrapper for checking password match
	 * @param Validate $array
	 * @param string   $field
	 * @return void
	 */
	public static function _check_password_matches(Validate $array, $field)
	{
		$auth = Auth::instance();
		
		if ($array['password'] !== $array[$field])
		{
			// Re-use the error messge from the 'matches' rule in Validate
			$array->error($field, 'matches', array('param1' => 'password'));
		}
	}
	
	/**
	 * Check if user has a particular role
	 * @param mixed $role 	Role to test for, can be Model_Role object, string role name of integer role id
	 * @return bool			Whether or not the user has the requested role
	 */
	public function has_role($role)
	{
		// Check what sort of argument we have been passed
		if ($role instanceof Model_Role)
		{
			$key = 'id';
			$val = $role->id;
		}
		elseif (is_string($role))
		{
			$key = 'name';
			$val = $role;
		}
		else
		{
			$key = 'id';
			$val = (int) $role;
		}

		foreach ($this->roles as $user_role)
		{	
			if ($user_role->{$key} === $val)
			{
				return TRUE;
			}
		}
		
		return FALSE;
	}
	
} // End Model_Auth_User