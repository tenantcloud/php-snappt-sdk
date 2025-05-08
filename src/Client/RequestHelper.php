<?php

namespace TenantCloud\Snappt\Client;

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
}
