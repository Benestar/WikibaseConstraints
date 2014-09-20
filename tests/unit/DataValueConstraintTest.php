<?php

namespace Wikibase\Test;

use DataValues\StringValue;
use Wikibase\Constraints\DataValueConstraint;
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

	public function provideValidateStatements() {
		$cases = array();

		$statements = new StatementList();
		$statements->addNewStatement( new PropertyNoValueSnak( 42 ) );

		$cases[] = array( true, true, $statements, true );
		$cases[] = array( false, true, $statements, true );
		$cases[] = array( true, false, $statements, true );
		$cases[] = array( false, false, $statements, true );

		$statements = new StatementList();
		$statements->addNewStatement( new PropertyValueSnak( 42, new StringValue( 'foo bar' ) ) );

		$cases[] = array( true, true, $statements, true );
		$cases[] = array( false, true, $statements, true );
		$cases[] = array( true, false, $statements, false );
		$cases[] = array( false, false, $statements, true );

		return $cases;
	}

	/**
	 * @dataProvider provideValidateStatements
	 *
	 * @param boolean $supportsDataValue
	 * @param boolean $checkDataValue
	 * @param StatementList $statements
	 * @param boolean $expected
	 */
	public function testValidateStatements( $supportsDataValue, $checkDataValue, StatementList $statements, $expected ) {
		$dataValueConstraint = new DataValueConstraint( $this->getDataValueCheckerMock( $supportsDataValue, $checkDataValue ) );
		$validated = $dataValueConstraint->validateStatements( $statements );
		$this->assertEquals( $expected, $validated );
	}

	/**
	 * @param boolean $supportsDataValue
	 * @param boolean $checkDataValue
	 * @return DataValueChecker
	 */
	private function getDataValueCheckerMock( $supportsDataValue, $checkDataValue ) {
		$dataValueChecker = $this->getMock( 'Wikibase\Constraints\DataValueChecker' );

		$dataValueChecker->expects( $this->any() )
			->method( 'supportsDataValue' )
			->will( $this->returnValue( $supportsDataValue ) );

		
		$dataValueChecker->expects( $this->any() )
			->method( 'checkDataValue' )
			->will( $this->returnValue( $checkDataValue ) );

		return $dataValueChecker;
	}

}
