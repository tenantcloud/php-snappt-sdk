<?php

namespace TenantCloud\Snappt\Fake;

use GuzzleHttp\Psr7\Response;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Psr\Http\Message\ResponseInterface;
use Ramsey\Uuid\Uuid;
use TenantCloud\Snappt\Applicants\ApplicantsApi;
use TenantCloud\Snappt\Applicants\DTO\ApplicantDTO;
use TenantCloud\Snappt\Applicants\DTO\DocumentDTO;
use TenantCloud\Snappt\Applicants\DTO\DocumentIncomeVerificationDetailDTO;
use TenantCloud\Snappt\Applicants\DTO\IncomeVerificationDetailDTO;
use TenantCloud\Snappt\Applicants\Enum\Format;
use TenantCloud\Snappt\Applicants\Enum\Preset;
use TenantCloud\Snappt\Exceptions\NotFoundException;

class FakeApplicantsApi implements ApplicantsApi
{
	public function __construct(
		private readonly Repository $cache
	) {}

	public function get(string $applicantId, bool $includeDocuments): ApplicantDTO
	{
		if (!$this->cache->has("{$applicantId}:applicant")) {
			throw new NotFoundException();
		}

		$applicantData = $this->cache->get("{$applicantId}:applicant");
		$applicantEmail = Arr::get($applicantData, 'email', '');

		if (
			Str::contains($applicantEmail, 'undetermined_snappt') &&
			!Arr::get($applicantData, 'applicantIdentifier')
		) {
			$applicantDto = $this->getReadyAndUndeterminedApplicantDto($applicantData, $applicantId);
		} elseif (Str::contains($applicantEmail, 'edited_snappt')) {
			$applicantDto = $this->getReadyAndEditedApplicantDto($applicantData, $applicantId);
		} else {
			$applicantDto = $this->getReadyAndCleanApplicantDto($applicantData, $applicantId);
		}

		$this->cache->put("{$applicantId}:applicant", [
			...$applicantDto->toArray(),
			...$this->cache->get("{$applicantId}:applicant"),
		]);

		return $applicantDto;
	}

	public function report(string $applicantId, Preset $preset, Format $format): ResponseInterface
	{
		if (!$this->cache->has("{$applicantId}:applicant")) {
			throw new NotFoundException();
		}

		$applicantData = $this->cache->get("{$applicantId}:applicant");
		$applicantEmail = Arr::get($applicantData, 'email', '');

		if (
			Str::contains($applicantEmail, 'undetermined_snappt') &&
			!Arr::get($applicantData, 'applicantIdentifier')
		) {
			$content = (string) file_get_contents(__DIR__ . '/../../resources/reports/Sample Report_Clean docs with Income Error.pdf');
		} elseif (Str::contains($applicantEmail, 'edited_snappt')) {
			$content = (string) file_get_contents(__DIR__ . '/../../resources/reports/Sample Report_Edited.pdf');
		} else {
			$content = (string) file_get_contents(__DIR__ . '/../../resources/reports/Sample Report_Clean with Income.pdf');
		}

		return new Response(
			200,
			['Content-Type' => 'application/pdf'],
			$content
		);
	}

