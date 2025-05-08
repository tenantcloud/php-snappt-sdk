<?php

namespace TenantCloud\Snappt\ApplicantSessions;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Arr;
use TenantCloud\Snappt\ApplicantSessions\DTO\CreateSessionDTO;
use TenantCloud\Snappt\ApplicantSessions\DTO\SessionDTO;
use TenantCloud\Snappt\ApplicantSessions\DTO\UpdateApplicationDTO;
use TenantCloud\Snappt\Client\RequestHelper;
use TenantCloud\Snappt\Exceptions\ErrorResponseException;

use function TenantCloud\GuzzleHelper\psr_response_to_json;

class ApplicantSessionsApiImpl implements ApplicantSessionsApi
{
	use RequestHelper;

	private const CREATE_SESSION_API = '/session';
	private const UPDATE_SESSION_API = '/session/application';

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

	public function updateApplication(UpdateApplicationDTO $updateApplicationDTO): UpdateApplicationDTO
	{
		$jsonResponse = $this->httpClient->post(
			self::UPDATE_SESSION_API,
			[
				RequestOptions::HEADERS => $this->setUnauthenticatedSessionToken($this->apiKey),
				RequestOptions::JSON    => $updateApplicationDTO->toArray(),
			]
		);

		$response = (array) psr_response_to_json($jsonResponse);

		if (Arr::has($response, 'error')) {
			$errorMessage = sprintf('Received error response from API "%s". Error: %s', self::UPDATE_SESSION_API, $response['error']);

			throw new ErrorResponseException($errorMessage);
		}

		return UpdateApplicationDTO::from($response);
	}
}
