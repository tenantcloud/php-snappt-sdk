<?php

namespace TenantCloud\Snappt\Applicants;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Arr;
use TenantCloud\Snappt\Applicants\DTO\CreateSessionDTO;
use TenantCloud\Snappt\Applicants\DTO\SessionDTO;
use TenantCloud\Snappt\Client\RequestHelper;

use function TenantCloud\GuzzleHelper\psr_response_to_json;

class ApplicantsApiImpl implements ApplicantsApi
{
	use RequestHelper;

	private const CREATE_SESSION_API = '/session';

	public function __construct(
		private readonly Client $httpClient,
		private readonly string $apiKey,
	) {}

	public function createSession(CreateSessionDTO $createSessionDTO): SessionDTO
	{
		$query = http_build_query([
			'applicationType' => $createSessionDTO->getApplicationType(),
		]);

		$url = self::CREATE_SESSION_API . '?' . $query;

		$jsonResponse = $this->httpClient->post(
			$url,
			[
				RequestOptions::HEADERS => $this->setAuthHeader($this->apiKey),
				RequestOptions::JSON    => Arr::except($createSessionDTO->toArray(), ['applicationType']),
			]
		);

		$response = (array) psr_response_to_json($jsonResponse);

		return SessionDTO::from($response);
	}
}
