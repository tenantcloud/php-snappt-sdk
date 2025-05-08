<?php

namespace TenantCloud\Snappt\Client;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\RequestOptions;
use Psr\Log\LoggerInterface;
use TenantCloud\GuzzleHelper\GuzzleMiddleware;
use TenantCloud\Snappt\Applicants\ApplicantsApi;
use TenantCloud\Snappt\Applicants\ApplicantsApiImpl;

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

	public function applicants(): ApplicantsApi
	{
		return new ApplicantsApiImpl($this->httpClient, $this->apiKey);
	}
}
