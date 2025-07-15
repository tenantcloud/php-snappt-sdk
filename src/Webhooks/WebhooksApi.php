<?php

namespace TenantCloud\Snappt\Webhooks;

use TenantCloud\Snappt\Webhooks\DTO\CreateWebhookDTO;
use TenantCloud\Snappt\Webhooks\DTO\WebhookDTO;
use TenantCloud\Snappt\Webhooks\DTO\WebhooksDTO;

interface WebhooksApi
{
	public function list(): WebhooksDTO;

	public function find(string $webhookId): WebhookDTO;

	public function create(CreateWebhookDTO $createWebhookDTO): WebhookDTO;

	public function update(string $webhookId, CreateWebhookDTO $createWebhookDTO): WebhookDTO;

	public function delete(string $webhookId): void;
}
