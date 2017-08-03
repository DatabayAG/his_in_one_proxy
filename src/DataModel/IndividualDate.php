<?php

namespace HisInOneProxy\DataModel;

use HisInOneProxy\DataModel\Traits;

class IndividualDate
{
	use Traits\LockVersion, Traits\ObjGuid, Traits\PlannedDatesId, Traits\RoomId, Traits\StartEndTime, Traits\WeekDay;

	/**
	 * @var int
	 */
	protected $execution_date;

	/**
	 * @return int
	 */
	public function getExecutionDate()
	{
		return $this->execution_date;
	}

	/**
	 * @param int $execution_date
	 */
	public function setExecutionDate($execution_date)
	{
		$this->execution_date = $execution_date;
	}

}
