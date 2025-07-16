<?php

namespace TenantCloud\Snappt\Webhooks\Enum;

enum EventType: string
{
	case REPORT_READY = 'REPORT_READY';
	case IDV_REPORT_READY = 'IDV_REPORT_READY';
	case APPLICATION_SUBMITTED = 'APPLICATION_SUBMITTED';
}
