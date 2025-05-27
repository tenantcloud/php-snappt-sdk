<?php

namespace TenantCloud\Snappt\Fake;

use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use TenantCloud\Snappt\ApplicantSessions\ApplicantSessionsApi;
use TenantCloud\Snappt\ApplicantSessions\DTO\CreateSessionDTO;
use TenantCloud\Snappt\ApplicantSessions\DTO\DocumentDTO;
use TenantCloud\Snappt\ApplicantSessions\DTO\SessionDTO;
use TenantCloud\Snappt\ApplicantSessions\DTO\UpdateApplicationDTO;
use TenantCloud\Snappt\ApplicantSessions\Enum\DocumentType;
use TenantCloud\Snappt\Exceptions\NotFoundException;

class FakeApplicantSessionsApi implements ApplicantSessionsApi
{
	public function __construct(
		private readonly Repository $cache
	) {}

	public function createSession(CreateSessionDTO $createSessionDTO): SessionDTO
	{
		$sessionToken = Str::uuid()->toString();

		$sessionDto = SessionDTO::create()
			->setId(Str::uuid()->toString())
			->setApplicantDetailId(Str::uuid()->toString())
			->setToken($sessionToken);

		$this->cache->put(
			"{$sessionToken}:applicant:session",
			[
				...$createSessionDTO->toArray(),
				...$sessionDto->toArray(),
			]
		);

		return $sessionDto;
	}

	public function updateApplication(UpdateApplicationDTO $updateApplicationDTO, string $sessionToken): UpdateApplicationDTO
	{
		if (!$this->cache->has("{$sessionToken}:applicant:session")) {
			throw new NotFoundException();
		}

		$applicant = $this->cache->get("{$sessionToken}:applicant:session");

		$this->cache->put(
			"{$sessionToken}:applicant:session",
			[
				...$updateApplicationDTO->toArray(),
				...Arr::except($applicant, 'token'),
			]
		);

		return $updateApplicationDTO;
	}

	public function uploadDocument(DocumentType $documentType, string $sessionToken, string $filePath): DocumentDTO
	{
		if (!$this->cache->has("{$sessionToken}:applicant:session")) {
			throw new NotFoundException();
		}

		$id = Arr::get($this->cache->get("{$sessionToken}:applicant:session"), 'id');

		$documentDto = DocumentDTO::create()
			->setId(Str::uuid()->toString())
			->setType($documentType)
			->setFileName(basename($filePath))
			->setResult('PENDING')
			->setInsertedAt('2025-05-27T08:08:40.810Z')
			->setProcessStatus('SUCCESS')
			->setUnauthenticatedSessionId((string) $id);

		$this->cache->put(
			"{$sessionToken}:applicant:documents",
			$documentDto->toArray(),
		);

		return $documentDto;
	}

	public function submit(string $sessionToken): string
	{
		if (!$this->cache->has("{$sessionToken}:applicant:session")) {
			throw new NotFoundException();
		}

		$applicantId = Str::uuid()->toString();

		$this->cache->put("{$sessionToken}:applicant:session", [
			'applicantId' => $applicantId,
			...Arr::except($this->cache->get("{$sessionToken}:applicant:session"), 'token'),
		]);

		$this->cache->put("{$applicantId}:applicant", [
			'applicantId' => $applicantId,
			...Arr::except($this->cache->get("{$sessionToken}:applicant:session"), 'token'),
		]);

		return $applicantId;
	}
}
