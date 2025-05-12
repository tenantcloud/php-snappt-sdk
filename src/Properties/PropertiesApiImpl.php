<?php

namespace TenantCloud\Snappt\Properties;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Arr;
use TenantCloud\Snappt\Client\RequestHelper;
use TenantCloud\Snappt\Exceptions\ErrorResponseException;
use TenantCloud\Snappt\Properties\DTO\CreatePropertyDTO;
use TenantCloud\Snappt\Properties\DTO\PropertyDTO;
use function TenantCloud\GuzzleHelper\psr_response_to_json;

class PropertiesApiImpl implements PropertiesApi
{
	use RequestHelper;

	private const CREATE_PROPERTY_API = '/properties';

	public function __construct(
		private readonly Client $httpClient,
		private readonly string $apiKey,
	) {}

	public function create(CreatePropertyDTO $propertyDTO): PropertyDTO
	{
		$jsonResponse = $this->httpClient->post(
			self::CREATE_PROPERTY_API,
			[
				RequestOptions::HEADERS => $this->setAuthHeader($this->apiKey),
				RequestOptions::JSON    => $propertyDTO->toArray(),
			]
		);

		$response = (array) psr_response_to_json($jsonResponse);

		if (Arr::has($response, 'error')) {
			throw new ErrorResponseException(self::CREATE_PROPERTY_API, json_encode($response));
		}

		return PropertyDTO::from($response);
	}

	public function enableIncomeVerification(string $propertyId, bool $enabled)
	{

	}
}
