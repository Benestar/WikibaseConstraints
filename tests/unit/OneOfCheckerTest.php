<?php

namespace Wikibase\Test;

use DataValues\StringValue;
use InvalidArgumentException;
use Wikibase\Constraints\OneOfChecker;

/**
 * @covers Wikibase\Constraints\OneOfChecker
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

	public function testGetName() {
		$oneOfConstrain = new OneOfChecker( array() );
		$this->assertEquals( 'oneof', $oneOfConstrain->getName() );
	}

}
