INSERT INTO mo_webhooks_injection
(
	timestamp
	, type
	, event_id
	, node_name
	, recv_method
	, subaccount_id
	, transmission_id
	, conn_name
	, msg_batchname
	, msg_spoolname
	, conn_stage
	, message_id
	, binding
	, binding_group
	, pathway
	, pathway_group
	, msg_size
	, routing_domain
	, msg_from
	, friendly_from
	, rcpt_to
	, raw_rcpt_to
	, rcpt_type
	, subject
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
	, :msg_batchname
	, :msg_spoolname
	, :conn_stage
	, :message_id
	, :binding
	, :binding_group
	, :pathway
	, :pathway_group
	, :msg_size
	, :routing_domain
	, :msg_from
	, :friendly_from
	, :rcpt_to
	, :raw_rcpt_to
	, :rcpt_type
	, :subject
	, :customer_id
	, :campaign_id
	, :template_id
	, :template_version
	, :rcpt_tags
	, :rcpt_meta
);