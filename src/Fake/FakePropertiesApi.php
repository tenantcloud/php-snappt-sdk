<?php

namespace TenantCloud\Snappt\Fake;

use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Str;
use TenantCloud\Snappt\Exceptions\NotFoundException;
use TenantCloud\Snappt\Properties\DTO\CreateOrUpdatePropertyDTO;
use TenantCloud\Snappt\Properties\DTO\PropertyDTO;
use TenantCloud\Snappt\Properties\PropertiesApi;

class FakePropertiesApi implements PropertiesApi
{
	public function __construct(
		private readonly Repository $cache
	) {}

	public function get(string $propertyId): PropertyDTO
	{
		if (!$this->cache->has("property:{$propertyId}")) {
			throw new NotFoundException();
		}

		return PropertyDTO::from($this->cache->get("property:{$propertyId}"));
	}

	public function create(CreateOrUpdatePropertyDTO $propertyDTO): PropertyDTO
	{
		$propertyId = Str::uuid()->toString();
		$shortId = Str::random(10);

		$dto = PropertyDTO::create()
			->setId($propertyId)
			->setShortId($shortId)
			->setBankStatement(2)
			->setPaystub(2)
			->setCompanyId(Str::uuid()->toString())
			->setCompanyShortId(Str::random(10))
			->setIdentityVerificationEnabled(false)
			->setIncomeVerificationEnabled(false)
			->setUpdatedAt('2025-05-27T10:10:09.000Z')
			->setInsertedAt('2025-05-27T10:10:09.000Z');

		$this->cache->put(
			"property:{$propertyId}",
			[
				...$propertyDTO->toArray(),
				...$dto->toArray(),
			]
		);

		return PropertyDTO::from($this->cache->get("property:{$propertyId}"));
	}

	public function update(string $propertyId, CreateOrUpdatePropertyDTO $propertyDTO): PropertyDTO
	{
		if (!$this->cache->has("property:{$propertyId}")) {
			throw new NotFoundException();
		}

		$this->cache->put(
			"property:{$propertyId}",
			array_merge(
				$this->cache->get("property:{$propertyId}"),
				$propertyDTO->toArray()
			)
		);

		return PropertyDTO::from($this->cache->get("property:{$propertyId}"));
	}

	public function enableIncomeVerification(string $propertyId, bool $enabled): PropertyDTO
	{
		if (!$this->cache->has("property:{$propertyId}")) {
			throw new NotFoundException();
		}

		$this->cache->put(
			"property:{$propertyId}",
			array_merge(
				$this->cache->get("property:{$propertyId}"),
				['incomeVerificationEnabled' => $enabled],
			)
		);

		return PropertyDTO::from($this->cache->get("property:{$propertyId}"));
	}
}
