INSERT INTO mo_webhooks_ad_status
(
	timestamp
	, type
	, event_id
	, customer_id
	, subaccount_id
	, node_name
	, binding
	, routing_domain
	, action
	, rule
	, trigger
	, scope
	, status
	, start
	, stop
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
	, :action
	, :rule
	, :trigger
	, :scope
	, :status
	, :start
	, :stop