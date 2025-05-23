<?php

namespace TenantCloud\Snappt\Applicants\Enum;

enum Preset: string
{
	case FCRA = 'fcra';
	case SUMMARY_AND_DOCUMENTS = 'summary-and-documents';
	case SUMMARY = 'summary';
}
