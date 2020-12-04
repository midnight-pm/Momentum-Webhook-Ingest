<?php

	/*
		http://php.net/manual/en/function.function-exists.php
	*/
	if(!function_exists("release_exclusive_lock"))
	{
		/*
			http://php.net/manual/en/functions.user-defined.php
		*/
		function release_exclusive_lock($directory, $filename, $deletion, $handle)
		{
			/*
				http://www.php.net/manual/en/function.is-string.php
			*/
			if(!is_string($directory))
			{
				throw new Exception ("Provided input is invalid. - [release_exclusive_lock]");

				return false;
			}
			else
			{
				/*
					http://www.php.net/manual/en/function.empty.php
				*/
				if(empty($directory))
				{
					throw new Exception ("Provided input is empty. - [release_exclusive_lock]");

					return false;
				}
			}

			if(!is_string($filename))
			{
				throw new Exception ("Provided input is invalid. - [release_exclusive_lock]");

				return false;
			}
			else
			{
				if(empty($filename))
				{
					throw new Exception ("Provided input is empty. - [release_exclusive_lock]");

					return false;
				}
			}

			if(!is_bool($deletion))
			{
				throw new Exception ("Provided input is invalid. - [release_exclusive_lock]");

				return false;
			}

			/*
				Verify that a valid file handle resource has been provided.

				http://php.net/manual/en/function.is-resource.php
			*/
			if(!is_resource($handle))
			{
				throw new Exception ("Could not verify that the file \"$handle\" was successfully opened for reading and writing. - [release_exclusive_lock]");
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
				throw new Exception ("The directory \"$directory\" does not appear to exist. - [release_exclusive_lock]");
			}
			else
			{
				if(!is_readable($directory))
				{
					throw new Exception ("The directory \"$directory\" does not appear to be readable, or this process does not have permission to access it. - [release_exclusive_lock]");
				}

				if(!is_writeable($directory))
				{
					throw new Exception ("The directory \"$directory\" does not appear to be writeable. - [release_exclusive_lock]");
				}
			}

			/*
				Check to see if the file $filename exists. 
				If it does, verify that permissions are ok.
				If it does not, skip the verification and
				move straight to fopen.
				
				fopen will open a handle to the	file using
				the mode "r+".

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
					throw new Exception ("The file \"$file_path\" does not appear to be readable, or this process does not have permission to access it. - [release_exclusive_lock]");
				}
				if(!is_writeable($file_path))
				{
					throw new Exception ("The file \"$file_path\" does not appear to be writeable. - [release_exclusive_lock]");
				}
			}

			/*
				Release the lock on the file.

				http://php.net/manual/en/function.flock.php
			*/
			if(!flock($handle, LOCK_UN))
			{
				/*
					The lock could not be released.
					Raise a warning and provide a return value of false.
				*/
				trigger_error("Failed to release lock on the file \"$file_path\". - [release_exclusive_lock]", E_USER_WARNING);

				return false;
			}
			else
			{
				/*
					Close the file handle.

					http://php.net/manual/en/function.fclose.php
				*/
				if(!fclose($handle))
				{
					/*
						The file could not be closed.

						This should not happen for any reason, but in the
						event that it possibly does, this logic is provided
						to account for such.

						Raise a notice and provide a return value of true
						as the file was still unlocked at this stage.
					*/
					trigger_error("Failed to close the file \"$file_path\". - [release_exclusive_lock]", E_USER_WARNING);

					return true;
				}
			}

			/*
				Clear the stat cache, just in case anything
				was obtained and cached on the file $file_path.
			*/
			clearstatcache($file_path);

			/*
				Remove the lock file.
			*/
			if($deletion === true)
			{
				if(!unlink($file_path))
				{
					/*
						Raise a notice that the file could not be deleted and move on.
					*/
					trigger_error("Failed to remove the file \"$file_path\". - [release_exclusive_lock]", E_USER_WARNING);
				}
			}

			/*
				Return a boolean value of true to indicate that the lock has been released.
			*/
			return true;
		}
	}