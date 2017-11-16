<?php

include_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\Parser;

require_once 'test/TestCaseExtension.php';

/**
 * Class ParsePreferredRoomsTest
 */
class ParsePreferredRoomsTest extends TestCaseExtension
{
	/**
	 * @var \HisInOneProxy\Log\Log
	 */
	protected $log;

	protected $collectedMessages = array();

	protected function setUp()
	{
		parent::setUp();
	}

	public function test_simpleIncompleteParsing_shouldReturnLogWarning()
	{
		$xml    = file_get_contents('test/fixtures/incomplete/room_incomplete.xml');
		$parser = new Parser\ParsePreferredRooms($this->log);
		$parser->parse(simplexml_load_string($xml), new \HisInOneProxy\DataModel\PlanElementPreferencePart());
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals('Warning: No id given for Room, skipping!', $msg);
	}

	public function test_simpleRoomParsing_shouldReturnOrgUnit()
	{
		$xml      = file_get_contents('test/fixtures/his_room.xml');
		$parser = new Parser\ParsePreferredRooms($this->log);
		$plan_part =  new \HisInOneProxy\DataModel\PlanElementPreferencePart();
		$parser->parse(simplexml_load_string('<resp>'.$xml .'</resp>'), $plan_part);
		$room = $plan_part->getPreferredRooms()[0];
		$this->assertEquals('1', $room->getId());
		$this->assertEquals('033d5dcf-fe96-4f6e-8d4f-90d66b0d48ea', $room->getObjGuid());
		$this->assertEquals('S001', $room->getShortText());
		$this->assertEquals('Seminarraum 001', $room->getDefaultText());
		$this->assertEquals('', $room->getLongText());
		$this->assertEquals('12', $room->getDefaultLanguageId());
		$this->assertEquals('S001', $room->getUniqueName());
		$this->assertEquals('', $room->getDescription());
		$this->assertEquals('false', $room->getPartOfRoomComposition());
		$this->assertEquals('Room', $room->getClassRoomName());
		$this->assertEquals('1', $room->getFloorId());
		$this->assertEquals('96', $room->getDin277RoomUseId());
		$this->assertEquals('100.000000', $room->getArea());
		$this->assertEquals('0', $room->getRoomSegmentCount());
	}
	

}