<?php

namespace TenantCloud\Snappt\ApplicantSessions\DTO;

use TenantCloud\DataTransferObjects\CamelDataTransferObject;
use TenantCloud\Snappt\ApplicantSessions\Enum\ApplicationType;

/**
 * @method string getApplicationType()
 * @method bool   hasApplicationType()
 * @method self   setCompanyShortId(string $companyShortId)
 * @method string getCompanyShortId()
 * @method bool   hasCompanyShortId()
 * @method self   setPropertyShortId(string $propertyShortId)
 * @method string getPropertyShortId()
 * @method bool   hasPropertyShortId()
 * @method self   setFirstName(string $firstName)
 * @method string getFirstName()
 * @method bool   hasFirstName()
 * @method self   setLastName(string $lastName)
 * @method string getLastName()
 * @method bool   hasLastName()
 * @method self   setEmail(string $email)
 * @method string getEmail()
 * @method bool   hasEmail()
 * @method self   setApplicantIdentifier(string $applicantIdentifier)
 * @method string getApplicantIdentifier()
 * @method bool   hasApplicantIdentifier()
 */
class CreateSessionDTO extends CamelDataTransferObject
{
	protected array $fields = [
		'applicationType',
		'companyShortId',
		'propertyShortId',
		'firstName',
		'lastName',
		'email',
		'applicantIdentifier',
	];

	public function setApplicationType(ApplicationType $applicationType): self
	{
		return $this->set('applicationType', $applicationType);
	}
}
