<?php

namespace TenantCloud\Snappt\Fake;

use TenantCloud\Snappt\ApplicantSessions\ApplicantSessionsApi;
use TenantCloud\Snappt\Client\SnapptClient;

class FakeSnapptClient implements SnapptClient
{
	public function applicantSessions(): ApplicantSessionsApi
	{
		return new FakeApplicantSessionsApi();
	}
}
