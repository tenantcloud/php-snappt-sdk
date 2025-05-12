<?php

namespace TenantCloud\Snappt\Properties\DTO;

use TenantCloud\DataTransferObjects\CamelDataTransferObject;
use TenantCloud\Snappt\Properties\Enum\IdentityVerificationReportImageType;
use TenantCloud\Snappt\Properties\Enum\Status;
use Webmozart\Assert\Assert;

/**
 * @method self                                           setName(string $name)
 * @method string                                         getName()
 * @method bool                                           hasName()
 * @method self                                           setEmail(string $email)
 * @method string                                         getEmail()
 * @method bool                                           hasEmail()
 * @method self                                           setAddress(string $address)
 * @method string                                         getAddress()
 * @method bool                                           hasAddress()
 * @method self                                           setCity(string $city)
 * @method string                                         getCity()
 * @method bool                                           hasCity()
 * @method self                                           setZip(string $zip)
 * @method string                                         getZip()
 * @method bool                                           hasZip()
 * @method self                                           setState(?string $state)
 * @method string|null                                    getState()
 * @method bool                                           hasState()
 * @method self                                           setEntityName(?string $entityName)
 * @method string|null                                    getEntityName()
 * @method bool                                           hasEntityName()
 * @method self                                           setLogo(?string $logo)
 * @method string|null                                    getLogo()
 * @method bool                                           hasLogo()
 * @method self                                           setPhone(?string $phone)
 * @method string|null                                    getPhone()
 * @method bool                                           hasPhone()
 * @method self                                           setPhoneIsRequired(?bool $phoneIsRequired)
 * @method bool|null                                      getPhoneIsRequired()
 * @method bool                                           hasPhoneIsRequired()
 * @method self                                           setWebsite(?string $website)
 * @method string|null                                    getWebsite()
 * @method bool                                           hasWebsite()
 * @method self                                           setUnit(int $unit)
 * @method int                                            getUnit()
 * @method bool                                           hasUnit()
 * @method self                                           setPmcName(?string $pmcName)
 * @method string|null                                    getPmcName()
 * @method bool                                           hasPmcName()
 * @method self                                           setUnitIsRequired(?bool $unitIsRequired)
 * @method bool|null                                      getUnitIsRequired()
 * @method bool                                           hasUnitIsRequired()
 * @method string                                         getStatus()
 * @method bool                                           hasStatus()
 * @method self                                           setBankStatement(?int $bankStatement)
 * @method int|null                                       getBankStatement()
 * @method bool                                           hasBankStatement()
 * @method self                                           setPaystub(?int $pmcName)
 * @method int|null                                       getPaystub()
 * @method bool                                           hasPaystub()
 * @method self                                           setSupportedDoctypes(?SupportedDoctypesDTO $supportedDoctypes)
 * @method SupportedDoctypesDTO|null                      getSupportedDoctypes()
 * @method bool                                           hasSupportedDoctypes()
 * @method list<IdentityVerificationReportImageType>|null getIdentityVerificationReportImageTypes()
 * @method bool                                           hasIdentityVerificationReportImageTypes()
 */
class CreatePropertyDTO extends CamelDataTransferObject
{
	protected array $fields = [
		'name',
		'email',
		'address',
		'city',
		'zip',
		'state',
		'entityName',
		'logo',
		'phone',
		'phoneIsRequired',
		'website',
		'unit',
		'pmcName',
		'unitIsRequired',
		'status',
		'bankStatement',
		'paystub',
		'supportedDoctypes',
		'identityVerificationReportImageTypes',
	];

	public function setStatus(Status $status): self
	{
		return $this->set('status', $status->value);
	}

	/**
	 * @param list<IdentityVerificationReportImageType>|null $identityVerificationReportImageTypes
	 */
	public function setIdentityVerificationReportImageTypes(?array $identityVerificationReportImageTypes): self
	{
		if (!$identityVerificationReportImageTypes) {
			return $this->set('identityVerificationReportImageTypes', null);
		}

		Assert::allIsInstanceOf($identityVerificationReportImageTypes, IdentityVerificationReportImageType::class);

		$imageTypes = [];

		foreach ($identityVerificationReportImageTypes as $imageType) {
			$imageTypes[] = $imageType->value;
		}

		return $this->set('identityVerificationReportImageTypes', $imageTypes);
	}
}
