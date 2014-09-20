<?php

namespace Wikibase\Test;

use DataValues\DataValue;
use DataValues\NumberValue;
use DataValues\StringValue;
use InvalidArgumentException;
use Wikibase\Constraints\RangeConstraint;
use Wikibase\DataModel\Snak\PropertyNoValueSnak;
use Wikibase\DataModel\Snak\PropertyValueSnak;
use Wikibase\DataModel\Snak\Snak;
use Wikibase\DataModel\Statement\StatementList;

/**
 * @covers Wikibase\Constraints\RangeConstraint
 *
 * @license GNU GPL v2+
 * @author Bene* < benestar.wikimedia@gmail.com >
 */
class RangeConstraintTest extends \PHPUnit_Framework_TestCase {

	private function newInstance() {
		return new RangeConstraint( new NumberValue( 1 ), new NumberValue( 3 ) );
	}

	public function provideSupportsSnak() {
		$cases = array();

		$cases[] = array(
			new PropertyNoValueSnak( 42 ),
			false
		);

		$cases[] = array(
			new PropertyValueSnak( 42, new StringValue( 'foo' ) ),
			false
		);

		$cases[] = array(
			new PropertyValueSnak( 42, new NumberValue( 123 ) ),
			true
		);

		return $cases;
	}

	/**
	 * @dataProvider provideSupportsSnak
	 *
	 * @param Snak $snak
	 * @param boolean $expected
	 */
	public function testSupportsSnak( Snak $snak, $expected ) {
		$this->assertEquals( $expected, $this->newInstance()->supportsSnak( $snak ) );
	}

	public function provideCheckSnak() {
		$cases = array();

		$cases[] = array(
			new PropertyValueSnak( 42, new NumberValue( 5 ) ),
			new NumberValue( 1 ),
			new NumberValue( 10 ),
			true
		);

		$cases[] = array(
			new PropertyValueSnak( 42, new NumberValue( 10 ) ),
			new NumberValue( 1 ),
			new NumberValue( 10 ),
			true
		);

		$cases[] = array(
			new PropertyValueSnak( 42, new NumberValue( 1 ) ),
			new NumberValue( 1 ),
			new NumberValue( 10 ),
			true
		);

		$cases[] = array(
			new PropertyValueSnak( 42, new NumberValue( 0 ) ),
			new NumberValue( 1 ),
			new NumberValue( 10 ),
			false
		);

		$cases[] = array(
			new PropertyValueSnak( 42, new NumberValue( 12 ) ),
			new NumberValue( 1 ),
			new NumberValue( 10 ),
			false
		);

		$cases[] = array(
			new PropertyValueSnak( 42, new NumberValue( 4 ) ),
			new NumberValue( 4 ),
			new NumberValue( 4 ),
			true
		);

		$cases[] = array(
			new PropertyValueSnak( 42, new NumberValue( 7 ) ),
			new NumberValue( 4 ),
			new NumberValue( 4 ),
			false
		);

		return $cases;
	}

	/**
	 * @dataProvider provideCheckSnak
	 *
	 * @param Snak $snak
	 * @param DataValue $minValue
	 * @param DataValue $maxValue
	 * @param boolean $expected
	 */
	public function testCheckSnak( Snak $snak, DataValue $minValue, DataValue $maxValue, $expected ) {
		$rangeConstraint = new RangeConstraint( $minValue, $maxValue );
		$this->assertEquals( $expected, $rangeConstraint->checkSnak( $snak, new StatementList() ) );
	}

	public function provideCheckSnakFails() {
		$cases = array();

		$cases[] = array(
			new PropertyNoValueSnak( 42 )
		);

		$cases[] = array(
			new PropertyValueSnak( 42, new StringValue( 'foo bar' ) )
		);

		return $cases;
	}

	/**
	 * @dataProvider provideCheckSnakFails
	 * @expectedException InvalidArgumentException
	 *
	 * @param Snak $snak
	 */
	public function testCheckSnakFails( Snak $snak ) {
		$this->newInstance()->checkSnak( $snak, new StatementList() );
	}

	public function provideConstructionFails() {
		$cases = array();

		$cases[] = array(
			new StringValue( 'foo bar' ),
			new NumberValue( 123 )
		);

		$cases[] = array(
			new NumberValue( 10 ),
			new NumberValue( 1 )
		);

		return $cases;
	}

	/**
	 * @dataProvider provideConstructionFails
	 * @expectedException InvalidArgumentException
	 *
	 * @param DataValue $minValue
	 * @param DataValue $maxValue
	 */
	public function testConstructionFails( DataValue $minValue, DataValue $maxValue ) {
		new RangeConstraint( $minValue, $maxValue );
	}

	public function testGetName() {
		$this->assertEquals( 'range', $this->newInstance()->getName() );
	}

}
