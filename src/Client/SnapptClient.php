<?php

namespace TenantCloud\Snappt\Client;

use TenantCloud\Snappt\Applicants\ApplicantsApi;

interface SnapptClient
{
	public function applicants(): ApplicantsApi;
}
