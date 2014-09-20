<?php

namespace Wikibase\Test;

use DataValues\StringValue;
use InvalidArgumentException;
use Wikibase\Constraints\OneOfConstraint;

/**
 * @covers Wikibase\Constraints\OneOfConstraint
 *
 * @license GNU GPL v2+
 * @author Bene* < benestar.wikimedia@gmail.com >
 */
class OneOfConstraintTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testConstructionFails() {
		new OneOfConstraint( array( new StringValue( 'foo bar' ), null ) );
	}

	public function testGetName() {
		$oneOfConstrain = new OneOfConstraint( array() );
		$this->assertEquals( 'oneof', $oneOfConstrain->getName() );
	}

}
