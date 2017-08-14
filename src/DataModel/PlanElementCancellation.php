<?php

namespace HisInOneProxy\DataModel;

use HisInOneProxy\DataModel\Traits;

/**
 * Class PlanElementCancellation
 * @package HisInOneProxy\DataModel
 */
class PlanElementCancellation
{
	use Traits\LanguageId, Traits\LockVersion, Traits\ObjGuid, Traits\PlannedDatesId;

	/**
	 * @var string
	 */
	protected $canceled_date;

	/**
	 * @var string
	 */
	protected $remark;

	/**
	 * @return string
	 */
	public function getCanceledDate()
	{
		return $this->canceled_date;
	}

	/**
	 * @param string $canceled_date
	 */
	public function setCanceledDate($canceled_date)
	{
		$this->canceled_date = $canceled_date;
	}

	/**
	 * @return string
	 */
	public function getRemark()
	{
		return $this->remark;
	}

	/**
	 * @param string $remark
	 */
	public function setRemark($remark)
	{
		$this->remark = $remark;
	}
}
