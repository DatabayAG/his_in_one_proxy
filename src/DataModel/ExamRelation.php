<?php

namespace HisInOneProxy\DataModel;

use HisInOneProxy\DataModel\Traits;

/**
 * Class ExamRelation
 * @package HisInOneProxy\DataModel
 */
class ExamRelation
{

    use Traits\PersonId, Traits\PlanElementId, Traits\UnitId, Traits\SortingOrder;

    /**
     * @var boolean
     */
    protected $cancellation;

    /**
     * @var int
     */
    protected $work_status_id;

    /**
     * @return boolean
     */
    public function getCancellation()
    {
        return $this->cancellation;
    }

    /**
     * @param boolean $cancellation
     */
    public function setCancellation($cancellation)
    {
        $this->cancellation = $cancellation;
    }

    /**
     * @return int
     */
    public function getWorkStatusId()
    {
        return $this->work_status_id;
    }

    /**
     * @param int $work_status_id
     */
    public function setWorkStatusId($work_status_id)
    {
        $this->work_status_id = $work_status_id;
    }
}
