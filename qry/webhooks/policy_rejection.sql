INSERT INTO mo_webhooks_policy_rejection
(
	timestamp
	, type
	, event_id
	, node_name
	, recv_method
	, subaccount_id
	, transmission_id
	, conn_name
	, message_id
	, binding
	, binding_group
	, pathway
	, pathway_group
	, msg_from
	, friendly_from
	, rcpt_to
	, raw_rcpt_to
	, rcpt_type
	, error_code
	, reason
	, raw_reason
	, scope_name
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
	, :recv_method
	, :subaccount_id
	, :transmission_id
	, :conn_name
	, :message_id
	, :binding
	, :binding_group
	, :pathway
	, :pathway_group
	, :msg_from
	, :friendly_from
	, :rcpt_to
	, :raw_rcpt_to
	, :rcpt_type
	, :error_code
	, :reason
	, :raw_reason
	, :scope_name
	, :customer_id
	, :campaign_id
	, :template_id
	, :template_version
	, :rcpt_tags
	, :rcpt_meta
);