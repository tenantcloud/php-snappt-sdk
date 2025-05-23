<?php

namespace TenantCloud\Snappt\ApplicantSessions\Enum;

enum DocumentType: string
{
	case PAY_STUB = 'PAYSTUB';
	case BANK_STATEMENT = 'BANK_STATEMENT';
}
