USE Momentum;
ALTER DATABASE Momentum CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS mo_webhooks_injection
(
	id bigint NOT NULL PRIMARY KEY AUTO_INCREMENT
	, recorded TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
	, timestamp bigint NULL
	, type varchar(255) NULL
	, event_id bigint NULL
	, node_name varchar(255) NULL
	, recv_method varchar(255) NULL
	, subaccount_id int NULL
	, transmission_id bigint NULL
	, conn_name varchar(30) NULL
	, msg_batchname varchar(30) NULL
	, msg_spoolname varchar(30) NULL
	, conn_stage int NULL
	, message_id varchar(255) NULL
	, binding varchar(255) NULL
	, binding_group varchar(255) NULL
	, pathway varchar(255) NULL
	, pathway_group varchar(255) NULL
	, msg_size int NULL
	, routing_domain varchar(255) NULL
	, msg_from varchar(640) NULL
	, friendly_from varchar(640) NULL
	, rcpt_to varchar(640) NULL
	, raw_rcpt_to varchar(640) NULL
	, rcpt_type varchar(30) NULL
	, subject text NULL
	, customer_id int NULL
	, campaign_id varchar(255) NULL
	, template_id varchar(255) NULL
	, template_version varchar(255) NULL
	, rcpt_meta text NULL
	, rcpt_tags text NULL
);
/*
SELECT * FROM mo_webhooks_injection;

DROP TABLE mo_webhooks_injection;
*/

CREATE TABLE IF NOT EXISTS mo_webhooks_delay
(
	id bigint NOT NULL PRIMARY KEY AUTO_INCREMENT
	, recorded TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
	, timestamp bigint NULL
	, type varchar(255) NULL
	, event_id bigint NULL
	, node_name varchar(255) NULL
	, recv_method varchar(255) NULL
	, delv_method varchar(255) NULL
	, subaccount_id int NULL
	, transmission_id bigint NULL
	, conn_name varchar(30) NULL
	, msg_batchname varchar(30) NULL
	, msg_spoolname varchar(30) NULL
	, conn_stage int NULL
	, message_id varchar(255) NULL
	, binding varchar(255) NULL
	, binding_group varchar(255) NULL
	, msg_size int NULL
	, routing_domain varchar(255) NULL
	, msg_from varchar(640) NULL
	, friendly_from varchar(640) NULL
	, rcpt_to varchar(640) NULL
	, raw_rcpt_to varchar(640) NULL
	, rcpt_type varchar(30) NULL
	, subject text NULL
	, queue_time int NULL
	, num_retries int NULL
	, bounce_class int NULL
	, error_code int NULL
	, reason text NULL
	, raw_reason text NULL
	, customer_id int NULL
	, campaign_id varchar(255) NULL
	, template_id varchar(255) NULL
	, template_version varchar(255) NULL
	, rcpt_meta text NULL
	, rcpt_tags text NULL
);

/*
SELECT * FROM mo_webhooks_delay;

DROP TABLE mo_webhooks_delay;
*/

CREATE TABLE IF NOT EXISTS mo_webhooks_bounce
(
	id bigint NOT NULL PRIMARY KEY AUTO_INCREMENT
	, recorded TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
	, timestamp bigint NULL
	, type varchar(255) NULL
	, event_id bigint NULL
	, node_name varchar(255) NULL
	, recv_method varchar(255) NULL
	, delv_method varchar(255) NULL
	, subaccount_id int NULL
	, transmission_id bigint NULL
	, conn_name varchar(30) NULL
	, msg_batchname varchar(30) NULL
	, msg_spoolname varchar(30) NULL
	, conn_stage int NULL
	, message_id varchar(255) NULL
	, binding varchar(255) NULL
	, binding_group varchar(255) NULL
	, msg_size int NULL
	, routing_domain varchar(255) NULL
	, msg_from varchar(640) NULL
	, friendly_from varchar(640) NULL
	, rcpt_to varchar(640) NULL
	, raw_rcpt_to varchar(640) NULL
	, rcpt_type varchar(30) NULL
	, subject text NULL
	, queue_time int NULL
	, num_retries int NULL
	, bounce_class int NULL
	, error_code int NULL
	, reason text NULL
	, raw_reason text NULL
	, customer_id int NULL
	, campaign_id varchar(255) NULL
	, template_id varchar(255) NULL
	, template_version varchar(255) NULL
	, rcpt_meta text NULL
	, rcpt_tags text NULL
);

