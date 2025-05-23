<?php

namespace TenantCloud\Snappt\Client;

use TenantCloud\Snappt\Applicants\ApplicantsApi;
use TenantCloud\Snappt\ApplicantSessions\ApplicantSessionsApi;
use TenantCloud\Snappt\Properties\PropertiesApi;

interface SnapptClient
{
	public function applicantSessions(): ApplicantSessionsApi;

	public function properties(): PropertiesApi;

	public function applicants(): ApplicantsApi;
}
