<?php

	/*
		http://php.net/manual/en/function.function-exists.php
	*/
	if(!function_exists("obtain_exclusive_lock"))
	{
		/*
			http://php.net/manual/en/functions.user-defined.php
		*/
		function obtain_exclusive_lock($directory, $filename)
		{
			/*
				http://www.php.net/manual/en/function.is-string.php
			*/
			if(!is_string($directory))
			{
				throw new Exception ("Provided input is invalid. - [obtain_exclusive_lock]");

				return false;
			}
			else
			{
				/*
					http://www.php.net/manual/en/function.empty.php
				*/
				if(empty($directory))
				{
					throw new Exception ("Provided input is empty. - [obtain_exclusive_lock]");

					return false;
				}
			}

			if(!is_string($filename))
			{
				throw new Exception ("Provided input is invalid. - [obtain_exclusive_lock]");

				return false;
			}
			else
			{
				if(empty($filename))
				{
					throw new Exception ("Provided input is empty. - [obtain_exclusive_lock]");

					return false;
				}
			}

			/*
				Check for the existence of the provided directory, then
				confirm that it can both be read from and written to.

				http://php.net/manual/en/function.file-exists.php
				http://php.net/manual/en/function.is-readable.php
				http://php.net/manual/en/function.is-writeable.php
			*/
			if(!file_exists($directory))
			{
				/*
					Raise warning and attempt to create the directory of it does not exist.
				*/
				trigger_error("The directory \"$directory\" does not exist. - [obtain_exclusive_lock]", E_USER_WARNING);

				if(!mkdir($directory, 0755, true))
				{
					/*
						Not possible to proceed. Raise exception error.
					*/
					throw new Exception ("Failed to create directory \"$directory\". - [obtain_exclusive_lock]");

					return false;
				}
				else
				{
					/*
						Raise notice and move on.
					*/
					trigger_error("Created directory \"$directory\".  - [obtain_exclusive_lock]", E_USER_NOTICE);
				}
			}

			if(!is_readable($directory))
			{
				throw new Exception ("The directory \"$directory\" does not appear to be readable, or this process does not have permission to access it. - [obtain_exclusive_lock]");
			}

			if(!is_writeable($directory))
			{
				throw new Exception ("The directory \"$directory\" does not appear to be writeable. - [obtain_exclusive_lock]");
			}

			/*
				Check to see if the file $filename exists. If it does, verify that permissions are ok.
				If it does not, skip the verification and move straight to fopen.
				
				fopen will open a handle to the	file using the mode "c+".
				Information on "mode c+" from php.net:

				Open the file for reading and writing; otherwise it has the same behavior as 'c': If
				the file does not exist, it is created. If it exists, it is neither truncated (as
				opposed to 'w'), nor the call to this function fails (as is the case with 'x'). The
				file pointer is positioned on the beginning of the file. This may be useful if it's
				desired to get an advisory lock (see flock()) before attempting to modify the file,
				as using 'w' could truncate the file before the lock was obtained (if truncation is
				desired, ftruncate() can be used after the lock is requested). 

				http://php.net/manual/en/function.fopen.php
			*/
			$file_path = $directory . "/" . $filename;

			/*
				Check permissions.
			*/
			if(file_exists($file_path))
			{
				if(!is_readable($file_path))
				{
					throw new Exception ("The file \"$file_path\" does not appear to be readable, or this process does not have permission to access it. - [obtain_exclusive_lock]");
				}
				if(!is_writeable($file_path))
				{
					throw new Exception ("The file \"$file_path\" does not appear to be writeable. - [obtain_exclusive_lock]");
				}
			}

			/*
				Open file handle.
			*/
			$handle = fopen($file_path, "c+");

			if(!$handle)
			{
				$error = error_get_last();

				$error_type = $error["type"];
				$error_mesg = $error["message"];
				$error_file = $error["file"];
				$error_line = $error["line"];

				$error_otpt = "[$error_type] $error_mesg ($error_file:$error_line)";

				throw new Exception ("An error occurred when trying to open the file \"$file_path\" for reading and writing: $error_otpt. - [obtain_exclusive_lock]");
			}
			else
			{
				/*
					Verify that a file handle resource has been opened.

					http://php.net/manual/en/function.is-resource.php
				*/
				if(!is_resource($handle))
				{
					throw new Exception ("Could not verify that the file \"$file_path\" was successfully opened for reading and writing. - [obtain_exclusive_lock]");
				}
			}

			/*
				Attempt to obtain a lock on the file.
				The flags LOCK_EX and LOCK_NB will be used
				during this check.

				LOCK_EX - Attempt to obtain an exclusive lock.
				LOCK_NB - This should be a non-blocking lock.

				This will allow the process to continue if it
				cannot immediately obtain an exclusive lock.

				http://php.net/manual/en/function.flock.php
			*/
			if(!flock($handle, LOCK_EX | LOCK_NB))
			{
				/*
					An exclusive lock could not be obtained.
				*/
				throw new Exception("An exclusive lock could not be obtained. - [obtain_exclusive_lock]");
			}
			else
			{
				/*
					Truncate the file to 0-length.

					http://php.net/manual/en/function.ftruncate.php
				*/
				if(!ftruncate($handle, 0))
				{
					/*
						Raise a notice and move on.
					*/
					trigger_error("Could not truncate the lock file.", E_USER_NOTICE);
				}
				else
				{
					/*
						Rewind the position of the file pointer to the beginning of the file stream.

						http://php.net/manual/en/function.rewind.php
					*/
					if(!rewind($handle))
					{
						/*
							Raise a notice and move on.
						*/
						trigger_error("Could not set file pointer position to the start of the file.", E_USER_NOTICE);
					}
				}

				/*
					Get the pid for the current process and
					write it to the file.

					http://php.net/manual/en/function.getmypid.php
				*/
				$current_pid = getmypid();

				if(!$current_pid)
				{
					/*
						Raise a notice and move on.
					*/
					trigger_error("Unable to obtain the current process id. It will not be written to the lock file.", E_USER_NOTICE);
				}
				else
				{
					if(!fwrite($handle, $current_pid))
					{
						/*
							This should not happen, but the logic is here
							just in case.

							If this process is unable to write the pid to
							the file, then raise a notice and move on.
						*/
						trigger_error("Could not write PID to lock file.", E_USER_NOTICE);
					}
				}
			}
			
			/*
				Provide the file handle as a return value.
				It can then have the lock released, and the
				handle closed by another function.
			*/
			return $handle;
		}
	}