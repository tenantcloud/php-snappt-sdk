<?php

namespace Tests\Functional;

use PHPUnit\Framework\Attributes\DataProvider;
use TenantCloud\Snappt\Exceptions\ErrorResponseException;
use TenantCloud\Snappt\Properties\DTO\CreatePropertyDTO;
use TenantCloud\Snappt\Properties\DTO\PropertyDTO;
use TenantCloud\Snappt\Properties\DTO\SupportedDoctypesDTO;
use TenantCloud\Snappt\Properties\Enum\IdentityVerificationReportImageType;
use TenantCloud\Snappt\Properties\Enum\Status;
use Tests\TestCase;

class PropertiesTest extends TestCase
{
	#[DataProvider('createPropertySuccessProvider')]
	public function testCreatePropertySuccess(string $fileName, CreatePropertyDTO $createPropertyDto, callable $assertion): void
	{
		$snapptClient = $this->mockResponse(
			200,
			(string) file_get_contents(__DIR__ . "/../resources/properties/{$fileName}")
		);

		$property = $snapptClient->properties()->create($createPropertyDto);

		$assertion($property);
	}

	public static function createPropertySuccessProvider(): iterable
	{
		yield 'create property with min data' => [
			'min-property-created.json',
			CreatePropertyDTO::create()
				->setName('Test property name')
				->setEmail('test@gmail.com')
				->setAddress('123 melrose str')
				->setCity('Brooklyn')
				->setZip('11206')
				->setUnit(1)
				->setStatus(Status::ACTIVE),
			function (PropertyDTO $property) {
				self::assertSame('Test property name', $property->getName());
				self::assertSame('test@gmail.com', $property->getEmail());
				self::assertSame('123 melrose str', $property->getAddress());
				self::assertSame('Brooklyn', $property->getCity());
				self::assertSame('11206', $property->getZip());
				self::assertSame(1, (int) $property->getUnit());
				self::assertSame(Status::ACTIVE->value, $property->getStatus());
				self::assertSame('ac796cf6-2f08-47ca-a30c-40b727ffd166', $property->getId());
				self::assertSame('a9c7c3e196', $property->getShortId());
				self::assertSame('0808ebe9-e12b-496a-9fe6-50c9475a3b8f', $property->getCompanyId());
				self::assertSame('b8iZzSUMmy', $property->getCompanyShortId());
				self::assertSame('https://demo.documentportal.info/application/apply/b8iZzSUMmy/a9c7c3e196', $property->getApplicantLink());
				self::assertSame('https://fraud.demo.snappt.com/application/applyonbehalf/b8iZzSUMmy/a9c7c3e196', $property->getLeasingTeamLink());
				self::assertSame('2025-05-12T07:59:08.000Z', $property->getInsertedAt());
				self::assertSame('2025-05-12T07:59:08.000Z', $property->getUpdatedAt());
				self::assertNull($property->getLogo());
				self::assertNull($property->getPhone());
				self::assertNull($property->getWebsite());
				self::assertNull($property->getState());
				self::assertNull($property->getSupportedDoctypes());
				self::assertNull($property->getBankStatement());
				self::assertNull($property->getPaystub());
				self::assertNull($property->getPmcName());
				self::assertNull($property->getEntityName());
				self::assertTrue($property->getPhoneIsRequired());
				self::assertTrue($property->getUnitIsRequired());
				self::assertFalse($property->getIdentityVerificationEnabled());
				self::assertFalse($property->getIncomeVerificationEnabled());
			},
		];

		yield 'create property with max data' => [
			'max-property-created.json',
			CreatePropertyDTO::create()
				->setName('Test property name')
				->setEmail('test@gmail.com')
				->setAddress('123 melrose str')
				->setCity('Brooklyn')
				->setZip('11206')
				->setUnit(1)
				->setStatus(Status::ACTIVE)
				->setState('NY')
				->setEntityName('Test entity name')
				->setLogo('https://montrealfilmjournal.com/wp-content/uploads/2020/02/R0001226.jpg')
				->setPhone('1888888888')
				->setPhoneIsRequired(true)
				->setWebsite('https://ll.tc.loc')
				->setPmcName('Test pmc name')
				->setUnitIsRequired(true)
				->setBankStatement(3)
				->setPaystub(4)
				->setSupportedDoctypes(
					SupportedDoctypesDTO::create()
						->setW2(0)
						->setPayrollStatement(1)
				)
				->setIdentityVerificationReportImageTypes([
					IdentityVerificationReportImageType::SELFIE
				]),
			function (PropertyDTO $property) {
				self::assertSame('Test property name', $property->getName());
				self::assertSame('test@gmail.com', $property->getEmail());
				self::assertSame('123 melrose str', $property->getAddress());
				self::assertSame('Brooklyn', $property->getCity());
				self::assertSame('11206', $property->getZip());
				self::assertSame(1, (int) $property->getUnit());
				self::assertSame(Status::ACTIVE->value, $property->getStatus());
				self::assertSame('529c5f44-c1b5-47dd-afc8-42dc2941f61e', $property->getId());
				self::assertSame('0c53fa6a39', $property->getShortId());
				self::assertSame('0808ebe9-e12b-496a-9fe6-50c9475a3b8f', $property->getCompanyId());
				self::assertSame('b8iZzSUMmy', $property->getCompanyShortId());
				self::assertSame('https://demo.documentportal.info/application/apply/b8iZzSUMmy/0c53fa6a39', $property->getApplicantLink());
				self::assertSame('https://fraud.demo.snappt.com/application/applyonbehalf/b8iZzSUMmy/0c53fa6a39', $property->getLeasingTeamLink());
				self::assertSame('2025-05-12T08:52:03.000Z', $property->getInsertedAt());
				self::assertSame('2025-05-12T08:52:03.000Z', $property->getUpdatedAt());
				self::assertSame('https://montrealfilmjournal.com/wp-content/uploads/2020/02/R0001226.jpg', $property->getLogo());
				self::assertSame('1888888888', $property->getPhone());
				self::assertSame('https://ll.tc.loc', $property->getWebsite());
				self::assertSame('NY', $property->getState());
				self::assertSame(['w2' => 0, 'payroll_statement' => 1], $property->getSupportedDoctypes());
				self::assertSame(3, $property->getBankStatement());
				self::assertSame(4, $property->getPaystub());
				self::assertSame('Test pmc name', $property->getPmcName());
				self::assertSame('Test entity name', $property->getEntityName());
				self::assertTrue($property->getPhoneIsRequired());
				self::assertTrue($property->getUnitIsRequired());
				self::assertFalse($property->getIdentityVerificationEnabled());
				self::assertFalse($property->getIncomeVerificationEnabled());
			},
		];
	}

	public function testCreatePropertyError(): void
	{
		$snapptClient = $this->mockResponse(
			200,
			(string) file_get_contents(__DIR__ . '/../resources/properties/property-error.json')
		);

		$this->expectException(ErrorResponseException::class);
		$this->expectExceptionMessage('Received error response from API "/properties". {"error":"error message","propertyId":"529c5f44-c1b5-47dd-afc8-42dc2941f61e"}');

		$snapptClient->properties()->create(CreatePropertyDTO::create());
	}
}
