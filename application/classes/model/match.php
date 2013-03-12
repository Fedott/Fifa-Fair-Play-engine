<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * @property $id
 * @property $date
 * @property $table
 * @property Model_Line $home
 * @property Model_Line $away
 * @property $home_goals
 * @property $away_goals
 * @property $confirm
 * @property $tech
 * @property $comments
 * @property Model_Planned_Match $planned_match
 */
class Model_Match extends Jelly_Model
{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->sorting(array('date' => 'desc'))
			->load_with(array('table', 'home', 'away'))
			->fields(array(
				'id' => new Field_Primary,
				'date' => new Field_Integer(array(
					'default' => time(),
				)),
				'table' => new Field_BelongsTo,
				'home' => new Field_BelongsTo(array(
					'column' => 'home_id',
					'foreign' => 'line.id',
				)),
				'away' => new Field_BelongsTo(array(
					'column' => 'away_id',
					'foreign' => 'line.id',
				)),
				'home_goals' => new Field_Integer,
				'away_goals' => new Field_Integer,
				'confirm' => new Field_Boolean(array(
					'default' => 0,
				)),
				'tech' => Jelly::field('boolean', array(
					'default' => 0,
				)),
				'comments' => new Field_HasMany(),
				'videos' => Jelly::field('hasmany'),
				'planned_match' => Jelly::field('hasone'),
			));
	}

	/**
	 * Подтверждение матча и занесение результатов в таблицу в соответствии с результатом
	 * @return bool
	 */
	public function commit()
	{
		if( ! $this->loaded())
			return false;

		if( ! $this->home || ! $this->away || ! $this->table)
			return false;

		if($this->confirm)
			return false;


		/** @var $home Model_Line */
		$home = $this->home;
		/** @var $away Model_Line */
		$away = $this->away;

		// Начисляем очки и меняем количестви побед/поражений/ничьих
		if($this->home_goals == $this->away_goals)
		{
			$home->points += 1;
			$away->points += 1;

			$home->drawn++;
			$away->drawn++;
		}
		else if($this->home_goals > $this->away_goals)
		{
			$home->points += 3;

			$home->win++;
			$away->lose++;
		}
		else if($this->home_goals < $this->away_goals)
		{
			$away->points += 3;

			$home->lose++;
			$away->win++;
		}

		// Меняем статистику по забитым/пропущеным
		$home->goals += $this->home_goals;
		$home->passed_goals += $this->away_goals;
		$away->goals += $this->away_goals;
		$away->passed_goals += $this->home_goals;

		// Увеличиваем количество сыгранных игр
		$away->games++;
		$home->games++;

		$this->confirm = true;

		$home->save();
		$away->save();
		$this->save();

		return true;
	}

	public function rollback()
	{
		if( ! $this->confirm)
			return false;


		/** @var $home Model_Line */
		$home = Jelly::select('line', $this->home->id);
		/** @var $away Model_Line */
		$away = Jelly::select('line', $this->away->id);

		// Начисляем очки и меняем количестви побед/поражений/ничьих
		if($this->home_goals == $this->away_goals)
		{
			$home->points -= 1;
			$away->points -= 1;

			$home->drawn--;
			$away->drawn--;
		}
		else if($this->home_goals > $this->away_goals)
		{
			$home->points -= 3;

			$home->win--;
			$away->lose--;
		}
		else if($this->home_goals < $this->away_goals)
		{
			$away->points -= 3;

			$home->lose--;
			$away->win--;
		}

		// Меняем статистику по забитым/пропущеным
		$home->goals -= $this->home_goals;
		$home->passed_goals -= $this->away_goals;
		$away->goals -= $this->away_goals;
		$away->passed_goals -= $this->home_goals;

		// Увеличиваем количество сыгранных игр
		$away->games--;
		$home->games--;

		$this->confirm = false;

		$home->save();
		$away->save();
		$this->save();

		return true;
	}

	public function delete($key = NULL)
	{
		if($this->planned_match->loaded())
		{
			$this->planned_match->played = false;
			$this->planned_match->match = NULL;
			$this->planned_match->save();
		}

		return parent::delete($key);
	}


}
