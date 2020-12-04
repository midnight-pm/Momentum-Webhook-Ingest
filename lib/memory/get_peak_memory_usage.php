<?php

	/*
		Memory usage check.
	*/

	/*
		http://php.net/manual/en/function.function-exists.php
	*/
	if(!function_exists("get_peak_memory_usage"))
	{
		/*
			http://php.net/manual/en/functions.user-defined.php
		*/
		function get_peak_memory_usage()
		{

			/*
				https://stackoverflow.com/a/2510459
				http://php.net/manual/de/function.filesize.php
			*/
			if(!function_exists("format_bytes"))
			{
				function format_bytes($bytes, $precision = 2)
				{
					$units = array('B', 'KB', 'MB', 'GB', 'TB');

					$bytes = max($bytes, 0);
					$pow = floor(($bytes ? log($bytes) : 0) / log(1024));
					$pow = min($pow, count($units) - 1);

					$bytes /= pow(1024, $pow);

					$result = round($bytes, $precision) . ' ' . $units[$pow];

					return $result;
				}
			}

			/*
				* https://stackoverflow.com/a/28978624
				* Converts shorthand memory notation value to bytes
				* From http://php.net/manual/en/function.ini-get.php
				*
				* @param $val Memory size shorthand notation string
			*/
			if(!function_exists("return_bytes"))
			{
				function return_bytes($val)
				{
					$val = trim($val);
					$last = strtolower($val[strlen($val)-1]);
					switch($last) {
						// The 'G' modifier is available since PHP 5.1.0
						case 'g':
							$val *= 1024;
						case 'm':
							$val *= 1024;
						case 'k':
							$val *= 1024;
					}
					return $val;
				}
			}

			/*
				http://php.net/manual/en/function.ini-get.php
			*/
			$memory_limit = return_bytes(ini_get('memory_limit'));

			/*
				http://php.net/manual/en/function.memory-get-peak-usage.php
			*/
			$memory_usage = memory_get_peak_usage();

			$decimal = ($memory_usage / $memory_limit);
			$percent_e = ((float)$decimal * 100);
			$percent_r = round((float)$decimal * 100);

			$result = "Memory Usage: $percent_r% [Peak: " . format_bytes($memory_usage) . " | " . format_bytes($memory_limit) . "] ($percent_e%)";

			return $result;
			
		}
	}

?>