<?php

namespace TenantCloud\Snappt\Webhooks\DTO;

use TenantCloud\DataTransferObjects\CamelDataTransferObject;

/**
 * @method self         setId(string $id)
 * @method string       getId()
 * @method bool         hasId()
 * @method self         setMethod(string $method)
 * @method string       getMethod()
 * @method bool         hasMethod()
 * @method self         setUrl(string $url)
 * @method string       getUrl()
 * @method bool         hasUrl()
 * @method self         setHeaders(string[] $headers)
 * @method list<string> getHeaders()
 * @method bool         hasHeaders()
 * @method self         setEvents(string[] $events)
 * @method list<string> getEvents()
 * @method bool         hasEvents()
 * @method self         setIsActive(bool $isActive)
 * @method bool         getIsActive()
 * @method bool         hasIsActive()
 * @method self         setApiKeyId(string $apiKeyId)
 * @method string       getApiKeyId()
 * @method bool         hasApiKeyId()
 * @method self         setInsertedAt(string $insertedAt)
 * @method string       getInsertedAt()
 * @method bool         hasInsertedAt()
 * @method self         setUpdatedAt(string $updatedAt)
 * @method string       getUpdatedAt()
 * @method bool         hasUpdatedAt()
 */
class WebhookDTO extends CamelDataTransferObject
{
	protected array $fields = [
		'id',
		'method',
		'url',
		'headers',
		'events',
		'isActive',
		'apiKeyId',
		'insertedAt',
		'updatedAt',
	];
}
