<?php

namespace TenantCloud\Snappt\Applicants;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Arr;
use TenantCloud\Snappt\Applicants\DTO\ApplicantDTO;
use TenantCloud\Snappt\Client\RequestHelper;
use TenantCloud\Snappt\Exceptions\ErrorResponseException;
use function TenantCloud\GuzzleHelper\psr_response_to_json;

class ApplicantsApiImpl implements ApplicantsApi
{
	use RequestHelper;

	private const GET_APPLICANT_API = '/applicants/%s';

	public function __construct(
		private readonly Client $httpClient,
		private readonly string $apiKey,
	) {}

	public function get(string $applicantId, bool $includeDocuments): ApplicantDTO
	{
		$query = http_build_query([
			'includeDocuments' => $includeDocuments,
		]);

		$url = sprintf(self::GET_APPLICANT_API, $applicantId) . '?' . $query;

		$jsonResponse = $this->httpClient->get(
			$url,
			[
				RequestOptions::HEADERS => $this->setAuthHeader($this->apiKey),
			]
		);

		$response = (array) psr_response_to_json($jsonResponse);

		return ApplicantDTO::from($response);
	}
}
