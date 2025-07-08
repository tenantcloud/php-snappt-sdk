<?php

namespace TenantCloud\Snappt\Client;

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
}
