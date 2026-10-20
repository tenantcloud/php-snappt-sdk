<?php

namespace TenantCloud\Snappt\ApplicantSessions;

use GuzzleHttp\Promise\PromiseInterface;
use TenantCloud\Snappt\ApplicantSessions\DTO\CreateSessionDTO;
use TenantCloud\Snappt\ApplicantSessions\DTO\DocumentDTO;
use TenantCloud\Snappt\ApplicantSessions\DTO\SessionDTO;
use TenantCloud\Snappt\ApplicantSessions\DTO\UpdateApplicationDTO;
use TenantCloud\Snappt\ApplicantSessions\Enum\DocumentType;

interface ApplicantSessionsApi
{
	public function createSession(CreateSessionDTO $createSessionDTO): SessionDTO;

	public function updateApplication(UpdateApplicationDTO $updateApplicationDTO, string $sessionToken): UpdateApplicationDTO;

	public function uploadDocument(DocumentType $documentType, string $sessionToken, string $filePath): DocumentDTO;

	/**
	 * Resolves with {@see DocumentDTO}.
	 */
	public function uploadDocumentAsync(DocumentType $documentType, string $sessionToken, string $filePath): PromiseInterface;

	public function submit(string $sessionToken): string;
}
