<?php

namespace Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Config\Repository;
use Illuminate\Foundation\Testing\WithFaker;
use Orchestra\Testbench\TestCase as BaseTestCase;
use TenantCloud\Snappt\Client\SnapptClient;
use TenantCloud\Snappt\Client\SnapptClientImpl;
use TenantCloud\Snappt\SnapptSdkServiceProvider;

class TestCase extends BaseTestCase
{
	use WithFaker;

	protected function getPackageProviders($app): array
	{
		return [
			SnapptSdkServiceProvider::class,
		];
	}

	protected function mockResponse(int $statusCode, ?string $responseBody = null): SnapptClient
	{
		$mock = new MockHandler([
			new Response(
				$statusCode,
				[],
				$responseBody
			),
		]);

		$handlerStack = HandlerStack::create($mock);

		$client = new Client(['handler' => $handlerStack]);

		$config = $this->app->make(Repository::class);

		$this->app->bind(SnapptClient::class, fn () => new SnapptClientImpl(
			$config->get('snappt.api_key') ?? '',
			$config->get('snappt.base_url') ?? '',
			30,
			null,
			$client
		));

		return $this->app->make(SnapptClient::class);
	}
}