	/**
	 * @param array<string, mixed> $applicantData
	 */
	private function getReadyAndCleanApplicantDto(array $applicantData, string $applicantId): ApplicantDTO
	{
		return ApplicantDTO::from($applicantData)
			->setId($applicantId)
			->setFullName(Arr::get($applicantData, 'firstName', '') . ' ' . Arr::get($applicantData, 'lastName', ''))
			->setFirstName(Arr::get($applicantData, 'firstName', ''))
			->setMiddleInitial(null)
			->setLastName(Arr::get($applicantData, 'lastName', ''))
			->setEmail(Arr::get($applicantData, 'email', ''))
			->setPhone(Arr::get($applicantData, 'phone'))
			->setNotification(false)
			->setEntryId(Uuid::uuid4()->toString())
			->setInsertedAt('2025-07-08T18:18:25.000Z')
			->setUpdatedAt('2025-07-08T18:18:25.000Z')
			->setStatus('READY')
			->setResult('CLEAN')
			->setApplicantDetailId(Arr::get($applicantData, 'applicantDetailId'))
			->setDocuments([
				DocumentDTO::create()
					->setId($docId1 = Uuid::uuid4()->toString())
					->setFileName('/proofs/' . $docId1 . '/file')
					->setInsertedAt('2025-07-08T18:18:25.000Z')
					->setType('PAYSTUB')
					->setResult('CLEAN')
					->setSourceType('DOCUMENT_UPLOAD')
					->setIncomeVerificationDetails(
						DocumentIncomeVerificationDetailDTO::create()
							->setCalculationStartDate('2025-06-01T00:00:00.000Z')
							->setCalculationEndDate('2025-06-30T00:00:00.000Z')
							->setGrossIncome(8913.68)
							->setIncomeSource('D & N Apartment Living')
							->setApplicantName('Test User')
					),
				DocumentDTO::create()
					->setId($docId2 = Uuid::uuid4()->toString())
					->setFileName('/proofs/' . $docId2 . '/file')
					->setInsertedAt('2025-07-08T18:18:25.000Z')
					->setType('BANK_STATEMENT')
					->setResult('CLEAN')
					->setSourceType('DOCUMENT_UPLOAD'),
				DocumentDTO::create()
					->setId($docId3 = Uuid::uuid4()->toString())
					->setFileName('/proofs/' . $docId3 . '/file')
					->setInsertedAt('2025-07-08T18:18:25.000Z')
					->setType('BANK_STATEMENT')
					->setResult('CLEAN')
					->setSourceType('DOCUMENT_UPLOAD'),
				DocumentDTO::create()
					->setId($docId4 = Uuid::uuid4()->toString())
					->setFileName('/proofs/' . $docId4 . '/file')
					->setInsertedAt('2025-07-08T18:18:25.000Z')
					->setType('PAYSTUB')
					->setResult('CLEAN')
					->setSourceType('DOCUMENT_UPLOAD')
					->setIncomeVerificationDetails(
						DocumentIncomeVerificationDetailDTO::create()
							->setCalculationStartDate('2025-06-01T00:00:00.000Z')
							->setCalculationEndDate('2025-06-30T00:00:00.000Z')
							->setGrossIncome(8913.68)
							->setIncomeSource('D & N Apartment Living')
							->setApplicantName('Test User')
					),
			])
			->setIncomeVerificationDetails(
				IncomeVerificationDetailDTO::create()
					->setCalculationDate('2025-07-08T18:28:17.858Z')
					->setGrossDailyIncome('292.25')
					->setGrossMonthlyIncome('8896')
					->setGrossYearlyIncome('106753.74')
					->setConsecutiveDays(61)
					->setStatus('ok')
					->setStatusDetails([])
			);
	}

