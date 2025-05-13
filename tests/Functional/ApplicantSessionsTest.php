<?php

namespace Tests\Functional;

use InvalidArgumentException;
use TenantCloud\Snappt\ApplicantSessions\DTO\CreateSessionDTO;
use TenantCloud\Snappt\ApplicantSessions\DTO\UpdateApplicationDTO;
use TenantCloud\Snappt\ApplicantSessions\Enum\ApplicationType;
use TenantCloud\Snappt\ApplicantSessions\Enum\DocumentType;
use TenantCloud\Snappt\Exceptions\ErrorResponseException;
use Tests\TestCase;

class ApplicantSessionsTest extends TestCase
{
	public function testCreateSessionSuccess(): void
	{
		$snapptClient = $this->mockResponse(
			200,
			(string) file_get_contents(__DIR__ . '/../resources/applicant-sessions/session.json')
		);

		$createSessionDto = CreateSessionDTO::create()
			->setApplicationType(ApplicationType::UNAUTHENTICATED_USER)
			->setCompanyShortId($this->faker->uuid())
			->setPropertyShortId($this->faker->uuid())
			->setFirstName($this->faker->firstName())
			->setLastName($this->faker->lastName())
			->setEmail($this->faker->email());

		$session = $snapptClient->applicantSessions()->createSession($createSessionDto);

		$this->assertSame('321ca6da-7915-4c2b-81cf-4ab5f3fcf298', $session->getId());
		$this->assertSame('48f575a7-83ee-4b79-8dd1-e6bfaa86445d', $session->getToken());
		$this->assertSame('ce1ec936-3135-4f84-8e1f-6310e55d7db6', $session->getApplicantDetailId());
	}

	public function testUpdateApplicationSuccess(): void
	{
		$snapptClient = $this->mockResponse(
			200,
			(string) file_get_contents(__DIR__ . '/../resources/applicant-sessions/update-application-success.json')
		);

		$updateApplicationDTO = UpdateApplicationDTO::create()
			->setId($id = '321ca6da-7915-4c2b-81cf-4ab5f3fcf298')
			->setType($type = ApplicationType::UNAUTHENTICATED_USER)
			->setUnit($unit = 'unit 123')
			->setFirstName($firstName = 'John')
			->setMiddleInitial($middleInitial = 'JD')
			->setLastName($lastName = 'Doe')
			->setEmail($email = 'johndoe@gmail.com')
			->setNotificationEmail($notificationEmail = 'johndoe@gmail.com')
			->setPhone($phone = '188888888')
			->setHasPreviouslySubmitted($hasPreviouslySubmitted = null)
			->setApplicantDetailId($applicantDetailId = 'ce1ec936-3135-4f84-8e1f-6310e55d7db6')
			->setPropertyShortId($propertyShortId = 'hRFs404isW');

		$application = $snapptClient->applicantSessions()->updateApplication($updateApplicationDTO, 'session-token');

		$this->assertSame($id, $application->getId());
		$this->assertSame($type->value, $application->getType());
		$this->assertSame($unit, $application->getUnit());
		$this->assertSame($firstName, $application->getFirstName());
		$this->assertSame($middleInitial, $application->getMiddleInitial());
		$this->assertSame($lastName, $application->getLastName());
		$this->assertSame($email, $application->getEmail());
		$this->assertSame($notificationEmail, $application->getNotificationEmail());
		$this->assertSame($phone, $application->getPhone());
		$this->assertSame($hasPreviouslySubmitted, $application->getHasPreviouslySubmitted());
		$this->assertSame($applicantDetailId, $application->getApplicantDetailId());
		$this->assertSame($propertyShortId, $application->getPropertyShortId());
	}

	public function testUpdateApplicationError(): void
	{
		$snapptClient = $this->mockResponse(
			200,
			(string) file_get_contents(__DIR__ . '/../resources/applicant-sessions/update-application-error.json')
		);

		$this->expectException(ErrorResponseException::class);
		$this->expectExceptionMessage('{"error":"error message"}');

		$snapptClient->applicantSessions()->updateApplication(UpdateApplicationDTO::create(), 'session-token');
	}

	public function testUploadDocumentSuccess(): void
	{
		$snapptClient = $this->mockResponse(
			200,
			(string) file_get_contents(__DIR__ . '/../resources/applicant-sessions/upload-document-success.json')
		);

		$document = $snapptClient
			->applicantSessions()
			->uploadDocument(
				DocumentType::PAY_STUB,
				'session-token',
				__DIR__ . '/../../resources/documents/1537 Corinth Checking.pdf',
			);

		$this->assertSame('bc535bcf-811e-45b3-84a2-112de8a5430e', $document->getId());
		$this->assertSame('1537 Corinth Checking.pdf', $document->getFileName());
		$this->assertSame('321ca6da-7915-4c2b-81cf-4ab5f3fcf298', $document->getUnauthenticatedSessionId());
		$this->assertSame('2025-05-08T13:39:43.386Z', $document->getInsertedAt());
		$this->assertSame('PAYSTUB', $document->getType());
		$this->assertSame('SUCCESS', $document->getProcessStatus());
		$this->assertSame('PENDING', $document->getResult());
	}

	public function testUploadDocumentErrorFileNotExists(): void
	{
		$snapptClient = $this->mockResponse(200);

		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage('File not found at path: not-exists-document.pdf');

		$snapptClient
			->applicantSessions()
			->uploadDocument(
				DocumentType::PAY_STUB,
				'session-token',
				'not-exists-document.pdf',
			);
	}

	public function testUploadDocumentError(): void
	{
		$snapptClient = $this->mockResponse(
			200,
			(string) file_get_contents(__DIR__ . '/../resources/applicant-sessions/upload-document-error.json')
		);

		$this->expectException(ErrorResponseException::class);
		$this->expectExceptionMessage('{"statusCode":1111,"error":"error message","failedChecks":["failed check 1","failed check 2"]}');

		$snapptClient
			->applicantSessions()
			->uploadDocument(
				DocumentType::PAY_STUB,
				'session-token',
				__DIR__ . '/../../resources/documents/1537 Corinth Checking.pdf',
			);
	}

	public function testSubmitSuccess(): void
	{
		$snapptClient = $this->mockResponse(
			200,
			(string) file_get_contents(__DIR__ . '/../resources/applicant-sessions/submit.json')
		);

		$applicantId = $snapptClient->applicantSessions()->submit('session-token');

		$this->assertSame('cffe49a5-bfe3-4d3c-a51e-7a44a94dbd27', $applicantId);
	}
}
