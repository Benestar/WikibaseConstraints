<?php

namespace Wikibase\Test;

use Wikibase\Constraints\SnakConstraint;
use Wikibase\DataModel\Snak\PropertyNoValueSnak;

/**
 * @covers Wikibase\Constraints\SnakConstraint
 *
 * @license GNU GPL v2+
 * @author Bene* < benestar.wikimedia@gmail.com >
 */
class SnakConstraintTest extends \PHPUnit_Framework_TestCase {

	public function testGetName() {
		$snakConstraint = new SnakConstraint( new PropertyNoValueSnak( 42 ) );
		$this->assertEquals( 'snak', $snakConstraint->getName() );
	}

}
