<?php

namespace TenantCloud\Snappt\Properties\DTO;

use TenantCloud\DataTransferObjects\DataTransferObject;

/**
 * @method self setPaystub(int $payStub)
 * @method int  getPaystub()
 * @method bool hasPaystub()
 * @method self setBankStatement(int $bankStatement)
 * @method int  getBankStatement()
 * @method bool hasBankStatement()
 * @method self setCashAppStatement(int $cashAppStatement)
 * @method int  getCashAppStatement()
 * @method bool hasCashAppStatement()
 * @method self setCreditDebitCardStatement(int $creditDebitCardStatement)
 * @method int  getCreditDebitCardStatement()
 * @method bool hasCreditDebitCardStatement()
 * @method self setDepartmentOfVeteransAffairsBenefitLetter(int $departmentOfVeteransAffairsBenefitLetter)
 * @method int  getDepartmentOfVeteransAffairsBenefitLetter()
 * @method bool hasDepartmentOfVeteransAffairsBenefitLetter()
 * @method self setInvestmentAccount(int $investmentAccount)
 * @method int  getInvestmentAccount()
 * @method bool hasInvestmentAccount()
 * @method self setSocialSecurityBenefitsLetter(int $socialSecurityBenefitsLetter)
 * @method int  getSocialSecurityBenefitsLetter()
 * @method bool hasSocialSecurityBenefitsLetter()
 * @method self setSocialSecurityStatement(int $socialSecurityStatement)
 * @method int  getSocialSecurityStatement()
 * @method bool hasSocialSecurityStatement()
 * @method self setTaxTranscript(int $taxTranscript)
 * @method int  getTaxTranscript()
 * @method bool hasTaxTranscript()
 * @method self setUtilityBill(int $utilityBill)
 * @method int  getUtilityBill()
 * @method bool hasUtilityBill()
 * @method self setPayrollStatement(int $payrollStatement)
 * @method int  getPayrollStatement()
 * @method bool hasPayrollStatement()
 * @method self setW2(int $w2)
 * @method int  getW2()
 * @method bool hasW2()
 */
class SupportedDoctypesDTO extends DataTransferObject
{
	protected array $fields = [
		'paystub',
		'bank_statement',
		'cash_app_statement',
		'credit_debit_card_statement',
		'department_of_veterans_affairs_benefit_letter',
		'investment_account',
		'social_security_benefits_letter',
		'social_security_statement',
		'tax_transcript',
		'utility_bill',
		'payroll_statement',
		'w2',
	];
}
