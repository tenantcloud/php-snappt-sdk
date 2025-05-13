<?php

namespace Tests\Functional;

use PHPUnit\Framework\Attributes\DataProvider;
use TenantCloud\Snappt\Applicants\Enum\Format;
use TenantCloud\Snappt\Applicants\Enum\Preset;
use Tests\TestCase;

class ApplicantsTest extends TestCase
{
	#[DataProvider('getApplicantSuccessProvider')]
	public function testGetApplicantSuccess(string $filename, bool $includeDocuments): void
	{
		$mockResponseBody = (string) file_get_contents(__DIR__ . "/../resources/applicants/{$filename}");

		$snapptClient = $this->mockResponse(
			200,
			$mockResponseBody
		);

		$applicant = $snapptClient->applicants()->get('cffe49a5-bfe3-4d3c-a51e-7a44a94dbd27', $includeDocuments);

		$this->assertSame(json_decode($mockResponseBody, true), $applicant->toArray());
	}

	public static function getApplicantSuccessProvider(): iterable
	{
		yield 'with documents and income verification' => [
			'get-with-documents-success.json',
			true,
		];

		yield 'without documents and with income verification' => [
			'get-without-documents-and-with-income-verification-success.json',
			false,
		];

		yield 'without documents and income verification' => [
			'get-without-documents-and-income-verification.json',
			false,
		];

		yield 'without documents and with error in income verification' => [
			'get-with-income-verification-error-success.json',
			false,
		];

		yield 'without documents and income verification is null' => [
			'get-without-documents-and-income-verification-is-null-success.json',
			false,
		];
	}

	public function testReportSuccess(): void
	{
		$snapptClient = $this->mockResponse(
			200,
			(string) file_get_contents(__DIR__ . '/../../resources/reports/Sample Report_Clean with Income.pdf'),
			['Content-Type' => 'application/pdf'],
		);

		$response = $snapptClient
			->applicants()
			->report('cffe49a5-bfe3-4d3c-a51e-7a44a94dbd27', Preset::SUMMARY, Format::PDF);

		$this->assertEquals(200, $response->getStatusCode());
		$this->assertEquals('application/pdf', $response->getHeaderLine('Content-Type'));
		$this->assertStringContainsString('%PDF', (string) $response->getBody());
	}
}
