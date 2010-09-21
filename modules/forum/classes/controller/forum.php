<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Forum extends Controller_Template
{
	public function action_index()
	{
		$sections = Jelly::select('section')->execute();

		$view = new View('forum/index');
		$view->sections = $sections;

		$this->template->title = __("Форум");
		$this->template->content = $view;
		$this->template->breadcrumb = HTML::anchor('', __("Главная"))." > ";
	}
	
	public function action_section($id )
	{
		$sections = array(0 => Jelly::select('section', $id));

		$view = new View('forum/index');
		$view->sections = $sections;

		$this->template->title = $sections[0]->name;
		$this->template->content = $view;
		$this->template->breadcrumb = HTML::anchor('', __("Главная"))." > "
				.HTML::anchor("forum", __("Форум"))." > ";
	}

	public function action_view($id)
	{
		$forum = Jelly::select('forum', $id);

		$view = new View('forum/forum_view');
		$view->forum = $forum;
		$view->auth = $this->auth;

		$this->template->title = $forum->name;
		$this->template->content = $view;
		$this->template->breadcrumb = HTML::anchor('', __("Главная"))." > "
				.HTML::anchor("forum", __("Форум"))." > "
				.HTML::anchor("forum/section/".$forum->section->id, $forum->section->name)." > ";
	}

	public function action_topic_create($forum_id)
	{
		$topic = Jelly::factory('topic');
		$post = Jelly::factory('post');
		$forum = Jelly::select('forum', $forum_id);

		$errors = array();

		if($_POST)
		{
			try
			{
				$topic->set(arr::extract($_POST, array('title', 'description')));
				$topic->author = $this->user->id;
				$topic->forum = $forum_id;
				$topic->date = time();
				$topic->save();
				$post->set(arr::extract($_POST, array('title', 'text')));
				$post->author = $this->user->id;
				$post->topic = $topic->id;
				$post->date = $topic->date;
				$post->save();
				Request::instance()->redirect('forum/topic/view/'.$topic->id);
			}
			catch (Validate_Exception $exp)
			{
				$errors = $exp->array->errors('topic');
			}
		}

		$view = new View('forum/topic_create');
		$view->topic = $topic;
		$view->post = $post;
		$view->errors = $errors;

		$this->template->title = __("Новая тема");
		$this->template->content = $view;
		$this->template->breadcrumb = HTML::anchor('', __("Главная"))." > "
				.HTML::anchor("forum", __("Форум"))." > "
				.HTML::anchor("forum/section/".$forum->section->id, $forum->section->name)." > "
				.HTML::anchor('forum/view/'.$forum->id, $forum->name)." > ";
	}

	public function action_topic_view($id)
	{
		$topic = Jelly::select('topic')->with('forum')->load($id);
		$count_posts = Jelly::select('post')->by_topic($topic->id)->count();

		$pagination = Pagination::factory(array(
			'total_items' => $count_posts,
			'group'       => 'forum',
		));

		$posts = Jelly::select('post')
				->by_topic($topic->id)
				->offset($pagination->offset)
				->limit($pagination->items_per_page)
				->execute();

		$view = new View('forum/topic_view');
		$view->topic = $topic;
		$view->posts = $posts;
		$view->pagination = $pagination;
		$view->postform = Jelly::factory('post');

		$this->template->title = $topic->title;
		$this->template->content = $view;
		$this->template->breadcrumb = HTML::anchor('', __("Главная"))." > "
				.HTML::anchor("forum", __("Форум"))." > "
				.HTML::anchor("forum/section/".$topic->forum->section->id, $topic->forum->section->name)." > "
				.HTML::anchor('forum/view/'.$topic->forum->id, $topic->forum->name)." > ";
	}

	public function action_topic_reply($topic_id)
	{
		$topic = Jelly::select('topic', $topic_id);
		$post = Jelly::factory('post');

		$errors = array();

		if($_POST)
		{
			try
			{
				$post->set(arr::extract($_POST, array('title', 'text')));
				$post->author = $this->user->id;
				$post->topic = $topic->id;
				$post->date = time();
				$post->save();
				Request::instance()->redirect('forum/topic/view/'.$topic->id.'?postid='.$post->id.'#post'.$post->id);
			}
			catch (Validate_Exception $exp)
			{
				$errors = $exp->array->errors('topic');
			}
		}

		$view = new View('forum/topic_reply');
		$view->post = $post;
		$view->errors = $errors;

		$this->template->title = __("Ответить");
		$this->template->content = $view;
		$this->template->breadcrumb = HTML::anchor('', __("Главная"))." > "
				.HTML::anchor("forum", __("Форум"))." > "
				.HTML::anchor("forum/section/".$topic->forum->section->id, $topic->forum->section->name)." > "
				.HTML::anchor('forum/view/'.$topic->forum->id, $topic->forum->name)." > "
				.HTML::anchor('forum/topic/view/'.$topic->id, $topic->title)." > ";
	}
}