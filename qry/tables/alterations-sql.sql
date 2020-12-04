/*
	https://stackoverflow.com/questions/10718905/how-to-change-the-column-position-of-mysql-table-without-losing-column-data/10718926
	https://stackoverflow.com/questions/3379454/mysql-alter-table-add-field-before-or-after-a-field-already-present
*/
ALTER TABLE sp_webhooks_injection ADD id bigint NOT NULL PRIMARY KEY AUTO_INCREMENT FIRST;
ALTER TABLE sp_webhooks_bounce ADD id bigint NOT NULL PRIMARY KEY AUTO_INCREMENT FIRST;
ALTER TABLE sp_webhooks_delivery ADD id bigint NOT NULL PRIMARY KEY AUTO_INCREMENT FIRST;
ALTER TABLE sp_webhooks_delay ADD id bigint NOT NULL PRIMARY KEY AUTO_INCREMENT FIRST;
ALTER TABLE sp_webhooks_initial_open ADD id bigint NOT NULL PRIMARY KEY AUTO_INCREMENT FIRST;
ALTER TABLE sp_webhooks_open ADD id bigint NOT NULL PRIMARY KEY AUTO_INCREMENT FIRST;
ALTER TABLE sp_webhooks_click ADD id bigint NOT NULL PRIMARY KEY AUTO_INCREMENT FIRST;
ALTER TABLE sp_webhooks_list_unsubscribe ADD id bigint NOT NULL PRIMARY KEY AUTO_INCREMENT FIRST;
ALTER TABLE sp_webhooks_link_unsubscribe ADD id bigint NOT NULL PRIMARY KEY AUTO_INCREMENT FIRST;
ALTER TABLE sp_webhooks_spam_complaint ADD id bigint NOT NULL PRIMARY KEY AUTO_INCREMENT FIRST;
ALTER TABLE sp_webhooks_policy_rejection ADD id bigint NOT NULL PRIMARY KEY AUTO_INCREMENT FIRST;
ALTER TABLE sp_webhooks_out_of_band ADD id bigint NOT NULL PRIMARY KEY AUTO_INCREMENT FIRST;



ALTER TABLE SparkPost.sp_webhooks_injection CHANGE rcpt_meta rcpt_meta text;
ALTER TABLE SparkPost.sp_webhooks_injection CHANGE rcpt_tags rcpt_tags text;
ALTER TABLE SparkPost.sp_webhooks_delivery CHANGE rcpt_meta rcpt_meta text;
ALTER TABLE SparkPost.sp_webhooks_delivery CHANGE rcpt_tags rcpt_tags text;
ALTER TABLE SparkPost.sp_webhooks_delay CHANGE rcpt_meta rcpt_meta text;
ALTER TABLE SparkPost.sp_webhooks_delay CHANGE rcpt_tags rcpt_tags text;
ALTER TABLE SparkPost.sp_webhooks_bounce CHANGE rcpt_meta rcpt_meta text;
ALTER TABLE SparkPost.sp_webhooks_bounce CHANGE rcpt_tags rcpt_tags text;
ALTER TABLE SparkPost.sp_webhooks_out_of_band CHANGE rcpt_meta rcpt_meta text;
ALTER TABLE SparkPost.sp_webhooks_out_of_band CHANGE rcpt_tags rcpt_tags text;
ALTER TABLE SparkPost.sp_webhooks_spam_complaint CHANGE rcpt_meta rcpt_meta text;
ALTER TABLE SparkPost.sp_webhooks_spam_complaint CHANGE rcpt_tags rcpt_tags text;
ALTER TABLE SparkPost.sp_webhooks_list_unsubscribe CHANGE rcpt_meta rcpt_meta text;
ALTER TABLE SparkPost.sp_webhooks_list_unsubscribe CHANGE rcpt_tags rcpt_tags text;
ALTER TABLE SparkPost.sp_webhooks_link_unsubscribe CHANGE rcpt_meta rcpt_meta text;
ALTER TABLE SparkPost.sp_webhooks_link_unsubscribe CHANGE rcpt_tags rcpt_tags text;
ALTER TABLE SparkPost.sp_webhooks_click CHANGE rcpt_meta rcpt_meta text;
ALTER TABLE SparkPost.sp_webhooks_click CHANGE rcpt_tags rcpt_tags text;
ALTER TABLE SparkPost.sp_webhooks_open CHANGE rcpt_meta rcpt_meta text;
ALTER TABLE SparkPost.sp_webhooks_open CHANGE rcpt_tags rcpt_tags text;
ALTER TABLE SparkPost.sp_webhooks_initial_open CHANGE rcpt_meta rcpt_meta text;
ALTER TABLE SparkPost.sp_webhooks_initial_open CHANGE rcpt_tags rcpt_tags text;
ALTER TABLE SparkPost.sp_webhooks_policy_rejection CHANGE rcpt_meta rcpt_meta text;
ALTER TABLE SparkPost.sp_webhooks_policy_rejection CHANGE rcpt_tags rcpt_tags text;




