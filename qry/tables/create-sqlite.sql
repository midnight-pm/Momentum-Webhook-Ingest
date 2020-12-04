/*
	SQLite Datatypes
	https://www.sqlite.org/datatype3.html

	No "id" column will be specified. Instead, we'll rely upon a combination of the track UUID and SQLite's
	automatic "rowid"
	http://www.sqlitetutorial.net/sqlite-autoincrement/

	https://stackoverflow.com/questions/6109532/what-is-the-maximum-size-limit-of-varchar-data-type-in-sqlite
*/

CREATE TABLE IF NOT EXISTS sp_webhooks_injection
(
	recorded TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
	, timestamp bigint NULL
	, type varchar(255) NULL
	, event_id varchar(255) NULL
	, recv_method varchar(255) NULL
	, injection_time varchar(255) NULL
	, subaccount_id varchar(255) NULL
	, message_id varchar(255) NULL 
	, transmission_id bigint NULL
	, sending_ip varchar(255) NULL
	, ip_pool varchar(255) NULL
	, msg_size int NULL
	, routing_domain varchar(255) NULL
	, msg_from varchar(640) NULL
	, friendly_from varchar(640) NULL
	, rcpt_to varchar(640) NULL
	, raw_rcpt_to varchar(640) NULL
	, subject text NULL
	, transactional varchar(255) NULL
	, open_tracking bit NULL
	, initial_pixel bit NULL
	, customer_id varchar(255) NULL
	, campaign_id varchar(255) NULL
	, template_id varchar(255) NULL
	, template_version varchar(255) NULL
	, rcpt_meta varchar(8000) NULL
	, rcpt_tags varchar(8000) NULL
);
/*
SELECT * FROM sp_webhooks_injection;

DROP TABLE sp_webhooks_injection;
*/

CREATE TABLE sp_webhooks_delay
(
	recorded TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
	, timestamp bigint NULL
	, type varchar(255) NULL
	, event_id varchar(255) NULL
	, recv_method varchar(255) NULL
	, injection_time varchar(255) NULL
	, delv_method varchar(255) NULL
	, queue_time int NULL
	, num_retries int NULL
	, bounce_class int NULL
	, error_code int NULL
	, reason text NULL
	, raw_reason text NULL
	, subaccount_id varchar(255) NULL
	, message_id varchar(255) NULL 
	, transmission_id bigint NULL
	, sending_ip varchar(255) NULL
	, ip_pool varchar(255) NULL
	, ip_address varchar(255) NULL
	, msg_size int NULL
	, routing_domain varchar(255) NULL
	, msg_from varchar(640) NULL
	, friendly_from varchar(640) NULL
	, rcpt_to varchar(640) NULL
	, raw_rcpt_to varchar(640) NULL
	, subject text NULL
	, transactional varchar(255) NULL
	, open_tracking bit NULL
	, initial_pixel bit NULL
	, customer_id varchar(255) NULL
	, campaign_id varchar(255) NULL
	, template_id varchar(255) NULL
	, template_version varchar(255) NULL
	, rcpt_meta varchar(8000) NULL
	, rcpt_tags varchar(8000) NULL
);

/*
SELECT * FROM sp_webhooks_delay;

DROP TABLE sp_webhooks_delay;
*/

CREATE TABLE sp_webhooks_bounce
(
	recorded TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
	, timestamp bigint NULL
	, type varchar(255) NULL
	, event_id varchar(255) NULL
	, recv_method varchar(255) NULL
	, injection_time varchar(255) NULL
	, delv_method varchar(255) NULL
	, num_retries int NULL
	, bounce_class int NULL
	, error_code int NULL
	, reason text NULL
	, raw_reason text NULL
	, subaccount_id varchar(255) NULL
	, message_id varchar(255) NULL 
	, transmission_id bigint NULL
	, sending_ip varchar(255) NULL
	, ip_pool varchar(255) NULL
	, ip_address varchar(255) NULL
	, msg_size int NULL
	, routing_domain varchar(255) NULL
	, msg_from varchar(640) NULL
	, friendly_from varchar(640) NULL
	, rcpt_to varchar(640) NULL
	, raw_rcpt_to varchar(640) NULL
	, subject text NULL
	, transactional varchar(255) NULL
	, open_tracking bit NULL
	, initial_pixel bit NULL
	, customer_id varchar(255) NULL
	, campaign_id varchar(255) NULL
	, template_id varchar(255) NULL
	, template_version varchar(255) NULL
	, rcpt_meta varchar(8000) NULL
	, rcpt_tags varchar(8000) NULL
);

