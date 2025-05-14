<?php

namespace TenantCloud\Snappt\Applicants\DTO;

use TenantCloud\DataTransferObjects\CamelDataTransferObject;

/**
 * @method self                             setId(string $id)
 * @method string                           getId()
 * @method bool                             hasId()
 * @method self                             setFullName(?string $fullName)
 * @method string|null                      getFullName()
 * @method bool                             hasFullName()
 * @method self                             setFirstName(?string $firstName)
 * @method string|null                      getFirstName()
 * @method bool                             hasFirstName()
 * @method self                             setMiddleInitial(?string $middleInitial)
 * @method string|null                      getMiddleInitial()
 * @method bool                             hasMiddleInitial()
 * @method self                             setLastName(?string $lastName)
 * @method string|null                      getLastName()
 * @method bool                             hasLastName()
 * @method self                             setEmail(?string $email)
 * @method string|null                      getEmail()
 * @method bool                             hasEmail()
 * @method self                             setPhone(?string $phone)
 * @method string|null                      getPhone()
 * @method bool                             hasPhone()
 * @method self                             setNotification(bool $notification)
 * @method bool                             getNotification()
 * @method bool                             hasNotification()
 * @method self                             setEntryId(string $entryId)
 * @method string                           getEntryId()
 * @method bool                             hasEntryId()
 * @method self                             setInsertedAt(string $insertedAt)
 * @method string                           getInsertedAt()
 * @method bool                             hasInsertedAt()
 * @method self                             setUpdatedAt(string $updatedAt)
 * @method string                           getUpdatedAt()
 * @method bool                             hasUpdatedAt()
 * @method self                             setStatus(string $status)
 * @method string                           getStatus()
 * @method bool                             hasStatus()
 * @method self                             setResult(string $result)
 * @method string                           getResult()
 * @method bool                             hasResult()
 * @method self                             setApplicantDetailId(?string $applicantDetailId)
 * @method string|null                      getApplicantDetailId()
 * @method bool                             hasApplicantDetailId()
 * @method list<DocumentDTO>                getDocuments()
 * @method bool                             hasDocuments()
 * @method IncomeVerificationDetailDTO|null getIncomeVerificationDetails()
 * @method bool                             hasIncomeVerificationDetails()
 */
class ApplicantDTO extends CamelDataTransferObject
{
	protected array $fields = [
		'id',
		'fullName',
		'firstName',
		'middleInitial',
		'lastName',
		'email',
		'phone',
		'notification',
		'entryId',
		'insertedAt',
		'updatedAt',
		'status',
		'result',
		'applicantDetailId',
		'documents',
		'incomeVerificationDetails',
	];

	/**
	 * @param list<array<string, mixed>> $documents
	 */
	public function setDocuments(array $documents): self
	{
		$documentsDto = [];

		foreach ($documents as $document) {
			$documentsDto[] = DocumentDTO::from($document);
		}

		return $this->set('documents', $documentsDto);
	}

	/**
	 * @param array<string, mixed>|null $incomeVerificationDetails
	 */
	public function setIncomeVerificationDetails(?array $incomeVerificationDetails): self
	{
		if (!$incomeVerificationDetails) {
			return $this->set('incomeVerificationDetails', null);
		}

		return $this->set('incomeVerificationDetails', IncomeVerificationDetailDTO::from($incomeVerificationDetails));
	}
}
