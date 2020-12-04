<?php


	/*
		http://php.net/manual/en/function.function-exists.php
	*/
	if(!function_exists("db_connect"))
	{
		/*
			http://php.net/manual/en/functions.user-defined.php
		*/
		function db_connect($db_config)
		{
			/*
				Test input.
				http://php.net/manual/en/function.is-array.php
			*/
			if(!is_array($db_config))
			{
				throw new Exception("Input is invalid. - [db_connect]");

				return false;
			}
			else
			{
				/*
					Test input to ensure that it is not empty.
				*/
				if(empty($db_config["engine"]))
				{
					throw new Exception("Missing database engine specification. - [db_connect]");

					return false;
				}
			}

			/*
				Select the database type.
			*/
			if(strtolower($db_config["engine"]) === "mysql")
			{
				/*
					Test config parameters to ensure they are not empty.
				*/
				if(empty($db_config["sql"]["mysql"]["host_name"]))
				{
					throw new Exception("Missing server. - [db_connect]");

					return false;
				}
				if(empty($db_config["sql"]["mysql"]["host_address"]))
				{
					throw new Exception("Missing server address. - [db_connect]");

					return false;
				}
				if(empty($db_config["sql"]["mysql"]["host_port"]))
				{
					throw new Exception("Missing server port. - [db_connect]");

					return false;
				}
				elseif(empty($db_config["sql"]["mysql"]["database"]))
				{
					throw new Exception("Missing database name. - [db_connect]");

					return false;
				}
				elseif(empty($db_config["sql"]["mysql"]["username"]))
				{
					throw new Exception("Missing username. - [db_connect]");

					return false;
				}
				elseif(empty($db_config["sql"]["mysql"]["password"]))
				{
					throw new Exception("Missing password. - [db_connect]");

					return false;
				}
				elseif(empty($db_config["sql"]["mysql"]["charset"]))
				{
					throw new Exception("Missing password. - [db_connect]");

					return false;
				}
			}
			elseif(strtolower($db_config["engine"]) === "sqlserver")
			{
				/*
					Test config parameters to ensure they are not empty.
				*/
				if(empty($db_config["sql"]["sqlserver"]["host_name"]))
				{
					throw new Exception("Missing server. - [db_connect]");

					return false;
				}
				if(empty($db_config["sql"]["sqlserver"]["host_address"]))
				{
					throw new Exception("Missing server address. - [db_connect]");

					return false;
				}
				if(empty($db_config["sql"]["sqlserver"]["host_port"]))
				{
					throw new Exception("Missing server port. - [db_connect]");

					return false;
				}
				elseif(empty($db_config["sql"]["sqlserver"]["database"]))
				{
					throw new Exception("Missing database name. - [db_connect]");

					return false;
				}
				elseif(empty($db_config["sql"]["sqlserver"]["username"]))
				{
					throw new Exception("Missing username. - [db_connect]");

					return false;
				}
				elseif(empty($db_config["sql"]["sqlserver"]["password"]))
				{
					throw new Exception("Missing password. - [db_connect]");

					return false;
				}
			}
			elseif(strtolower($db_config["engine"]) === "sqlite")
			{
				/*
					Test config parameters to ensure they are not empty.
				*/
				if(empty($db_config["sqlite"]["directory"]))
				{
					throw new Exception("Missing database location. - [db_connect]");

					return false;
				}
				if(empty($db_config["sqlite"]["filename"]))
				{
					throw new Exception("Missing database filename. - [db_connect]");

					return false;
				}

				/*
					Set location of file.
				*/
				$db_location = $db_config["directory"] . "/" . $db_config ["filename"];

				if(file_exists($db_location) === false)
				{
					throw new Exception("Specified database location of \"$db_location\" does not appear to exist.");
				}
				else
				{
					if(is_readable($db_location) === false)
					{
						throw new Exception("Permission error: The file \"$db_location\" does not appear to be readable.");
					}
					else
					{
						if(is_writable($db_location) === false)
						{
							throw new Exception("Permission error: The file \"$db_location\" does not appear to be writeable.");
						}
					}
				}
			}
			else
			{
				throw new Exception("Unsupported database type. - [db_connect]");

				return false;
			}

			/*
				http://php.net/manual/en/pdo.getavailabledrivers.php
			*/
			$available_pdo_drivers = PDO::getAvailableDrivers();

			/*
				Construct DSN Variable depending on the selected database type.
			*/
			if(strtolower($db_config["engine"]) === "mysql")
			{
				/*
					Confirm availability of needed SQL driver.

					http://php.net/manual/en/function.in-array.php
				*/
				if(in_array("mysql", $available_pdo_drivers))
				{
					/*
						https://www.php.net/manual/en/ref.pdo-mysql.connection.php
						https://www.php.net/manual/en/mysqlinfo.concepts.charset.php
					*/
					$data_source_name = "mysql:host=" . $db_config["sql"]["mysql"]["host_name"] . ";port=" . $db_config["sql"]["mysql"]["host_port"] . ";dbname=" . $db_config["sql"]["mysql"]["database"] . ";charset=" . $db_config["sql"]["mysql"]["charset"];

					$username = $db_config["sql"]["mysql"]["username"];
					$password = $db_config["sql"]["mysql"]["password"];
				}
				else
				{
					throw new Exception("Could not find the necessary SQL driver. There is no SQL driver available for SQLSRV nor for DBLIB. - [db_connect]");

					return false;
				}
			}
			elseif(strtolower($db_config["engine"]) === "sqlserver")
			{
				/*
					Confirm availability of needed SQL driver.
				*/
				if(in_array("sqlsrv", $available_pdo_drivers))
				{
					/*
						http://php.net/manual/en/ref.pdo-sqlsrv.connection.php
					*/
					$data_source_name = "sqlsrv:Server=" . $db_config["sql"]["sqlserver"]["host_name"] . ";Database=" . $db_config["sql"]["sqlserver"]["database"] . ";Encrypt=true;TrustServerCertificate=true";
				}
				elseif(in_array("dblib", $available_pdo_drivers))
				{
					/*
						http://php.net/manual/en/ref.pdo-dblib.php
					*/
					$data_source_name = "dblib:host=" . $db_config["sql"]["sqlserver"]["host_name"] . ";dbname=" . $db_config["sql"]["sqlserver"]["database"] . "";
				}
				else
				{
					throw new Exception("Could not find the necessary SQL driver. There is no SQL driver available for SQLSRV nor for DBLIB. - [db_connect]");

					return false;
				}

				$username = $db_config["sql"]["sqlserver"]["username"];
				$password = $db_config["sql"]["sqlserver"]["password"];
			}
			elseif(strtolower($db_config["engine"]) === "sqlite")
			{
				/*
					Confirm availability of needed SQL driver.
				*/
				if(in_array("sqlite", $available_pdo_drivers))
				{
					/*
						https://php.net/manual/en/ref.pdo-sqlite.connection.php
					*/
					$data_source_name = "sqlite:" . $db_location;
				}
				else
				{
					throw new Exception("Could not find the necessary SQL driver. There is no SQL driver available for SQLITE. - [db_connect]");

					return false;
				}
			}

			/*
				Attempt a connection.
			*/
			try
			{
				/*
					http://php.net/manual/en/pdo.construct.php
				*/
				if(strtolower($db_config["engine"]) === "mysql")
				{
					if($db_config["sql"]["mysql"]["ssl"] === true)
					{
						/*
							https://stackoverflow.com/a/56153645
						*/
						$connection = new PDO($data_source_name, $username, $password, [ PDO::MYSQL_ATTR_SSL_CA => true, PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false ]);
					}
					else
					{
						$connection = new PDO($data_source_name, $username, $password);
					}
				}
				elseif(strtolower($db_config["engine"]) === "sqlserver")
				{
					$connection = new PDO($data_source_name, $username, $password);
				}
				elseif(strtolower($db_config["engine"]) === "sqlite")
				{
					$connection = new PDO($data_source_name);
				}

				/*
					https://www.php.net/manual/en/pdo.setattribute.php
				*/
				$connection->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			}
			/*
				Use the PDOException handler.
				http://php.net/manual/en/class.pdoexception.php
			*/
			catch(PDOException $e)
			{
				$error_msg = $e->getMessage();
				$error_code = $e->getCode();

				$error = "$error_msg - [$error_code] - [db_connect]";
				throw new Exception($error); 

				return false;
			}

			return $connection;
		}
	}
	
?>
