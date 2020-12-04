INSERT INTO mo_webhooks_ad_adjust
(
	timestamp
	, type
	, event_id
	, customer_id
	, subaccount_id
	, node_name
	, binding
	, routing_domain
	, opt_value
	, option
	, scope
)
VALUES
(
	:timestamp
	, :type
	, :event_id
	, :customer_id
	, :subaccount_id
	, :node_name
	, :binding
	, :routing_domain
	, :opt_value
	, :option
	, :scope