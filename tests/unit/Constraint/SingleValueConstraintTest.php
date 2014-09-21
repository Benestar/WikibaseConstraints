<?php

namespace Wikibase\Test;

use Wikibase\Constraints\Constraint\SingleValueConstraint;
use Wikibase\DataModel\Snak\PropertyNoValueSnak;
use Wikibase\DataModel\Snak\PropertySomeValueSnak;
use Wikibase\DataModel\Statement\StatementList;

/**
 * @covers Wikibase\Constraints\Constraint\SingleValueConstraint
 *
 * @license GNU GPL v2+
 * @author Bene* < benestar.wikimedia@gmail.com >
 */
class SingleValueConstraintTest extends \PHPUnit_Framework_TestCase {

	public function testValidateStatements_returnsTrue() {
		$singleValueConstraint = new SingleValueConstraint();
		$statements = new StatementList();
		$statements->addNewStatement( new PropertyNoValueSnak( 42 ) );
		$this->assertTrue( $singleValueConstraint->validateStatements( $statements ) );
	}

	public function testValidateStatements_returnsFalse() {
		$singleValueConstraint = new SingleValueConstraint();
		$statements = new StatementList();
		$statements->addNewStatement( new PropertyNoValueSnak( 42 ) );
		$statements->addNewStatement( new PropertySomeValueSnak( 42 ) );
		$this->assertFalse( $singleValueConstraint->validateStatements( $statements ) );
	}

	public function testGetName() {
		$singleValueConstraint = new SingleValueConstraint();
		$this->assertEquals( 'singlevalue', $singleValueConstraint->getName() );
	}

	public function testEquals() {
		$singleValueConstraint1 = new SingleValueConstraint();
		$singleValueConstraint2 = new SingleValueConstraint();

		$this->assertTrue( $singleValueConstraint1->equals( $singleValueConstraint2 ) );
		$this->assertTrue( $singleValueConstraint1->equals( $singleValueConstraint1 ) );
	}

	public function testNotEquals() {
		$singleValueConstraint = new SingleValueConstraint();

		$this->assertFalse( $singleValueConstraint->equals( null ) );
	}

}
