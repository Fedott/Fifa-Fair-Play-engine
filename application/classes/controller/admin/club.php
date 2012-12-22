<?php defined('SYSPATH') OR die('No direct access allowed.');

	class Controller_Admin_Club extends Controller_Admin
	{
		public function action_index()
		{
			$this->action_list();
		}

		public function action_list()
		{
			$clubs = Jelly::query('club')->execute();

			$view = new View('admin/clubs_list');
			$view->clubs = $clubs;

			$this->template->title = __("Клубы");
			$this->template->content = $view;
			$this->template->breadcrumb = HTML::anchor('admin', 'Админка')." > ".
					HTML::anchor('admin/club', 'Управление клубами')." > ";
		}

		public function action_edit($cid = NULL)
		{
			if($cid === NULL)
				$club = Jelly::factory ('club');
			else
				$club = Jelly::query('club', $cid)->execute();
			$errors = array();

			if($_POST)
			{
				try
				{
					$club->set(Arr::extract($_POST, array('name')));
					$club->url = url::string_to_url($club->name);
					if(isset($_FILES))
						$club->logo = $_FILES['logo'];
					$club->save();
					Request::current()->redirect('admin/club/view/'.$club->id);
				}
				catch (Validate_Exception $exp)
				{
					$errors = $exp->array->errors('club');
				}
			}

			$view = new View('admin/club_edit');
			$view->club = $club;
			$view->errors = $errors;

			$this->template->title = __("Редактирование");
			$this->template->content = $view;
			$this->template->breadcrumb = HTML::anchor('admin', 'Админка')." > ".
					HTML::anchor('admin/club', 'Управление клубами')." > ".
					HTML::anchor('admin/club/view/'.$club->id, 'Клуб '.$club->name)." > ";
		}

		public function action_view($id)
		{
			$club = Jelly::query('club', $id)->execute();

			$view = new View('admin/club_view');
			$view->club = $club;

			$this->template->title = __("Клуб :name", array(':name' => $club->name));
			$this->template->content = $view;
			$this->template->breadcrumb = HTML::anchor('admin', 'Админка')." > ".
					HTML::anchor('admin/club', 'Управление клубами')." > ";
		}

		public function action_adds($cid)
		{
			$errors = array();
			$allow = array();
			$club = Jelly::query('club', $cid)->execute();

			if($_POST)
			{
				foreach($_POST['last_name'] as $key => $val)
				{
					if(!empty($val))
					{
						try
						{
							$player = Jelly::factory('player');
							$player->set(array('last_name' => $_POST['last_name'][$key], 'first_name' => $_POST['first_name'][$key], 'club' => $cid));
							$player->save();
							$allow[] = $player->player_name(false);
						}
						catch (Validate_Exception $exp)
						{
							$errors[] = $player->player_name().": ".implode(",", $exp->array->errors('player'));
						}
					}
				}
			}

			$view = new View('admin/players_adds');
			$view->club = $club;
			$view->errors = $errors;
			$view->allow = $allow;

			$this->template->title = __('Добавление игроков');
			$this->template->content = $view;
			$this->template->breadcrumb = HTML::anchor('admin', 'Админка')." > ".
					HTML::anchor('admin/club', 'Управление клубами')." > ".
					HTML::anchor('admin/club/view/'.$club->id, 'Клуб '.$club->name)." > ";
		}
		
		public function action_parse_from_wiki($club_id)
		{
			/** @var $club Model_Club */
			$club = Jelly::query("club", $club_id)->execute();
			$errors = array();
			$allow = array();
			
			if($_POST)
			{
				include Kohana::find_file('vendor', 'phpQuery');

				$tables = phpQuery::newDocumentHTML($_POST['tables']);

				/** @var $other_club Model_Club */
				$other_club = Jelly::query('club')->where('name', '=', 'Other clubs')->limit(1)->execute();

				$players_arr = array();
				foreach ($tables->find("tr.vcard.agent span.fn") as $player)
				{
					$player_full_name = array('first_name' => NULL, 'last_name' => NULL);
					$player_name = pq($player)->text();
					$player_name = preg_replace("!\(.+\)!", "", $player_name);
					if(substr_count($player_name, " "))
					{
						$tmp = explode(" ", $player_name, 2);
						$player_full_name['first_name'] = trim($tmp[0]);
						$player_full_name['last_name'] = trim($tmp[1]);
					}
					else
					{
						$player_full_name['last_name'] = trim($player_name);
					}
					
					$players_arr[] = $player_full_name;
				}

				foreach($club->players as $club_player)
				{
					/** @var $club_player Model_Player */
					$club_player_isset = false;
					foreach($players_arr as $key => $player_new_arr)
					{
						if(
							$club_player->first_name == $player_new_arr['first_name']
							AND $club_player->last_name == $player_new_arr['last_name']
						)
						{
							$club_player_isset = true;
							unset($players_arr[$key]);
							break;
						}
					}
					if( ! $club_player_isset)
					{
						$club_player->club = $other_club;
						$club_player->save();
					}
				}

				foreach($players_arr as $player_new_arr)
				{
					try
					{
						$isset_player_builder = Jelly::query('player');
						if($player_new_arr['first_name'] === NULL)
						{
							$isset_player_builder->where('first_name', 'IN', array('', NULL));
						}
						else
						{
							$isset_player_builder->where('first_name', '=', $player_new_arr['first_name']);
						}

						/** @var $isset_player Jelly_Collection */
						$isset_player = $isset_player_builder
								->and_where('last_name', '=', $player_new_arr['last_name'])
								->execute();
						if($isset_player->count() == 1)
						{
							/** @var $moved_player Model_Player */
							$moved_player = $isset_player->current();
							$moved_player->club = $club;
							$moved_player->save();
							continue;
						}
						if($isset_player->count() > 1)
						{
							$errors[] = implode(' ', $player_new_arr) . " Есть более одного такого игрока";
							continue;
						}

						/** @var $player Model_Player */
						$player = Jelly::factory('player');
						$player->set(array('last_name' => $player_new_arr['last_name'], 'first_name' => $player_new_arr['first_name'], 'club' => $club->id));
						$player->save();
						$allow[] = $player->player_name(false);
					}
					catch (Exception $exp)
					{
						$errors[] = $player->player_name().": ".implode(",", $exp->array->errors('player'));
					}
				}
			}
			
			$view = new View('admin/parse_from_wiki');
			$view->club = $club;
			$view->errors = $errors;
			$view->allow = $allow;
			
			$this->template->title = __("Добавление игроков из wiki");
			$this->template->content = $view;
			$this->template->breadcrumb = HTML::anchor('admin', 'Админка')." > ".
					HTML::anchor('admin/club', 'Управление клубами')." > ".
					HTML::anchor('admin/club/view/'.$club->id, 'Клуб '.$club->name)." > ";
		}
	}