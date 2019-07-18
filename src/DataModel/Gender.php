<?php

namespace HisInOneProxy\DataModel;

use HisInOneProxy\DataModel\Traits;

/**
 * Class Gender
 * @package HisInOneProxy\DataModel
 */
class Gender
{

    use Traits\DefaultObject;

    /**
     * @var string
     */
    protected $letter_salutation;

    /**
     * @var string
     */
    protected $form_of_address;

    /**
     * @return string
     */
    public function getLetterSalutation()
    {
        return $this->letter_salutation;
    }

    /**
     * @param string $letter_salutation
     */
    public function setLetterSalutation($letter_salutation)
    {
        $this->letter_salutation = $letter_salutation;
    }

    /**
     * @return string
     */
    public function getFormOfAddress()
    {
        return $this->form_of_address;
    }

    /**
     * @param string $form_of_address
     */
    public function setFormOfAddress($form_of_address)
    {
        $this->form_of_address = $form_of_address;
    }
}