<?php

namespace Wikibase\Test;

use Wikibase\Constraints\ConflictConstraint;
use Wikibase\DataModel\Snak\PropertyNoValueSnak;

/**
 * @covers Wikibase\Constraints\ConflictConstraint
 *
 * @license GNU GPL v2+
 * @author Bene* < benestar.wikimedia@gmail.com >
 */
class ConflictConstraintTest extends \PHPUnit_Framework_TestCase {

	public function testGetName() {
		$conflictConstraint = new ConflictConstraint( new PropertyNoValueSnak( 42 ) );
		$this->assertEquals( 'conflict', $conflictConstraint->getName() );
	}

}
