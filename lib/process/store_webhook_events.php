<?php

	/*
		http://php.net/manual/en/function.function-exists.php
	*/
	if(!function_exists("store_webhook_events"))
	{
		/*
			http://php.net/manual/en/functions.user-defined.php
		*/
		function store_webhook_events($db_connection, $webhooks)
		{
			global $log;
			global $config;

			/*
				http://php.net/manual/en/function.is-object.php
			*/
			if(!is_object($db_connection))
			{
				throw new Exception("Database connection is not available. - [store_webhook_events]");

				return false;
			}

			/*
				Assign SQL queries array.
			*/
			$query_files = array(
				"injection" => QRY_PATH . "/webhooks/injection.sql"
				, "delivery" => QRY_PATH . "/webhooks/delivery.sql"
				, "delay" => QRY_PATH . "/webhooks/delay.sql"
				, "bounce" => QRY_PATH . "/webhooks/bounce.sql"
				, "out_of_band" => QRY_PATH . "/webhooks/out_of_band.sql"
				, "policy_rejection" => QRY_PATH . "/webhooks/policy_rejection.sql"
				, "spam_complaint" => QRY_PATH . "/webhooks/spam_complaint.sql"
				, "open" => QRY_PATH . "/webhooks/open.sql"
				, "click" => QRY_PATH . "/webhooks/click.sql"
				, "list_unsubscribe" => QRY_PATH . "/webhooks/list_unsubscribe.sql"
				, "link_unsubscribe" => QRY_PATH . "/webhooks/link_unsubscribe.sql"
				, "ad_adjust" => QRY_PATH . "/webhooks/ad_adjust.sql"
				, "ad_status" => QRY_PATH . "/webhooks/ad_status.sql"
			);

			/*
				Confirm query files exist.
			*/
			foreach($query_files AS $query_file)
			{
				if(!file_exists($query_file))
				{
					throw new Exception("Missing file \"$query_file\". - [store_webhook_events]");

					return false;
				}
			}

			/*
				http://php.net/manual/en/function.is-array.php
			*/
			if(is_array($webhooks))
			{
				/*
					http://php.net/manual/en/function.count.php
				*/
				$webhook_count = count($webhooks);
				if($config["debug_mode"] == true)
				{
					trigger_error("Processing $webhook_count webhook(s). - [store_webhook_events]", E_USER_NOTICE);
				}
				$log->write("Processing $webhook_count webhook(s). - [store_webhook_events]");

				/*
					BEGIN SQL Transaction
				*/
				if($config["debug_mode"] == true)
				{
					trigger_error("Beginnning SQL Transaction. - [store_webhook_events]", E_USER_NOTICE);
				}
				$log->write("Beginnning SQL Transaction. - [store_webhook_events]");
				$db_connection->beginTransaction();

				foreach($webhooks AS $webhook)
				{
					/*
						Evaluate Input to Ensure that 
					*/
					if(!empty($webhook["msys"]["message_event"]))
					{
						$array = $webhook["msys"]["message_event"];
					}
					elseif(!empty($webhook["msys"]["track_event"]))
					{
						$array = $webhook["msys"]["track_event"];
					}
					elseif(!empty($webhook["msys"]["unsubscribe_event"]))
					{
						$array = $webhook["msys"]["unsubscribe_event"];
					}
					elseif(!empty($webhook["message_event"]))
					{
						$array = $webhook["message_event"];
					}
					elseif(!empty($webhook["track_event"]))
					{
						$array = $webhook["track_event"];
					}
					elseif(!empty($webhook["unsubscribe_event"]))
					{
						$array = $webhook["unsubscribe_event"];
					}
					else
					{
						$array = $webhook;
					}

					if(isset($array["type"]) && !empty($array["type"]))
					{
						if($config["debug_mode"] == true)
						{
							trigger_error("Recording webhook of type \"" . $array["type"] . "\". - [store_webhook_events]", E_USER_NOTICE);
						}
						$log->write("Recording webhook of type \"" . $array["type"] . "\". - [store_webhook_events]");

						/*
							Convert "rcpt_meta" back to a JSON string, and store as such.
							Retain partial output on error as it is a string. The data should be retained as close to its raw form as is possible.

							http://php.net/manual/en/function.json-encode.php
							http://php.net/manual/en/json.constants.php

							If "rcpt_meta" does not have a value, then set the field to null and insert as such.
						*/
						if(isset($array["rcpt_meta"]))
						{
							if(!empty($array["rcpt_meta"]))
							{
								$rcpt_meta_json = json_encode($array["rcpt_meta"], JSON_PARTIAL_OUTPUT_ON_ERROR);

								/*
									Overwrite the value of the key "rcpt_meta" with JSON string stored in $rcpt_meta_json.
								*/
								$array["rcpt_meta"] = $rcpt_meta_json;

								if($config["debug_mode"] === true)
								{
									var_dump($array["rcpt_meta"]);
								}
							}
							else
							{
								$array["rcpt_meta"] = NULL;
							}
						}
						else
						{
							$array["rcpt_meta"] = NULL;
						}

						/*
							As with "rcpt_meta", convert "rcpt_tags" back to a JSON string, and store as such.
						*/
						if(isset($array["rcpt_tags"]))
						{
							if(!empty($array["rcpt_tags"]))
							{
								$rcpt_tags_json = json_encode($array["rcpt_tags"], JSON_PARTIAL_OUTPUT_ON_ERROR);

								/*
									Overwrite the value of the key "rcpt_tags" with JSON string stored in $rcpt_tags_json.
								*/
								$array["rcpt_tags"] = $rcpt_tags_json;

								if($config["debug_mode"] === true)
								{
									var_dump($array["rcpt_tags"]);
								}
							}
							else
							{
								$array["rcpt_tags"] = NULL;
							}
						}
						else
						{
							$array["rcpt_tags"] = NULL;
						}

						/*
							http://php.net/manual/en/control-structures.switch.php

							https://stackoverflow.com/questions/3399755/if-versus-switch
							https://stackoverflow.com/questions/10773047/which-is-faster-and-better-switch-case-or-if-else-if
						*/
						switch($array["type"])
						{
							/*
								The column "type" is evaluated using a switch statement. Based on the value of the key "type",
								a respective query is used. That query is then prepared, and further populated with keys from 
								array based on the switch case.

								Because keys need to be checked to determine if they are set within the scope of an array,
								is/elseif/else is not valid syntax.

								Accordingly, tertiary operators are used instead.

								The syntax can be read as follows: if the key is set (regardless of whether or not it has a 
								value), then use the value of that key (if there is no value, then the field would be empty).
								If the key is not set, then supply "NULL" instead.

								Statements will be passed this array of values in the execution phase of the SQL statement.
								The result of the statement will, in turn, be passed to the variable $sql_result.

								Reference:
								
								http://php.net/manual/en/pdo.prepare.php
								https://developers.sparkpost.com/api/webhooks/
							*/
							case "injection":
								$sql_params_injection = array(
										"timestamp" => (isset($array["timestamp"]) ? $array["timestamp"] : NULL)
										, "type" => (isset($array["type"]) ? $array["type"] : NULL)
										, "event_id" => (isset($array["event_id"]) ? $array["event_id"] : NULL)
										, "node_name" => (isset($array["node_name"]) ? $array["node_name"] : NULL)
										, "recv_method" => (isset($array["recv_method"]) ? $array["recv_method"] : NULL)
										, "subaccount_id" => (isset($array["subaccount_id"]) ? $array["subaccount_id"] : NULL)
										, "transmission_id" => (isset($array["transmission_id"]) ? $array["transmission_id"] : NULL)
										, "conn_name" => (isset($array["conn_name"]) ? $array["conn_name"] : NULL)
										, "msg_batchname" => (isset($array["msg_batchname"]) ? $array["msg_batchname"] : NULL)
										, "msg_spoolname" => (isset($array["msg_spoolname"]) ? $array["msg_spoolname"] : NULL)
										, "conn_stage" => (isset($array["conn_stage"]) ? $array["conn_stage"] : NULL)
										, "message_id" => (isset($array["message_id"]) ? $array["message_id"] : NULL)
										, "binding" => (isset($array["binding"]) ? $array["binding"] : NULL)
										, "binding_group" => (isset($array["binding_group"]) ? $array["binding_group"] : NULL)
										, "pathway" => (isset($array["pathway"]) ? $array["pathway"] : NULL)
										, "pathway_group" => (isset($array["pathway_group"]) ? $array["pathway_group"] : NULL)
										, "msg_size" => (isset($array["msg_size"]) ? $array["msg_size"] : NULL)
										, "routing_domain" => (isset($array["routing_domain"]) ? $array["routing_domain"] : NULL)
										, "msg_from" => (isset($array["msg_from"]) ? $array["msg_from"] : NULL)
										, "friendly_from" => (isset($array["friendly_from"]) ? $array["friendly_from"] : NULL)
										, "rcpt_to" => (isset($array["rcpt_to"]) ? $array["rcpt_to"] : NULL)
										, "raw_rcpt_to" => (isset($array["raw_rcpt_to"]) ? $array["raw_rcpt_to"] : NULL)
										, "rcpt_type" => (isset($array["rcpt_type"]) ? $array["rcpt_type"] : NULL)
										, "subject" => (isset($array["subject"]) ? $array["subject"] : NULL)
										, "customer_id" => (isset($array["customer_id"]) ? $array["customer_id"] : NULL)
										, "campaign_id" => (isset($array["campaign_id"]) ? $array["campaign_id"] : NULL)
										, "template_id" => (isset($array["template_id"]) ? $array["template_id"] : NULL)
										, "template_version" => (isset($array["template_version"]) ? $array["template_version"] : NULL)
										, "rcpt_tags" => (isset($array["rcpt_tags"]) ? $array["rcpt_tags"] : NULL)
										, "rcpt_meta" => (isset($array["rcpt_meta"]) ? $array["rcpt_meta"] : NULL)
									);
								$sql_query = file_get_contents($query_files["injection"]);
								$sql_statement = $db_connection->prepare($sql_query);
								$sql_result = $sql_statement->execute($sql_params_injection);

								if($config["debug_mode"] === true)
								{
									var_dump($sql_params_injection);
								}
							break;

							case "delivery":
								$sql_params_delivery = array(
										"timestamp" => (isset($array["timestamp"]) ? $array["timestamp"] : NULL)
										, "type" => (isset($array["type"]) ? $array["type"] : NULL)
										, "event_id" => (isset($array["event_id"]) ? $array["event_id"] : NULL)
										, "node_name" => (isset($array["node_name"]) ? $array["node_name"] : NULL)
										, "recv_method" => (isset($array["recv_method"]) ? $array["recv_method"] : NULL)
										, "delv_method" => (isset($array["delv_method"]) ? $array["delv_method"] : NULL)
										, "subaccount_id" => (isset($array["subaccount_id"]) ? $array["subaccount_id"] : NULL)
										, "transmission_id" => (isset($array["transmission_id"]) ? $array["transmission_id"] : NULL)
										, "conn_name" => (isset($array["conn_name"]) ? $array["conn_name"] : NULL)
										, "msg_batchname" => (isset($array["msg_batchname"]) ? $array["msg_batchname"] : NULL)
										, "msg_spoolname" => (isset($array["msg_spoolname"]) ? $array["msg_spoolname"] : NULL)
										, "conn_stage" => (isset($array["conn_stage"]) ? $array["conn_stage"] : NULL)
										, "message_id" => (isset($array["message_id"]) ? $array["message_id"] : NULL)
										, "binding" => (isset($array["binding"]) ? $array["binding"] : NULL)
										, "binding_group" => (isset($array["binding_group"]) ? $array["binding_group"] : NULL)
										, "msg_size" => (isset($array["msg_size"]) ? $array["msg_size"] : NULL)
										, "routing_domain" => (isset($array["routing_domain"]) ? $array["routing_domain"] : NULL)
										, "msg_from" => (isset($array["msg_from"]) ? $array["msg_from"] : NULL)
										, "friendly_from" => (isset($array["friendly_from"]) ? $array["friendly_from"] : NULL)
										, "rcpt_to" => (isset($array["rcpt_to"]) ? $array["rcpt_to"] : NULL)
										, "raw_rcpt_to" => (isset($array["raw_rcpt_to"]) ? $array["raw_rcpt_to"] : NULL)
										, "rcpt_type" => (isset($array["rcpt_type"]) ? $array["rcpt_type"] : NULL)
										, "subject" => (isset($array["subject"]) ? $array["subject"] : NULL)
										, "queue_time" => (isset($array["queue_time"]) ? $array["queue_time"] : NULL)
										, "num_retries" => (isset($array["num_retries"]) ? $array["num_retries"] : NULL)
										, "ip_address" => (isset($array["ip_address"]) ? $array["ip_address"] : NULL)
										, "customer_id" => (isset($array["customer_id"]) ? $array["customer_id"] : NULL)
										, "campaign_id" => (isset($array["campaign_id"]) ? $array["campaign_id"] : NULL)
										, "template_id" => (isset($array["template_id"]) ? $array["template_id"] : NULL)
										, "template_version" => (isset($array["template_version"]) ? $array["template_version"] : NULL)
										, "rcpt_tags" => (isset($array["rcpt_tags"]) ? $array["rcpt_tags"] : NULL)
										, "rcpt_meta" => (isset($array["rcpt_meta"]) ? $array["rcpt_meta"] : NULL)
									);
								$sql_query = file_get_contents($query_files["delivery"]);
								$sql_statement = $db_connection->prepare($sql_query);
								$sql_result = $sql_statement->execute($sql_params_delivery);

								if($config["debug_mode"] === true)
								{
									var_dump($sql_params_delivery);
								}
							break;

							case "delay":
								$sql_params_delay = array(
										"timestamp" => (isset($array["timestamp"]) ? $array["timestamp"] : NULL)
										, "type" => (isset($array["type"]) ? $array["type"] : NULL)
										, "event_id" => (isset($array["event_id"]) ? $array["event_id"] : NULL)
										, "node_name" => (isset($array["node_name"]) ? $array["node_name"] : NULL)
										, "recv_method" => (isset($array["recv_method"]) ? $array["recv_method"] : NULL)
										, "delv_method" => (isset($array["delv_method"]) ? $array["delv_method"] : NULL)
										, "subaccount_id" => (isset($array["subaccount_id"]) ? $array["subaccount_id"] : NULL)
										, "transmission_id" => (isset($array["transmission_id"]) ? $array["transmission_id"] : NULL)
										, "conn_name" => (isset($array["conn_name"]) ? $array["conn_name"] : NULL)
										, "msg_batchname" => (isset($array["msg_batchname"]) ? $array["msg_batchname"] : NULL)
										, "msg_spoolname" => (isset($array["msg_spoolname"]) ? $array["msg_spoolname"] : NULL)
										, "conn_stage" => (isset($array["conn_stage"]) ? $array["conn_stage"] : NULL)
										, "message_id" => (isset($array["message_id"]) ? $array["message_id"] : NULL)
										, "binding" => (isset($array["binding"]) ? $array["binding"] : NULL)
										, "binding_group" => (isset($array["binding_group"]) ? $array["binding_group"] : NULL)
										, "msg_size" => (isset($array["msg_size"]) ? $array["msg_size"] : NULL)
										, "routing_domain" => (isset($array["routing_domain"]) ? $array["routing_domain"] : NULL)
										, "msg_from" => (isset($array["msg_from"]) ? $array["msg_from"] : NULL)
										, "friendly_from" => (isset($array["friendly_from"]) ? $array["friendly_from"] : NULL)
										, "rcpt_to" => (isset($array["rcpt_to"]) ? $array["rcpt_to"] : NULL)
										, "raw_rcpt_to" => (isset($array["raw_rcpt_to"]) ? $array["raw_rcpt_to"] : NULL)
										, "rcpt_type" => (isset($array["rcpt_type"]) ? $array["rcpt_type"] : NULL)
										, "subject" => (isset($array["subject"]) ? $array["subject"] : NULL)
										, "queue_time" => (isset($array["queue_time"]) ? $array["queue_time"] : NULL)
										, "num_retries" => (isset($array["num_retries"]) ? $array["num_retries"] : NULL)
										, "bounce_class" => (isset($array["bounce_class"]) ? $array["bounce_class"] : NULL)
										, "error_code" => (isset($array["error_code"]) ? $array["error_code"] : NULL)
										, "reason" => (isset($array["reason"]) ? $array["reason"] : NULL)
										, "raw_reason" => (isset($array["raw_reason"]) ? $array["raw_reason"] : NULL)
										, "customer_id" => (isset($array["customer_id"]) ? $array["customer_id"] : NULL)
										, "campaign_id" => (isset($array["campaign_id"]) ? $array["campaign_id"] : NULL)
										, "template_id" => (isset($array["template_id"]) ? $array["template_id"] : NULL)
										, "template_version" => (isset($array["template_version"]) ? $array["template_version"] : NULL)
										, "rcpt_meta" => (isset($array["rcpt_meta"]) ? $array["rcpt_meta"] : NULL)
										, "rcpt_tags" => (isset($array["rcpt_tags"]) ? $array["rcpt_tags"] : NULL)
									);
								$sql_query = file_get_contents($query_files["delay"]);
								$sql_statement = $db_connection->prepare($sql_query);
								$sql_result = $sql_statement->execute($sql_params_delay);

								if($config["debug_mode"] === true)
								{
									var_dump($sql_params_delay);
								}
							break;

							case "bounce":
								$sql_params_bounce = array(
										"timestamp" => (isset($array["timestamp"]) ? $array["timestamp"] : NULL)
										, "type" => (isset($array["type"]) ? $array["type"] : NULL)
										, "event_id" => (isset($array["event_id"]) ? $array["event_id"] : NULL)
										, "node_name" => (isset($array["node_name"]) ? $array["node_name"] : NULL)
										, "recv_method" => (isset($array["recv_method"]) ? $array["recv_method"] : NULL)
										, "delv_method" => (isset($array["delv_method"]) ? $array["delv_method"] : NULL)
										, "subaccount_id" => (isset($array["subaccount_id"]) ? $array["subaccount_id"] : NULL)
										, "transmission_id" => (isset($array["transmission_id"]) ? $array["transmission_id"] : NULL)
										, "conn_name" => (isset($array["conn_name"]) ? $array["conn_name"] : NULL)
										, "msg_batchname" => (isset($array["msg_batchname"]) ? $array["msg_batchname"] : NULL)
										, "msg_spoolname" => (isset($array["msg_spoolname"]) ? $array["msg_spoolname"] : NULL)
										, "conn_stage" => (isset($array["conn_stage"]) ? $array["conn_stage"] : NULL)
										, "message_id" => (isset($array["message_id"]) ? $array["message_id"] : NULL)
										, "binding" => (isset($array["binding"]) ? $array["binding"] : NULL)
										, "binding_group" => (isset($array["binding_group"]) ? $array["binding_group"] : NULL)
										, "msg_size" => (isset($array["msg_size"]) ? $array["msg_size"] : NULL)
										, "routing_domain" => (isset($array["routing_domain"]) ? $array["routing_domain"] : NULL)
										, "msg_from" => (isset($array["msg_from"]) ? $array["msg_from"] : NULL)
										, "friendly_from" => (isset($array["friendly_from"]) ? $array["friendly_from"] : NULL)
										, "rcpt_to" => (isset($array["rcpt_to"]) ? $array["rcpt_to"] : NULL)
										, "raw_rcpt_to" => (isset($array["raw_rcpt_to"]) ? $array["raw_rcpt_to"] : NULL)
										, "rcpt_type" => (isset($array["rcpt_type"]) ? $array["rcpt_type"] : NULL)
										, "subject" => (isset($array["subject"]) ? $array["subject"] : NULL)
										, "queue_time" => (isset($array["queue_time"]) ? $array["queue_time"] : NULL)
										, "num_retries" => (isset($array["num_retries"]) ? $array["num_retries"] : NULL)
										, "bounce_class" => (isset($array["bounce_class"]) ? $array["bounce_class"] : NULL)
										, "error_code" => (isset($array["error_code"]) ? $array["error_code"] : NULL)
										, "reason" => (isset($array["reason"]) ? $array["reason"] : NULL)
										, "raw_reason" => (isset($array["raw_reason"]) ? $array["raw_reason"] : NULL)
										, "customer_id" => (isset($array["customer_id"]) ? $array["customer_id"] : NULL)
										, "campaign_id" => (isset($array["campaign_id"]) ? $array["campaign_id"] : NULL)
										, "template_id" => (isset($array["template_id"]) ? $array["template_id"] : NULL)
										, "template_version" => (isset($array["template_version"]) ? $array["template_version"] : NULL)
										, "rcpt_meta" => (isset($array["rcpt_meta"]) ? $array["rcpt_meta"] : NULL)
										, "rcpt_tags" => (isset($array["rcpt_tags"]) ? $array["rcpt_tags"] : NULL)
									);
								$sql_query = file_get_contents($query_files["bounce"]);
								$sql_statement = $db_connection->prepare($sql_query);
								$sql_result = $sql_statement->execute($sql_params_bounce);

								if($config["debug_mode"] === true)
								{
									var_dump($sql_params_bounce);
								}
							break;

							case "out_of_band":
								$sql_params_out_of_band = array(
										"timestamp" => (isset($array["timestamp"]) ? $array["timestamp"] : NULL)
										, "type" => (isset($array["type"]) ? $array["type"] : NULL)
										, "event_id" => (isset($array["event_id"]) ? $array["event_id"] : NULL)
										, "node_name" => (isset($array["node_name"]) ? $array["node_name"] : NULL)
										, "recv_method" => (isset($array["recv_method"]) ? $array["recv_method"] : NULL)
										, "delv_method" => (isset($array["delv_method"]) ? $array["delv_method"] : NULL)
										, "subaccount_id" => (isset($array["subaccount_id"]) ? $array["subaccount_id"] : NULL)
										, "conn_stage" => (isset($array["conn_stage"]) ? $array["conn_stage"] : NULL)
										, "message_id" => (isset($array["message_id"]) ? $array["message_id"] : NULL)
										, "binding" => (isset($array["binding"]) ? $array["binding"] : NULL)
										, "binding_group" => (isset($array["binding_group"]) ? $array["binding_group"] : NULL)
										, "msg_from" => (isset($array["msg_from"]) ? $array["msg_from"] : NULL)
										, "rcpt_to" => (isset($array["rcpt_to"]) ? $array["rcpt_to"] : NULL)
										, "raw_rcpt_to" => (isset($array["raw_rcpt_to"]) ? $array["raw_rcpt_to"] : NULL)
										, "bounce_class" => (isset($array["bounce_class"]) ? $array["bounce_class"] : NULL)
										, "error_code" => (isset($array["error_code"]) ? $array["error_code"] : NULL)
										, "reason" => (isset($array["reason"]) ? $array["reason"] : NULL)
										, "raw_reason" => (isset($array["raw_reason"]) ? $array["raw_reason"] : NULL)
										, "customer_id" => (isset($array["customer_id"]) ? $array["customer_id"] : NULL)
										, "campaign_id" => (isset($array["campaign_id"]) ? $array["campaign_id"] : NULL)
										, "template_id" => (isset($array["template_id"]) ? $array["template_id"] : NULL)
										, "template_version" => (isset($array["template_version"]) ? $array["template_version"] : NULL)
									);
								$sql_query = file_get_contents($query_files["out_of_band"]);
								$sql_statement = $db_connection->prepare($sql_query);
								$sql_result = $sql_statement->execute($sql_params_out_of_band);

								if($config["debug_mode"] === true)
								{
									var_dump($sql_params_out_of_band);
								}
							break;

							case "policy_rejection":
								$sql_params_policy_rejection = array(
										"timestamp" => (isset($array["timestamp"]) ? $array["timestamp"] : NULL)
										, "type" => (isset($array["type"]) ? $array["type"] : NULL)
										, "event_id" => (isset($array["event_id"]) ? $array["event_id"] : NULL)
										, "node_name" => (isset($array["node_name"]) ? $array["node_name"] : NULL)
										, "recv_method" => (isset($array["recv_method"]) ? $array["recv_method"] : NULL)
										, "subaccount_id" => (isset($array["subaccount_id"]) ? $array["subaccount_id"] : NULL)
										, "transmission_id" => (isset($array["transmission_id"]) ? $array["transmission_id"] : NULL)
										, "conn_name" => (isset($array["conn_name"]) ? $array["conn_name"] : NULL)
										, "message_id" => (isset($array["message_id"]) ? $array["message_id"] : NULL)
										, "binding" => (isset($array["binding"]) ? $array["binding"] : NULL)
										, "binding_group" => (isset($array["binding_group"]) ? $array["binding_group"] : NULL)
										, "pathway" => (isset($array["pathway"]) ? $array["pathway"] : NULL)
										, "pathway_group" => (isset($array["pathway_group"]) ? $array["pathway_group"] : NULL)
										, "msg_from" => (isset($array["msg_from"]) ? $array["msg_from"] : NULL)
										, "friendly_from" => (isset($array["friendly_from"]) ? $array["friendly_from"] : NULL)
										, "rcpt_to" => (isset($array["rcpt_to"]) ? $array["rcpt_to"] : NULL)
										, "raw_rcpt_to" => (isset($array["raw_rcpt_to"]) ? $array["raw_rcpt_to"] : NULL)
										, "rcpt_type" => (isset($array["rcpt_type"]) ? $array["rcpt_type"] : NULL)
										, "error_code" => (isset($array["error_code"]) ? $array["error_code"] : NULL)
										, "reason" => (isset($array["reason"]) ? $array["reason"] : NULL)
										, "raw_reason" => (isset($array["raw_reason"]) ? $array["raw_reason"] : NULL)
										, "scope_name" => (isset($array["scope_name"]) ? $array["scope_name"] : NULL)
										, "customer_id" => (isset($array["customer_id"]) ? $array["customer_id"] : NULL)
										, "campaign_id" => (isset($array["campaign_id"]) ? $array["campaign_id"] : NULL)
										, "template_id" => (isset($array["template_id"]) ? $array["template_id"] : NULL)
										, "template_version" => (isset($array["template_version"]) ? $array["template_version"] : NULL)
										, "rcpt_meta" => (isset($array["rcpt_meta"]) ? $array["rcpt_meta"] : NULL)
										, "rcpt_tags" => (isset($array["rcpt_tags"]) ? $array["rcpt_tags"] : NULL)
									);
								$sql_query = file_get_contents($query_files["policy_rejection"]);
								$sql_statement = $db_connection->prepare($sql_query);
								$sql_result = $sql_statement->execute($sql_params_policy_rejection);

								if($config["debug_mode"] === true)
								{
									var_dump($sql_params_policy_rejection);
								}
							break;

							case "spam_complaint":
								$sql_params_spam_complaint = array(
										"timestamp" => (isset($array["timestamp"]) ? $array["timestamp"] : NULL)
										, "type" => (isset($array["type"]) ? $array["type"] : NULL)
										, "event_id" => (isset($array["event_id"]) ? $array["event_id"] : NULL)
										, "node_name" => (isset($array["node_name"]) ? $array["node_name"] : NULL)
										, "subaccount_id" => (isset($array["subaccount_id"]) ? $array["subaccount_id"] : NULL)
										, "transmission_id" => (isset($array["transmission_id"]) ? $array["transmission_id"] : NULL)
										, "msg_spoolname" => (isset($array["msg_spoolname"]) ? $array["msg_spoolname"] : NULL)
										, "message_id" => (isset($array["message_id"]) ? $array["message_id"] : NULL)
										, "binding" => (isset($array["binding"]) ? $array["binding"] : NULL)
										, "binding_group" => (isset($array["binding_group"]) ? $array["binding_group"] : NULL)
										, "friendly_from" => (isset($array["friendly_from"]) ? $array["friendly_from"] : NULL)
										, "rcpt_to" => (isset($array["rcpt_to"]) ? $array["rcpt_to"] : NULL)
										, "raw_rcpt_to" => (isset($array["raw_rcpt_to"]) ? $array["raw_rcpt_to"] : NULL)
										, "rcpt_type" => (isset($array["rcpt_type"]) ? $array["rcpt_type"] : NULL)
										, "fbtype" => (isset($array["fbtype"]) ? $array["fbtype"] : NULL)
										, "report_by" => (isset($array["report_by"]) ? $array["report_by"] : NULL)
										, "report_to" => (isset($array["report_to"]) ? $array["report_to"] : NULL)
										, "user_str" => (isset($array["user_str"]) ? $array["user_str"] : NULL)
										, "customer_id" => (isset($array["customer_id"]) ? $array["customer_id"] : NULL)
										, "campaign_id" => (isset($array["campaign_id"]) ? $array["campaign_id"] : NULL)
										, "template_id" => (isset($array["template_id"]) ? $array["template_id"] : NULL)
										, "template_version" => (isset($array["template_version"]) ? $array["template_version"] : NULL)
										, "rcpt_meta" => (isset($array["rcpt_meta"]) ? $array["rcpt_meta"] : NULL)
										, "rcpt_tags" => (isset($array["rcpt_tags"]) ? $array["rcpt_tags"] : NULL)
									);
								$sql_query = file_get_contents($query_files["spam_complaint"]);
								$sql_statement = $db_connection->prepare($sql_query);
								$sql_result = $sql_statement->execute($sql_params_spam_complaint);

								if($config["debug_mode"] === true)
								{
									var_dump($sql_params_spam_complaint);
								}
							break;

							case "open":
								$sql_params_open = array(
										"timestamp" => (isset($array["timestamp"]) ? $array["timestamp"] : NULL)
										, "type" => (isset($array["type"]) ? $array["type"] : NULL)
										, "event_id" => (isset($array["event_id"]) ? $array["event_id"] : NULL)
										, "message_id" => (isset($array["message_id"]) ? $array["message_id"] : NULL)
										, "node_name" => (isset($array["node_name"]) ? $array["node_name"] : NULL)
										, "delv_method" => (isset($array["delv_method"]) ? $array["delv_method"] : NULL)
										, "campaign_id" => (isset($array["campaign_id"]) ? $array["campaign_id"] : NULL)
										, "customer_id" => (isset($array["customer_id"]) ? $array["customer_id"] : NULL)
										, "subaccount_id" => (isset($array["subaccount_id"]) ? (int) $array["subaccount_id"] : NULL)
										, "transmission_id" => (isset($array["transmission_id"]) ? $array["transmission_id"] : NULL)
										, "rcpt_to" => (isset($array["rcpt_to"]) ? $array["rcpt_to"] : NULL)
										, "raw_rcpt_to" => (isset($array["raw_rcpt_to"]) ? $array["raw_rcpt_to"] : NULL)
										, "rcpt_type" => (isset($array["rcpt_type"]) ? $array["rcpt_type"] : NULL)
										, "ip_address" => (isset($array["ip_address"]) ? $array["ip_address"] : NULL)
										, "user_agent" => (isset($array["user_agent"]) ? $array["user_agent"] : NULL)
										, "template_id" => (isset($array["template_id"]) ? $array["template_id"] : NULL)
										, "template_version" => (isset($array["template_version"]) ? $array["template_version"] : NULL)
										, "rcpt_meta" => (isset($array["rcpt_meta"]) ? $array["rcpt_meta"] : NULL)
										, "rcpt_tags" => (isset($array["rcpt_tags"]) ? $array["rcpt_tags"] : NULL)
									);
								$sql_query = file_get_contents($query_files["open"]);
								$sql_statement = $db_connection->prepare($sql_query);
								$sql_result = $sql_statement->execute($sql_params_open);

								if($config["debug_mode"] === true)
								{
									var_dump($sql_params_open);
								}
							break;

							case "click":
								$sql_params_click = array(
										"timestamp" => (isset($array["timestamp"]) ? $array["timestamp"] : NULL)
										, "type" => (isset($array["type"]) ? $array["type"] : NULL)
										, "event_id" => (isset($array["event_id"]) ? $array["event_id"] : NULL)
										, "message_id" => (isset($array["message_id"]) ? $array["message_id"] : NULL)
										, "node_name" => (isset($array["node_name"]) ? $array["node_name"] : NULL)
										, "delv_method" => (isset($array["delv_method"]) ? $array["delv_method"] : NULL)
										, "campaign_id" => (isset($array["campaign_id"]) ? $array["campaign_id"] : NULL)
										, "customer_id" => (isset($array["customer_id"]) ? $array["customer_id"] : NULL)
										, "subaccount_id" => (isset($array["subaccount_id"]) ? (int) $array["subaccount_id"] : NULL)
										, "transmission_id" => (isset($array["transmission_id"]) ? $array["transmission_id"] : NULL)
										, "rcpt_to" => (isset($array["rcpt_to"]) ? $array["rcpt_to"] : NULL)
										, "raw_rcpt_to" => (isset($array["raw_rcpt_to"]) ? $array["raw_rcpt_to"] : NULL)
										, "rcpt_type" => (isset($array["rcpt_type"]) ? $array["rcpt_type"] : NULL)
										, "ip_address" => (isset($array["ip_address"]) ? $array["ip_address"] : NULL)
										//, "target_link_name" => (isset($array["target_link_name"]) ? $array["target_link_name"] : NULL)
										, "target_link_name" => (isset($array["target_link_name"]) ? NULL : NULL) // Temporarily set the value for target_link_name to NULL.
										, "target_link_url" => (isset($array["target_link_url"]) ? $array["target_link_url"] : NULL)
										, "user_agent" => (isset($array["user_agent"]) ? $array["user_agent"] : NULL)
										, "template_id" => (isset($array["template_id"]) ? $array["template_id"] : NULL)
										, "template_version" => (isset($array["template_version"]) ? $array["template_version"] : NULL)
										, "rcpt_meta" => (isset($array["rcpt_meta"]) ? $array["rcpt_meta"] : NULL)
										, "rcpt_tags" => (isset($array["rcpt_tags"]) ? $array["rcpt_tags"] : NULL)
									);
								$sql_query = file_get_contents($query_files["click"]);
								$sql_statement = $db_connection->prepare($sql_query);
								$sql_result = $sql_statement->execute($sql_params_click);

								if($config["debug_mode"] === true)
								{
									var_dump($sql_params_click);
								}
							break;

							case "list_unsubscribe":
								$sql_params_list_unsubscribe = array(
										"timestamp" => (isset($array["timestamp"]) ? $array["timestamp"] : NULL)
										, "type" => (isset($array["type"]) ? $array["type"] : NULL)
										, "event_id" => (isset($array["event_id"]) ? $array["event_id"] : NULL)
										, "message_id" => (isset($array["message_id"]) ? $array["message_id"] : NULL)
										, "customer_id" => (isset($array["customer_id"]) ? $array["customer_id"] : NULL)
										, "campaign_id" => (isset($array["campaign_id"]) ? $array["campaign_id"] : NULL)
										, "subaccount_id" => (isset($array["subaccount_id"]) ? (int) $array["subaccount_id"] : NULL)
										, "transmission_id" => (isset($array["transmission_id"]) ? $array["transmission_id"] : NULL)
										, "mailfrom" => (isset($array["mailfrom"]) ? $array["mailfrom"] : NULL)
										, "friendly_from" => (isset($array["friendly_from"]) ? $array["friendly_from"] : NULL)
										, "rcpt_to" => (isset($array["rcpt_to"]) ? $array["rcpt_to"] : NULL)
										, "raw_rcpt_to" => (isset($array["raw_rcpt_to"]) ? $array["raw_rcpt_to"] : NULL)
										, "rcpt_type" => (isset($array["rcpt_type"]) ? $array["rcpt_type"] : NULL)
										, "template_id" => (isset($array["template_id"]) ? $array["template_id"] : NULL)
										, "template_version" => (isset($array["template_version"]) ? $array["template_version"] : NULL)
										, "rcpt_meta" => (isset($array["rcpt_meta"]) ? $array["rcpt_meta"] : NULL)
										, "rcpt_tags" => (isset($array["rcpt_tags"]) ? $array["rcpt_tags"] : NULL)
									);
								$sql_query = file_get_contents($query_files["list_unsubscribe"]);
								$sql_statement = $db_connection->prepare($sql_query);
								$sql_result = $sql_statement->execute($sql_params_list_unsubscribe);

								if($config["debug_mode"] === true)
								{
									var_dump($sql_params_list_unsubscribe);
								}
							break;

							case "link_unsubscribe":
								$sql_params_link_unsubscribe = array(
										"timestamp" => (isset($array["timestamp"]) ? $array["timestamp"] : NULL)
										, "type" => (isset($array["type"]) ? $array["type"] : NULL)
										, "event_id" => (isset($array["event_id"]) ? $array["event_id"] : NULL)
										, "message_id" => (isset($array["message_id"]) ? $array["message_id"] : NULL)
										, "customer_id" => (isset($array["customer_id"]) ? $array["customer_id"] : NULL)
										, "campaign_id" => (isset($array["campaign_id"]) ? $array["campaign_id"] : NULL)
										, "subaccount_id" => (isset($array["subaccount_id"]) ? (int) $array["subaccount_id"] : NULL)
										, "transmission_id" => (isset($array["transmission_id"]) ? $array["transmission_id"] : NULL)
										, "mailfrom" => (isset($array["mailfrom"]) ? $array["mailfrom"] : NULL)
										, "friendly_from" => (isset($array["friendly_from"]) ? $array["friendly_from"] : NULL)
										, "rcpt_to" => (isset($array["rcpt_to"]) ? $array["rcpt_to"] : NULL)
										, "raw_rcpt_to" => (isset($array["raw_rcpt_to"]) ? $array["raw_rcpt_to"] : NULL)
										, "rcpt_type" => (isset($array["rcpt_type"]) ? $array["rcpt_type"] : NULL)
										, "user_agent" => (isset($array["user_agent"]) ? $array["user_agent"] : NULL)
										, "template_id" => (isset($array["template_id"]) ? $array["template_id"] : NULL)
										, "template_version" => (isset($array["template_version"]) ? $array["template_version"] : NULL)
										, "rcpt_meta" => (isset($array["rcpt_meta"]) ? $array["rcpt_meta"] : NULL)
										, "rcpt_tags" => (isset($array["rcpt_tags"]) ? $array["rcpt_tags"] : NULL)
									);
								$sql_query = file_get_contents($query_files["link_unsubscribe"]);
								$sql_statement = $db_connection->prepare($sql_query);
								$sql_result = $sql_statement->execute($sql_params_link_unsubscribe);

								if($config["debug_mode"] === true)
								{
									var_dump($sql_params_link_unsubscribe);
								}
							break;

							case "ad_adjust":
								$sql_params_link_unsubscribe = array(
										"timestamp" => (isset($array["timestamp"]) ? $array["timestamp"] : NULL)
										, "type" => (isset($array["type"]) ? $array["type"] : NULL)
										, "event_id" => (isset($array["event_id"]) ? $array["event_id"] : NULL)
										, "customer_id" => (isset($array["customer_id"]) ? $array["customer_id"] : NULL)
										, "subaccount_id" => (isset($array["subaccount_id"]) ? (int) $array["subaccount_id"] : NULL)
										, "node_name" => (isset($array["node_name"]) ? $array["node_name"] : NULL)
										, "binding" => (isset($array["binding"]) ? $array["binding"] : NULL)
										, "routing_domain" => (isset($array["routing_domain"]) ? $array["routing_domain"] : NULL)
										, "opt_value" => (isset($array["opt_value"]) ? $array["opt_value"] : NULL)
										, "option" => (isset($array["option"]) ? $array["option"] : NULL)
										, "scope" => (isset($array["scope"]) ? $array["scope"] : NULL)
									);
								$sql_query = file_get_contents($query_files["ad_adjust"]);
								$sql_statement = $db_connection->prepare($sql_query);
								$sql_result = $sql_statement->execute($sql_params_link_unsubscribe);

								if($config["debug_mode"] === true)
								{
									var_dump($sql_params_link_unsubscribe);
								}
							break;

							case "ad_status":
								$sql_params_link_unsubscribe = array(
										"timestamp" => (isset($array["timestamp"]) ? $array["timestamp"] : NULL)
										, "type" => (isset($array["type"]) ? $array["type"] : NULL)
										, "event_id" => (isset($array["event_id"]) ? $array["event_id"] : NULL)
										, "customer_id" => (isset($array["customer_id"]) ? $array["customer_id"] : NULL)
										, "subaccount_id" => (isset($array["subaccount_id"]) ? (int) $array["subaccount_id"] : NULL)
										, "node_name" => (isset($array["node_name"]) ? $array["node_name"] : NULL)
										, "binding" => (isset($array["binding"]) ? $array["binding"] : NULL)
										, "routing_domain" => (isset($array["routing_domain"]) ? $array["routing_domain"] : NULL)
										, "action" => (isset($array["action"]) ? $array["action"] : NULL)
										, "rule" => (isset($array["rule"]) ? $array["rule"] : NULL)
										, "trigger" => (isset($array["trigger"]) ? $array["trigger"] : NULL)
										, "scope" => (isset($array["scope"]) ? $array["scope"] : NULL)
										, "status" => (isset($array["status"]) ? $array["status"] : NULL)
										, "start" => (isset($array["start"]) ? $array["start"] : NULL)
										, "stop" => (isset($array["stop"]) ? $array["stop"] : NULL)
									);
								$sql_query = file_get_contents($query_files["ad_status"]);
								$sql_statement = $db_connection->prepare($sql_query);
								$sql_result = $sql_statement->execute($sql_params_link_unsubscribe);

								if($config["debug_mode"] === true)
								{
									var_dump($sql_params_link_unsubscribe);
								}
							break;

							default:

								if($config["debug_mode"] == true)
								{
									var_dump($webhook);
								}

								/*
									Raise warning and move on.
								*/
								trigger_error("Unsupported Webhook Type. \"" . $array["type"] . "\" is not supported. - [store_webhook_events]", E_USER_WARNING);
								$log->write("Unsupported Webhook Type. \"" . $array["type"] . "\" is not supported. - [store_webhook_events]");

								ob_start();
								var_dump($webhook);
								$variable_dump = ob_get_clean();
								$log->write("$variable_dump - [store_webhook_events]");

							break;
						}
					}
					else
					{
						if($config["debug_mode"] == true)
						{
							ob_start();
							var_dump($webhook);
							$variable_dump = ob_get_clean();

							/*
								Raise warning and move on.
							*/
							trigger_error("Invalid Webhook: $variable_dump - [store_webhook_events]", E_USER_WARNING);
							$log->write("Invalid Webhook: $variable_dump - [store_webhook_events]");
						}
						else
						{
							trigger_error("Invalid Webhook - [store_webhook_events]", E_USER_WARNING);
							$log->write("Invalid Webhook - [store_webhook_events]");
						}
					}
					
					if(isset($sql_result) === true)
					{
						if($sql_result === false)
						{
							$db_error = $db_connection->errorInfo();
							if(is_array($db_error) === true)
							{
								if(empty($db_error[1]) === true && empty($db_error[2]) === true)
								{
									$db_error_emsg = "Error encountered before query was attempted.";
								}
								else
								{
									$db_error_emsg = "[" . $db_error[0] . "] " . $db_error[1] . " - [" . $db_error[2] . "]";

									/*
										Rollback.
									*/
									$rollback = $db_connection->rollBack();
								}
							}
							else
							{
								$db_error_emsg = "Undefined error or no SQL error";
							}
							/*
								Raise warning and continue.
							*/
							trigger_error("$db_error_emsg - [store_webhook_events]", E_USER_WARNING);
							$log->write("$db_error_emsg - [store_webhook_events]");

							ob_start();
							var_dump($webhook);
							$variable_dump = ob_get_clean();

							$log->write("$variable_dump - [store_webhook_events]");
						}
						else
						{
							if($config["debug_mode"] === true)
							{
								trigger_error("Row written to database. - [store_webhook_events]", E_USER_NOTICE);
							}
							$log->write("Row written to database. - [store_webhook_events]");
						}
					}
				}

				/*
					If a rollback occurred, the connection should have returned to autocommit mode.
					As a result, the remainder of the INSERT statements should have been added.
					Unset the variable "$rollback" and return false to indicate an error occurred with that specific file.

					If no rollback occurred, commit the transaction.
					If the commit is successful, return true. If it is not successful, return false. *
						* PDOException() will likely be triggered here.
				*/
				if(isset($rollback) === true)
				{
					if($rollback === true)
					{
						unset($rollback);
						return false;
					}
					else
					{
						if($config["debug_mode"] == true)
						{
							trigger_error("Committing SQL Transaction. - [store_webhook_events]", E_USER_NOTICE);
						}
						$log->write("Committing SQL Transaction. - [store_webhook_events]");
						$commit = $db_connection->commit();
					}

					unset($rollback);
				}
				else
				{
					if($config["debug_mode"] == true)
					{
						trigger_error("Committing SQL Transaction. - [store_webhook_events]", E_USER_NOTICE);
					}
					$log->write("Committing SQL Transaction. - [store_webhook_events]");
					$commit = $db_connection->commit();
				}

				if($commit === true)
				{
					return true;
				}
				else
				{
					return false;
				}

			}
			else
			{
				trigger_error("Provided input is not an array. - [store_webhook_events]", E_USER_WARNING);
				$log->write("Provided input is not an array. - [store_webhook_events]");
				
			}
		}
	}

?>