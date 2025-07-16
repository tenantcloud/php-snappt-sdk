<?php

namespace TenantCloud\Snappt\Client;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\RequestOptions;
use Psr\Log\LoggerInterface;
use TenantCloud\GuzzleHelper\DumpRequestBody\HeaderObfuscator;
use TenantCloud\GuzzleHelper\DumpRequestBody\JsonObfuscator;
use TenantCloud\GuzzleHelper\GuzzleMiddleware;
use TenantCloud\Snappt\Applicants\ApplicantsApi;
use TenantCloud\Snappt\Applicants\ApplicantsApiImpl;
use TenantCloud\Snappt\ApplicantSessions\ApplicantSessionsApi;
use TenantCloud\Snappt\ApplicantSessions\ApplicantSessionsApiImpl;
use TenantCloud\Snappt\Properties\PropertiesApi;
use TenantCloud\Snappt\Properties\PropertiesApiImpl;
use TenantCloud\Snappt\Webhooks\WebhooksApi;
use TenantCloud\Snappt\Webhooks\WebhooksApiImpl;

class SnapptClientImpl implements SnapptClient
{
	private readonly Client $httpClient;

	public function __construct(
		private readonly string $apiKey,
		string $baseUrl,
		int $timeout = 30,
		?LoggerInterface $logger = null,
		?Client $httpClient = null
	) {
		$stack = HandlerStack::create();

		// Return all response body.
		$stack->unshift(GuzzleMiddleware::fullErrorResponseBody());

		// Hide secret info from error responses.
		$stack->unshift(GuzzleMiddleware::dumpRequestBody([
			new JsonObfuscator([
				'email',
				'phone',
			]),
			new HeaderObfuscator(['Authorization']),
		]));

		if ($logger) {
			$stack->push(GuzzleMiddleware::tracingLog($logger));
		}

		$this->httpClient = $httpClient ?? new Client([
			'base_uri'                      => $baseUrl,
			'handler'                       => $stack,
			RequestOptions::CONNECT_TIMEOUT => $timeout,
			RequestOptions::TIMEOUT         => $timeout,
		]);
	}

	public function applicantSessions(): ApplicantSessionsApi
	{
		return new ApplicantSessionsApiImpl($this->httpClient, $this->apiKey);
	}

	public function properties(): PropertiesApi
	{
		return new PropertiesApiImpl($this->httpClient, $this->apiKey);
	}

	public function applicants(): ApplicantsApi
	{
		return new ApplicantsApiImpl($this->httpClient, $this->apiKey);
	}

	public function webhooks(): WebhooksApi
	{
		return new WebhooksApiImpl($this->httpClient, $this->apiKey);
	}
}
