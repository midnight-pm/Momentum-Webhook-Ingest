INSERT INTO mo_webhooks_out_of_band
(
	timestamp
	, type
	, event_id
	, node_name
	, recv_method
	, delv_method
	, subaccount_id
	, conn_stage
	, message_id
	, binding
	, binding_group
	, msg_from
	, rcpt_to
	, raw_rcpt_to
	, bounce_class
	, error_code
	, reason
	, raw_reason
	, customer_id
	, campaign_id
	, template_id
	, template_version
)
VALUES
(
	:timestamp
	, :type
	, :event_id
	, :node_name
	, :recv_method
	, :delv_method
	, :subaccount_id
	, :conn_stage
	, :message_id
	, :binding
	, :binding_group
	, :msg_from
	, :rcpt_to
	, :raw_rcpt_to
	, :bounce_class
	, :error_code
	, :reason
	, :raw_reason
	, :customer_id
	, :campaign_id
	, :template_id
	, :template_version
);