/*
SELECT * FROM mo_webhooks_bounce;

DROP TABLE mo_webhooks_bounce;
*/

CREATE TABLE IF NOT EXISTS mo_webhooks_delivery
(
	id bigint NOT NULL PRIMARY KEY AUTO_INCREMENT
	, recorded TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
	, timestamp bigint NULL
	, type varchar(255) NULL
	, event_id bigint NULL
	, node_name varchar(255) NULL
	, recv_method varchar(255) NULL
	, delv_method varchar(255) NULL
	, subaccount_id int NULL
	, transmission_id bigint NULL
	, conn_name varchar(30) NULL
	, msg_batchname varchar(30) NULL
	, msg_spoolname varchar(30) NULL
	, conn_stage int NULL
	, message_id varchar(255) NULL
	, binding varchar(255) NULL
	, binding_group varchar(255) NULL
	, msg_size int NULL
	, routing_domain varchar(255) NULL
	, msg_from varchar(640) NULL
	, friendly_from varchar(640) NULL
	, rcpt_to varchar(640) NULL
	, raw_rcpt_to varchar(640) NULL
	, rcpt_type varchar(30) NULL
	, subject text NULL
	, queue_time int NULL
	, num_retries int NULL
	, ip_address varchar(255) NULL
	, customer_id int NULL
	, campaign_id varchar(255) NULL
	, template_id varchar(255) NULL
	, template_version varchar(255) NULL
	, rcpt_meta text NULL
	, rcpt_tags text NULL
);

/*
SELECT * FROM mo_webhooks_delivery;

DROP TABLE mo_webhooks_delivery;
*/

CREATE TABLE IF NOT EXISTS mo_webhooks_policy_rejection
(
	id bigint NOT NULL PRIMARY KEY AUTO_INCREMENT
	, recorded TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
	, timestamp bigint NULL
	, type varchar(255) NULL
	, event_id bigint NULL
	, node_name varchar(255) NULL
	, recv_method varchar(255) NULL
	, subaccount_id int NULL
	, transmission_id bigint NULL
	, conn_name varchar(30) NULL
	, message_id varchar(255) NULL
	, binding varchar(255) NULL
	, binding_group varchar(255) NULL
	, pathway varchar(255) NULL
	, pathway_group varchar(255) NULL
	, msg_from varchar(640) NULL
	, friendly_from varchar(640) NULL
	, rcpt_to varchar(640) NULL
	, raw_rcpt_to varchar(640) NULL
	, rcpt_type varchar(30) NULL
	, error_code int NULL
	, reason text NULL
	, raw_reason text NULL
	, scope_name varchar(255) NULL
	, customer_id int NULL
	, campaign_id varchar(255) NULL
	, template_id varchar(255) NULL
	, template_version varchar(255) NULL
	, rcpt_meta text NULL
	, rcpt_tags text NULL
);

/*
SELECT * FROM mo_webhooks_policy_rejection;

DROP TABLE mo_webhooks_policy_rejection;
*/


