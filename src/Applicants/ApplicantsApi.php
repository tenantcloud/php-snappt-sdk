<?php

namespace TenantCloud\Snappt\Applicants;

use TenantCloud\Snappt\Applicants\DTO\ApplicantDTO;

interface ApplicantsApi
{
	public function get(string $applicantId, bool $includeDocuments): ApplicantDTO;
}
