<?php

namespace TenantCloud\Snappt\Webhooks\DTO;

use TenantCloud\DataTransferObjects\CamelDataTransferObject;

/**
 * @method list<WebhookDTO> getWebhooks()
 * @method bool             hasWebhooks()
 */
class WebhooksDTO extends CamelDataTransferObject
{
	protected array $fields = [
		'webhooks',
	];

	/**
	 * @param list<array<string, mixed>|WebhookDTO> $webhooks
	 */
	public function setWebhooks(array $webhooks): self
	{
		$webhooksData = [];

		foreach ($webhooks as $webhook) {
			if (!($webhook instanceof WebhookDTO)) {
				$webhook = WebhookDTO::from($webhook);
			}

			$webhooksData[] = $webhook;
		}

		return $this->set('webhooks', $webhooksData);
	}
}
