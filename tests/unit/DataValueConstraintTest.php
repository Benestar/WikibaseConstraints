<?php

namespace Wikibase\Test;

use DataValues\StringValue;
use InvalidArgumentException;
use Wikibase\Constraints\DataValueConstraint;
use Wikibase\DataModel\Snak\PropertyNoValueSnak;
use Wikibase\DataModel\Snak\PropertyValueSnak;
use Wikibase\DataModel\Snak\Snak;
use Wikibase\DataModel\Statement\StatementList;

/**
 * @covers Wikibase\Constraints\DataValueConstraint
 *
 * @license GNU GPL v2+
 * @author Bene* < benestar.wikimedia@gmail.com >
 */
class DataValueConstraintTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @param boolean $supportsDataValue
	 * @param boolean $checkDataValue
	 * @return DataValueConstraint
	 */
	private function newInstance( $supportsDataValue, $checkDataValue ) {
		$dataValueConstraint = $this->getMockForAbstractClass( 'Wikibase\Constraints\DataValueConstraint' );

		$dataValueConstraint->expects( $this->any() )
			->method( 'supportsDataValue' )
			->will( $this->returnValue( $supportsDataValue ) );

		
		$dataValueConstraint->expects( $this->any() )
			->method( 'checkDataValue' )
			->will( $this->returnValue( $checkDataValue ) );

		return $dataValueConstraint;
	}

	public function provideSupportsSnak() {
		$cases = array();

		$cases[] = array(
			new PropertyNoValueSnak( 42 ),
			false,
			false
		);

		$cases[] = array(
			new PropertyNoValueSnak( 42 ),
			true,
			false
		);

		$cases[] = array(
			new PropertyValueSnak( 42, new StringValue( 'foo' ) ),
			false,
			false
		);

		$cases[] = array(
			new PropertyValueSnak( 42, new StringValue( 'foo' ) ),
			true,
			true
		);

		return $cases;
	}

	/**
	 * @dataProvider provideSupportsSnak
	 *
	 * @param Snak $snak
	 * @param boolean $supportsDataValue
	 * @param boolean $expected
	 */
	public function testSupportsSnak( Snak $snak, $supportsDataValue, $expected ) {
		$this->assertEquals( $expected, $this->newInstance( $supportsDataValue, true )->supportsSnak( $snak ) );
	}

	public function provideCheckSnak() {
		$cases = array();

		$cases[] = array(
			new PropertyValueSnak( 42, new StringValue( 'foo' ) ),
			false,
			false
		);

		$cases[] = array(
			new PropertyValueSnak( 42, new StringValue( 'foo' ) ),
			true,
			true
		);

		return $cases;
	}

	/**
	 * @dataProvider provideCheckSnak
	 *
	 * @param Snak $snak
	 * @param boolean $checkDataValue
	 * @param boolean $expected
	 */
	public function testCheckSnak( Snak $snak, $checkDataValue, $expected ) {
		$this->assertEquals( $expected, $this->newInstance( true, $checkDataValue )->checkSnak( $snak, new StatementList() ) );
	}

	public function provideCheckSnakFails() {
		$cases = array();

		$cases[] = array(
			new PropertyNoValueSnak( 42 ),
			false
		);

		$cases[] = array(
			new PropertyNoValueSnak( 42 ),
			true
		);

		$cases[] = array(
			new PropertyValueSnak( 42, new StringValue( 'foo' ) ),
			false
		);

		return $cases;
	}

	/**
	 * @dataProvider provideCheckSnakFails
	 * @expectedException InvalidArgumentException
	 *
	 * @param Snak $snak
	 */
	public function testCheckSnakFails( Snak $snak, $supportsDataValue ) {
		$this->newInstance( $supportsDataValue, false )->checkSnak( $snak, new StatementList() );
	}

}
