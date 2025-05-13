<?php

namespace TenantCloud\Snappt\Client;

use Illuminate\Support\Arr;
use TenantCloud\Snappt\Exceptions\ErrorResponseException;

trait RequestHelper
{
	public function setAuthHeader(string $apiKey): array
	{
		return [
			'Authorization' => 'Bearer ' . $apiKey,
		];
	}

	public function setUnauthenticatedSessionToken(string $sessionToken): array
	{
		return [
			'x-unauthenticated-session-token' => $sessionToken,
		];
	}

	public function throwIfResponseHasError(array $response): void
	{
		if (Arr::has($response, 'error')) {
			throw new ErrorResponseException(json_encode($response, JSON_THROW_ON_ERROR));
		}
	}
}
