<?php

namespace TenantCloud\Snappt\Properties\DTO;

use TenantCloud\DataTransferObjects\CamelDataTransferObject;
use TenantCloud\Snappt\Properties\Enum\IdentityVerificationReportImageType;

/**
 * @method self                                           setId(string $id)
 * @method string                                         getId()
 * @method bool                                           hasId()
 * @method self                                           setShortId(string $shortId)
 * @method string                                         getShortId()
 * @method bool                                           hasShortId()
 * @method self                                           setName(string $name)
 * @method string                                         getName()
 * @method bool                                           hasName()
 * @method self                                           setEmail(?string $email)
 * @method string|null                                    getEmail()
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
 * @method self                                           setUnit(?string $unit)
 * @method string|null                                    getUnit()
 * @method bool                                           hasUnit()
 * @method self                                           setPmcName(?string $pmcName)
 * @method string|null                                    getPmcName()
 * @method bool                                           hasPmcName()
 * @method self                                           setUnitIsRequired(?bool $unitIsRequired)
 * @method bool|null                                      getUnitIsRequired()
 * @method bool                                           hasUnitIsRequired()
 * @method self                                           setStatus(string $status)
 * @method string                                         getStatus()
 * @method bool                                           hasStatus()
 * @method self                                           setBankStatement(?int $bankStatement)
 * @method int|null                                       getBankStatement()
 * @method bool                                           hasBankStatement()
 * @method self                                           setPaystub(?int $payStub)
 * @method int|null                                       getPaystub()
 * @method bool                                           hasPaystub()
 * @method self                                           setSupportedDoctypes(?SupportedDoctypesDTO $supportedDoctypes)
 * @method array|null                                     getSupportedDoctypes()
 * @method bool                                           hasSupportedDoctypes()
 * @method list<IdentityVerificationReportImageType>|null getIdentityVerificationReportImageTypes()
 * @method bool                                           hasIdentityVerificationReportImageTypes()
 * @method self                                           setCompanyId(?string $companyId)
 * @method string|null                                    getCompanyId()
 * @method bool                                           hasCompanyId()
 * @method self                                           setCompanyShortId(?string $companyShortId)
 * @method string|null                                    getCompanyShortId()
 * @method bool                                           hasCompanyShortId()
 * @method self                                           setApplicantLink(string $applicantLink)
 * @method string                                         getApplicantLink()
 * @method bool                                           hasApplicantLink()
 * @method self                                           setLeasingTeamLink(string $leasingTeamLink)
 * @method string                                         getLeasingTeamLink()
 * @method bool                                           hasLeasingTeamLink()
 * @method self                                           setIdentityVerificationEnabled(?bool $identityVerificationEnabled)
 * @method bool|null                                      getIdentityVerificationEnabled()
 * @method bool                                           hasIdentityVerificationEnabled()
 * @method self                                           setIncomeVerificationEnabled(?bool $incomeVerificationEnabled)
 * @method bool|null                                      getIncomeVerificationEnabled()
 * @method bool                                           hasIncomeVerificationEnabled()
 * @method self                                           setInsertedAt(string $insertedAt)
 * @method string                                         getInsertedAt()
 * @method bool                                           hasInsertedAt()
 * @method self                                           setUpdatedAt(string $updatedAt)
 * @method string                                         getUpdatedAt()
 * @method bool                                           hasUpdatedAt()
 * @method self                                           setPropertyFeature(string $propertyFeature)
 * @method string                                         getPropertyFeature()
 * @method bool                                           hasPropertyFeature()
 */
class PropertyDTO extends CamelDataTransferObject
{
	protected array $fields = [
		'id',
		'shortId',
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
		'companyId',
		'companyShortId',
		'applicantLink',
		'leasingTeamLink',
		'identityVerificationEnabled',
		'incomeVerificationEnabled',
		'insertedAt',
		'updatedAt',
		'propertyFeature',
	];

	/**
	 * @param list<IdentityVerificationReportImageType>|null $identityVerificationReportImageTypes
	 */
	public function setIdentityVerificationReportImageTypes(?array $identityVerificationReportImageTypes): self
	{
		if (!$identityVerificationReportImageTypes) {
			return $this->set('identityVerificationReportImageTypes', null);
		}

		$imageTypes = [];

		foreach ($identityVerificationReportImageTypes as $imageType) {
			$imageTypes[] = $imageType->value;
		}

		return $this->set('identityVerificationReportImageTypes', $imageTypes);
	}
}
