<?php defined('SYSPATH') OR die('No direct access allowed.');

	class Controller_Match extends Controller_Template
	{
		public $template = 'fifa';
		
		public function before()
		{
			$this->auth = Auth::instance();
			$this->user = $this->auth->get_user();

			return parent::before();
		}

		public function action_index()
		{
			$this->action_list();
		}

		public function action_list($tableid = NULL)
		{
			$tournament = Jelly::select('table', $tableid);
			
			if($tableid == NULL)
			{
				$count = Jelly::select('match')->count();
				$tournament = Jelly::factory('table');
			}
			else
			{
				$count = Jelly::select('match')
						->where('table_id', '=', $tableid)
						->count();
				$tournament = Jelly::select('table', $tableid);
			}

			$pagination = Pagination::factory(array(
				'total_items' => $count,
			));

			$matches = Jelly::select('match')
					->offset($pagination->offset)
					->limit($pagination->current_page)
					->execute();

			$view = new View('matches_list');
			$view->matches = $matches;
			$view->tourn = $tournament;
			$view->pagination = $pagination;

			if($tournament->loaded())
			{
				$this->template->title = __('Матчи');
				$this->template->breadcrumb = HTML::anchor('tournament/view/'.$tournament->id, 'Турнир: '.$tournament->name)." > ";
			}
			else
			{
				$this->template->title = __('Все матчи');
				$this->template->breadcrumb = HTML::anchor('', 'Главная')." > ";
			}
			$this->template->content = $view;
		}

		public function action_reg($tourn)
		{
			if(!$this->auth->logged_in('coach'))
			{
				Request::instance()->redirect('/');
			}
			if(!Jelly::select('line')->where('user_id', "=", $this->user->id)->and_where("table_id", "=", $tourn)->count())
			{
				Request::instance()->redirect('/');
			}
			
			$tournament = Jelly::select('table', $tourn);
			
			
		}
	}