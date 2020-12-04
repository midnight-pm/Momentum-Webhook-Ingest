CREATE INDEX ix_mo_injection_timestamp ON mo_webhooks_injection(timestamp);
CREATE INDEX ix_mo_injection_campaign_id ON mo_webhooks_injection(campaign_id);
CREATE INDEX ix_mo_injection_raw_rcpt_to ON mo_webhooks_injection(raw_rcpt_to);
CREATE INDEX ix_mo_injection_campaign_id_raw_rcpt_to ON mo_webhooks_delivery(campaign_id,raw_rcpt_to);
CREATE INDEX ix_mo_injection_message_transmission_id ON mo_webhooks_injection(message_id,transmission_id);

CREATE INDEX ix_mo_bounce_timestamp ON mo_webhooks_bounce(timestamp);
CREATE INDEX ix_mo_bounce_campaign_id ON mo_webhooks_bounce(campaign_id);
CREATE INDEX ix_mo_bounce_raw_rcpt_to ON mo_webhooks_bounce(raw_rcpt_to);
CREATE INDEX ix_mo_bounce_campaign_id_raw_rcpt_to ON mo_webhooks_delivery(campaign_id,raw_rcpt_to);
CREATE INDEX ix_mo_bounce_message_transmission_id ON mo_webhooks_bounce(message_id,transmission_id);

CREATE INDEX ix_mo_delivery_timestamp ON mo_webhooks_delivery(timestamp);
CREATE INDEX ix_mo_delivery_campaign_id ON mo_webhooks_delivery(campaign_id);
CREATE INDEX ix_mo_delivery_raw_rcpt_to ON mo_webhooks_delivery(raw_rcpt_to);
CREATE INDEX ix_mo_delivery_campaign_id_raw_rcpt_to ON mo_webhooks_delivery(campaign_id,raw_rcpt_to);
CREATE INDEX ix_mo_delivery_message_transmission_id ON mo_webhooks_delivery(message_id,transmission_id);

CREATE INDEX ix_mo_delay_timestamp ON mo_webhooks_delay(timestamp);
CREATE INDEX ix_mo_delay_campaign_id ON mo_webhooks_delay(campaign_id);
CREATE INDEX ix_mo_delay_raw_rcpt_to ON mo_webhooks_delay(raw_rcpt_to);
CREATE INDEX ix_mo_delay_campaign_id_raw_rcpt_to ON mo_webhooks_delivery(campaign_id,raw_rcpt_to);
CREATE INDEX ix_mo_delay_message_transmission_id ON mo_webhooks_delay(message_id,transmission_id);

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