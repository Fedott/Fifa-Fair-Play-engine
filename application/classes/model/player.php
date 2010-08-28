<?php defined('SYSPATH') OR die('No direct access allowed.');

	class Model_Player extends Jelly_Model
	{
		public static function initialize(Jelly_Meta $meta)
		{
			$meta->fields(array(
				'id' => new Field_Primary,
				'first_name' => new Field_String,
				'last_name' => new Field_String(array(
					'rules' => array(
						'not_empty' => array(TRUE),
					),
				)),
				'club' => new Field_BelongsTo,
				'year_of_birth' => new Field_Integer,
			));
		}

		public function player_name($limit = TRUE)
		{
			if(!empty($this->first_name))
			{
				if($limit){
					$return = text::limit_chars($this->first_name, 1, '.');
					$return.= $this->last_name;
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