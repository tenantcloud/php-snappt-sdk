<?php

namespace TenantCloud\Snappt\ApplicantSessions\DTO;

use TenantCloud\DataTransferObjects\CamelDataTransferObject;
use TenantCloud\Snappt\ApplicantSessions\Enum\DocumentType;

/**
 * @method self   setId(string $id)
 * @method string getId()
 * @method bool   hasId()
 * @method self   setFileName(string $fileName)
 * @method string getFileName()
 * @method bool   hasFileName()
 * @method self   setUnauthenticatedSessionId(string $unauthenticatedSessionId)
 * @method string getUnauthenticatedSessionId()
 * @method bool   hasUnauthenticatedSessionId()
 * @method self   setInsertedAt(string $insertedAt)
 * @method string getInsertedAt()
 * @method bool   hasInsertedAt()
 * @method string getType()
 * @method bool   hasType()
 * @method self   setProcessStatus(string $processStatus)
 * @method string getProcessStatus()
 * @method bool   hasProcessStatus()
 * @method self   setResult(string $processStatus)
 * @method string getResult()
 * @method bool   hasResult()
 */
class DocumentDTO extends CamelDataTransferObject
{
	protected array $fields = [
		'id',
		'fileName',
		'unauthenticatedSessionId',
		'insertedAt',
		'type',
		'processStatus',
		'result',
	];

	public function setType(string|DocumentType $type): self
	{
		return $this->set('type', $type instanceof DocumentType ? $type->value : $type);
	}
}
