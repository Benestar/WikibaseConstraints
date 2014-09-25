<?php

namespace Wikibase\Test;

use DataValues\NumberValue;
use Wikibase\Constraints\Constraint\DiffRangeConstraint;
use Wikibase\DataModel\Snak\PropertyValueSnak;
use Wikibase\DataModel\Statement\StatementList;

/**
 * @covers Wikibase\Constraints\Constraint\DiffRangeConstraint
 *
 * @license GNU GPL v2+
 * @author Bene* < benestar.wikimedia@gmail.com >
 */
class DiffRangeConstraintTest extends \PHPUnit_Framework_TestCase {

	public function testValidateStatements_returnsTrue() {
		$diffRangeConstraint = new DiffRangeConstraint( new NumberValue( 5 ) );
		$statements = new StatementList();
		$statements->addNewStatement( new PropertyValueSnak( 42, new NumberValue( 2 ) ) );
		$statements->addNewStatement( new PropertyValueSnak( 42, new NumberValue( 5 ) ) );
		$this->assertTrue( $diffRangeConstraint->validateStatements( $statements ) );
	}

	public function testValidateStatements_returnsFalse() {
		$diffRangeConstraint = new DiffRangeConstraint( new NumberValue( 5 ) );
		$statements = new StatementList();
		$statements->addNewStatement( new PropertyValueSnak( 42, new NumberValue( 2 ) ) );
		$statements->addNewStatement( new PropertyValueSnak( 42, new NumberValue( 9 ) ) );
		$this->assertFalse( $diffRangeConstraint->validateStatements( $statements ) );
	}

	public function testGetName() {
		$diffRangeConstraint = new DiffRangeConstraint( new NumberValue( 42 ) );
		$this->assertEquals( 'diffrange', $diffRangeConstraint->getName() );
	}

	public function testEquals() {
		$diffRangeConstraint1 = new DiffRangeConstraint( new NumberValue( 42 ) );
		$diffRangeConstraint2 = new DiffRangeConstraint( new NumberValue( 42 ) );

		$this->assertTrue( $diffRangeConstraint1->equals( $diffRangeConstraint2 ) );
		$this->assertTrue( $diffRangeConstraint1->equals( $diffRangeConstraint1 ) );
	}

	public function testNotEquals() {
		$diffRangeConstraint1 = new DiffRangeConstraint( new NumberValue( 42 ) );
		$diffRangeConstraint2 = new DiffRangeConstraint( new NumberValue( 24 ) );

		$this->assertFalse( $diffRangeConstraint1->equals( $diffRangeConstraint2 ) );
		$this->assertFalse( $diffRangeConstraint1->equals( null ) );
	}

}
