<?php

namespace Wikibase\Test;

use Wikibase\Constraints\MultiValueConstraint;

/**
 * @covers Wikibase\Constraints\MultiValueConstraint
 *
 * @license GNU GPL v2+
 * @author Bene* < benestar.wikimedia@gmail.com >
 */
class MultiValueConstraintTest extends \PHPUnit_Framework_TestCase {

	public function testGetName() {
		$multiValueConstrain = new MultiValueConstraint();
		$this->assertEquals( 'multivalue', $multiValueConstrain->getName() );
	}

}
