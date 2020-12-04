<?php

	/*
		Return Values:
			Success:
				string containing json content

			Errors:
				false	- Run Error.
				0 		- Invalid Mime Type
						  Bad File (?)
				1 		- Could not obtain a lock. Must be reprocessed.
						  Lock error (?)
				2 		- Resource Error
				3 		- Read Error
				4 		- File Does Not Exist (?)
				5		- Error encountered while reading the file contents
				6		- The file was empty.
	*/

	/*
		http://www.php.net/manual/en/function.function-exists.php
	*/
	if(!function_exists("read_input_file"))
	{
		/*
			http://www.php.net/manual/en/functions.user-defined.php
		*/
		function read_input_file($file)
		{
			// global $log;

			/*
				http://www.php.net/manual/en/function.is-string.php
			*/
			if(!is_string($file))
			{
				throw new Exception ("Provided input is invalid. - [read_input_files]");

				return (int) 0;
			}
			else
			{
				/*
					http://www.php.net/manual/en/function.empty.php
				*/
				if(empty($file))
				{
					throw new Exception ("Provided input is empty. - [read_input_files]");

					return (int) 0;
				}

				/*
					http://www.php.net/manual/en/function.file-exists.php
				*/
				if(!file_exists($file))
				{
					trigger_error("The file \"$file\" could not be found. - [read_input_files]", E_USER_WARNING);

					return (int) 4;
				}

				/*
					http://www.php.net/manual/en/function.is-readable.php
				*/
				if(!is_readable($file))
				{
					trigger_error("The file \"$file\" does not appear to be readable. - [read_input_files]", E_USER_WARNING);

					return (int) 3;
				}

				/*
					http://www.php.net/manual/en/function.mime-content-type.php
					http://www.php.net/manual/en/function.in-array.php
					-------------------------------------------------------
					Test the MIME Content-Type of the input file.

					Throw out the file if it is does not match the list of allowed MIME Content-Types.
				*/
				$valid_mime_types = array(
					"text/plain"
					, "text/json"
					, "text/x-json"
					, "application/json"
				);

				$input_mimetype = mime_content_type($file);

				if(!in_array($input_mimetype, $valid_mime_types))
				{
					/*
						http://www.php.net/manual/en/function.trigger-error.php
					*/
					trigger_error("Invalid MIME Content-Type Detected. MIME Content-Type of \"$input_mimetype\" found in \"$file\". - [read_input_file]", E_USER_WARNING);

					return (int) 0;
				}
			}

			/*
				Begin file processing.

				Open the file (in read only mode), and then get an exclusive lock on the file.

				http://www.php.net/manual/en/function.fopen.php
				http://www.php.net/manual/en/function.flock.php
			*/
			$file_handle = fopen($file, "r");

			/*
				Check to ensure that a file handle was successfully opened.
			*/
			if(!$file_handle)
			{
				trigger_error("An error was encountered when attempting to open \"$file\". - [read_input_file]", E_USER_WARNING);

				return (int) 3;
			}
			else
			{
				/*
					Confirm that the handle is indeed a resource.

					http://www.php.net/manual/en/function.is-resource.php
				*/
				if(!is_resource($file_handle))
				{
					trigger_error("A resource error was encountered when attempting to open \"$file\". - [read_input_file]", E_USER_WARNING);

					return (int) 2;
				}
			}

			/*
				Wait for, and obtain a lock on the file.
				https://ivopetkov.com/b/reading-locked-files-in-php/
			*/
			if(!flock($file_handle, LOCK_SH))
			{
				trigger_error("Could not obtain a shared lock on \"$file\". - [read_input_file]", E_USER_WARNING);

				return (int) 1;
			}

			/*
				Read the contents of the file into memory. Store as a string.
				http://www.php.net/manual/en/function.fread.php

				http://www.php.net/manual/en/function.filesize.php
				http://www.php.net/manual/en/function.clearstatcache.php
			*/
			$file_size = filesize($file);

			/*
				Set the pointer to the start of the file handle.

				http://www.php.net/manual/en/function.rewind.php
			*/
			if(!rewind($file_handle))
			{
				/*
					Should not happen, but raise notice in case it does.
				*/
				trigger_error("Could not set the file pointer to the beginning of the file \"$file\". - [read_input_file]", E_USER_NOTICE);
			}

			/*
				Read contents into a variable.
			*/
			$file_contents = fread($file_handle, $file_size);

			/*
				Remove whitespace, new lines, tabs, etc. from the beginning and end of the string.
				http://www.php.net/manual/en/function.trim.php
			*/
			$result = trim($file_contents);

			/*
				Clear the stat cache.
			*/
			clearstatcache($file);

			/*
				Release the lock on the file.
			*/
			if(!flock($file_handle, LOCK_UN))
			{
				/*
					Should not happen, but raise notice in case it does.
				*/
				trigger_error("Could not release the shared lock on the file \"$file\". - [read_input_file]", E_USER_NOTICE);
			}

			/*
				Close out the file handle.

				http://www.php.net/manual/en/function.fclose.php
			*/
			if(!fclose($file_handle))
			{
				/*
					Should not happen, but raise notice in case it does.
				*/
				trigger_error("Could not close the file handle for the file \"$file\". - [read_input_file]", E_USER_NOTICE);
			}

			/*
				Check that the file contents were successfully written to the string.
			*/
			if($result !== false)
			{
				if(!empty($result))
				{
					return $result;
				}
				else
				{
					trigger_error("The file \"$file\" appears to have contained no content. - [read_input_file]", E_USER_NOTICE);

					return (int) 6;
				}
			}
			else
			{
				trigger_error("An error was encountered while reading the contents of the file \"$file\". - [read_input_file]", E_USER_NOTICE);

				return (int) 5;
			}
		}
	}

?>