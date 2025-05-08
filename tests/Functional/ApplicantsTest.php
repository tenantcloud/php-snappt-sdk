<?php

namespace Tests\Functional;

use TenantCloud\Snappt\Applicants\DTO\CreateSessionDTO;
use TenantCloud\Snappt\Applicants\DTO\UpdateApplicationDTO;
use TenantCloud\Snappt\Applicants\Enum\ApplicationType;
use Tests\TestCase;

class ApplicantsTest extends TestCase
{
	public function testCreateSessionSuccess(): void
	{
		$snapptClient = $this->mockResponse(
			200,
			(string) file_get_contents(__DIR__ . '/../resources/applicants/session.json')
		);

		$createSessionDto = CreateSessionDTO::create()
			->setApplicationType(ApplicationType::UNAUTHENTICATED_USER)
			->setCompanyShortId($this->faker->uuid())
			->setPropertyShortId($this->faker->uuid())
			->setFirstName($this->faker->firstName())
			->setLastName($this->faker->lastName())
			->setEmail($this->faker->email());

		$session = $snapptClient->applicants()->createSession($createSessionDto);

		$this->assertSame('321ca6da-7915-4c2b-81cf-4ab5f3fcf298', $session->getId());
		$this->assertSame('48f575a7-83ee-4b79-8dd1-e6bfaa86445d', $session->getToken());
		$this->assertSame('ce1ec936-3135-4f84-8e1f-6310e55d7db6', $session->getApplicantDetailId());
	}

	public function testUpdateApplicationSuccess(): void
	{
		$snapptClient = $this->mockResponse(
			200,
			(string) file_get_contents(__DIR__ . '/../resources/applicants/update-application-success.json')
		);

		$updateApplicationDTO = UpdateApplicationDTO::create()
			->setId($id = '321ca6da-7915-4c2b-81cf-4ab5f3fcf298')
			->setType($type = ApplicationType::UNAUTHENTICATED_USER)
			->setUnit($unit ='unit 123')
			->setFirstName($firstName ='John')
			->setMiddleInitial($middleInitial = 'JD')
			->setLastName($lastName = 'Doe')
			->setEmail($email = 'johndoe@gmail.com')
			->setNotificationEmail($notificationEmail = 'johndoe@gmail.com')
			->setPhone($phone = '188888888')
			->setHasPreviouslySubmitted($hasPreviouslySubmitted = null)
			->setApplicantDetailId($applicantDetailId = 'ce1ec936-3135-4f84-8e1f-6310e55d7db6')
			->setPropertyShortId($propertyShortId = 'hRFs404isW');

		$application = $snapptClient->applicants()->updateApplication($updateApplicationDTO);

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
}
