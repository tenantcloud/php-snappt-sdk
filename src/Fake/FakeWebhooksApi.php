<?php

namespace TenantCloud\Snappt\Fake;

use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Str;
use TenantCloud\Snappt\Exceptions\NotFoundException;
use TenantCloud\Snappt\Webhooks\DTO\CreateWebhookDTO;
use TenantCloud\Snappt\Webhooks\DTO\WebhookDTO;
use TenantCloud\Snappt\Webhooks\DTO\WebhooksDTO;
use TenantCloud\Snappt\Webhooks\WebhooksApi;

class FakeWebhooksApi implements WebhooksApi
{
	public function __construct(
		private readonly Repository $cache
	) {}

	public function list(): WebhooksDTO
	{
		return WebhooksDTO::create()
			->setWebhooks($this->cache->get('webhooks', []));
	}

	public function find(string $webhookId): WebhookDTO
	{
		$webhooks = $this->cache->get('webhooks', []);

		foreach ($webhooks as $webhook) {
			if ($webhook['id'] === $webhookId) {
				return WebhookDTO::from($webhook);
			}
		}

		throw new NotFoundException();
	}

	public function create(CreateWebhookDTO $createWebhookDTO): WebhookDTO
	{
		$webhookId = Str::uuid()->toString();
		$apiKey = Str::uuid()->toString();

		$webhookDto = WebhookDTO::create()
			->setId($webhookId)
			->setMethod($createWebhookDTO->getMethod())
			->setUrl($createWebhookDTO->getUrl())
			->setHeaders([])
			->setEvents($createWebhookDTO->getEvents())
			->setIsActive($createWebhookDTO->getIsActive())
			->setApiKeyId($apiKey)
			->setInsertedAt('2025-07-15 12:44:01+00:00')
			->setUpdatedAt('2025-07-15 12:44:01+00:00');

		$webhooks = $this->cache->get('webhooks', []);

		$webhooks[] = $webhookDto->toArray();

		$this->cache->put('webhooks', $webhooks);

		return $webhookDto;
	}

	public function update(string $webhookId, CreateWebhookDTO $createWebhookDTO): WebhookDTO
	{
		$webhooks = $this->cache->get('webhooks', []);

		foreach ($webhooks as $index => $webhookData) {
			if ($webhookData['id'] === $webhookId) {
				$webhook = WebhookDTO::from($webhookData);

				$webhook
					->setMethod($createWebhookDTO->getMethod())
					->setUrl($createWebhookDTO->getUrl())
					->setEvents($createWebhookDTO->getEvents())
					->setIsActive($createWebhookDTO->getIsActive())
					->setUpdatedAt(now()->toIso8601String());

				$webhooks[$index] = $webhook->toArray();

				break;
			}
		}

		if (!isset($webhook)) {
			throw new NotFoundException();
		}

		$this->cache->put('webhooks', $webhooks);

		return $webhook;
	}

	public function delete(string $webhookId): void
	{
		$webhooks = $this->cache->get('webhooks', []);

		$webhooks = array_filter($webhooks, fn (array $webhook) => $webhook['id'] !== $webhookId);

		$this->cache->put('webhooks', array_values($webhooks));
	}
}