CREATE TABLE IF NOT EXISTS mo_webhooks_spam_complaint
(
	id bigint NOT NULL PRIMARY KEY AUTO_INCREMENT
	, recorded TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
	, timestamp bigint NULL
	, type varchar(255) NULL
	, event_id bigint NULL
	, node_name varchar(255) NULL
	, subaccount_id int NULL
	, transmission_id bigint NULL
	, msg_spoolname varchar(30) NULL
	, message_id varchar(255) NULL
	, binding varchar(255) NULL
	, binding_group varchar(255) NULL
	, friendly_from varchar(640) NULL
	, rcpt_to varchar(640) NULL
	, raw_rcpt_to varchar(640) NULL
	, rcpt_type varchar(30) NULL
	, fbtype varchar(640) NULL
	, report_by varchar(640) NULL
	, report_to varchar(640) NULL
	, user_str text NULL
	, customer_id int NULL
	, campaign_id varchar(255) NULL
	, template_id varchar(255) NULL
	, template_version varchar(255) NULL
	, rcpt_tags text NULL
	, rcpt_meta text NULL
);

/*
SELECT * FROM mo_webhooks_spam_complaint;

DROP TABLE mo_webhooks_spam_complaint;
*/


CREATE TABLE IF NOT EXISTS mo_webhooks_out_of_band
(
	id bigint NOT NULL PRIMARY KEY AUTO_INCREMENT
	, recorded TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
	, timestamp bigint NULL
	, type varchar(255) NULL
	, event_id bigint NULL
	, node_name varchar(255) NULL
	, recv_method varchar(255) NULL
	, delv_method varchar(255) NULL
	, subaccount_id int NULL
	, conn_stage int NULL
	, message_id varchar(255) NULL
	, binding varchar(255) NULL
	, binding_group varchar(255) NULL
	, msg_from varchar(640) NULL
	, rcpt_to varchar(640) NULL
	, raw_rcpt_to varchar(640) NULL
	, bounce_class int NULL
	, error_code int NULL
	, reason text NULL
	, raw_reason text NULL
	, customer_id int NULL
	, campaign_id varchar(255) NULL
	, template_id varchar(255) NULL
	, template_version varchar(255) NULL
);

/*
SELECT * FROM mo_webhooks_out_of_band;

DROP TABLE mo_webhooks_out_of_band;
*/


CREATE TABLE IF NOT EXISTS mo_webhooks_open
(
	id bigint NOT NULL PRIMARY KEY AUTO_INCREMENT
	, recorded TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
	, timestamp bigint NULL
	, type varchar(255) NULL
	, event_id bigint NULL
	, message_id varchar(255) NULL
	, node_name varchar(255) NULL
	, delv_method varchar(255) NULL
	, campaign_id varchar(255) NULL 
	, customer_id varchar(255) NULL
	, subaccount_id int NULL
	, transmission_id bigint NULL
	, rcpt_to varchar(640) NULL
	, raw_rcpt_to varchar(640) NULL
	, rcpt_type varchar(255) NULL
	, ip_address varchar(255) NULL 
	, user_agent text NULL
	, template_id varchar(255) NULL
	, template_version varchar(255) NULL
	, rcpt_meta text NULL
	, rcpt_tags text NULL
);

/*
SELECT * FROM mo_webhooks_open;

DROP TABLE mo_webhooks_open;
*/


CREATE TABLE IF NOT EXISTS mo_webhooks_click
(
	id bigint NOT NULL PRIMARY KEY AUTO_INCREMENT
	, recorded TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
	, timestamp bigint NULL
	, type varchar(255) NULL
	, event_id bigint NULL
	, message_id varchar(255) NULL
	, node_name varchar(255) NULL
	, delv_method varchar(255) NULL
	, campaign_id varchar(255) NULL 
	, customer_id varchar(255) NULL
	, subaccount_id int NULL
	, transmission_id bigint NULL
	, rcpt_to varchar(640) NULL
	, raw_rcpt_to varchar(640) NULL
	, rcpt_type varchar(255) NULL
	, ip_address varchar(255) NULL
	, target_link_name varchar(1280) NULL
	, target_link_url varchar(1280) NULL
	, user_agent text NULL
	, template_id varchar(255) NULL
	, template_version varchar(255) NULL
	, rcpt_meta text NULL
	, rcpt_tags text NULL
);

