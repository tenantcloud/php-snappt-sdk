<?php

namespace TenantCloud\Snappt\Client;

use TenantCloud\Snappt\ApplicantSessions\ApplicantSessionsApi;

interface SnapptClient
{
	public function applicantSessions(): ApplicantSessionsApi;
}
