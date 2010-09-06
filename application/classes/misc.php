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
			return date('d-m-Y H:i', $date);
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
	}