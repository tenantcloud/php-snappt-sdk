<?php

namespace TenantCloud\Snappt\Client;

use Illuminate\Support\Arr;
use TenantCloud\Snappt\Exceptions\ErrorResponseException;

trait RequestHelper
{
	/**
	 * @return array<string, string>
	 */
	public function setAuthHeader(string $apiKey): array
	{
		return [
			'Authorization' => 'Bearer ' . $apiKey,
		];
	}

	/**
	 * @return array<string, string>
	 */
	public function setUnauthenticatedSessionToken(string $sessionToken): array
	{
		return [
			'x-unauthenticated-session-token' => $sessionToken,
		];
	}

	/**
	 * @param array<string, mixed> $response
	 */
	public function throwIfResponseHasError(array $response): void
	{
		if (Arr::has($response, 'error')) {
			throw new ErrorResponseException(json_encode($response, JSON_THROW_ON_ERROR));
		}
	}
}
