<?php defined('SYSPATH') OR die('No direct access allowed.');

	class Jelly_Field_Image extends Jelly_Field_File
	{
		public $rules = array();

		public $resize = FALSE;
		public $max_width = NULL;
		public $max_height = NULL;
		public $master_dimension = NULL;

		public function save($model, $value, $loaded)
		{
			$original = $model->get($this->name, FALSE);

			// Upload a file?
			if (is_array($value) AND upload::valid($value))
			{
				if (FALSE !== ($filename = upload::save($value, NULL, $this->path)))
				{
					// Resize image
					if($this->resize)
					{
						Image::factory($filename)
								->resize($this->max_width, $this->max_height, $this->master_dimension)
								->save();
					}
					
					// Chop off the original path
					$value = str_replace($this->path, '', $filename);

					// Ensure we have no leading slash
					if (is_string($value))
					{
						$value = trim($value, '/');
					}

					 // Delete the old file if we need to
					if ($this->delete_old_file AND $original != $this->default)
					{
						$path = $this->path.$original;

						if (file_exists($path))
						{
							unlink($path);
						}
					}
				}
				else
				{
					$value = $this->default;
				}
			}

			return $value;
		}
	}