<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Class Model_Table
 * @property $id
 * @property $name
 * @property $url
 * @property $type
 * @property $season
 * @property $active
 * @property $visible
 * @property $ended
 * @property Jelly_Collection $lines
 * @property $matches
 */
class Model_Table extends Jelly_Model
{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->fields(array(
			'id' => new Field_Primary,
			'name' => new Field_String(array(
				'rules' => array(
					'not_empty' => array(TRUE),
				),
			)),
			'url' => new Field_String(array(
				'unique' => TRUE,
			)),
			'type' => new Field_Enum(array(
				'choices' => array('friendly', 'official'),
			)),
			'season' => new Field_Integer,
			'active' => new Field_Boolean(array(
				'default' => FALSE,
			)),
			'visible' => new Field_Boolean(array(
				'default' => FALSE,
			)),
			'ended' => new Field_Boolean(array(
				'default' => FALSE,
			)),
			'lines' => new Field_HasMany,
			'matches' => new Field_Integer(array(
				'default' => 2,
			)),
		));
	}

	public function make_schedule()
	{
		$scheduled = array();
		$matches = array();
		$rounds = count($this->lines) * $this->matches - $this->matches;
		$circle_rounds = $rounds / $this->matches;
		for($circle = 0; $circle < $this->matches; $circle++)
		{
			$matches[$circle] = array();
			for($round = 0; $round < $circle_rounds; $round++)
			{
				$clubs = $this->lines->as_array(NULL, 'id');
				while(count($clubs) > 1)
				{
					$found = false;
					while ( ! $found)
					{
						$home_club = $clubs[array_rand($clubs)];
						$away_club = $home_club;
						while($away_club == $home_club)
						{
							$away_club = $clubs[array_rand($clubs)];
						}
						if($this->_check_exists_planned_match($matches[$circle], $home_club, $away_club))
						{
							$matches[$circle][$round] = array('home' => $home_club, 'away' => $away_club);
							$found = true;
							unset($clubs[array_search($home_club, $clubs)]);
							unset($clubs[array_search($away_club, $clubs)]);
						}
					}
				}
			}
		}

		return $this->_create_planned_matches($matches);
	}

	protected function _create_planned_matches($matches, $save = FALSE)
	{
		$objects = array();
		foreach($matches as $circle => $circle_matches)
		{
			foreach($circle_matches as $round => $round_matches)
			{
				foreach($round_matches as $match)
				{
					/** @var $match_object Model_Planned_Match */
					$match_object = Jelly::factory('planned_match', $match);
					$match_object->table = $this;
					$match_object->round = $round + 1;
					$objects[] = $match_object;

					if($save)
					{
						$match_object->save();
					}
				}
			}
		}

		return $objects;
	}

	protected function _check_exists_planned_match($matches, $home, $away)
	{
		$arr1 = array('home' => $home, 'away' => $away);
		$arr2 = array('home' => $away, 'away' => $home);
		if(in_array($arr1, $matches) OR in_array($arr2, $matches))
		{
			return false;
		}

		return true;
	}
}