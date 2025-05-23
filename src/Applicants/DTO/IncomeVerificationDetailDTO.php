<?php

namespace TenantCloud\Snappt\Applicants\DTO;

use TenantCloud\DataTransferObjects\CamelDataTransferObject;

/**
 * @method self          setCalculationDate(string $calculationDate)
 * @method string        getCalculationDate()
 * @method bool          hasCalculationDate()
 * @method self          setGrossDailyIncome(?int $grossDailyIncome)
 * @method int|null      getGrossDailyIncome()
 * @method bool          hasGrossDailyIncome()
 * @method self          setGrossMonthlyIncome(?int $grossMonthlyIncome)
 * @method int|null      getGrossMonthlyIncome()
 * @method bool          hasGrossMonthlyIncome()
 * @method self          setGrossYearlyIncome(?int $grossYearlyIncome)
 * @method int|null      getGrossYearlyIncome()
 * @method bool          hasGrossYearlyIncome()
 * @method self          setConsecutiveDays(?int $consecutiveDays)
 * @method int|null      getConsecutiveDays()
 * @method bool          hasConsecutiveDays()
 * @method self          setStatus(string $status)
 * @method string        getStatus()
 * @method bool          hasStatus()
 * @method list<CodeDTO> getStatusDetails()
 * @method bool          hasStatusDetails()
 */
class IncomeVerificationDetailDTO extends CamelDataTransferObject
{
	protected array $fields = [
		'calculationDate',
		'grossDailyIncome',
		'grossMonthlyIncome',
		'grossYearlyIncome',
		'consecutiveDays',
		'status',
		'statusDetails',
	];

	public function setStatusDetails(?array $statusDetails): self
	{
		if ($statusDetails === null) {
			return $this->set('statusDetails', null);
		}

		$codesDto = [];

		foreach ($statusDetails as $statusDetail) {
			$codesDto[] = CodeDTO::from($statusDetail);
		}

		return $this->set('statusDetails', $codesDto);
	}
}
