<?php

namespace TenantCloud\Snappt\Applicants\DTO;

use TenantCloud\DataTransferObjects\CamelDataTransferObject;

/**
 * @method self                                     setId(string $id)
 * @method string                                   getId()
 * @method bool                                     hasId()
 * @method self                                     setFileName(string $fileName)
 * @method string                                   getFileName()
 * @method bool                                     hasFileName()
 * @method self                                     setInsertedAt(string $insertedAt)
 * @method string                                   getInsertedAt()
 * @method bool                                     hasInsertedAt()
 * @method self                                     setType(string $type)
 * @method string                                   getType()
 * @method bool                                     hasType()
 * @method self                                     setResult(string $result)
 * @method string                                   getResult()
 * @method bool                                     hasResult()
 * @method self                                     setSourceType(string $sourceType)
 * @method string                                   getSourceType()
 * @method bool                                     hasSourceType()
 * @method DocumentIncomeVerificationDetailDTO|null getIncomeVerificationDetails()
 * @method bool                                     hasIncomeVerificationDetails()
 */
class DocumentDTO extends CamelDataTransferObject
{
	protected array $fields = [
		'id',
		'fileName',
		'insertedAt',
		'type',
		'result',
		'sourceType',
		'incomeVerificationDetails',
	];

	public function setIncomeVerificationDetails(mixed $documentIncomeVerificationDetails): self
	{
		if (!$documentIncomeVerificationDetails) {
			return $this->set('incomeVerificationDetails', null);
		}

		if (is_array($documentIncomeVerificationDetails)) {
			$documentIncomeVerificationDetails = DocumentIncomeVerificationDetailDTO::from($documentIncomeVerificationDetails);
		}

		return $this->set(
			'incomeVerificationDetails',
			DocumentIncomeVerificationDetailDTO::from($documentIncomeVerificationDetails)
		);
	}
}