/*
SELECT * FROM sp_webhooks_bounce;

DROP TABLE sp_webhooks_bounce;
*/

CREATE TABLE sp_webhooks_delivery
(
	recorded TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
	, timestamp bigint NULL
	, type varchar(255) NULL
	, event_id varchar(255) NULL
	, recv_method varchar(255) NULL
	, injection_time varchar(255) NULL
	, delv_method varchar(255) NULL
	, queue_time int NULL
	, num_retries int NULL
	, subaccount_id varchar(255) NULL
	, message_id varchar(255) NULL 
	, transmission_id bigint NULL
	, sending_ip varchar(255) NULL
	, ip_pool varchar(255) NULL
	, ip_address varchar(255) NULL
	, msg_size int NULL
	, routing_domain varchar(255) NULL
	, msg_from varchar(640) NULL
	, friendly_from varchar(640) NULL
	, rcpt_to varchar(640) NULL
	, raw_rcpt_to varchar(640) NULL
	, subject text NULL
	, transactional varchar(255) NULL
	, open_tracking bit NULL
	, initial_pixel bit NULL
	, customer_id varchar(255) NULL
	, campaign_id varchar(255) NULL
	, template_id varchar(255) NULL
	, template_version varchar(255) NULL
	, rcpt_meta varchar(8000) NULL
	, rcpt_tags varchar(8000) NULL
);

/*
SELECT * FROM sp_webhooks_delivery;

DROP TABLE sp_webhooks_delivery;
*/

CREATE TABLE sp_webhooks_policy_rejection
(
	recorded TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
	, timestamp bigint NULL
	, type varchar(255) NULL
	, event_id varchar(255) NULL
	, recv_method varchar(255) NULL
	, injection_time varchar(255) NULL
	, bounce_class int NULL
	, error_code int NULL
	, reason text NULL
	, raw_reason text NULL
	, subaccount_id varchar(255) NULL
	, message_id varchar(255) NULL 
	, transmission_id bigint NULL
	, remote_addr varchar(255) NULL
	, sending_ip varchar(255) NULL
	, ip_pool varchar(255) NULL
	, msg_from varchar(640) NULL
	, friendly_from varchar(640) NULL
	, rcpt_to varchar(640) NULL
	, raw_rcpt_to varchar(640) NULL
	, rcpt_type varchar(255) NULL
	, transactional varchar(255) NULL
	, customer_id varchar(255) NULL
	, campaign_id varchar(255) NULL
	, template_id varchar(255) NULL
	, template_version varchar(255) NULL
	, rcpt_meta varchar(8000) NULL
	, rcpt_tags varchar(8000) NULL
);

/*
SELECT * FROM sp_webhooks_policy_rejection;

DROP TABLE sp_webhooks_policy_rejection;
*/


