<?php

namespace Wikibase\Test;

use DataValues\NumberValue;
use DataValues\StringValue;
use InvalidArgumentException;
use Wikibase\Constraints\Constraint\OneOfChecker;

/**
 * @covers Wikibase\Constraints\Constraint\OneOfChecker
 *
 * @license GNU GPL v2+
 * @author Bene* < benestar.wikimedia@gmail.com >
 */
class OneOfCheckerTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testConstructionFails() {
		new OneOfChecker( array( new StringValue( 'foo bar' ), null ) );
	}

	public function testSupportsDataValue() {
		$oneOfChecker = new OneOfChecker( array() );
		$this->assertTrue( $oneOfChecker->supportsDataValue( new StringValue( 'foo bar' ) ) );
		$this->assertTrue( $oneOfChecker->supportsDataValue( new NumberValue( 42 ) ) );
	}

	public function testCheckDataValue_returnsTrue() {
		$oneOfChecker = new OneOfChecker( array( new StringValue( 'foo' ), new StringValue( 'bar' ) ) );
		$this->assertTrue( $oneOfChecker->checkDataValue( new StringValue( 'foo' ) ) );
		$this->assertTrue( $oneOfChecker->checkDataValue( new StringValue( 'bar' ) ) );
	}

	public function testCheckDataValue_returnsFalse() {
		$oneOfChecker = new OneOfChecker( array( new StringValue( 'foo' ), new StringValue( 'bar' ) ) );
		$this->assertFalse( $oneOfChecker->checkDataValue( new StringValue( 'baz' ) ) );
	}

	public function testGetName() {
		$oneOfChecker = new OneOfChecker( array() );
		$this->assertEquals( 'oneof', $oneOfChecker->getName() );
	}

	public function testEquals() {
		$oneOfChecker1 = new OneOfChecker( array( new StringValue( 'foo' ) ) );
		$oneOfChecker2 = new OneOfChecker( array( new StringValue( 'foo' ) ) );

		$this->assertTrue( $oneOfChecker1->equals( $oneOfChecker2 ) );
		$this->assertTrue( $oneOfChecker1->equals( $oneOfChecker1 ) );
	}

	public function testNotEquals() {
		$oneOfChecker1 = new OneOfChecker( array( new StringValue( 'foo' ) ) );
		$oneOfChecker2 = new OneOfChecker( array( new StringValue( 'bar' ) ) );

		$this->assertFalse( $oneOfChecker1->equals( $oneOfChecker2 ) );
		$this->assertFalse( $oneOfChecker1->equals( null ) );
	}

}
