<?php

namespace Wikibase\Test;

use Wikibase\Constraints\Constraint\ConflictConstraint;
use Wikibase\DataModel\Snak\PropertyNoValueSnak;
use Wikibase\DataModel\Snak\PropertySomeValueSnak;
use Wikibase\DataModel\Statement\StatementList;

/**
 * @covers Wikibase\Constraints\Constraint\ConflictConstraint
 *
 * @license GNU GPL v2+
 * @author Bene* < benestar.wikimedia@gmail.com >
 */
class ConflictConstraintTest extends \PHPUnit_Framework_TestCase {

	public function testValidateStatements_returnsTrue() {
		$conflictConstraint = new ConflictConstraint( new PropertyNoValueSnak( 42 ) );
		$statements = new StatementList();
		$statements->addNewStatement( new PropertySomeValueSnak( 42 ) );
		$this->assertTrue( $conflictConstraint->validateStatements( $statements ) );
	}

	public function testValidateStatements_returnsFalse() {
		$conflictConstraint = new ConflictConstraint( new PropertyNoValueSnak( 42 ) );
		$statements = new StatementList();
		$statements->addNewStatement( new PropertyNoValueSnak( 42 ) );
		$this->assertFalse( $conflictConstraint->validateStatements( $statements ) );
	}

	public function testGetName() {
		$conflictConstraint = new ConflictConstraint( new PropertyNoValueSnak( 42 ) );
		$this->assertEquals( 'conflict', $conflictConstraint->getName() );
	}

	public function testEquals() {
		$conflictConstraint1 = new ConflictConstraint( new PropertyNoValueSnak( 42 ) );
		$conflictConstraint2 = new ConflictConstraint( new PropertyNoValueSnak( 42 ) );

		$this->assertTrue( $conflictConstraint1->equals( $conflictConstraint2 ) );
		$this->assertTrue( $conflictConstraint1->equals( $conflictConstraint1 ) );
	}

	public function testNotEquals() {
		$conflictConstraint1 = new ConflictConstraint( new PropertyNoValueSnak( 42 ) );
		$conflictConstraint2 = new ConflictConstraint( new PropertySomeValueSnak( 42 ) );

		$this->assertFalse( $conflictConstraint1->equals( $conflictConstraint2 ) );
		$this->assertFalse( $conflictConstraint1->equals( null ) );
	}

}
