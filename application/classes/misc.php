<?php defined('SYSPATH') OR die('No direct access allowed.');

	class MISC {
		public static function get_goals_images($count)
		{
			$goals = '';
			for($i = 1; $i <= $count; $i++)
			{
				$goals.= "<img src=\"/templates/fifa/img/goal.gif\"/>\n";
			}

			return $goals;
		}

		public static function get_human_date($date = NULL)
		{
			return strftime('%e %b %y %X', $date);
//			return date('d M Y H:i', $date);
		}

		public static function get_human_short_date($timestamp = NULL)
		{
			return strftime('%e %b', $timestamp);
		}

		public static function set_error_message($text)
		{
			Session::instance()->set('error_message', $text);
		}

		public static function get_error_message()
		{
			$session = Session::instance();
			$message = $session->get('error_message');
			$session->delete('error_message');
			return $message;
		}

		public static function isset_error_message()
		{
			return (bool) Session::instance()->get('error_message', FALSE);
		}

		public static function set_apply_message($text)
		{
			Session::instance()->set('apply_message', $text);
		}

		public static function get_apply_message()
		{
			$session = Session::instance();
			$message = $session->get('apply_message');
			$session->delete('apply_message');
			return $message;
		}

		public static function isset_apply_message()
		{
			return (bool) Session::instance()->get('apply_message', FALSE);
		}

		public static function confirm_link($uri, $title, $confirm_text, array $attr = array())
		{
			if(isset($attr['class']))
				$attr['class'].= " confirm ";
			else
				$attr['class'] = " confirm ";
			$attr['confirm_text'] = $confirm_text;
			return HTML::anchor($uri, $title, $attr);
		}

		public static function title_from_breadcrumb($breadcrumb)
		{
			$bc_sections = explode(" > ", strip_tags($breadcrumb));
			$title = '';
			foreach ($bc_sections as $num => $str)
			{
				if($num != 0 AND !empty ($str))
				{
					$title = " &bull; ".$str;
				}
			}

			return $title;
		}

		static public function not_duplicate_send($field_name, $interval = 60)
		{
			$last_send = Session::instance()->get($field_name, 0);
			if($last_send < time() - $interval)
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}

		static public function duplicate_send_time_set($field_name)
		{
			return Session::instance()->set($field_name, time());
		}

		/**
		 * @param Jelly_Collection  $matches
		 * @param int               $line_id
		 * @return string
		 */
		static public function matches_to_bullet($matches, $line_id)
		{
			$result = '';
			foreach ($matches as $match)
			{
				/** @var Model_Match $match */
				if ($match->home->id() == $line_id)
				{
					if ($match->home_goals > $match->away_goals)
						$color = 'green';
					else if ($match->home_goals == $match->away_goals)
						$color = 'yellow';
					else
						$color = 'red';
				}
				else
				{
					if ($match->home_goals < $match->away_goals)
						$color = 'green';
					else if ($match->home_goals == $match->away_goals)
						$color = 'yellow';
					else
						$color = 'red';
				}

				$result = html::anchor("match/view/".$match->id, "<span class='bullet {$color}'>&bullet;</span>") . $result;
			}

			return $result;
		}

		/**
		 * @param Model_Match   $match
		 * @param int           $line_id
		 */
		static public function matches_to_score_line($match, $line_id)
		{
			$result = '';

			if ($match->home->id == $line_id)
			{
				$result = "<span class='";
				if ($match->home_goals > $match->away_goals)
				{
					$result.= 'win';
				}
				else if ($match->home_goals == $match->away_goals)
				{
					$result.= 'draw';
				}
				else
				{
					$result.= 'lose';
				}
				$result.= "'>";
				$result.= $match->home_goals . " - " . $match->away_goals;
				$result.= "</span>";
			}
			else
			{
				$result = "<span class='";
				if ($match->home_goals < $match->away_goals)
				{
					$result.= 'win';
				}
				else if ($match->home_goals == $match->away_goals)
				{
					$result.= 'draw';
				}
				else
				{
					$result.= 'lose';
				}
				$result.= "'>";
				$result.= $match->away_goals . " - " . $match->home_goals;
				$result.= "</span>";
			}

			return $result;
		}
	}