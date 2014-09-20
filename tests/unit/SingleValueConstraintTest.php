<?php

namespace Wikibase\Test;

use Wikibase\Constraints\SingleValueConstraint;

/**
 * @covers Wikibase\Constraints\SingleValueConstraint
 *
 * @license GNU GPL v2+
 * @author Bene* < benestar.wikimedia@gmail.com >
 */
class SingleValueConstraintTest extends \PHPUnit_Framework_TestCase {

	public function testGetName() {
		$singleValueConstraint = new SingleValueConstraint();
		$this->assertEquals( 'singlevalue', $singleValueConstraint->getName() );
	}

}