/*
SELECT * FROM mo_webhooks_click;

DROP TABLE mo_webhooks_click;
*/


CREATE TABLE IF NOT EXISTS mo_webhooks_list_unsubscribe
(
	id bigint NOT NULL PRIMARY KEY AUTO_INCREMENT
	, recorded TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
	, timestamp bigint NULL
	, type varchar(255) NULL
	, event_id bigint NULL
	, message_id varchar(255) NULL
	, customer_id varchar(255) NULL
	, campaign_id varchar(255) NULL
	, subaccount_id int NULL
	, transmission_id bigint NULL
	, mailfrom int NULL
	, friendly_from varchar(640) NULL
	, rcpt_to varchar(640) NULL
	, raw_rcpt_to varchar(640) NULL
	, rcpt_type varchar(640) NULL
	, template_id varchar(255) NULL
	, template_version varchar(255) NULL
	, rcpt_meta text NULL
	, rcpt_tags text NULL
);

/*
SELECT * FROM mo_webhooks_list_unsubscribe;

DROP TABLE mo_webhooks_list_unsubscribe;
*/


CREATE TABLE IF NOT EXISTS mo_webhooks_link_unsubscribe
(
	id bigint NOT NULL PRIMARY KEY AUTO_INCREMENT
	, recorded TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
	, timestamp bigint NULL
	, type varchar(255) NULL
	, event_id bigint NULL
	, message_id varchar(255) NULL
	, customer_id varchar(255) NULL
	, campaign_id varchar(255) NULL
	, subaccount_id int NULL
	, transmission_id bigint NULL
	, mailfrom int NULL
	, friendly_from varchar(640) NULL
	, rcpt_to varchar(640) NULL
	, raw_rcpt_to varchar(640) NULL
	, rcpt_type varchar(640) NULL
	, user_agent text NULL
	, template_id varchar(255) NULL
	, template_version varchar(255) NULL
	, rcpt_meta text NULL
	, rcpt_tags text NULL
);

/*
SELECT * FROM mo_webhooks_link_unsubscribe;

DROP TABLE mo_webhooks_link_unsubscribe;
*/


CREATE TABLE IF NOT EXISTS mo_webhooks_ad_adjust
(
	id bigint NOT NULL PRIMARY KEY AUTO_INCREMENT
	, recorded TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
	, timestamp bigint NULL
	, type varchar(255) NULL
	, event_id bigint NULL
	, customer_id varchar(255) NULL
	, subaccount_id int NULL
	, node_name varchar(255) NULL
	, binding varchar(255) NULL
	, routing_domain varchar(255) NULL
	, opt_value varchar(255) NULL
	, `option` varchar(255) NULL
	, `scope` varchar(255) NULL
);

/*
SELECT * FROM mo_webhooks_ad_adjust;

DROP TABLE mo_webhooks_ad_adjust;
*/


CREATE TABLE IF NOT EXISTS mo_webhooks_ad_status
(
	id bigint NOT NULL PRIMARY KEY AUTO_INCREMENT
	, recorded TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
	, timestamp bigint NULL
	, type varchar(255) NULL
	, event_id bigint NULL
	, customer_id varchar(255) NULL
	, subaccount_id int NULL
	, node_name varchar(255) NULL
	, binding varchar(255) NULL
	, routing_domain varchar(255) NULL
	, action varchar(255) NULL
	, rule varchar(255) NULL
	, `trigger` text NULL
	, `scope` varchar(255) NULL
	, status varchar(255) NULL
	, `start` bigint NULL
	, stop bigint NULL
);

/*
SELECT * FROM mo_webhooks_ad_status;

DROP TABLE mo_webhooks_ad_status;
*/


