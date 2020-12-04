INSERT INTO mo_webhooks_delivery
(
	timestamp
	, type
	, event_id
	, node_name
	, recv_method
	, delv_method
	, subaccount_id
	, transmission_id
	, conn_name
	, msg_batchname
	, msg_spoolname
	, conn_stage
	, message_id
	, binding
	, binding_group
	, msg_size
	, routing_domain
	, msg_from
	, friendly_from
	, rcpt_to
	, raw_rcpt_to
	, rcpt_type
	, subject
	, queue_time
	, num_retries
	, ip_address
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
	, :delv_method
	, :subaccount_id
	, :transmission_id
	, :conn_name
	, :msg_batchname
	, :msg_spoolname
	, :conn_stage
	, :message_id
	, :binding
	, :binding_group
	, :msg_size
	, :routing_domain
	, :msg_from
	, :friendly_from
	, :rcpt_to
	, :raw_rcpt_to
	, :rcpt_type
	, :subject
	, :queue_time
	, :num_retries
	, :ip_address
	, :customer_id
	, :campaign_id
	, :template_id
	, :template_version
	, :rcpt_tags
	, :rcpt_meta
);