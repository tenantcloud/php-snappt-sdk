<?php

namespace TenantCloud\Snappt\Applicants\DTO;

use TenantCloud\DataTransferObjects\CamelDataTransferObject;
use TenantCloud\Snappt\Applicants\Enum\ApplicationType;

/**
 * @method self   	   setId(string $id)
 * @method string 	   getId()
 * @method bool   	   hasId()
 * @method string 	   getType()
 * @method bool   	   hasType()
 * @method self   	   setUnit(?string $unit)
 * @method string|null getUnit()
 * @method bool   	   hasUnit()
 * @method self        setFirstName(?string $firstName)
 * @method string|null getFirstName()
 * @method bool        hasFirstName()
 * @method self        setMiddleInitial(?string $middleInitial)
 * @method string|null getMiddleInitial()
 * @method bool        hasMiddleInitial()
 * @method self        setLastName(?string $lastName)
 * @method string|null getLastName()
 * @method bool        hasLastName()
 * @method self        setEmail(?string $email)
 * @method string|null getEmail()
 * @method bool        hasEmail()
 * @method self        setNotificationEmail(?string $notificationEmail)
 * @method string|null getNotificationEmail()
 * @method bool        hasNotificationEmail()
 * @method self        setPhone(?string $phone)
 * @method string|null getPhone()
 * @method bool        hasPhone()
 * @method self        setHasPreviouslySubmitted(?bool $hasPreviouslySubmitted)
 * @method bool|null   getHasPreviouslySubmitted()
 * @method bool        hasHasPreviouslySubmitted()
 * @method self        setApplicantDetailId(?string $applicantDetailId)
 * @method string|null getApplicantDetailId()
 * @method bool        hasApplicantDetailId()
 * @method self        setPropertyShortId(?string $propertyShortId)
 * @method string|null getPropertyShortId()
 * @method bool        hasPropertyShortId()
 */
class UpdateApplicationDTO extends CamelDataTransferObject
{
	protected array $fields = [
		'id',
		'type',
		'unit',
		'firstName',
		'middleInitial',
		'lastName',
		'email',
		'notificationEmail',
		'phone',
		'hasPreviouslySubmitted',
		'applicantDetailId',
		'propertyShortId',
	];

	public function setType(ApplicationType|string $type): self
	{
		return $this->set('type', $type instanceof ApplicationType ? $type->value : $type);
	}
}
