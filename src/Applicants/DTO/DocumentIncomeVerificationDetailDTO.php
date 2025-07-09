<?php

namespace TenantCloud\Snappt\Applicants\DTO;

use TenantCloud\DataTransferObjects\CamelDataTransferObject;

/**
 * @method self        setCalculationStartDate(string $calculationStartDate)
 * @method string      getCalculationStartDate()
 * @method bool        hasCalculationStartDate()
 * @method self        setCalculationEndDate(string $calculationEndDate)
 * @method string      getCalculationEndDate()
 * @method bool        hasCalculationEndDate()
 * @method self        setGrossIncome(?float $grossIncome)
 * @method float|null  getGrossIncome()
 * @method bool        hasGrossIncome()
 * @method self        setIncomeSource(?string $incomeSource)
 * @method string|null getIncomeSource()
 * @method bool        hasIncomeSource()
 * @method self        setApplicantName(?string $applicantName)
 * @method string|null getApplicantName()
 * @method bool        hasApplicantName()
 */
class DocumentIncomeVerificationDetailDTO extends CamelDataTransferObject
{
	protected array $fields = [
		'calculationStartDate',
		'calculationEndDate',
		'grossIncome',
		'incomeSource',
		'applicantName',
	];
}
