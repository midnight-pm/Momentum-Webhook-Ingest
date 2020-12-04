<?php

	/*
		???
	*/

	/*
		http://php.net/manual/en/function.function-exists.php
	*/
	if(!function_exists("move_input_files"))
	{
		/*
			http://php.net/manual/en/functions.user-defined.php
		*/
		function move_input_files($array, $guid)
		{
			global $log;

			/*
				http://php.net/manual/en/function.is-array.php
			*/
			if(!is_array($array))
			{
				throw new Exception ("Provided input is invalid. - [move_input_files]");

				return false;
			}
			else
			{
				/*
					http://php.net/manual/en/function.empty.php
				*/
				if(empty($array))
				{
					throw new Exception ("Provided input is empty. - [move_input_files]");

					return false;
				}
			}

			$log->write("Moving " . count($array) . " file(s) for exclusive use.");

			if($config["use_system_temp"] === false)
			{
				$cfg_temp_dir = $config["directory"];
				$new_temp_dir = "$cfg_temp_dir/$guid";
				if(!file_exists($cfg_temp_dir))
				{
					throw new Exception ("The path, \"$cfg_temp_dir\", that the operating system returned for the temporary directory does not exist, or this process does not have permission to access it. - [move_input_files]");
				}
				else
				{
					if(is_readable($cfg_temp_dir) === false || is_writable($cfg_temp_dir) === false)
					{
						throw new Exception ("Permissions error encountered when attempting to read from and write to \"$cfg_temp_dir\". - [move_input_files]");
					}
					else
					{
						/*
							http://php.net/manual/en/function.mkdir.php
						*/
						if(!mkdir($new_temp_dir, 0777, true))
						{
							throw new Exception ("Could not create the directory \"$new_temp_dir\". - [move_input_files]");
						}
					}
				}
			}
			else
			{
				/*
					Obtain the location of the system's temporary directory.
				*/
				$sys_temp_dir = sys_get_temp_dir();
				$process_user = get_current_user();
				$new_temp_dir = "$sys_temp_dir/$process_user/$guid";
				
				/*
					Create a temporary directory
				*/
				if(!is_string($sys_temp_dir))
				{
					throw new Exception ("Return temporary directory is not a valid path. - [move_input_files]");
				}
				else
				{
					if(empty($sys_temp_dir))
					{
						throw new Exception ("Did not properly return system temporary directory. - [move_input_files]");
					}
					else
					{
						if(!file_exists($sys_temp_dir))
						{
							throw new Exception ("The path, \"$sys_temp_dir\", that the operating system returned for the temporary directory does not exist, or this process does not have permission to access it. - [move_input_files]");
						}
						else
						{
							if(is_readable($sys_temp_dir) === false || is_writable($sys_temp_dir) === false)
							{
								throw new Exception ("Permissions error encountered when attempting to read from and write to \"$sys_temp_dir\". - [move_input_files]");
							}
							else
							{
								/*
									http://php.net/manual/en/function.mkdir.php
								*/
								if(!mkdir($new_temp_dir, 0777, true))
								{
									throw new Exception ("Could not create the directory \"$new_temp_dir\". - [move_input_files]");
								}
							}
						}
					}
				}
			}

			/*
				Instantiate an empty array.
			*/
			$files = array();

			/*
				http://php.net/manual/en/control-structures.foreach.php
			*/
			foreach($array AS $file)
			{
				/*
					https://www.php.net/manual/en/function.basename.php
					https://www.php.net/manual/en/function.rename.php
				*/
				$name = basename($file);
				$path = "$new_temp_dir/$name";
				$move = rename($file, $path);
				if($move === true)
				{
					array_push($files, $path);
					
					/*
						Notify and proceed onward.
					*/
					trigger_error("Moved \"$file\" to \"$path\". - [move_input_files]", E_USER_NOTICE);
					$log->write("Moved \"$file\" to \"$path\". - [move_input_files]");
				}
				else
				{
					/*
						Keep Calm and Carry On.
					*/
					trigger_error("Error encounted when attempting to move \"$file\" to \"$path\". - [move_input_files]", E_USER_WARNING);
					$log->write("Error encounted when attempting to move \"$file\" to \"$path\". - [move_input_files]");
				}
			}

			if(!empty($files))
			{
				return $files;
			}
			else
			{
				return false;
			}
		}
	}

?>