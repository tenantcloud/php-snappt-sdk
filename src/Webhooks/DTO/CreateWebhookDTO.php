<?php

namespace TenantCloud\Snappt\Webhooks\DTO;

use TenantCloud\DataTransferObjects\CamelDataTransferObject;
use TenantCloud\Snappt\Webhooks\Enum\EventType;

/**
 * @method self         setUrl(string $url)
 * @method string       getUrl()
 * @method bool         hasUrl()
 * @method list<string> getEvents()
 * @method bool         hasEvents()
 * @method self         setMethod(string $method)
 * @method string       getMethod()
 * @method bool         hasMethod()
 * @method self         setIsActive(bool $isActive)
 * @method bool         getIsActive()
 * @method bool         hasIsActive()
 */
class CreateWebhookDTO extends CamelDataTransferObject
{
	protected array $fields = [
		'url',
		'events',
		'method',
		'isActive',
	];

	/**
	 * @param list<EventType> $events
	 */
	public function setEvents(array $events): self
	{
		$eventTypes = [];

		foreach ($events as $event) {
			$eventTypes[] = $event->value;
		}

		return $this->set('events', $eventTypes);
	}
}
