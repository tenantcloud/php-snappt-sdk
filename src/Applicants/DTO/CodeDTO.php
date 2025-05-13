<?php

namespace TenantCloud\Snappt\Applicants\DTO;

use TenantCloud\DataTransferObjects\CamelDataTransferObject;

/**
 * @method self setCode(int $code)
 * @method int  getCode()
 * @method bool hasCode()
 */
class CodeDTO extends CamelDataTransferObject
{
	protected array $fields = [
		'code',
	];
}
