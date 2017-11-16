<?php
require_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\DataModel;

/**
 * Class RoomTest
 */
class RoomTest extends PHPUnit\Framework\TestCase
{

	/**
	 * @var DataModel\Room $instance
	 */
	protected $instance;

	protected function setUp()
	{
		$this->instance = new DataModel\Room();
	}

	public function test_instantiateObject_shouldReturnInstance()
	{
		$this->assertInstanceOf('HisInOneProxy\DataModel\Room', $this->instance);
	}

	public function test_getId_shouldReturnId()
	{
		$this->instance->setId(272);
		$this->assertEquals(272, $this->instance->getId());
	}

	public function test_getObjGuid_shouldReturnObjGuid()
	{
		$this->instance->setObjGuid(2711);
		$this->assertEquals(2711, $this->instance->getObjGuid());
	}

	public function test_getDefaultLanguageId_shouldReturnPreferredRoomId()
	{
		$this->instance->setDefaultLanguageId(14372);
		$this->assertEquals(14372, $this->instance->getDefaultLanguageId());
	}

	public function test_ggetDescription_shouldReturnPreferredRoomForPlanElementPartsId()
	{
		$this->instance->setDescription('description');
		$this->assertEquals('description', $this->instance->getDescription());
	}

	public function test_getPartOfRoomComposition_shouldReturnPriority()
	{
		$this->instance->setPartOfRoomComposition(27);
		$this->assertEquals(27, $this->instance->getPartOfRoomComposition());
	}

	public function test_getClassRoomName_shouldReturnPriority()
	{
		$this->instance->setClassRoomName('room of 45');
		$this->assertEquals('room of 45', $this->instance->getClassRoomName());
	}

	public function test_getFloorId_shouldReturnPriority()
	{
		$this->instance->setFloorId(12);
		$this->assertEquals(12, $this->instance->getFloorId());
	}

	public function test_getDin277RoomUseId_shouldReturnPriority()
	{
		$this->instance->setDin277RoomUseId(1);
		$this->assertEquals(1, $this->instance->getDin277RoomUseId());
	}

	public function test_getArea_shouldReturnPriority()
	{
		$this->instance->setArea(8);
		$this->assertEquals(8, $this->instance->getArea());
	}

	public function test_getRoomSegmentCount_shouldReturnPriority()
	{
		$this->instance->setRoomSegmentCount(866);
		$this->assertEquals(866, $this->instance->getRoomSegmentCount());
	}

}