CREATE TABLE sp_webhooks_spam_complaint
(
	recorded TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
	, timestamp bigint NULL
	, type varchar(255) NULL
	, event_id varchar(255) NULL
	, injection_time varchar(255) NULL
	, delv_method varchar(255) NULL
	, subaccount_id varchar(255) NULL
	, message_id varchar(255) NULL 
	, transmission_id bigint NULL
	, sending_ip varchar(255) NULL
	, ip_pool varchar(255) NULL
	, ip_address varchar(255) NULL
	, msg_size int NULL
	, routing_domain varchar(255) NULL
	, msg_from varchar(640) NULL
	, friendly_from varchar(640) NULL
	, rcpt_to varchar(640) NULL
	, raw_rcpt_to varchar(640) NULL
	, fbtype varchar(640) NULL
	, report_by varchar(640) NULL
	, report_to varchar(640) NULL
	, subject text NULL
	, transactional varchar(255) NULL
	, customer_id varchar(255) NULL
	, campaign_id varchar(255) NULL
	, template_id varchar(255) NULL
	, template_version varchar(255) NULL
	, rcpt_meta varchar(8000) NULL
	, rcpt_tags varchar(8000) NULL
	, user_str text NULL
	, ab_test_id varchar(255) NULL
	, ab_test_version varchar(255) NULL
);

/*
SELECT * FROM sp_webhooks_spam_complaint;

DROP TABLE sp_webhooks_spam_complaint;
*/


CREATE TABLE sp_webhooks_out_of_band
(
	recorded TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
	, timestamp bigint NULL
	, type varchar(255) NULL
	, event_id varchar(255) NULL
	, recv_method varchar(255) NULL
	, injection_time varchar(255) NULL
	, delv_method varchar(255) NULL
	, num_retries int NULL
	, bounce_class int NULL
	, error_code int NULL
	, reason text NULL
	, raw_reason text NULL
	, subaccount_id varchar(255) NULL
	, message_id varchar(255) NULL 
	, transmission_id bigint NULL
	, sending_ip varchar(255) NULL
	, ip_pool varchar(255) NULL
	, ip_address varchar(255) NULL
	, msg_size int NULL
	, routing_domain varchar(255) NULL
	, msg_from varchar(640) NULL
	, friendly_from varchar(640) NULL
	, rcpt_to varchar(640) NULL
	, raw_rcpt_to varchar(640) NULL
	, subject text NULL
	, transactional varchar(255) NULL
	, open_tracking bit NULL
	, initial_pixel bit NULL
	, customer_id varchar(255) NULL
	, campaign_id varchar(255) NULL
	, template_id varchar(255) NULL
	, template_version varchar(255) NULL
	, rcpt_meta varchar(8000) NULL
	, rcpt_tags varchar(8000) NULL
);

/*
SELECT * FROM sp_webhooks_out_of_band;

DROP TABLE sp_webhooks_out_of_band;
*/


CREATE TABLE sp_webhooks_initial_open
(
	recorded TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
	, timestamp bigint NULL
	, type varchar(255) NULL
	, event_id varchar(255) NULL
	, delv_method varchar(255) NULL
	, message_id varchar(255) NULL 
	, ip_address varchar(255) NULL 
	, ip_pool varchar(255) NULL 
	, routing_domain varchar(255) NULL 
	, msg_from varchar(640) NULL
	, msg_size int NULL
	, conn_stage bigint NULL
	, campaign_id varchar(255) NULL 
	, customer_id varchar(255) NULL
	, subaccount_id int NULL
	, sending_ip varchar(255) NULL
	, transmission_id bigint NULL
	, transactional varchar(255) NULL
	, open_tracking bit NULL
	, initial_pixel bit NULL
	, rcpt_meta varchar(8000) NULL
	, rcpt_tags varchar(8000) NULL
	, template_id varchar(255) NULL
	, template_version varchar(255) NULL
	, raw_rcpt_to varchar(640) NULL
	, user_agent text NULL
	, geo_ip_country varchar(255) NULL
	, geo_ip_region varchar(255) NULL
	, geo_ip_city varchar(255) NULL
	, geo_ip_zip varchar(255) NULL
	, geo_ip_latitude varchar(255) NULL
	, geo_ip_longitude varchar(255) NULL
);

/*
SELECT * FROM sp_webhooks_initial_open;

DROP TABLE sp_webhooks_initial_open;
*/


