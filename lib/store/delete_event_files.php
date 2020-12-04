<?php

	/*
		http://php.net/manual/en/function.function-exists.php
	*/
	if(!function_exists("delete_event_files"))
	{
		function delete_event_files($input)
		{
			global $log;

			/*
				http://php.net/manual/en/function.is-string.php
			*/
			if(!is_array($input))
			{
				throw new Exception ("Provided input is invalid. - [delete_event_files]");

				return false;
			}
			else
			{
				/*
					http://php.net/manual/en/function.empty.php
				*/
				if(empty($input))
				{
					throw new Exception ("Provided input is empty. - [delete_event_files]");

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

				$deletion = $array["delete"];

				if($deletion === true)
				{
					/*
						https://www.php.net/manual/en/function.unlink.php
					*/
					if(!unlink($file_path))
					{
						/*
							Raise warning, log, and move on.
						*/
						trigger_error("Failed to remove \"$file_path\". - [delete_event_files]", E_USER_WARNING);
						$log->write("Failed to remove \"$file_path\". - [delete_event_files]");
					}
					else
					{
						/*
							Raise notice, log, and move on.
						*/
						trigger_error("Removed \"$file_path\". - [delete_event_files]", E_USER_NOTICE);
						$log->write("Removed \"$file_path\". - [delete_event_files]");
					}
				}
			}

			return true;
		}
	}

?>