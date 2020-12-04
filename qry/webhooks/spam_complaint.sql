INSERT INTO mo_webhooks_spam_complaint
(
	timestamp
	, type
	, event_id
	, node_name
	, subaccount_id
	, transmission_id
	, msg_spoolname
	, message_id
	, binding
	, binding_group
	, friendly_from
	, rcpt_to
	, raw_rcpt_to
	, rcpt_type
	, fbtype
	, report_by
	, report_to
	, user_str
	, customer_id
	, campaign_id
	, template_id
	, template_version
	, rcpt_tags
	, rcpt_meta
)
VALUES
(
	:timestamp
	, :type
	, :event_id
	, :node_name
	, :subaccount_id
	, :transmission_id
	, :msg_spoolname
	, :message_id
	, :binding
	, :binding_group
	, :friendly_from
	, :rcpt_to
	, :raw_rcpt_to
	, :rcpt_type
	, :fbtype
	, :report_by
	, :report_to
	, :user_str
	, :customer_id
	, :campaign_id
	, :template_id
	, :template_version
	, :rcpt_tags
	, :rcpt_meta
);