ALTER TABLE SparkPost.sp_webhooks_injection CHANGE open_tracking open_tracking boolean;
ALTER TABLE SparkPost.sp_webhooks_delivery CHANGE open_tracking open_tracking boolean;
ALTER TABLE SparkPost.sp_webhooks_delay CHANGE open_tracking open_tracking boolean;
ALTER TABLE SparkPost.sp_webhooks_bounce CHANGE open_tracking open_tracking boolean;
ALTER TABLE SparkPost.sp_webhooks_out_of_band CHANGE open_tracking open_tracking boolean;
ALTER TABLE SparkPost.sp_webhooks_spam_complaint CHANGE open_tracking open_tracking boolean;
ALTER TABLE SparkPost.sp_webhooks_list_unsubscribe CHANGE open_tracking open_tracking boolean;
ALTER TABLE SparkPost.sp_webhooks_link_unsubscribe CHANGE open_tracking open_tracking boolean;
ALTER TABLE SparkPost.sp_webhooks_click CHANGE open_tracking open_tracking boolean;
ALTER TABLE SparkPost.sp_webhooks_open CHANGE open_tracking open_tracking boolean;
ALTER TABLE SparkPost.sp_webhooks_initial_open CHANGE open_tracking open_tracking boolean;
ALTER TABLE SparkPost.sp_webhooks_policy_rejection CHANGE open_tracking open_tracking boolean;




ALTER TABLE SparkPost.sp_webhooks_injection CHANGE initial_pixel initial_pixel boolean;
ALTER TABLE SparkPost.sp_webhooks_delivery CHANGE initial_pixel initial_pixel boolean;
ALTER TABLE SparkPost.sp_webhooks_delay CHANGE initial_pixel initial_pixel boolean;
ALTER TABLE SparkPost.sp_webhooks_bounce CHANGE initial_pixel initial_pixel boolean;
ALTER TABLE SparkPost.sp_webhooks_out_of_band CHANGE initial_pixel initial_pixel boolean;
ALTER TABLE SparkPost.sp_webhooks_spam_complaint CHANGE initial_pixel initial_pixel boolean;
ALTER TABLE SparkPost.sp_webhooks_list_unsubscribe CHANGE initial_pixel initial_pixel boolean;
ALTER TABLE SparkPost.sp_webhooks_link_unsubscribe CHANGE initial_pixel initial_pixel boolean;
ALTER TABLE SparkPost.sp_webhooks_click CHANGE initial_pixel initial_pixel boolean;
ALTER TABLE SparkPost.sp_webhooks_open CHANGE initial_pixel initial_pixel boolean;
ALTER TABLE SparkPost.sp_webhooks_initial_open CHANGE initial_pixel initial_pixel boolean;
ALTER TABLE SparkPost.sp_webhooks_policy_rejection CHANGE initial_pixel initial_pixel boolean;




ALTER TABLE SparkPost.sp_webhooks_injection CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE SparkPost.sp_webhooks_delivery CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE SparkPost.sp_webhooks_delay CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE SparkPost.sp_webhooks_bounce CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE SparkPost.sp_webhooks_out_of_band CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE SparkPost.sp_webhooks_spam_complaint CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE SparkPost.sp_webhooks_list_unsubscribe CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE SparkPost.sp_webhooks_link_unsubscribe CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE SparkPost.sp_webhooks_click CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE SparkPost.sp_webhooks_open CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE SparkPost.sp_webhooks_initial_open CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE SparkPost.sp_webhooks_policy_rejection CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;