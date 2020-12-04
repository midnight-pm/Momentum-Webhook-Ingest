INSERT INTO mo_webhooks_link_unsubscribe
(
	timestamp
	, type
	, event_id
	, message_id
	, customer_id
	, campaign_id
	, subaccount_id
	, transmission_id
	, mailfrom
	, friendly_from
	, rcpt_to
	, raw_rcpt_to
	, rcpt_type
	, user_agent
	, template_id
	, template_version
	, rcpt_meta
	, rcpt_tags
)
VALUES
(
	:timestamp
	, :type
	, :event_id
	, :message_id
	, :customer_id
	, :campaign_id
	, :subaccount_id
	, :transmission_id
	, :mailfrom
	, :friendly_from
	, :rcpt_to
	, :raw_rcpt_to
	, :rcpt_type
	, :user_agent
	, :template_id
	, :template_version
	, :rcpt_meta
	, :rcpt_tags
);