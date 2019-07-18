<?php

namespace HisInOneProxy\DataModel;

use HisInOneProxy\DataModel\Traits;

/**
 * Class FieldOfStudy
 * @package HisInOneProxy\DataModel
 */
class FieldOfStudy
{
    use Traits\DefaultObject;

    /**
     * @var string
     */
    protected $a_stat;

    /**
     * @var string
     */
    protected $a_stat_guest_auditor;

    /**
     * @return string
     */
    public function getAStat()
    {
        return $this->a_stat;
    }

    /**
     * @param string $a_stat
     */
    public function setAStat($a_stat)
    {
        $this->a_stat = $a_stat;
    }

    /**
     * @return string
     */
    public function getAStatGuestAuditor()
    {
        return $this->a_stat_guest_auditor;
    }

    /**
     * @param string $a_stat_guest_auditor
     */
    public function setAStatGuestAuditor($a_stat_guest_auditor)
    {
        $this->a_stat_guest_auditor = $a_stat_guest_auditor;
    }
}