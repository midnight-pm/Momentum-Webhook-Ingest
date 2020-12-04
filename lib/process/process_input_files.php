<?php

	/*
		???
	*/

	/*
		http://php.net/manual/en/function.function-exists.php
	*/
	if(!function_exists("process_input_files"))
	{
		/*
			http://php.net/manual/en/functions.user-defined.php
		*/
		function process_input_files($array, $db_connection)
		{
			global $log;

			/*
				http://php.net/manual/en/function.is-array.php
			*/
			if(!is_array($array))
			{
				throw new Exception ("Provided input is invalid. - [process_input_files]");

				return false;
			}
			else
			{
				/*
					http://php.net/manual/en/function.empty.php
				*/
				if(empty($array))
				{
					throw new Exception ("Provided input is empty. - [process_input_files]");

					return false;
				}
			}

			$log->write("Processing " . count($array) . " file(s).");

			/*
				Instantiate an empty array.
			*/
			$result = array();

			/*
				http://php.net/manual/en/control-structures.foreach.php
			*/
			foreach($array AS $file)
			{
				/*
					Raise notice, log it, and move on.
				*/
				trigger_error("Current file: \"$file\" - [process_input_files]", E_USER_NOTICE);
				$log->write("Current file: \"$file\" - [process_input_files]");

				/*
					In Order:
					1. Open Input File
					2. Read Input File into Memory
					3. Close Input File
					4. Process Data
						a. Validate JSON
						b. Parse and Write into DB
					5. Delete Input File.
						a. Move elsewhere for long term storage?
						b. Send to /dev/null?
				*/
				$json = read_input_file($file);

				if($json === false)
				{
					$discard_file = false;
					$proceed_with_exec = false;
				}
				elseif($json === 0)
				{
					$discard_file = false;
					$proceed_with_exec = false;
				}
				elseif($json === 1)
				{
					$discard_file = false;
					$proceed_with_exec = false;
				}
				elseif($json === 2)
				{
					$discard_file = false;
					$proceed_with_exec = false;
				}
				elseif($json === 3)
				{
					$discard_file = false;
					$proceed_with_exec = false;
				}
				elseif($json === 4)
				{
					$discard_file = false;
					$proceed_with_exec = false;
				}
				elseif($json === 5)
				{
					$discard_file = false;
					$proceed_with_exec = false;
				}
				elseif($json === 6)
				{
					$discard_file = true;
					$proceed_with_exec = false;
				}
				else
				{
					$discard_file = true;
					$proceed_with_exec = true;
				}

				if($proceed_with_exec !== true)
				{
					/*
						Log and move on.
					*/
					$log->write("Failed to successfully read the contents of the file: \"$file\".");
				}
				else
				{
					/*
						Run JSON through validation.
					*/
					$log->write("Checking JSON for possible errors. - [process_input_files]");

					$json_validation = json_validate($json);

					if($json_validation !== true)
					{
						$proceed_with_exec = false;
						$discard_file = true;

						/*
							Raise warning, log it, and move on.
						*/
						trigger_error("The provided input failed JSON validation. Error: \"$json_validation\" - [process_input_files]", E_USER_WARNING);
						$log->write("The provided input failed JSON validation. Error: \"$json_validation\" - [process_input_files]");
					}
					else
					{
						$log->write("Decoding JSON and converting it into an array. - [process_input_files]");
						$data = decode_json_to_array($json);

						if($data === false)
						{
							$proceed_with_exec = false;
							$discard_file = true;

							/*
								Raise warning, log it, and move on.
							*/
							trigger_error("The provided input could not be converted to an array for processing - [process_input_files]", E_USER_WARNING);
							$log->write("The provided input could not be converted to an array for processing - [process_input_files]");
						}
						else
						{
							$process = store_webhook_events($db_connection, $data);

							if($process === true)
							{
								$proceed_with_exec = true;
								$discard_file = true;

								/*
									Raise notice, log it, and move on.
								*/
								trigger_error("Successfully processed input. - [process_input_files]", E_USER_NOTICE);
								$log->write("Successfully processed input. - [process_input_files]");
							}
							else
							{
								$proceed_with_exec = false;
								$discard_file = false;

								/*
									Raise notice, log it, and move on.
								*/
								trigger_error("Error encountered while processing input. - [process_input_files]", E_USER_NOTICE);
								$log->write("Error encountered while processing input. - [process_input_files]");
							}
						}
					}
				}

				$file_result = array(
						"file" => $file
						, "processed" => $proceed_with_exec
						, "delete" => $discard_file
					);

				/*
					Push results to main result array.
				*/
				array_push($result, $file_result);

			}

			if(!empty($result))
			{
				return $result;
			}
			else
			{
				return false;
			}
		}
	}

?>