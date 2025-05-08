<?php

namespace TenantCloud\Snappt\Fake;

use TenantCloud\Snappt\Applicants\ApplicantsApi;
use TenantCloud\Snappt\Client\SnapptClient;

class FakeSnapptClient implements SnapptClient
{
	public function applicants(): ApplicantsApi
	{
		return new FakeApplicantsApi();
	}
}
