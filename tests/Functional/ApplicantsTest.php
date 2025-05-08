<?php

namespace Tests\Functional;

use TenantCloud\Snappt\Applicants\DTO\CreateSessionDTO;
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

		$createSessionDto = $this->getFilledSessionDto();

		$session = $snapptClient->applicants()->createSession($createSessionDto);

		$this->assertSame('321ca6da-7915-4c2b-81cf-4ab5f3fcf298', $session->getId());
		$this->assertSame('48f575a7-83ee-4b79-8dd1-e6bfaa86445d', $session->getToken());
		$this->assertSame('ce1ec936-3135-4f84-8e1f-6310e55d7db6', $session->getApplicantDetailId());
	}

	private function getFilledSessionDto(): CreateSessionDTO
	{
		return CreateSessionDTO::create()
			->setApplicationType(ApplicationType::UNAUTHENTICATED_USER)
			->setCompanyShortId($this->faker->uuid())
			->setPropertyShortId($this->faker->uuid())
			->setFirstName($this->faker->firstName())
			->setLastName($this->faker->lastName())
			->setEmail($this->faker->email());
	}
}
