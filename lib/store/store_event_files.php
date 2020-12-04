<?php

	/*
		http://php.net/manual/en/function.function-exists.php
	*/
	if(!function_exists("store_event_files"))
	{
		function store_event_files($input, $timezone, $storage_path, $storage_perms)
		{
			global $log;

			/*
				http://php.net/manual/en/function.is-string.php
			*/
			if(!is_array($input))
			{
				throw new Exception ("Provided input is invalid. - [store_event_files]");

				return false;
			}
			else
			{
				/*
					http://php.net/manual/en/function.empty.php
				*/
				if(empty($input))
				{
					throw new Exception ("Provided input is empty. - [store_event_files]");

					return false;
				}
			}

			if(!is_string($storage_path))
			{
				throw new Exception ("Provided storage path is invalid. - [store_event_files]");

				return false;
			}
			else
			{
				if(empty($storage_path))
				{
					throw new Exception ("Provided storage path parameter is empty. - [store_event_files]");

					return false;
				}
				else
				{
					if(!file_exists($storage_path))
					{
						trigger_error("The directory \"$storage_path\" does not exist. - [store_event_files]", E_USER_WARNING);
						trigger_error("Attempting to create the directory \"$storage_path\". - [store_event_files]", E_USER_NOTICE);

						/*
							http://php.net/manual/en/function.mkdir.php
						*/
						if(!mkdir($storage_path, $storage_perms, true))
						{
							throw new Exception ("Could not create the directory \"$storage_path\". - [store_event_files]");

							return false;
						}
					}
				}
			}

			if(!is_string($timezone))
			{
				trigger_error("Configuration error. Verify that the timezone parameter has been properly configured. - [store_event_files]", E_USER_WARNING);

				return false;
			}
			else
			{
				/*
					http://php.net/manual/en/function.empty.php
				*/
				if(empty($timezone))
				{
					trigger_error("Configuration error. Verify that the timezone parameter has been properly configured. - [store_event_files]", E_USER_WARNING);

					return false;
				}
			}

			/*
				http://php.net/manual/en/function.date-default-timezone-set.php
			*/
			date_default_timezone_set($timezone);

			/*
				Store files under the following data structure:
				$storage_path . "/YEAR/MONTH/DAY/

				i.e.: /data/sparkpost/webhooks/storage/1970/01/01/
			*/
			$date_yr = date("Y", time());
			$date_mo = date("m", time());
			$date_dy = date("d", time());

			$dir_path = $storage_path . "/" . $date_yr . "/" . $date_mo . "/" . $date_dy . "/";

			/*
				Check whether or not the storage path already exists.
				If it does not, attempt to create it.
			*/
			if(!file_exists($dir_path))
			{
				trigger_error("The directory \"$dir_path\" does not exist. - [store_event_files]", E_USER_WARNING);
				trigger_error("Attempting to create the directory \"$dir_path\". - [store_event_files]", E_USER_NOTICE);

				if(!mkdir($dir_path, $storage_perms, true))
				{
					throw new Exception ("Failed to create directory \"$dir_path\". - [store_event_files]");

					return false;
				}
			}

			/*
				Move contents of array into long term storage where the array parameter
				"delete" is set to a boolean value of "true".
			*/
			foreach($input AS $array)
			{
				$file_path = $array["file"];
				$file_name = basename($file_path);
				$destination = $dir_path . $file_name;

				$deletion = $array["delete"];

				if($deletion === true)
				{
					/*
						http://php.net/manual/en/function.rename.php
					*/
					if(!rename($file_path, $destination))
					{
						/*
							Raise warning, log, and move on.
						*/
						trigger_error("Failed to move \"$file_path\" to \"$destination\". - [store_event_files]", E_USER_WARNING);
						$log->write("Failed to move \"$file_path\" to \"$destination\". - [store_event_files]");
					}
					else
					{
						/*
							Raise notice, log, and move on.
						*/
						trigger_error("Moved \"$file_path\" to \"$destination\". - [store_event_files]", E_USER_NOTICE);
						$log->write("Moved \"$file_path\" to \"$destination\". - [store_event_files]");
					}
				}
			}

			return true;
		}
	}

?>