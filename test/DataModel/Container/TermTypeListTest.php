<?php
require_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\DataModel;

/**
 * Class TermTypeListTest
 */
class TermTypeListTest extends PHPUnit\Framework\TestCase
{

	/**
	 * @var DataModel\Container\TermTypeList $instance
	 */
	protected $instance;

	protected function setUp()
	{
		$this->instance = new DataModel\Container\TermTypeList();
	}

	public function test_instantiateObject_shouldReturnInstance()
	{
		$this->assertInstanceOf('HisInOneProxy\DataModel\Container\TermTypeList', $this->instance);
	}

	public function test_append_shouldReturnId()
	{
		$this->assertEquals(0, $this->instance->getSizeOfContainer());
		$term = new DataModel\TermType();
		$term->setId(1);
		$this->instance->appendTermType($term);
		$this->assertEquals(1, $this->instance->getSizeOfContainer());
		$term = new DataModel\TermType();
		$term->setId(5);
		$this->instance->appendTermType($term);
		$this->assertEquals(2, $this->instance->getSizeOfContainer());
		$term = new DataModel\TermType();
		$term->setId(6);
		$this->instance->appendTermType($term);
		$this->assertEquals(3, $this->instance->getSizeOfContainer());
	}

	public function test_generatorTest_shouldReturnInstance()
	{
		$values = array(2,1, 500050, 321423, 53454354);
		$this->instance = new DataModel\Container\TermTypeList();
		$this->assertEquals(0, $this->instance->getSizeOfContainer());
		$tt = new DataModel\TermType();
		$tt->setId(2);
		$this->instance->appendTermType($tt);
		$tt = new DataModel\TermType();
		$tt->setId(1);
		$this->instance->appendTermType($tt);
		$tt = new DataModel\TermType();
		$tt->setId(500050);
		$this->instance->appendTermType($tt);
		$tt = new DataModel\TermType();
		$tt->setId(321423);
		$this->instance->appendTermType($tt);
		$tt = new DataModel\TermType();
		$tt->setId(53454354);
		$this->instance->appendTermType($tt);
		$counter = 0 ;
		foreach($this->instance->getTermType() as $term_type)
		{
			$this->assertEquals($values[$counter], $term_type->getId());
			$counter++;
		}
	
	}
}