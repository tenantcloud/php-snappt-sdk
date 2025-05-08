<?php

namespace TenantCloud\Snappt\ApplicantSession;

use TenantCloud\Snappt\ApplicantSession\DTO\CreateSessionDTO;
use TenantCloud\Snappt\ApplicantSession\DTO\SessionDTO;
use TenantCloud\Snappt\ApplicantSession\DTO\UpdateApplicationDTO;

interface ApplicantsApi
{
	public function createSession(CreateSessionDTO $createSessionDTO): SessionDTO;

	public function updateApplication(UpdateApplicationDTO $updateApplicationDTO): UpdateApplicationDTO;
}