CREATE TABLE sp_webhooks_open
(
	recorded TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
	, timestamp bigint NULL
	, type varchar(255) NULL
	, event_id varchar(255) NULL
	, delv_method varchar(255) NULL
	, message_id varchar(255) NULL 
	, ip_address varchar(255) NULL 
	, ip_pool varchar(255) NULL 
	, routing_domain varchar(255) NULL 
	, msg_from varchar(640) NULL
	, msg_size int NULL
	, conn_stage bigint NULL
	, campaign_id varchar(255) NULL 
	, customer_id varchar(255) NULL
	, subaccount_id int NULL
	, sending_ip varchar(255) NULL
	, transmission_id bigint NULL
	, transactional varchar(255) NULL
	, open_tracking bit NULL
	, initial_pixel bit NULL
	, rcpt_meta varchar(8000) NULL
	, rcpt_tags varchar(8000) NULL
	, template_id varchar(255) NULL
	, template_version varchar(255) NULL
	, raw_rcpt_to varchar(640) NULL
	, user_agent text NULL
	, geo_ip_country varchar(255) NULL
	, geo_ip_region varchar(255) NULL
	, geo_ip_city varchar(255) NULL
	, geo_ip_zip varchar(255) NULL
	, geo_ip_latitude varchar(255) NULL
	, geo_ip_longitude varchar(255) NULL
);

/*
SELECT * FROM sp_webhooks_open;

DROP TABLE sp_webhooks_open;
*/


CREATE TABLE sp_webhooks_click
(
	recorded TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
	, timestamp bigint NULL
	, type varchar(255) NULL
	, event_id varchar(255) NULL
	, delv_method varchar(255) NULL
	, message_id varchar(255) NULL 
	, ip_address varchar(255) NULL 
	, ip_pool varchar(255) NULL 
	, routing_domain varchar(255) NULL 
	, msg_from varchar(640) NULL
	, msg_size int NULL
	, conn_stage bigint NULL
	, campaign_id varchar(255) NULL 
	, customer_id varchar(255) NULL
	, subaccount_id int NULL
	, sending_ip varchar(255) NULL
	, transmission_id bigint NULL
	, transactional varchar(255) NULL
	, open_tracking bit NULL
	, initial_pixel bit NULL
	, rcpt_meta varchar(8000) NULL
	, rcpt_tags varchar(8000) NULL
	, template_id varchar(255) NULL
	, template_version varchar(255) NULL
	, raw_rcpt_to varchar(640) NULL
	, user_agent text NULL
	, geo_ip_country varchar(255) NULL
	, geo_ip_region varchar(255) NULL
	, geo_ip_city varchar(255) NULL
	, geo_ip_zip varchar(255) NULL
	, geo_ip_latitude varchar(255) NULL
	, geo_ip_longitude varchar(255) NULL
	, target_link_name varchar(1280) NULL
	, target_link_url varchar(1280) NULL
);

/*
SELECT * FROM sp_webhooks_click;

DROP TABLE sp_webhooks_click;
*/


CREATE TABLE sp_webhooks_list_unsubscribe
(
	recorded TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
	, timestamp bigint NULL
	, type varchar(255) NULL
	, event_id varchar(255) NULL
	, injection_time varchar(255) NULL
	, recv_method varchar(255) NULL
	, subaccount_id varchar(255) NULL
	, message_id varchar(255) NULL 
	, transmission_id bigint NULL
	, sending_ip varchar(255) NULL
	, ip_pool varchar(255) NULL
	, ip_address varchar(255) NULL
	, mailfrom int NULL
	, routing_domain varchar(255) NULL
	, msg_from varchar(640) NULL
	, friendly_from varchar(640) NULL
	, raw_rcpt_to varchar(640) NULL
	, rcpt_type varchar(640) NULL
	, num_retries varchar(640) NULL
	, queue_time varchar(640) NULL
	, subject text NULL
	, transactional varchar(255) NULL
	, click_tracking varchar(640) NULL
	, open_tracking varchar(640) NULL
	, customer_id varchar(255) NULL
	, campaign_id varchar(255) NULL
	, template_id varchar(255) NULL
	, template_version varchar(255) NULL
	, rcpt_meta varchar(8000) NULL
	, rcpt_tags varchar(8000) NULL
	, ab_test_id varchar(255) NULL
	, ab_test_version varchar(255) NULL
);