/*
	Create Indexes on the tables for performance reasons.
	https://medium.com/@JasonWyatt/squeezing-performance-from-sqlite-indexes-indexes-c4e175f3c346
*/
CREATE INDEX ix_mo_injection_timestamp ON mo_webhooks_injection(timestamp);
CREATE INDEX ix_mo_injection_campaign_id ON mo_webhooks_injection(campaign_id);
CREATE INDEX ix_mo_injection_raw_rcpt_to ON mo_webhooks_injection(raw_rcpt_to);
CREATE INDEX ix_mo_injection_campaign_id_raw_rcpt_to ON mo_webhooks_delivery(campaign_id,raw_rcpt_to);
CREATE INDEX ix_mo_injection_message_transmission_id ON mo_webhooks_injection(message_id,transmission_id);
CREATE INDEX ix_mo_injection_routing_domain ON mo_webhooks_injection(routing_domain);

CREATE INDEX ix_mo_bounce_timestamp ON mo_webhooks_bounce(timestamp);
CREATE INDEX ix_mo_bounce_campaign_id ON mo_webhooks_bounce(campaign_id);
CREATE INDEX ix_mo_bounce_raw_rcpt_to ON mo_webhooks_bounce(raw_rcpt_to);
CREATE INDEX ix_mo_bounce_campaign_id_raw_rcpt_to ON mo_webhooks_delivery(campaign_id,raw_rcpt_to);
CREATE INDEX ix_mo_bounce_message_transmission_id ON mo_webhooks_bounce(message_id,transmission_id);
CREATE INDEX ix_mo_bounce_bounce_class ON mo_webhooks_bounce(bounce_class);
CREATE INDEX ix_mo_bounce_routing_domain ON mo_webhooks_bounce(routing_domain);

CREATE INDEX ix_mo_delivery_timestamp ON mo_webhooks_delivery(timestamp);
CREATE INDEX ix_mo_delivery_campaign_id ON mo_webhooks_delivery(campaign_id);
CREATE INDEX ix_mo_delivery_raw_rcpt_to ON mo_webhooks_delivery(raw_rcpt_to);
CREATE INDEX ix_mo_delivery_campaign_id_raw_rcpt_to ON mo_webhooks_delivery(campaign_id,raw_rcpt_to);
CREATE INDEX ix_mo_delivery_message_transmission_id ON mo_webhooks_delivery(message_id,transmission_id);
CREATE INDEX ix_mo_delivery_routing_domain ON mo_webhooks_delivery(routing_domain);

CREATE INDEX ix_mo_delay_timestamp ON mo_webhooks_delay(timestamp);
CREATE INDEX ix_mo_delay_campaign_id ON mo_webhooks_delay(campaign_id);
CREATE INDEX ix_mo_delay_raw_rcpt_to ON mo_webhooks_delay(raw_rcpt_to);
CREATE INDEX ix_mo_delay_campaign_id_raw_rcpt_to ON mo_webhooks_delivery(campaign_id,raw_rcpt_to);
CREATE INDEX ix_mo_delay_message_transmission_id ON mo_webhooks_delay(message_id,transmission_id);
CREATE INDEX ix_mo_delay_bounce_class ON mo_webhooks_delay(bounce_class);
CREATE INDEX ix_mo_delay_routing_domain ON mo_webhooks_delay(routing_domain);

CREATE INDEX ix_mo_oob_timestamp ON mo_webhooks_out_of_band(timestamp);
CREATE INDEX ix_mo_oob_campaign_id ON mo_webhooks_out_of_band(campaign_id);
CREATE INDEX ix_mo_oob_raw_rcpt_to ON mo_webhooks_out_of_band(raw_rcpt_to);
CREATE INDEX ix_mo_oob_campaign_id_raw_rcpt_to ON mo_webhooks_out_of_band(campaign_id,raw_rcpt_to);
CREATE INDEX ix_mo_oob_bounce_class ON mo_webhooks_out_of_band(bounce_class);

