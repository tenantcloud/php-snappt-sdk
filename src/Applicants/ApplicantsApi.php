<?php

namespace TenantCloud\Snappt\Applicants;

use Psr\Http\Message\ResponseInterface;
use TenantCloud\Snappt\Applicants\DTO\ApplicantDTO;
use TenantCloud\Snappt\Applicants\Enum\Format;
use TenantCloud\Snappt\Applicants\Enum\Preset;

interface ApplicantsApi
{
	public function get(string $applicantId, bool $includeDocuments): ApplicantDTO;

	public function report(string $applicantId, Preset $preset, Format $format): ResponseInterface;
}
