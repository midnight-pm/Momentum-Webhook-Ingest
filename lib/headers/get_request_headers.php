<?php

	/*
		http://php.net/manual/en/function.function-exists.php
	*/
	if(!function_exists("get_request_headers"))
	{
		/*
			http://php.net/manual/en/functions.user-defined.php
		*/
		function get_request_headers()
		{
			/*
				http://php.net/manual/en/function.php-sapi-name.php
				http://php.net/manual/en/reserved.constants.php#reserved.constants.core
			*/
			if(PHP_SAPI === 'cli')
			{
				/*
					No need for this if this script was called from a command line.
				*/
				return "Running from cli SAPI. No request headers available.";
			}
			else
			{
				/*
					http://php.net/manual/en/function.apache-request-headers.php
				*/
				$headers = apache_request_headers();

				if($headers === false)
				{
					throw new Exception ("Call to member function failed - [get_request_headers]");

					return false;
				}
				else
				{
					if(!is_array($headers))
					{
						throw new Exception ("Unknown error occurred. - [get_request_headers]");

						return false;
					}
					else
					{
						$result = "Request Headers: " . PHP_EOL;

						/*
							http://php.net/manual/en/control-structures.foreach.php
						*/
						foreach($headers AS $key => $value)
						{
							/*
								http://php.net/manual/en/language.operators.string.php
							*/
							$result .= "$key\: $value" . PHP_EOL;
						}

						/*
							http://php.net/manual/en/function.trim.php
						*/
						$result = trim($result);

						return $result;
					}
				}
			}
		}
	}

?>