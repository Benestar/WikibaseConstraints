<?php

namespace Wikibase\Test;

use DataValues\DataValue;
use DataValues\NumberValue;
use DataValues\StringValue;
use InvalidArgumentException;
use Wikibase\Constraints\OneOfConstraint;
use Wikibase\DataModel\Snak\PropertyNoValueSnak;
use Wikibase\DataModel\Snak\PropertyValueSnak;
use Wikibase\DataModel\Snak\Snak;
use Wikibase\DataModel\Statement\StatementList;

/**
 * @covers Wikibase\Constraints\OneOfConstraint
 *
 * @license GNU GPL v2+
 * @author Bene* < benestar.wikimedia@gmail.com >
 */
class OneOfConstraintTest extends \PHPUnit_Framework_TestCase {

	private function newInstance() {
		return new OneOfConstraint( array() );
	}

	public function provideSupportsSnak() {
		$cases = array();

		$cases[] = array(
			new PropertyNoValueSnak( 42 ),
			false
		);

		$cases[] = array(
			new PropertyValueSnak( 42, new StringValue( 'foo' ) ),
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

		$values = array(
			new StringValue( 'foo bar' ),
			new StringValue( 'bar foo' )
		);

		$cases[] = array(
			new PropertyValueSnak( 42, new StringValue( 'foo bar' ) ),
			$values,
			true
		);

		$cases[] = array(
			new PropertyValueSnak( 42, new NumberValue( 123 ) ),
			$values,
			false
		);

		$cases[] = array(
			new PropertyValueSnak( 42, new StringValue( 'bar foo' ) ),
			$values,
			true
		);

		$values[] = new NumberValue( 123 );

		$cases[] = array(
			new PropertyValueSnak( 42, new NumberValue( 123 ) ),
			$values,
			true
		);

		return $cases;
	}

	/**
	 * @dataProvider provideCheckSnak
	 *
	 * @param Snak $snak
	 * @param DataValue[] $values
	 * @param boolean $expected
	 */
	public function testCheckSnak( Snak $snak, array $values, $expected ) {
		$oneOfConstraint = new OneOfConstraint( $values );
		$this->assertEquals( $expected, $oneOfConstraint->checkSnak( $snak, new StatementList() ) );
	}

	public function provideCheckSnakFails() {
		$cases = array();

		$cases[] = array(
			new PropertyNoValueSnak( 42 )
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
			array( array(), array() )
		);

		$cases[] = array(
			array( 123, 456, 789 )
		);

		$cases[] = array(
			array( null, null )
		);

		$cases[] = array(
			array(
				new PropertyNoValueSnak( 42 ),
				new PropertyValueSnak( 23, new StringValue( 'foo bar' ) )
			)
		);

		$cases[] = array(
			array(
				new StringValue( 'foo bar' ),
				null,
				new NumberValue( 123 )
			)
		);

		return $cases;
	}

	/**
	 * @dataProvider provideConstructionFails
	 * @expectedException InvalidArgumentException
	 *
	 * @param array $values
	 */
	public function testConstructionFails( array $values ) {
		new OneOfConstraint( $values );
	}

	public function testGetName() {
		$this->assertEquals( 'oneof', $this->newInstance()->getName() );
	}

}
