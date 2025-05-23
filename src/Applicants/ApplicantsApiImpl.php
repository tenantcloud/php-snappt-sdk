<?php

namespace TenantCloud\Snappt\Applicants;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;
use TenantCloud\Snappt\Applicants\DTO\ApplicantDTO;
use TenantCloud\Snappt\Applicants\Enum\Format;
use TenantCloud\Snappt\Applicants\Enum\Preset;
use TenantCloud\Snappt\Client\RequestHelper;
use function TenantCloud\GuzzleHelper\psr_response_to_json;

class ApplicantsApiImpl implements ApplicantsApi
{
	use RequestHelper;

	private const GET_APPLICANT_API = '/applicants/%s';
	private const REPORT_APPLICANT_API = '/applicants/%s/report';

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

	public function report(string $applicantId, Preset $preset, Format $format): ResponseInterface
	{
		$query = http_build_query([
			'preset' => $preset->value,
			'format' => $format->value,
		]);

		$url = sprintf(self::REPORT_APPLICANT_API, $applicantId) . '?' . $query;

		return $this->httpClient->get(
			$url,
			[
				RequestOptions::HEADERS => array_merge(
					$this->setAuthHeader($this->apiKey),
					['Accept' => 'application/pdf'],
				),
			]
		);
	}
}
