<?php defined('SYSPATH') OR die('No direct access allowed.');

class Loader_Clubs
{
	protected $ids = array();

	/** @var Model_Club[] */
	protected $clubs = array();

	protected $loaded = false;

	/**
	 * @param Model_Line $line
	 * @return bool
	 */
	public function add_by_line(Model_Line $line)
	{
		if ($line->loaded())
		{
			$this->ids[$line->club_id()] = $line->club_id();
			return true;
		}

		return false;
	}

	/**
	 * @param $club_id
	 * @return bool
	 */
	public function add_by_id($club_id)
	{
		if (is_numeric($club_id))
		{
			$this->ids[$club_id] = $club_id;
			return true;
		}

		return false;
	}

	public function add_by_ids(array $ids)
	{
		array_map(array($this, 'add_by_id'), $ids);
	}

	public function load($force = false)
	{
		if ( ! $this->loaded OR $force)
		{
			if (empty($this->ids))
			{
				return;
			}

			$clubs = Jelly::select('club')
				->where("id", "IN", array_values($this->ids))
				->execute();

			foreach ($clubs as $club)
			{
				$this->clubs[$club->id] = $club;
			}

			$this->loaded = true;
		}
	}

	protected function load_one($club_id)
	{
		if (array_key_exists($club_id, $this->ids))
		{
			$this->add_by_id($club_id);
		}

		$this->clubs[$club_id] = Jelly::select("club", $club_id);
	}

	/**
	 * @param $club_id
	 * @return Model_Club
	 */
	public function get_by_id($club_id)
	{
		if ( ! array_key_exists($club_id, $this->ids))
		{
			$this->add_by_id($club_id);
			if ($this->loaded)
			{
				$this->load_one($club_id);
			}
		}

		if ( ! $this->loaded)
		{
			$this->load();
		}

		if (array_key_exists($club_id, $this->clubs))
		{
			return $this->clubs[$club_id];
		}

		return Jelly::factory('club');
	}

	/**
	 * @param Model_Line $line
	 * @return Model_Club
	 */
	public function get_by_line(Model_Line $line)
	{
		return $this->get_by_id($line->club_id());
	}
}
