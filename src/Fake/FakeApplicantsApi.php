<?php

namespace TenantCloud\Snappt\Fake;

use GuzzleHttp\Psr7\Response;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Str;
use Psr\Http\Message\ResponseInterface;
use TenantCloud\Snappt\Applicants\ApplicantsApi;
use TenantCloud\Snappt\Applicants\DTO\ApplicantDTO;
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

		$applicantDto = ApplicantDTO::from($this->cache->get("{$applicantId}:applicant"))
			->setId($applicantId)
			->setEntryId(Str::uuid()->toString())
			->setInsertedAt('2025-05-27T08:21:46.000Z')
			->setUpdatedAt('2025-05-27T08:21:46.000Z')
			->setStatus('READY')
			->setResult('CLEAN')
			->setIncomeVerificationDetails(
				IncomeVerificationDetailDTO::create()
					->setCalculationDate('2025-05-27T08:32:00.262Z')
					->setGrossDailyIncome('308.07')
					->setGrossMonthlyIncome('9377.79')
					->setGrossYearlyIncome('112533.46')
					->setConsecutiveDays(31)
					->setStatus('ok')
					->setStatusDetails([])
			);

		$this->cache->put("{$applicantId}:applicant", [
			...$applicantDto->toArray(),
			...$this->cache->get("{$applicantId}:applicant"),
		]);

		return $applicantDto;
	}

	public function report(string $applicantId, Preset $preset, Format $format): ResponseInterface
	{
		$content = (string) file_get_contents(__DIR__ . '/../../resources/reports/Sample Report_Clean with Income.pdf');

		return new Response(
			200,
			['Content-Type' => 'application/pdf'],
			$content
		);
	}
}
