<?php

namespace TenantCloud\Snappt\Properties\Enum;

enum IdentityVerificationReportImageType: string
{
	case SELFIE = 'selfie';
	case DOCUMENT = 'document';
	case NONE = 'none';
}
