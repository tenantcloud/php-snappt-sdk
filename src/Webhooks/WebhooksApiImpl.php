<?php

namespace TenantCloud\Snappt\Webhooks;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use TenantCloud\Snappt\Client\RequestHelper;
use TenantCloud\Snappt\Webhooks\DTO\CreateWebhookDTO;
use TenantCloud\Snappt\Webhooks\DTO\WebhookDTO;
use TenantCloud\Snappt\Webhooks\DTO\WebhooksDTO;

use function TenantCloud\GuzzleHelper\psr_response_to_json;

class WebhooksApiImpl implements WebhooksApi
{
	use RequestHelper;

	private const WEBHOOK_API = '/webhooks';
	private const WEBHOOK_ITEM_API = '/webhooks/%s';

	public function __construct(
		private readonly Client $httpClient,
		private readonly string $apiKey,
	) {}

	public function list(): WebhooksDTO
	{
		$jsonResponse = $this->httpClient->get(
			self::WEBHOOK_API,
			[
				RequestOptions::HEADERS => $this->setAuthHeader($this->apiKey),
			]
		);

		$response = (array) psr_response_to_json($jsonResponse);

		return WebhooksDTO::create()
			->setWebhooks($response);
	}

	public function find(string $webhookId): WebhookDTO
	{
		$jsonResponse = $this->httpClient->get(
			sprintf(self::WEBHOOK_ITEM_API, $webhookId),
			[
				RequestOptions::HEADERS => $this->setAuthHeader($this->apiKey),
			]
		);

		$response = (array) psr_response_to_json($jsonResponse);

		return WebhookDTO::from($response);
	}

	public function create(CreateWebhookDTO $createWebhookDTO): WebhookDTO
	{
		$jsonResponse = $this->httpClient->post(
			self::WEBHOOK_API,
			[
				RequestOptions::HEADERS => $this->setAuthHeader($this->apiKey),
				RequestOptions::JSON    => $createWebhookDTO->toArray(),
			]
		);

		$response = (array) psr_response_to_json($jsonResponse);

		return WebhookDTO::from($response);
	}

	public function update(string $webhookId, CreateWebhookDTO $createWebhookDTO): WebhookDTO
	{
		$jsonResponse = $this->httpClient->put(
			sprintf(self::WEBHOOK_ITEM_API, $webhookId),
			[
				RequestOptions::HEADERS => $this->setAuthHeader($this->apiKey),
				RequestOptions::JSON    => $createWebhookDTO->toArray(),
			]
		);

		$response = (array) psr_response_to_json($jsonResponse);

		return WebhookDTO::from($response);
	}

	public function delete(string $webhookId): void
	{
		$this->httpClient->delete(
			sprintf(self::WEBHOOK_ITEM_API, $webhookId),
			[
				RequestOptions::HEADERS => $this->setAuthHeader($this->apiKey),
			]
		);
	}
}
