<?php

namespace TenantCloud\Snappt\Client;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\RequestOptions;
use Psr\Log\LoggerInterface;
use TenantCloud\GuzzleHelper\GuzzleMiddleware;
use TenantCloud\Snappt\ApplicantSessions\ApplicantSessionsApi;
use TenantCloud\Snappt\ApplicantSessions\ApplicantSessionsApiImpl;
use TenantCloud\Snappt\Properties\PropertiesApi;
use TenantCloud\Snappt\Properties\PropertiesApiImpl;

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
		// todo:
		$stack->unshift(GuzzleMiddleware::dumpRequestBody());

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
}
