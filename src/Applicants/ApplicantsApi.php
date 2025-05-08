<?php

namespace TenantCloud\Snappt\Applicants;

use TenantCloud\Snappt\Applicants\DTO\CreateSessionDTO;
use TenantCloud\Snappt\Applicants\DTO\SessionDTO;

interface ApplicantsApi
{
	public function createSession(CreateSessionDTO $createSessionDTO): SessionDTO;
}
