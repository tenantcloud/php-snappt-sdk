<?php

namespace TenantCloud\Snappt\ApplicantSessions\Enum;

enum ApplicationType: string
{
	case LEASING_TEAM = 'leasing_team';
	case UNAUTHENTICATED_USER = 'unauthenticated_user';
}
