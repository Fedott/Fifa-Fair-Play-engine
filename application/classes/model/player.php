<?php defined('SYSPATH') OR die('No direct access allowed.');

	/**
	 * @property $id
	 * @property $first_name
	 * @property $last_name
	 * @property $club
	 * @property $year_of_birth
	 */
	class Model_Player extends Jelly_Model
	{
		public static function initialize(Jelly_Meta $meta)
		{
			$meta->fields(array(
				'id' => new Jelly_Field_Primary,
				'first_name' => new Jelly_Field_String,
				'last_name' => new Jelly_Field_String(array(
					'rules' => array(
						array('not_empty'),
					),
				)),
				'club' => new Jelly_Field_BelongsTo,
				'year_of_birth' => new Jelly_Field_Integer(array(
					'default' => 0,
				)),
			));
		}

		public function player_name($limit = TRUE, $last_name_first = FALSE)
		{
			if(!empty($this->first_name))
			{
				if($limit)
				{
					if($last_name_first)
					{
						$return = $this->last_name;
						$return.= ' '.text::limit_chars($this->first_name, 1, '.');
					}
					else
					{
						$return = text::limit_chars($this->first_name, 1, '.');
						$return.= ' '.$this->last_name;
					}
				}
				else
				{
					$return = $this->last_name;
					$return.= ' '.$this->first_name;
				}
			}
			else
			{
				$return = $this->last_name;
			}

			return $return;
		}
	}