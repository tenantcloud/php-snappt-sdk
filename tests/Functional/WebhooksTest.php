<?php

namespace Tests\Functional;

use TenantCloud\Snappt\Webhooks\DTO\CreateWebhookDTO;
use Tests\TestCase;

class WebhooksTest extends TestCase
{
	public function testList(): void
	{
		$snapptClient = $this->mockResponse(
			200,
			(string) file_get_contents(__DIR__ . '/../resources/webhooks/list.json')
		);

		$webhooks = $snapptClient->webhooks()->list();

		$this->assertCount(2, $webhooks->getWebhooks());
		$this->assertSame('f763814e-a424-448b-b999-0dc1eed98704', $webhooks->getWebhooks()[0]->getId());
		$this->assertSame('b495888a-8f2d-4421-9a2e-78bfaf265c54', $webhooks->getWebhooks()[1]->getId());
	}

	public function testFind(): void
	{
		$snapptClient = $this->mockResponse(
			200,
			(string) file_get_contents(__DIR__ . '/../resources/webhooks/get.json')
		);

		$webhook = $snapptClient->webhooks()->find('f763814e-a424-448b-b999-0dc1eed98704');

		$this->assertSame('f763814e-a424-448b-b999-0dc1eed98704', $webhook->getId());
	}

	public function testCreate(): void
	{
		$snapptClient = $this->mockResponse(
			200,
			(string) file_get_contents(__DIR__ . '/../resources/webhooks/create.json')
		);

		$webhook = $snapptClient->webhooks()->create(CreateWebhookDTO::create());

		$this->assertSame('f763814e-a424-448b-b999-0dc1eed98704', $webhook->getId());
	}

	public function testUpdate(): void
	{
		$snapptClient = $this->mockResponse(
			200,
			(string) file_get_contents(__DIR__ . '/../resources/webhooks/update.json')
		);

		$webhook = $snapptClient->webhooks()->update('f763814e-a424-448b-b999-0dc1eed98704', CreateWebhookDTO::create());

		$this->assertSame('f763814e-a424-448b-b999-0dc1eed98704', $webhook->getId());
		$this->assertSame('APPLICATION_SUBMITTED', $webhook->getEvents()[0]);
	}

	public function testDelete(): void
	{
		$this->expectNotToPerformAssertions();

		$snapptClient = $this->mockResponse(
			200,
			(string) file_get_contents(__DIR__ . '/../resources/webhooks/update.json')
		);

		$snapptClient->webhooks()->delete('f763814e-a424-448b-b999-0dc1eed98704');
	}
}
