<?php

namespace HisInOneProxy\DataModel;

use HisInOneProxy\DataModel\Traits;

/**
 * Class TimeSlot
 * @package HisInOneProxy\DataModel
 */
class TimeSlot
{
	use Traits\Appointment, Traits\LockVersion, Traits\ObjGuid;
}
