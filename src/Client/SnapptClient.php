<?php

namespace TenantCloud\Snappt\Client;

use TenantCloud\Snappt\Applicants\ApplicantsApi;
use TenantCloud\Snappt\ApplicantSessions\ApplicantSessionsApi;
use TenantCloud\Snappt\Properties\PropertiesApi;
use TenantCloud\Snappt\Webhooks\WebhooksApi;

interface SnapptClient
{
	public function applicantSessions(): ApplicantSessionsApi;

	public function properties(): PropertiesApi;

	public function applicants(): ApplicantsApi;

	public function webhooks(): WebhooksApi;
}
