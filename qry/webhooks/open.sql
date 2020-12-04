INSERT INTO mo_webhooks_open
(
	timestamp
	, type
	, event_id
	, message_id
	, node_name
	, delv_method
	, campaign_id 
	, customer_id
	, subaccount_id
	, transmission_id
	, rcpt_to
	, raw_rcpt_to
	, rcpt_type
	, ip_address
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
	, :node_name
	, :delv_method
	, :campaign_id 
	, :customer_id
	, :subaccount_id
	, :transmission_id
	, :rcpt_to
	, :raw_rcpt_to
	, :rcpt_type
	, :ip_address 
	, :user_agent
	, :template_id
	, :template_version
	, :rcpt_meta
	, :rcpt_tags
);