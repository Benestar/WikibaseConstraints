<?php

namespace Wikibase\Test;

use DataValues\NumberValue;
use DataValues\StringValue;
use Wikibase\Constraints\DataValueConstraint;
use Wikibase\Constraints\FormatChecker;
use Wikibase\Constraints\OneOfChecker;
use Wikibase\DataModel\Snak\PropertyNoValueSnak;
use Wikibase\DataModel\Snak\PropertyValueSnak;
use Wikibase\DataModel\Statement\StatementList;

/**
 * @covers Wikibase\Constraints\DataValueConstraint
 *
 * @license GNU GPL v2+
 * @author Bene* < benestar.wikimedia@gmail.com >
 */
class DataValueConstraintTest extends \PHPUnit_Framework_TestCase {

	public function testValidateStatements_returnsTrue() {
		$dataValueConstraint = new DataValueConstraint( new FormatChecker( '/foo/' ) );
		$statements = new StatementList();
		$statements->addNewStatement( new PropertyNoValueSnak( 42 ) );
		$statements->addNewStatement( new PropertyValueSnak( 42, new NumberValue( 123 ) ) );
		$statements->addNewStatement( new PropertyValueSnak( 42, new StringValue( 'foo bar' ) ) );
		$this->assertTrue( $dataValueConstraint->validateStatements( $statements ) );
	}

	public function testValidateStatements_returnsFalse() {
		$dataValueConstraint = new DataValueConstraint( new FormatChecker( '/foo/' ) );
		$statements = new StatementList();
		$statements->addNewStatement( new PropertyNoValueSnak( 42 ) );
		$statements->addNewStatement( new PropertyValueSnak( 42, new NumberValue( 123 ) ) );
		$statements->addNewStatement( new PropertyValueSnak( 42, new StringValue( 'bar' ) ) );
		$this->assertFalse( $dataValueConstraint->validateStatements( $statements ) );
	}

	public function testGetName() {
		$dataValueConstraintFormat = new DataValueConstraint( new FormatChecker( '' ) );
		$this->assertEquals( 'format', $dataValueConstraintFormat->getName() );
		$dataValueConstraintOneOf = new DataValueConstraint( new OneOfChecker( array() ) );
		$this->assertEquals( 'oneof', $dataValueConstraintOneOf->getName() );
	}

	public function testEquals() {
		$dataValueConstraint1 = new DataValueConstraint( new FormatChecker( 'foo' ) );
		$dataValueConstraint2 = new DataValueConstraint( new FormatChecker( 'foo' ) );

		$this->assertTrue( $dataValueConstraint1->equals( $dataValueConstraint2 ) );
		$this->assertTrue( $dataValueConstraint1->equals( $dataValueConstraint1 ) );
	}

	public function testNotEquals() {
		$dataValueConstraint1 = new DataValueConstraint( new FormatChecker( 'foo' ) );
		$dataValueConstraint2 = new DataValueConstraint( new FormatChecker( 'bar' ) );

		$this->assertFalse( $dataValueConstraint1->equals( $dataValueConstraint2 ) );
		$this->assertFalse( $dataValueConstraint1->equals( null ) );
	}

}
