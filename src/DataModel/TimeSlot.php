<?php

namespace HisInOneProxy\DataModel;

use HisInOneProxy\DataModel\Traits;

class TimeSlot
{
	use Traits\LockVersion, Traits\ObjGuid, Traits\StartEndTime, Traits\WeekDay;
}
