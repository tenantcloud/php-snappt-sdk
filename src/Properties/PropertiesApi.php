<?php

namespace TenantCloud\Snappt\Properties;

use TenantCloud\Snappt\Properties\DTO\CreateOrUpdatePropertyDTO;
use TenantCloud\Snappt\Properties\DTO\PropertyDTO;

interface PropertiesApi
{
	public function get(string $propertyId): PropertyDTO;

	public function create(CreateOrUpdatePropertyDTO $propertyDTO): PropertyDTO;

	public function update(string $propertyId, CreateOrUpdatePropertyDTO $propertyDTO): PropertyDTO;

	public function enableIncomeVerification(string $propertyId, bool $enabled): PropertyDTO;
}
