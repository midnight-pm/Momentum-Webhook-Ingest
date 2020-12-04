<?php

	/*
		This function will scan the specified directory for all files it contains.

		It will return an array of the resulting files.
	*/

	/*
		http://php.net/manual/en/function.function-exists.php
	*/
	if(!function_exists("scan_for_files"))
	{
		/*
			http://php.net/manual/en/functions.user-defined.php
		*/
		function scan_for_files($path)
		{
			// var_dump($path);

			/*
				Confirm that the provided directory is available.
			*/
			if(!is_dir($path))
			{
				throw new Exception ("\"$path\" does not exist or is not a directory.");

				return false;
			}
			else
			{
				if(!is_readable($path))
				{
					throw new Exception ("\"$path\" is not readable.");

					return false;
				}
			}

			function path_to_array($dir)
			{
				$scan_result = array();

				/*
					http://php.net/manual/en/function.scandir.php
				*/
				$cdir = scandir($dir);

				/*
					http://php.net/manual/en/control-structures.foreach.php
				*/
				/*
					These paths will be discarded from the result set.
				*/
				$dots = array(
					"."
					, ".."
					);

				foreach ($cdir as $key => $value)
				{
					if(!in_array($value, $dots))
					{
						/*
							http://php.net/manual/en/dir.constants.php
						*/
						if(is_dir($dir . DIRECTORY_SEPARATOR . $value))
						{
							$scan_result[$value] = path_to_array($dir . DIRECTORY_SEPARATOR . $value);
						}
						else
						{
							$scan_result[] = $dir . "/" . $value;
						}
					}
				}

				return $scan_result;
			}

			$file_paths = path_to_array($path);

			// var_dump($file_paths);

			/*
				Flatten the array provided by the function path_to_array(), Recursively Iterate through it, then Recursively Iterate through *that* to return just the file names and paths.
			*/
			$result = array();

			/*
				https://stackoverflow.com/questions/1319903/how-to-flatten-a-multidimensional-array
				https://stackoverflow.com/a/1320259

				http://php.net/manual/en/class.recursiveiteratoriterator.php
				http://php.net/manual/en/class.recursivearrayiterator.php
			*/
			$iterator = new RecursiveIteratorIterator(new RecursiveArrayIterator($file_paths));

			foreach($iterator AS $file)
			{
				/*
					http://php.net/manual/en/function.array-push.php
				*/
				$result[] = $file;
			}

			// var_dump($result);

			/*
				http://php.net/manual/en/function.count.php
			*/
			if(count($result) === 0)
			{
				return false;
			}
			else
			{
				return $result;
			}
		}
	}

?>