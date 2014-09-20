<?php

namespace Wikibase\Test;

use DataValues\NumberValue;
use DataValues\StringValue;
use InvalidArgumentException;
use Wikibase\Constraints\RangeConstraint;

/**
 * @covers Wikibase\Constraints\RangeConstraint
 *
 * @license GNU GPL v2+
 * @author Bene* < benestar.wikimedia@gmail.com >
 */
class RangeConstraintTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testConstructionFails_wrongDataTypes() {
		new RangeConstraint( new StringValue( 'foo bar' ), new NumberValue( 123 ) );
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testConstructionFails_wrongOrder() {
		new RangeConstraint( new NumberValue( 10 ), new NumberValue( 1 ) );
	}

	public function testGetName() {
		$rangeConstraint = new RangeConstraint( new NumberValue( 1 ), new NumberValue( 3 ) );
		$this->assertEquals( 'range', $rangeConstraint->getName() );
	}

}
