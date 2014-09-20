<?php

namespace Wikibase\Test;

use InvalidArgumentException;
use Wikibase\Constraints\FormatConstraint;

/**
 * @covers Wikibase\Constraints\FormatConstraint
 *
 * @license GNU GPL v2+
 * @author Bene* < benestar.wikimedia@gmail.com >
 */
class FormatConstraintTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testConstructionFails() {
		new FormatConstraint( 123 );
	}

	public function testGetName() {
		$formatConstrain = new FormatConstraint( '' );
		$this->assertEquals( 'format', $formatConstrain->getName() );
	}

}
