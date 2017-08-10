<?php

namespace HisInOneProxy\DataModel;

use HisInOneProxy\DataModel\Traits;

class EventDate
{
	use Traits\AcademicYear, Traits\Achievements, Traits\CompulsoryRequirement, Traits\Contents, Traits\Credits, Traits\ExternOrganizer, 
		Traits\Grading, Traits\LearningTarget, Traits\ObjectiveQualification, Traits\RecommendedRequirement,  
		Traits\PlanElementId, Traits\Literature, Traits\LockVersion, Traits\ObjGuid, Traits\TargetGroup, Traits\TeachingLanguageId,
		Traits\TeachingMethod, Traits\Workload;
}
