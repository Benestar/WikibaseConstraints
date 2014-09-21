<?php

namespace Wikibase\Test;

use Wikibase\Constraints\Constraint\SnakConstraint;
use Wikibase\DataModel\Snak\PropertyNoValueSnak;
use Wikibase\DataModel\Snak\PropertySomeValueSnak;
use Wikibase\DataModel\Statement\StatementList;

/**
 * @covers Wikibase\Constraints\Constraint\SnakConstraint
 *
 * @license GNU GPL v2+
 * @author Bene* < benestar.wikimedia@gmail.com >
 */
class SnakConstraintTest extends \PHPUnit_Framework_TestCase {

	public function testValidateStatements_returnsTrue() {
		$snakConstraint = new SnakConstraint( new PropertyNoValueSnak( 42 ) );
		$statements = new StatementList();
		$statements->addNewStatement( new PropertyNoValueSnak( 42 ) );
		$this->assertTrue( $snakConstraint->validateStatements( $statements ) );
	}

	public function testValidateStatements_returnsFalse() {
		$snakConstraint = new SnakConstraint( new PropertyNoValueSnak( 42 ) );
		$statements = new StatementList();
		$statements->addNewStatement( new PropertySomeValueSnak( 42 ) );
		$this->assertFalse( $snakConstraint->validateStatements( $statements ) );
	}

	public function testGetName() {
		$snakConstraint = new SnakConstraint( new PropertyNoValueSnak( 42 ) );
		$this->assertEquals( 'snak', $snakConstraint->getName() );
	}

	public function testEquals() {
		$snakConstraint1 = new SnakConstraint( new PropertyNoValueSnak( 42 ) );
		$snakConstraint2 = new SnakConstraint( new PropertyNoValueSnak( 42 ) );

		$this->assertTrue( $snakConstraint1->equals( $snakConstraint2 ) );
		$this->assertTrue( $snakConstraint1->equals( $snakConstraint1 ) );
	}

	public function testNotEquals() {
		$snakConstraint1 = new SnakConstraint( new PropertyNoValueSnak( 42 ) );
		$snakConstraint2 = new SnakConstraint( new PropertySomeValueSnak( 42 ) );

		$this->assertFalse( $snakConstraint1->equals( $snakConstraint2 ) );
		$this->assertFalse( $snakConstraint1->equals( null ) );
	}

}
