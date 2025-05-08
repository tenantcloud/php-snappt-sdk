<?php

namespace TenantCloud\Snappt\Applicants\Enum;

enum ApplicationType: string
{
	case LEASING_TEAM = 'leasing_team';
	case UNAUTHENTICATED_USER = 'unauthenticated_user';
}
