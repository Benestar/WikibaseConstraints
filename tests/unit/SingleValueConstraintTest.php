<?php

namespace Wikibase\Test;

use DataValues\NumberValue;
use DataValues\StringValue;
use Wikibase\Constraints\SingleValueConstraint;
use Wikibase\DataModel\Snak\PropertyNoValueSnak;
use Wikibase\DataModel\Snak\PropertyValueSnak;
use Wikibase\DataModel\Snak\Snak;
use Wikibase\DataModel\Statement\StatementList;

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
