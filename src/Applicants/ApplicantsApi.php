<?php

namespace TenantCloud\Snappt\Applicants;

use TenantCloud\Snappt\Applicants\DTO\CreateSessionDTO;
use TenantCloud\Snappt\Applicants\DTO\SessionDTO;
use TenantCloud\Snappt\Applicants\DTO\UpdateApplicationDTO;

interface ApplicantsApi
{
	public function createSession(CreateSessionDTO $createSessionDTO): SessionDTO;

	public function updateApplication(UpdateApplicationDTO $updateApplicationDTO): UpdateApplicationDTO;
}
