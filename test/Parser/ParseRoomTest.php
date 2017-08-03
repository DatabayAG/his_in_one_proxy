<?php

include_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\Parser;

require_once 'test/TestCaseExtension.php';

class ParseRoomTest extends TestCaseExtension
{
	protected function setUp()
	{
		parent::setUp();
	}

	public function test_simpleUnitIncompleteParsing_shouldReturnLogWarning()
	{
		$xml    = file_get_contents('test/fixtures/incomplete/unit_incomplete.xml');
		$parser = new Parser\ParseRoom($this->log);
		$parser->parse(simplexml_load_string($xml));
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals('Warning: No id given for Room, skipping!', $msg);
	}

	public function test_simpleRoomParsing_shouldReturnOrgUnit()
	{
		$xml      = file_get_contents('test/fixtures/room.xml');
		$parser   = new Parser\ParseRoom($this->log);
		$room = $parser->parse(simplexml_load_string( $xml));
		$this->assertEquals('23435', $room->getId());
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals('Info: Found Room with id 23435.', $msg);
		$this->assertEquals('87043563577076', $room->getObjGuid());
		$this->assertEquals('Short text', $room->getShortText());
		$this->assertEquals('default text', $room->getDefaultText());
		$this->assertEquals('Longtext', $room->getLongText());
		$this->assertEquals('23', $room->getDefaultLanguageId());
		$this->assertEquals('My super rooom', $room->getUniqueName());
		$this->assertEquals('Description', $room->getDescription());
		$this->assertEquals('1', $room->getPartOfRoomComposition());
		$this->assertEquals('My class room name', $room->getClassRoomName());
		$this->assertEquals('1000', $room->getFloorId());
		$this->assertEquals('1', $room->getDin277RoomUseId());
		$this->assertEquals('3', $room->getArea());
		$this->assertEquals('45', $room->getRoomSegmentCount());
	}

	public function test_simpleHisRoomParsing_shouldReturnOrgUnit()
	{
		$xml      = file_get_contents('test/fixtures/his_room.xml');
		$parser   = new Parser\ParseRoom($this->log, $xml);
		$room = $parser->parse(simplexml_load_string($xml));
		$this->assertEquals('1', $room->getId());
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals('Info: Found Room with id 1.', $msg);
		$this->assertEquals('033d5dcf-fe96-4f6e-8d4f-90d66b0d48ea', $room->getObjGuid());
		$this->assertEquals('S001', $room->getShortText());
		$this->assertEquals('Seminarraum 001', $room->getDefaultText());
		$this->assertNull($room->getLongText());
		$this->assertEquals('12', $room->getDefaultLanguageId());
		$this->assertEquals('S001', $room->getUniqueName());
		$this->assertNull($room->getDescription());
		$this->assertEquals('false', $room->getPartOfRoomComposition());
		$this->assertEquals('Room', $room->getClassRoomName());
		$this->assertEquals('1', $room->getFloorId());
		$this->assertEquals('96', $room->getDin277RoomUseId());
		$this->assertEquals('100.000000', $room->getArea());
		$this->assertEquals('0', $room->getRoomSegmentCount());
	}

}