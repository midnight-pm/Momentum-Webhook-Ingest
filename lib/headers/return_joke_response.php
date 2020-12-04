<?php

	/*
		Is someone doing something that they are not supposed to do?
		Is something attempting to enact an action that it should not be doing?
		Why would a process which is expressly intended to be run from the CLI ever need to be called from the web?

		Return a series of stupid error messages to the client should they attempt something that they are not supposed to do.

		The message returned will differ depending on the HTTP Request Method attempted.
		https://en.wikipedia.org/wiki/Hypertext_Transfer_Protocol#Request_methods
	*/

	/*
		http://php.net/manual/en/function.function-exists.php
	*/
	if(!function_exists("return_joke_response"))
	{
		/*
			http://php.net/manual/en/functions.user-defined.php
		*/
		function return_joke_response()
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
				return true;
			}
			else
			{
				/*
					http://php.net/manual/en/control-structures.switch.php
				*/
				switch($_SERVER["REQUEST_METHOD"])
				{
					/*
						"Safe" methods.
					*/
						case "GET":
							/*
								Return "405 Method Not Allowed" to client.
								http://php.net/http-response-code
								https://en.wikipedia.org/wiki/PC_LOAD_LETTER
							*/
							http_response_code(405);
							print "PC LOAD LETTER";

							break;

						case "HEAD":
							/*
								Return "422 Unprocessable Entity" to client.
								https://en.wikipedia.org/wiki/Abort,_Retry,_Fail%3F
							*/
							http_response_code(422);
							print "Abort, Retry, Fail?";

							break;

						case "OPTIONS":
							/*
								Return "500 Internal Server Error" to client.
								https://en.wikipedia.org/wiki/Fatal_exception_error
							*/
							http_response_code(500);
							print "⦻ This program has performed an illegal operation and will be shut down." . PHP_EOL . "If the problem persists, contact the program vendor.";

							break;

						case "TRACE":
							/*
								Return "500 Internal Server Error" to client.
								https://en.wikipedia.org/wiki/Fatal_system_error
							*/
							http_response_code(400);
							print "Kernel panic - not syncing: Attempted to kill init!";

							break;

					/*
						"Unsafe" methods.
					*/
						case "POST":
							/*
								Return "400 Bad Request" to client.
								https://en.wikipedia.org/wiki/Bad_command_or_file_name
							*/
							http_response_code(400);
							print "Bad command or file name";

							break;

						case "PUT":
							/*
								Return "400 Bad Request" to client.
								https://en.wikipedia.org/wiki/Not_a_typewriter
							*/
							http_response_code(400);
							print "Not a typewriter";

							break;

						case "DELETE":
							/*
								Return "400 Bad Request" to client.
							*/
							http_response_code(500);
							print "Segmentation fault";

							break;

						case "PATCH":
							/*
								Return "500 Internal Server Error" to client.
								https://en.wikipedia.org/wiki/Lp0_on_fire
							*/
							http_response_code(500);
							print "lp0 on fire";

							break;

					/*
						Miscellaneous methods.
					*/
						case "CONNECT":
							/*
								Return "500 Internal Server Error" to client.
								https://en.wikipedia.org/wiki/Out_of_memory
							*/
							http_response_code(500);
							print "Out of memory: kill process";

							break;

						default:
							/*
								Return "500 Internal Server Error" to client.
								https://en.wikipedia.org/wiki/Bomb_(icon)
							*/
							http_response_code(500);
							print "💣" . PHP_EOL . "Sorry, a system error occurred." . PHP_EOL . "unimplemented trap" . PHP_EOL . "To temporarily turn off extensions, restart and hold down the shift key.";

							break;
				}
			}
		}
	}

?>