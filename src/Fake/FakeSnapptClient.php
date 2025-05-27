<?php

namespace TenantCloud\Snappt\Fake;

use Illuminate\Contracts\Cache\Repository;
use TenantCloud\Snappt\Applicants\ApplicantsApi;
use TenantCloud\Snappt\ApplicantSessions\ApplicantSessionsApi;
use TenantCloud\Snappt\Client\SnapptClient;
use TenantCloud\Snappt\Properties\PropertiesApi;

class FakeSnapptClient implements SnapptClient
{
	public function __construct(
		private readonly Repository $cache
	) {}

	public function applicantSessions(): ApplicantSessionsApi
	{
		return new FakeApplicantSessionsApi($this->cache);
	}

	public function properties(): PropertiesApi
	{
		return new FakePropertiesApi($this->cache);
	}

	public function applicants(): ApplicantsApi
	{
		return new FakeApplicantsApi($this->cache);
	}
}
