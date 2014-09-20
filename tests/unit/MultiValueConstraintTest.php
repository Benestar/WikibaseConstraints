<?php

namespace Wikibase\Test;

use Wikibase\Constraints\MultiValueConstraint;
use Wikibase\DataModel\Snak\PropertyNoValueSnak;
use Wikibase\DataModel\Snak\PropertySomeValueSnak;
use Wikibase\DataModel\Statement\StatementList;

/**
 * @covers Wikibase\Constraints\MultiValueConstraint
 *
 * @license GNU GPL v2+
 * @author Bene* < benestar.wikimedia@gmail.com >
 */
class MultiValueConstraintTest extends \PHPUnit_Framework_TestCase {

	public function testValidateStatements_returnsTrue() {
		$multiValueConstraint = new MultiValueConstraint();
		$statements = new StatementList();
		$statements->addNewStatement( new PropertyNoValueSnak( 42 ) );
		$statements->addNewStatement( new PropertySomeValueSnak( 42 ) );
		$this->assertTrue( $multiValueConstraint->validateStatements( $statements ) );
	}

	public function testValidateStatements_returnsFalse() {
		$multiValueConstraint = new MultiValueConstraint();
		$statements = new StatementList();
		$statements->addNewStatement( new PropertyNoValueSnak( 42 ) );
		$this->assertFalse( $multiValueConstraint->validateStatements( $statements ) );
	}

	public function testGetName() {
		$multiValueConstraint = new MultiValueConstraint();
		$this->assertEquals( 'multivalue', $multiValueConstraint->getName() );
	}

	public function testEquals() {
		$multiValueConstraint1 = new MultiValueConstraint();
		$multiValueConstraint2 = new MultiValueConstraint();

		$this->assertTrue( $multiValueConstraint1->equals( $multiValueConstraint2 ) );
		$this->assertTrue( $multiValueConstraint1->equals( $multiValueConstraint1 ) );
	}

	public function testNotEquals() {
		$multiValueConstraint = new MultiValueConstraint();

		$this->assertFals( $multiValueConstraint->equals( null ) );
	}

}