	/**
	 * @param array<string, mixed> $applicantData
	 */
	private function getReadyAndEditedApplicantDto(array $applicantData, string $applicantId): ApplicantDTO
	{
		return ApplicantDTO::from($applicantData)
			->setId($applicantId)
			->setFullName(Arr::get($applicantData, 'firstName', '') . ' ' . Arr::get($applicantData, 'lastName', ''))
			->setFirstName(Arr::get($applicantData, 'firstName', ''))
			->setMiddleInitial(null)
			->setLastName(Arr::get($applicantData, 'lastName', ''))
			->setEmail(Arr::get($applicantData, 'email', ''))
			->setPhone(Arr::get($applicantData, 'phone'))
			->setNotification(false)
			->setEntryId(Uuid::uuid4()->toString())
			->setInsertedAt('2025-07-08T18:19:52.000Z')
			->setUpdatedAt('2025-07-08T18:19:52.000Z')
			->setStatus('READY')
			->setResult('EDITED')
			->setApplicantDetailId(Arr::get($applicantData, 'applicantDetailId'))
			->setDocuments([
				DocumentDTO::create()
					->setId($docId1 = Uuid::uuid4()->toString())
					->setFileName('/proofs/' . $docId1 . '/file')
					->setInsertedAt('2025-07-08T18:19:52.000Z')
					->setType('PAYSTUB')
					->setResult('EDITED')
					->setSourceType('DOCUMENT_UPLOAD'),
				DocumentDTO::create()
					->setId($docId2 = Uuid::uuid4()->toString())
					->setFileName('/proofs/' . $docId2 . '/file')
					->setInsertedAt('2025-07-08T18:19:52.000Z')
					->setType('BANK_STATEMENT')
					->setResult('EDITED')
					->setSourceType('DOCUMENT_UPLOAD'),
				DocumentDTO::create()
					->setId($docId3 = Uuid::uuid4()->toString())
					->setFileName('/proofs/' . $docId3 . '/file')
					->setInsertedAt('2025-07-08T18:19:52.000Z')
					->setType('PAYSTUB')
					->setResult('EDITED')
					->setSourceType('DOCUMENT_UPLOAD'),
				DocumentDTO::create()
					->setId($docId4 = Uuid::uuid4()->toString())
					->setFileName('/proofs/' . $docId4 . '/file')
					->setInsertedAt('2025-07-08T18:19:52.000Z')
					->setType('BANK_STATEMENT')
					->setResult('EDITED')
					->setSourceType('DOCUMENT_UPLOAD'),
			]);
	}

	/**
	 * @param array<string, mixed> $applicantData
	 */
	private function getReadyAndUndeterminedApplicantDto(array $applicantData, string $applicantId): ApplicantDTO
	{
		return ApplicantDTO::from($applicantData)
			->setId($applicantId)
			->setFullName(Arr::get($applicantData, 'firstName', '') . ' ' . Arr::get($applicantData, 'lastName', ''))
			->setFirstName(Arr::get($applicantData, 'firstName', ''))
			->setMiddleInitial(null)
			->setLastName(Arr::get($applicantData, 'lastName', ''))
			->setEmail(Arr::get($applicantData, 'email', ''))
			->setPhone(Arr::get($applicantData, 'phone'))
			->setNotification(false)
			->setEntryId(Uuid::uuid4()->toString())
			->setInsertedAt('2025-07-08T18:21:36.000Z')
			->setUpdatedAt('2025-07-08T18:21:36.000Z')
			->setStatus('READY')
			->setResult('UNDETERMINED')
			->setApplicantDetailId(Arr::get($applicantData, 'applicantDetailId'))
			->setDocuments([
				DocumentDTO::create()
					->setId($docId1 = Uuid::uuid4()->toString())
					->setFileName('/proofs/' . $docId1 . '/file')
					->setInsertedAt('2025-07-08T18:21:36.000Z')
					->setType('PAYSTUB')
					->setResult('UNDETERMINED')
					->setSourceType('DOCUMENT_UPLOAD'),
				DocumentDTO::create()
					->setId($docId2 = Uuid::uuid4()->toString())
					->setFileName('/proofs/' . $docId2 . '/file')
					->setInsertedAt('2025-07-08T18:21:36.000Z')
					->setType('BANK_STATEMENT')
					->setResult('UNDETERMINED')
					->setSourceType('DOCUMENT_UPLOAD'),
				DocumentDTO::create()
					->setId($docId3 = Uuid::uuid4()->toString())
					->setFileName('/proofs/' . $docId3 . '/file')
					->setInsertedAt('2025-07-08T18:21:36.000Z')
					->setType('PAYSTUB')
					->setResult('UNDETERMINED')
					->setSourceType('DOCUMENT_UPLOAD'),
				DocumentDTO::create()
					->setId($docId4 = Uuid::uuid4()->toString())
					->setFileName('/proofs/' . $docId4 . '/file')
					->setInsertedAt('2025-07-08T18:21:36.000Z')
					->setType('BANK_STATEMENT')
					->setResult('UNDETERMINED')
					->setSourceType('DOCUMENT_UPLOAD'),
			]);
	}
}
