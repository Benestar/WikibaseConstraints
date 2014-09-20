<?php

namespace Wikibase\Test;

use DataValues\NumberValue;
use DataValues\StringValue;
use InvalidArgumentException;
use Wikibase\Constraints\RangeChecker;

/**
 * @covers Wikibase\Constraints\RangeChecker
 *
 * @license GNU GPL v2+
 * @author Bene* < benestar.wikimedia@gmail.com >
 */
class RangeCheckerTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testConstructionFails_wrongDataTypes() {
		new RangeChecker( new StringValue( 'foo bar' ), new NumberValue( 123 ) );
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testConstructionFails_wrongOrder() {
		new RangeChecker( new NumberValue( 10 ), new NumberValue( 1 ) );
	}

	public function testSupportsDataValue() {
		$rangeChecker = new RangeChecker( new NumberValue( 1 ), new NumberValue( 3 ) );
		$this->assertTrue( $rangeChecker->supportsDataValue( new NumberValue( 42 ) ) );
	}

	public function testNotSupportsDataValue() {
		$rangeChecker = new RangeChecker( new NumberValue( 1 ), new NumberValue( 3 ) );
		$this->assertFalse( $rangeChecker->supportsDataValue( new StringValue( 'foo bar' ) ) );
	}

	public function testCheckDataValue_returnsTrue() {
		$rangeChecker = new RangeChecker( new NumberValue( 1 ), new NumberValue( 3 ) );
		$this->assertTrue( $rangeChecker->checkDataValue( new NumberValue( 1 ) ) );
		$this->assertTrue( $rangeChecker->checkDataValue( new NumberValue( 2 ) ) );
		$this->assertTrue( $rangeChecker->checkDataValue( new NumberValue( 3 ) ) );
	}

	public function testCheckDataValue_returnsFalse() {
		$rangeChecker = new RangeChecker( new NumberValue( 1 ), new NumberValue( 3 ) );
		$this->assertFalse( $rangeChecker->checkDataValue( new NumberValue( 0 ) ) );
		$this->assertFalse( $rangeChecker->checkDataValue( new NumberValue( 5 ) ) );
	}

	public function testCheckDataValue_minEqualsMax() {
		$rangeChecker = new RangeChecker( new NumberValue( 5 ), new NumberValue( 5 ) );
		$this->assertTrue( $rangeChecker->checkDataValue( new NumberValue( 5 ) ) );
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testCheckDataValue_throwsException() {
		$rangeChecker = new RangeChecker( new NumberValue( 1 ), new NumberValue( 3 ) );
		$rangeChecker->checkDataValue( new StringValue( 'foo bar' ) );
	}

	public function testGetName() {
		$rangeChecker = new RangeChecker( new NumberValue( 1 ), new NumberValue( 3 ) );
		$this->assertEquals( 'range', $rangeChecker->getName() );
	}

	public function testEquals() {
		$rangeChecker1 = new RangeChecker( new NumberValue( 1 ), new NumberValue( 3 ) );
		$rangeChecker2 = new RangeChecker( new NumberValue( 1 ), new NumberValue( 3 ) );
		$this->assertTrue( $rangeChecker1->equals( $rangeChecker2 ) );
	}

	public function testNotEquals() {
		$rangeChecker1 = new RangeChecker( new NumberValue( 1 ), new NumberValue( 3 ) );
		$rangeChecker2 = new RangeChecker( new NumberValue( 0 ), new NumberValue( 5 ) );
		$this->assertFalse( $rangeChecker1->equals( $rangeChecker2 ) );
	}

}
