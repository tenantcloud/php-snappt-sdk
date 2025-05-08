<?php

namespace TenantCloud\Snappt\ApplicantSessions;

use TenantCloud\Snappt\ApplicantSessions\DTO\CreateSessionDTO;
use TenantCloud\Snappt\ApplicantSessions\DTO\SessionDTO;
use TenantCloud\Snappt\ApplicantSessions\DTO\UpdateApplicationDTO;

interface ApplicantSessionsApi
{
	public function createSession(CreateSessionDTO $createSessionDTO): SessionDTO;

	public function updateApplication(UpdateApplicationDTO $updateApplicationDTO): UpdateApplicationDTO;
}
