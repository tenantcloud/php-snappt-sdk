<?php

namespace TenantCloud\Snappt\Properties;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use TenantCloud\Snappt\Client\RequestHelper;
use TenantCloud\Snappt\Properties\DTO\CreateOrUpdatePropertyDTO;
use TenantCloud\Snappt\Properties\DTO\PropertyDTO;

use function TenantCloud\GuzzleHelper\psr_response_to_json;

class PropertiesApiImpl implements PropertiesApi
{
	use RequestHelper;

	private const GET_PROPERTY_API = '/properties/%s';
	private const CREATE_PROPERTY_API = '/properties';
	private const UPDATE_PROPERTY_API = '/properties/%s';
	private const ENABLE_INCOME_VERIFICATION = '/properties/%s/income-verification';

	public function __construct(
		private readonly Client $httpClient,
		private readonly string $apiKey,
	) {}

	public function get(string $propertyId): PropertyDTO
	{
		$url = sprintf(self::GET_PROPERTY_API, $propertyId);

		$jsonResponse = $this->httpClient->get(
			$url,
			[
				RequestOptions::HEADERS => $this->setAuthHeader($this->apiKey),
			]
		);

		$response = (array) psr_response_to_json($jsonResponse);

		$this->throwIfResponseHasError($response);

		return PropertyDTO::from($response);
	}

	public function create(CreateOrUpdatePropertyDTO $propertyDTO): PropertyDTO
	{
		$jsonResponse = $this->httpClient->post(
			self::CREATE_PROPERTY_API,
			[
				RequestOptions::HEADERS => $this->setAuthHeader($this->apiKey),
				RequestOptions::JSON    => $propertyDTO->toArray(),
			]
		);

		$response = (array) psr_response_to_json($jsonResponse);

		$this->throwIfResponseHasError($response);

		return PropertyDTO::from($response);
	}

	public function update(string $propertyId, CreateOrUpdatePropertyDTO $propertyDTO): PropertyDTO
	{
		$url = sprintf(self::UPDATE_PROPERTY_API, $propertyId);

		$jsonResponse = $this->httpClient->put(
			$url,
			[
				RequestOptions::HEADERS => $this->setAuthHeader($this->apiKey),
				RequestOptions::JSON    => $propertyDTO->toArray(),
			]
		);

		$response = (array) psr_response_to_json($jsonResponse);

		$this->throwIfResponseHasError($response);

		return PropertyDTO::from($response);
	}

	public function enableIncomeVerification(string $propertyId, bool $enabled): PropertyDTO
	{
		$url = sprintf(self::ENABLE_INCOME_VERIFICATION, $propertyId);

		$jsonResponse = $this->httpClient->post(
			$url,
			[
				RequestOptions::HEADERS => $this->setAuthHeader($this->apiKey),
				RequestOptions::JSON    => [
					'enabled' => $enabled,
				],
			]
		);

		$response = (array) psr_response_to_json($jsonResponse);

		$this->throwIfResponseHasError($response);

		return PropertyDTO::from($response);
	}
}