/*
SELECT * FROM sp_webhooks_list_unsubscribe;

DROP TABLE sp_webhooks_list_unsubscribe;
*/


CREATE TABLE sp_webhooks_link_unsubscribe
(
	recorded TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
	, timestamp bigint NULL
	, type varchar(255) NULL
	, event_id varchar(255) NULL
	, injection_time varchar(255) NULL
	, delv_method varchar(255) NULL
	, recv_method varchar(255) NULL
	, subaccount_id varchar(255) NULL
	, message_id varchar(255) NULL 
	, transmission_id bigint NULL
	, sending_ip varchar(255) NULL
	, ip_pool varchar(255) NULL
	, ip_address varchar(255) NULL
	, mailfrom int NULL
	, routing_domain varchar(255) NULL
	, msg_from varchar(640) NULL
	, friendly_from varchar(640) NULL
	, raw_rcpt_to varchar(640) NULL
	, rcpt_type varchar(640) NULL
	, num_retries varchar(640) NULL
	, queue_time varchar(640) NULL
	, subject text NULL
	, transactional varchar(255) NULL
	, click_tracking varchar(640) NULL
	, open_tracking varchar(640) NULL
	, customer_id varchar(255) NULL
	, campaign_id varchar(255) NULL
	, template_id varchar(255) NULL
	, template_version varchar(255) NULL
	, rcpt_meta varchar(8000) NULL
	, rcpt_tags varchar(8000) NULL
	, ab_test_id varchar(255) NULL
	, ab_test_version varchar(255) NULL
	, user_agent text NULL
);

/*
SELECT * FROM sp_webhooks_link_unsubscribe;

DROP TABLE sp_webhooks_link_unsubscribe;
*/

/*
	Create Indexes on the tables for performance reasons.
	https://medium.com/@JasonWyatt/squeezing-performance-from-sqlite-indexes-indexes-c4e175f3c346
*/
CREATE INDEX ix_sp_injection_timestamp ON sp_webhooks_injection(timestamp);
CREATE INDEX ix_sp_injection_campaign_id ON sp_webhooks_injection(campaign_id);
CREATE INDEX ix_sp_injection_raw_rcpt_to ON sp_webhooks_injection(raw_rcpt_to);
CREATE INDEX ix_sp_injection_message_transmission_id ON sp_webhooks_injection(message_id,transmission_id);

CREATE INDEX ix_sp_bounce_timestamp ON sp_webhooks_bounce(timestamp);
CREATE INDEX ix_sp_bounce_campaign_id ON sp_webhooks_bounce(campaign_id);
CREATE INDEX ix_sp_bounce_raw_rcpt_to ON sp_webhooks_bounce(raw_rcpt_to);
CREATE INDEX ix_sp_bounce_message_transmission_id ON sp_webhooks_bounce(message_id,transmission_id);

CREATE INDEX ix_sp_delivery_timestamp ON sp_webhooks_delivery(timestamp);
CREATE INDEX ix_sp_delivery_campaign_id ON sp_webhooks_delivery(campaign_id);
CREATE INDEX ix_sp_delivery_raw_rcpt_to ON sp_webhooks_delivery(raw_rcpt_to);
CREATE INDEX ix_sp_delivery_message_transmission_id ON sp_webhooks_delivery(message_id,transmission_id);

CREATE INDEX ix_sp_delay_timestamp ON sp_webhooks_delay(timestamp);
CREATE INDEX ix_sp_delay_campaign_id ON sp_webhooks_delay(campaign_id);
CREATE INDEX ix_sp_delay_raw_rcpt_to ON sp_webhooks_delay(raw_rcpt_to);
CREATE INDEX ix_sp_delay_message_transmission_id ON sp_webhooks_delay(message_id,transmission_id);