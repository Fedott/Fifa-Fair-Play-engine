<?php
/**
 * User: fedot
 * Date: 13.11.12
 * Time: 13:14
 */

/**
 * @property $id int
 * @property $nick string
 * @property $games int
 * @property $goals int
 * @property $assists int
 * @property $shots int
 * @property $passes int
 * @property $tackles int
 * @property $season int
 * @property $date int
 */
class Model_Pro_Player extends Jelly_Model
{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->fields(array(
			'id'        => Jelly::field("primary"),
			'nick'      => Jelly::field("string"),
			'games'     => Jelly::field("integer"),
			'goals'     => Jelly::field("integer"),
			'assists'   => Jelly::field("integer"),
			'shots'     => Jelly::field("integer"),
			'passes'    => Jelly::field("integer"),
			'tackles'   => Jelly::field("integer"),
			'season'    => Jelly::field("integer"),
			'date'      => Jelly::field("integer"),
		));
	}

	public static function parse_eafoolballworld($season = '2012')
	{
		ob_end_clean();
		$members_url = 'http://www.eafootballworld.com/en_GB/clubs/partial/395A0001/1111/members-list';
		include_once Kohana::find_file('vendor', 'phpQuery');

		// Расчитываем сегодняшную дату
		$date = strtotime(date("d-m-Y"));

		$count_date_players = Jelly::select('pro_player')->where('date', '=', $date)->execute();
		if(count($count_date_players))
		{
			exit("Data for this day has already collected". PHP_EOL);
		}

		while(1)
		{
			$members_page_source = Curl::get($members_url);
			$members_page = phpQuery::newDocumentHTML($members_page_source);

			if(trim($members_page->find("div#widgets")->text()) == 'There are no members to display')
			{
				echo "Waiting..." . PHP_EOL;
				sleep(7);
				continue;
			}

			foreach($members_page->find('table tbody tr.nowrap') as $player_tr)
			{
				$player_tr = pq($player_tr);
				/** @var $player Model_Pro_Player */
				$player = Jelly::factory('pro_player');
				$player->season = $season;
				$player->date = $date;
				$i = 1;
				foreach($player_tr->find('td') as $player_td)
				{
					switch($i++)
					{
						case 2:
							$player->nick = pq($player_td)->find("div:first")->text();
							break;

						case 4:
							$player->games = pq($player_td)->text();
							break;

						case 5:
							$player->goals = pq($player_td)->text();
							break;

						case 6:
							$player->assists = pq($player_td)->text();
							break;

						case 7:
							$player->shots = pq($player_td)->text();
							break;

						case 8:
							$player->passes = pq($player_td)->text();
							break;

						case 9:
							$player->tackles = pq($player_td)->text();
							break;
					}
				}

				$player->save();
			}

			echo "The data collected for ". date("d-m-Y", $date) . PHP_EOL;

			break;
		}
	}
}
