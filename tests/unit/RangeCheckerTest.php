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

	public function testGetName() {
		$rangeConstraint = new RangeChecker( new NumberValue( 1 ), new NumberValue( 3 ) );
		$this->assertEquals( 'range', $rangeConstraint->getName() );
	}

}
