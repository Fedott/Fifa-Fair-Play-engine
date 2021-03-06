<?php

/**
 * @property $id
 * @property $youtube_key
 * @property $title
 * @property $description
 * @property $match
 */
class Model_Video extends Jelly_Model
{
	public $http_client = NULL;

	const EA_SPORTS_API_URL = "http://www.easports.com/fifa/football-club/api/media/list?personaName=__USERNAME__&platformName=__PLATFORM__&year=__YEAR__";

	public static function initialize(Jelly_Meta $meta)
	{
		$meta->fields(array(
			'id' => Jelly::field('primary'),
			'youtube_key' => Jelly::field('string'),
			'title' => Jelly::field('string', array(
				'rules' => array(
					'not_empty' => array(TRUE),
					'max_length' => array(255),
					'min_length' => array(3),
				),
			)),
			'description' => Jelly::field('string', array(
				'rules' => array(
					'max_length' => array(255),
				),
			)),
			'match' => Jelly::field('BelongsTo'),
		));
	}


	public function youtube_upload($file_path, $title, $description, $slug = NULL)
	{
		require_once $zend_path = Kohana::find_file('vendor', 'Zend/Loader');
		ini_set('include_path', ini_get('include_path').PATH_SEPARATOR.dirname(dirname($zend_path)));
		Zend_Loader::loadClass('Zend_Gdata_YouTube');
		Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
		Zend_Loader::loadClass('Zend_Gdata_YouTube_VideoEntry');
		Zend_Loader::loadClass('Zend_Gdata_App_MediaFileSource');

		$config = Kohana::config('video');

		$authentication_url = 'https://www.google.com/accounts/ClientLogin';
		$http_client = Zend_Gdata_ClientLogin::getHttpClient(
			$config['youtube']['login'],
			$config['youtube']['password'],
			'youtube',
			NULL,
			$config['youtube']['app_id'],
			NULL,
			NULL,
			$authentication_url
		);
		$http_client->setHeaders('X-GData-Key', 'key=' . $config['youtube']['dev_key']);

		$youtube = new Zend_Gdata_YouTube($http_client);
		$youtube->setMajorProtocolVersion(2);

		$file_info = new finfo(FILEINFO_MIME_TYPE);
		$file_mime_type = $file_info->file($file_path);
		if( ! $slug)
		{
			$path_info = pathinfo($file_path);
			$slug = $path_info['basename'];
		}

		Kohana::$log->add('info', 'Upload file mime: :type', array(':type' => $file_mime_type));

		$file_source = new Zend_Gdata_App_MediaFileSource($file_path);
		$file_source->setContentType($file_mime_type);
		$file_source->setSlug($slug);

		$new_video = new Zend_Gdata_YouTube_VideoEntry();
		$new_video->setMediaSource($file_source);
		$new_video->setVideoCategory('Games');
		$new_video->setVideoTitle($title);
		$new_video->setVideoDescription($description);

		$upload_url = 'http://uploads.gdata.youtube.com/feeds/api/users/default/uploads';

		try
		{
			/** @var $new_entry Zend_Gdata_YouTube_VideoEntry */
			$new_entry = $youtube->insertEntry($new_video, $upload_url, 'Zend_Gdata_YouTube_VideoEntry');
		}
		catch (Zend_Gdata_App_HttpException $e)
		{
			$e->getRawResponseBody();
			$validation = Validate::factory(array('video'));
			$validation->error('video', $e->getRawResponseBody());
			throw new Validate_Exception($validation);
			return FALSE;
		}
		catch (Zend_Gdata_App_Exception $e)
		{
			echo $e->getMessage();
			$validation = Validate::factory(array('video'));
			$validation->error('video', $e->getMessage());
			throw new Validate_Exception($validation);
			return FALSE;
		}

		$new_entry->setMajorProtocolVersion(2);
		$this->youtube_key = (string) $new_entry->getVideoId();

		return TRUE;
	}

	public function frame_code()
	{
		return '<iframe width="560" height="315" src="http://www.youtube.com/embed/'.$this->youtube_key.'" frameborder="0" allowfullscreen></iframe>';
	}

	public function match_id()
	{
		return ($this->loaded())?$this->_original['match']:FALSE;
	}

	public function eaworld_parse($url)
	{
		// http://www.easports.com/fifa/football-club/profile/media/PC/Fedotishe/2013/video/153282329
		// http://www.easports.com/fifa/football-club/api/media/list?personaName=Fedotishe&platformName=PC&year=2013
		$url_path = parse_url($url, PHP_URL_PATH);
		if ($url_path === null)
		{
			return false;
		}
		$url_path = trim($url_path, "/");
		$url_path_array = explode("/", $url_path);

		if (count($url_path_array) != 9)
		{
			return false;
		}

		$video_id = $url_path_array[8];

		$api_url = str_replace(array(
				'__USERNAME__',
				'__PLATFORM__',
				'__YEAR__',
			), array(
				$url_path_array[5],
				$url_path_array[4],
				$url_path_array[6],
			),
			self::EA_SPORTS_API_URL
		);

		$json_response = file_get_contents($api_url);
		$json_response = json_decode($json_response, true);

		$video_url = false;
		foreach (Arr::path($json_response, 'data.videos', array()) as $video_array)
		{
			if ($video_array['id'] == $video_id)
			{
				$video_url = $video_array['url'];
			}
		}

		return $video_url;
	}

	public function eaworld_download($url)
	{
		if ( ! $url)
		{
			return false;
		}

		$file_path = tempnam(sys_get_temp_dir(), "fifavideo");
		$remote_file_handle = fopen($url, "rb");
		$local_file_handle = fopen($file_path, "wb");
		$count_byte = stream_copy_to_stream($remote_file_handle, $local_file_handle);
		fclose($remote_file_handle);
		fclose($local_file_handle);

		if($count_byte)
		{
			return $file_path;
		}

		return false;
	}
}