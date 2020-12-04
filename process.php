<?php

	/*
		Define named constants.
		http://php.net/manual/en/function.define.php
	*/

	define('BASE_PATH', dirname(__FILE__));
	define('RES_PATH', BASE_PATH . "/res");
	define('LIB_PATH', BASE_PATH . "/lib");
	define('CLASS_PATH', BASE_PATH . "/cls");
	define('QRY_PATH', BASE_PATH . "/qry");

	require(RES_PATH . "/config.inc.php");
	require(CLASS_PATH . "/logger.class.php");

	require(LIB_PATH . "/error/exception_cleanup.php");
	require(LIB_PATH . "/error/exception_error_log.php");
	require(LIB_PATH . "/error/exception_error_output.php");
	require(LIB_PATH . "/error/exception_handler.php");
	require(LIB_PATH . "/guid/generate_guid.php");

	require(LIB_PATH . "/db/db_connect.php");
	require(LIB_PATH . "/db/db_create_tables.php");

	require(LIB_PATH . "/headers/get_request_headers.php");
	require(LIB_PATH . "/headers/return_joke_response.php");

	require(LIB_PATH . "/input/scan_for_files.php");
	require(LIB_PATH . "/input/move_input_files.php");
	require(LIB_PATH . "/input/read_input_file.php");

	require(LIB_PATH . "/json/decode_json_to_array.php");
	require(LIB_PATH . "/json/json_validate.php");

	require(LIB_PATH . "/lock/obtain_exclusive_lock.php");
	require(LIB_PATH . "/lock/release_exclusive_lock.php");

	require(LIB_PATH . "/memory/get_current_memory_usage.php");
	require(LIB_PATH . "/memory/get_peak_memory_usage.php");

	require(LIB_PATH . "/process/process_input_files.php");
	require(LIB_PATH . "/process/store_webhook_events.php");

	require(LIB_PATH . "/store/delete_event_files.php");
	require(LIB_PATH . "/store/store_event_files.php");

	/*
		Generate a GUID.
	*/
	$guid = generate_guid();

	/*
		Open logger
	*/
	try
	{
		$log = new logger();
	}
	catch (Exception $e)
	{
		if($config["debug_mode"] === true)
		{
			exception_error_output($e, $guid);
		}

		/*
			The logger is required.
		*/
		exit();
	}

	/*
		If the request was not made from the CLI, return a completely useless response to the client, log the interaction, and then full stop.

		http://php.net/manual/en/function.php-sapi-name.php
	*/
	if(PHP_SAPI !== "cli")
	{
		return_joke_response();

		$log->write("[$guid] Storing request headers.");
		$log->write("[$guid] " . get_request_headers());

		exception_error_log($e, $guid);

		if($config["debug_mode"] === true)
		{
			exception_error_output($e, $guid);
		}

		exit();
	}

	/*
		Open pid file and obtain an exclusive lock.
	*/
	try
	{
		if($config["process_lock"]["lock_process"] === true)
		{
			$log->write("[$guid] Obtaining a lock.");
			$lock_file_handle = obtain_exclusive_lock($config["process_lock"]["directory"], $config["process_lock"]["filename"]);
		}
	}
	catch (Exception $e)
	{
		exception_error_log($e, $guid);
		if($config["debug_mode"] === true)
		{
			exception_error_output($e, $guid);
		}

		exit();
	}

	/*
		Attempt to open a connection to the SQL database.
	*/
	try
	{
		$log->write("[$guid] Opening database connection.");
		$db = db_connect($config["database"]);
	}
	catch (Exception $e)
	{
		exception_error_log($e, $guid);
		if($config["debug_mode"] === true)
		{
			exception_error_output($e, $guid);
		}

		exit();
	}
	finally
	{
		if($config["debug_mode"] === true)
		{
			var_dump($db);
		}
	}

	/*
		Verify that the table exists in the SQL database.
		If it does not exist, create it.
	*/
	try
	{
		$log->write("[$guid] Checking database.");
		$build_table = db_create_tables($db, $config["database"]);
	}
	catch (Exception $e)
	{
		exception_error_log($e, $guid);
		if($config["debug_mode"] === true)
		{
			exception_error_output($e, $guid);
		}

		exit();
	}
	finally
	{
		if($config["debug_mode"] === true)
		{
			var_dump($build_table);
		}
	}

	/*
		Scan for files to process.
	*/
	try
	{
		$log->write("[$guid] Scanning for files to process.");
		$scan = scan_for_files($config["received"]["directory"]);

		if(!$scan)
		{
			throw new Exception("There are no files to process. This process cannot continue.");
		}
	}
	catch (Exception $e)
	{
		exception_error_log($e, $guid);
		if($config["debug_mode"] === true)
		{
			exception_error_output($e, $guid);
		}

		exit();
	}
	finally
	{
		if($config["debug_mode"] === true)
		{
			var_dump($scan);
		}
	}

	/*
		Move input files for processing.
	*/
	try
	{
		$log->write("[$guid] Moving input files for processing.");
		$files = move_input_files($scan, $config["temporary"], $guid);

		if(!$files)
		{
			throw new Exception("There are no files to process. This process cannot continue.");
		}
	}
	catch (Exception $e)
	{
		exception_error_log($e, $guid);
		if($config["debug_mode"] === true)
		{
			exception_error_output($e, $guid);
		}

		exit();
	}
	finally
	{
		if($config["debug_mode"] === true)
		{
			var_dump($files);
		}
	}

	/*
		Process input files.
	*/
	try
	{
		$log->write("[$guid] Reading input files into memory.");
		$process = process_input_files($files, $db);

		if(!$process)
		{
			throw new Exception("Failed to run process_input_files(). This process cannot continue.");
		}
	}
	catch (Exception $e)
	{
		exception_error_log($e, $guid);
		if($config["debug_mode"] === true)
		{
			exception_error_output($e, $guid);
		}

		exit();
	}
	finally
	{
		if($config["debug_mode"] === true)
		{
			var_dump($process);
		}
	}

	/*
		Move events to long term storage.
	*/
	try
	{
		if($config["storage"]["enable_storage"] === true)
		{
			$log->write("[$guid] Storing flagged and processed events.");
			$store_event_files = store_event_files($process, $config["storage"]["timezone"], $config["storage"]["storage_dir"], $config["storage"]["permissions"]);
		}
		else
		{
			$log->write("[$guid] Deleting flagged and processed events.");
			$delete_event_files = delete_event_files($process);
		}
	}
	catch (Exception $e)
	{
		exception_error_log($e, $guid);
		if($config["debug_mode"] === true)
		{
			exception_error_output($e, $guid);
		}

		exit();
	}
	finally
	{
		if($config["debug_mode"] === true)
		{
			var_dump($store_event_files);
		}
	}

	/*
		Release lock and close pid file.
	*/
	try
	{
		if($config["process_lock"]["lock_process"] === true)
		{
			$log->write("[$guid] Releasing lock.");
			release_exclusive_lock($config["process_lock"]["directory"], $config["process_lock"]["filename"], $config["process_lock"]["deletion"], $lock_file_handle);
		}
	}
	catch (Exception $e)
	{
		exception_error_log($e, $guid);
		if($config["debug_mode"] === true)
		{
			exception_error_output($e, $guid);
		}

		exit();
	}

	print get_current_memory_usage() . PHP_EOL;
	print get_peak_memory_usage() . PHP_EOL;

	$log->close();
	exit();

?>