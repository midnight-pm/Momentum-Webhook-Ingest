<?php

	$config = array(

		/*
			Enable/Disable Debug Mode
		*/
		"debug_mode" => true

		/*
			Process Locking
		*/
		, "process_lock" => array(
				"lock_process" => false
				, "directory" => "/tmp"
				, "filename" => "momentum_events_webhook_parser.lock"
				, "deletion" => true
			)

		/*
			Database Configuration
		*/
		, "database" => array(
				"engine" => "mysql"
				, "sql" => array(
					/*
						Database information and credentials will need to be supplied here
						in order for this process to successfully interact with the database.

						This process will be utilizing INSERT statements by way of Prepared Statements.
						https://en.wikipedia.org/wiki/Prepared_statement

						Ensure that the requisite tables are present on the database, and/or that
						the user specified has the appropriate permissions.
					*/
					"mysql" => array(
						"host_name" => "{{HOSTNAME}}"
						, "host_address" => "{{IP}}"
						, "host_port" => "3306"
						, "username" => "{{USERNAME}}"
						, "password" => "{{PASSWORD}}"
						, "database" => "{{DATABASE}}"
						, "charset" => "utf8mb4"
						, "ssl" => false
					)
					, "sqlserver" => array(
						"host_name" => "{{HOSTNAME}}"
						, "host_address" => "{{IP}}"
						, "host_port" => "1433"
						, "username" => "{{USERNAME}}"
						, "password" => "{{PASSWORD}}"
						, "database" => "{{DATABASE}}"
					)
				)
				, "sqlite" => array(
					"directory" => "/data/SQL"
					, "filename" => "momentum-db.sq3"
					/*
						Define a timezone to use for date related functions.
						http://php.net/manual/en/timezones.php
					*/
				)
				, "timezone" => "America/New_York"
			)

		/*
			Received Data Paramaters
		*/
		, "received" => array(
				/*
					Where is received data stored?

					By default, it is set to utilize a directory named "received" in the script's location.
					In some cases, this may not need to be changed.

					This script will require permissions to read from and write into that directory.
				*/
				"directory" => "/data/momentum/webhooks/received"
			)

		/*
			Temporary Data Paramaters
		*/
		, "temporary" => array(
				/*
					Use the system temporary directory?
				*/
				"use_system_temp" => false

				/*
					Where to temporarily store data?

					By default, it is set to utilize the system's temporary directory.
					In some cases, this may not need to be changed.

					This script will require permissions to read from and write into that directory.
				*/
				, "directory" => "/home/momentum/data/webhooks/temp"
			)

		/*
			Data Storage Parameters
		*/
		, "storage" => array(
				/*
					Define a timezone to use for date related functions.
					http://php.net/manual/en/timezones.php
				*/
				"timezone" => "America/New_York"

				/*
					Where will addressed data be stored?

					By default, it is set to utilize a directory named "storage" in the script's location.
					In some cases, this may not need to be changed.

					This script will require permissions to read from and write into that directory.
				*/
				, "enable_storage" => false
				, "directory" => "/data/momentum/webhooks/processed"

				/*
					This controls the permissions of the data storage directory.

					This will need to be defined using NUMERIC notation.
					In most cases, 0755 should suffice. Adjust accordingly as necessary.

					For further information, reference: 
					https://en.wikipedia.org/w/index.php?title=File_system_permissions&oldid=808567801#Numeric_notation

					Note: This setting has no effect when executed under Windows, but will still *need* to be set.
				*/
				, "permissions" => 0755
			)

		/*
			Logging Parameters
		*/
		, "logger" => array(
				/*
					Define a timezone to use for date related functions.
					http://php.net/manual/en/timezones.php
				*/
				"timezone" => "America/New_York"

				/*
					Where will log files be stored?
					In some cases, this may not need to be changed.
					By default, it is set to create a directory named "logs" in the script's location.
					If this script does not have permissions to do so, a directory will need to be created for it.
					This script will require permissions to write into that directory.
				*/
				, "log_dir_path" => "/home/momentum/data/webhooks/logs"

				/*
					This controls the permissions of the log directory.

					This will need to be defined using NUMERIC notation.
					In most cases, 0755 should suffice. Adjust accordingly as necessary.

					For further information, reference: 
					https://en.wikipedia.org/w/index.php?title=File_system_permissions&oldid=808567801#Numeric_notation

					Note: This setting has no effect when executed under Windows, but will still *need* to be set.
				*/
				, "log_dir_permissions" => 0755

				/*
					This identifies the prefix of the file name for the log files.
				*/
				, "log_file_name_prexfix" => "momentum_po"
			)
	);

?>