<?php

namespace HisInOneProxy\DataModel\Traits;

/**
 * Trait LearningTarget
 * @package HisInOneProxy\DataModel\Traits
 */
trait LearningTarget
{

    /**
     * @var string
     */
    protected $learning_target;

    /**
     * @return string
     */
    public function getLearningTarget()
    {
        return $this->learning_target;
    }

    /**
     * @param string $learning_target
     */
    public function setLearningTarget($learning_target)
    {
        $this->learning_target = $learning_target;
    }
}