CREATE INDEX ix_mo_policy_timestamp ON mo_webhooks_policy_rejection(timestamp);
CREATE INDEX ix_mo_policy_campaign_id ON mo_webhooks_policy_rejection(campaign_id);
CREATE INDEX ix_mo_policy_raw_rcpt_to ON mo_webhooks_policy_rejection(raw_rcpt_to);
CREATE INDEX ix_mo_policy_campaign_id_raw_rcpt_to ON mo_webhooks_policy_rejection(campaign_id,raw_rcpt_to);
CREATE INDEX ix_mo_policy_message_transmission_id ON mo_webhooks_policy_rejection(message_id,transmission_id);
CREATE INDEX ix_mo_policy_error_code ON mo_webhooks_policy_rejection(error_code);

CREATE INDEX ix_mo_spam_timestamp ON mo_webhooks_spam_complaint(timestamp);
CREATE INDEX ix_mo_spam_campaign_id ON mo_webhooks_spam_complaint(campaign_id);
CREATE INDEX ix_mo_spam_raw_rcpt_to ON mo_webhooks_spam_complaint(raw_rcpt_to);
CREATE INDEX ix_mo_spam_campaign_id_raw_rcpt_to ON mo_webhooks_spam_complaint(campaign_id,raw_rcpt_to);
CREATE INDEX ix_mo_spam_message_transmission_id ON mo_webhooks_spam_complaint(message_id,transmission_id);

CREATE INDEX ix_mo_open_timestamp ON mo_webhooks_open(timestamp);
CREATE INDEX ix_mo_open_campaign_id ON mo_webhooks_open(campaign_id);
CREATE INDEX ix_mo_open_raw_rcpt_to ON mo_webhooks_open(raw_rcpt_to);
CREATE INDEX ix_mo_open_campaign_id_raw_rcpt_to ON mo_webhooks_open(campaign_id,raw_rcpt_to);
CREATE INDEX ix_mo_open_message_transmission_id ON mo_webhooks_open(message_id,transmission_id);

CREATE INDEX ix_mo_click_timestamp ON mo_webhooks_click(timestamp);
CREATE INDEX ix_mo_click_campaign_id ON mo_webhooks_click(campaign_id);
CREATE INDEX ix_mo_click_raw_rcpt_to ON mo_webhooks_click(raw_rcpt_to);
CREATE INDEX ix_mo_click_campaign_id_raw_rcpt_to ON mo_webhooks_click(campaign_id,raw_rcpt_to);
CREATE INDEX ix_mo_click_message_transmission_id ON mo_webhooks_click(message_id,transmission_id);

CREATE INDEX ix_mo_list_unsubscribe_timestamp ON mo_webhooks_list_unsubscribe(timestamp);
CREATE INDEX ix_mo_list_unsubscribe_campaign_id ON mo_webhooks_list_unsubscribe(campaign_id);
CREATE INDEX ix_mo_list_unsubscribe_raw_rcpt_to ON mo_webhooks_list_unsubscribe(raw_rcpt_to);
CREATE INDEX ix_mo_list_unsubscribe_campaign_id_raw_rcpt_to ON mo_webhooks_list_unsubscribe(campaign_id,raw_rcpt_to);
CREATE INDEX ix_mo_list_unsubscribe_message_transmission_id ON mo_webhooks_list_unsubscribe(message_id,transmission_id);

/*
	Convert table CHARACTER SET to utf8mb4
	Convert table COLLATE to utf8mbr_unicode_ci
*/
ALTER TABLE mo_webhooks_list_unsubscribe CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE mo_webhooks_link_unsubscribe CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE mo_webhooks_spam_complaint CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE mo_webhooks_policy_rejection CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE mo_webhooks_out_of_band CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE mo_webhooks_injection CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE mo_webhooks_bounce CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE mo_webhooks_delivery CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE mo_webhooks_delay CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE mo_webhooks_open CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE mo_webhooks_click CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE mo_webhooks_list_unsubscribe CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE mo_webhooks_link_unsubscribe CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE mo_webhooks_ad_adjust CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE mo_webhooks_ad_status CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;