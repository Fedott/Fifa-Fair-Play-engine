<?php

class Controller_Admin_Video extends Controller_Admin
{
	public function action_index()
	{
		$this->action_list();
	}

	public function action_list()
	{
		$videos = Jelly::select('video')
				->order_by('id', 'desc')
				->execute();

		$view = View::factory('admin/videos_list');
		$view->videos = $videos;

		$this->template->title = "Видео";
		$this->template->content = $view;
		$this->template->breadcrumb = HTML::anchor('admin', 'Админка')." > ";
	}

	public function action_edit($video_id)
	{
		$video = Jelly::select('video', $video_id);
		$errors = array();

		if($_POST)
		{
			try
			{
				$video->set(arr::extract($_POST, array('title', 'description')));
				$video->save();
				MISC::set_apply_message('Информация успешно изменена');
				$this->request->redirect('admin/video/list');
			}
			catch (Validate_Exception $e)
			{
				$errors = $e->array->errors('video_edit');
			}
		}

		$view = View::factory('admin/video_edit');
		$view->video = $video;
		$view->errors = $errors;

		$this->template->title = "Редактирование видео: ".$video->title;
		$this->template->content = $view;
		$this->template->breadcrumb = HTML::anchor('admin', 'Админка')." > ".
			HTML::anchor('admin/video', 'Управление видео')." > ";
	}

	public function action_delete($video_id)
	{
		/** @var $video Model_Video */
		$video = Jelly::select('video', $video_id);

		if(isset($_GET['delete']))
		{
			$video->delete();
			MISC::set_apply_message('Видео успешно удалено');
			$this->request->redirect('admin/video');
		}

		$this->template->title = "Удаление видео, ".$video->title;
		$this->template->content = View::factory('admin/video_delete', array('video' => $video));
		$this->template->breadcrumb = HTML::anchor('admin', 'Админка')." > ".
			HTML::anchor('admin/video', 'Управление видео')." > ";
	}

}