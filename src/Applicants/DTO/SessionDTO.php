<?php

namespace TenantCloud\Snappt\Applicants\DTO;

use TenantCloud\DataTransferObjects\CamelDataTransferObject;

/**
 * @method self   setToken(string $token)
 * @method string getToken()
 * @method bool   hasToken()
 * @method self   setId(string $id)
 * @method string getId()
 * @method bool   hasId()
 * @method self   setApplicantDetailId(string $applicantDetailId)
 * @method string getApplicantDetailId()
 * @method bool   hasApplicantDetailId()
 */
class SessionDTO extends CamelDataTransferObject
{
	protected array $fields = [
		'token',
		'id',
		'applicantDetailId',
	];
}
