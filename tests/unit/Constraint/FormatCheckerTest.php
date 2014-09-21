<?php

namespace Wikibase\Test;

use DataValues\NumberValue;
use DataValues\StringValue;
use InvalidArgumentException;
use Wikibase\Constraints\Constraint\FormatChecker;

/**
 * @covers Wikibase\Constraint\Constraints\FormatChecker
 *
 * @license GNU GPL v2+
 * @author Bene* < benestar.wikimedia@gmail.com >
 */
class FormatCheckerTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testConstructionFails() {
		new FormatChecker( 123 );
	}

	public function testSupportsDataValue() {
		$formatChecker = new FormatChecker( '' );
		$this->assertTrue( $formatChecker->supportsDataValue( new StringValue( 'foo bar' ) ) );
	}

	public function testNotSupportsDataValue() {
		$formatChecker = new FormatChecker( '' );
		$this->assertFalse( $formatChecker->supportsDataValue( new NumberValue( 42 ) ) );
	}

	public function testCheckDataValue_returnsTrue() {
		$formatChecker = new FormatChecker( '/foo/' );
		$this->assertTrue( $formatChecker->checkDataValue( new StringValue( 'foo bar' ) ) );
	}

	public function testCheckDataValue_returnsFalse() {
		$formatChecker = new FormatChecker( '/foo/' );
		$this->assertFalse( $formatChecker->checkDataValue( new StringValue( 'bar' ) ) );
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testCheckDataValue_throwsException() {
		$formatChecker = new FormatChecker( '' );
		$formatChecker->checkDataValue( new NumberValue( 42 ) );
	}

	public function testGetName() {
		$formatChecker = new FormatChecker( '' );
		$this->assertEquals( 'format', $formatChecker->getName() );
	}

	public function testEquals() {
		$formatChecker1 = new FormatChecker( 'foo' );
		$formatChecker2 = new FormatChecker( 'foo' );

		$this->assertTrue( $formatChecker1->equals( $formatChecker2 ) );
		$this->assertTrue( $formatChecker1->equals( $formatChecker1 ) );
	}

	public function testNotEquals() {
		$formatChecker1 = new FormatChecker( 'foo' );
		$formatChecker2 = new FormatChecker( 'bar' );

		$this->assertFalse( $formatChecker1->equals( $formatChecker2 ) );
		$this->assertFalse( $formatChecker1->equals( null ) );
	}

}
