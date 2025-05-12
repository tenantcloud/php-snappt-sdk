<?php

namespace TenantCloud\Snappt\Properties;

use TenantCloud\Snappt\Properties\DTO\CreatePropertyDTO;
use TenantCloud\Snappt\Properties\DTO\PropertyDTO;

interface PropertiesApi
{
	public function create(CreatePropertyDTO $propertyDTO): PropertyDTO;

	public function enableIncomeVerification(string $propertyId, bool $enabled): PropertyDTO;
}
