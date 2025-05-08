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
}
