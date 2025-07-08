<?php

namespace TenantCloud\Snappt\ApplicantSessions;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Arr;
use InvalidArgumentException;
use TenantCloud\Snappt\ApplicantSessions\DTO\CreateSessionDTO;
use TenantCloud\Snappt\ApplicantSessions\DTO\DocumentDTO;
use TenantCloud\Snappt\ApplicantSessions\DTO\SessionDTO;
use TenantCloud\Snappt\ApplicantSessions\DTO\UpdateApplicationDTO;
use TenantCloud\Snappt\ApplicantSessions\Enum\DocumentType;
use TenantCloud\Snappt\Client\RequestHelper;
use TenantCloud\Snappt\Exceptions\ErrorResponseException;

use function TenantCloud\GuzzleHelper\psr_response_to_json;

class ApplicantSessionsApiImpl implements ApplicantSessionsApi
{
	use RequestHelper;

	private const CREATE_SESSION_API = '/session';
	private const UPDATE_SESSION_API = '/session/application';
	private const UPLOAD_DOCUMENT_API = '/session/documents';
	private const SUBMIT_API = '/session/submit';

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

	public function updateApplication(UpdateApplicationDTO $updateApplicationDTO, string $sessionToken): UpdateApplicationDTO
	{
		$jsonResponse = $this->httpClient->put(
			self::UPDATE_SESSION_API,
			[
				RequestOptions::HEADERS => $this->setUnauthenticatedSessionToken($sessionToken),
				RequestOptions::JSON    => $updateApplicationDTO->toArray(),
			]
		);

		$response = (array) psr_response_to_json($jsonResponse);

		if (Arr::has($response, 'error')) {
			$errorMessage = 'Error: ' . $response['error'];

			throw new ErrorResponseException(self::UPDATE_SESSION_API, $errorMessage);
		}

		return UpdateApplicationDTO::from($response);
	}

	public function uploadDocument(DocumentType $documentType, string $sessionToken, string $filePath): DocumentDTO
	{
		$jsonResponse = $this->httpClient->post(
			self::UPLOAD_DOCUMENT_API,
			[
				RequestOptions::HEADERS => array_merge(
					$this->setUnauthenticatedSessionToken($sessionToken),
					['Accept' => 'application/json']
				),
				RequestOptions::MULTIPART => [
					[
						'name'     => 'type',
						'contents' => $documentType->value,
					],
					[
						'name'     => 'fileName',
						'contents' => basename($filePath),
					],
					[
						'name'     => 'upload',
						'contents' => fopen($filePath, 'r'),
						'filename' => basename($filePath),
					],
				],
			]
		);

		$response = (array) psr_response_to_json($jsonResponse);

		if (Arr::has($response, 'error')) {
			$errorMessage = sprintf(
				'Error: %s. Status code: %s. Failed checks: %s',
				$response['error'],
				$response['statusCode'] ?? 'none',
				isset($response['failedChecks']) ? implode(', ', (array) $response['failedChecks']) : 'none'
			);

			throw new ErrorResponseException(self::UPLOAD_DOCUMENT_API, $errorMessage);
		}

		return DocumentDTO::from($response);
	}

	public function submit(string $sessionToken): string
	{
		$jsonResponse = $this->httpClient->post(
			self::SUBMIT_API,
			[
				RequestOptions::HEADERS => $this->setUnauthenticatedSessionToken($sessionToken),
			]
		);

		$response = (array) psr_response_to_json($jsonResponse);

		return $response['applicantId'];
	}
}
