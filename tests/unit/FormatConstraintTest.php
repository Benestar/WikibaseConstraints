<?php

namespace Wikibase\Test;

use DataValues\NumberValue;
use DataValues\StringValue;
use Wikibase\Constraints\FormatConstraint;
use Wikibase\DataModel\Snak\PropertyNoValueSnak;
use Wikibase\DataModel\Snak\PropertyValueSnak;
use Wikibase\DataModel\Snak\Snak;
use Wikibase\DataModel\Statement\StatementList;

/**
 * @covers Wikibase\Constraints\FormatConstraint
 *
 * @license GNU GPL v2+
 * @author Bene* < benestar.wikimedia@gmail.com >
 */
class FormatConstraintTest extends \PHPUnit_Framework_TestCase {

	public function provideSupportsSnak() {
		$cases = array();

		$cases[] = array(
			new PropertyNoValueSnak( 42 ),
			false
		);

		$cases[] = array(
			new PropertyValueSnak( 42, new NumberValue( 123 ) ),
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
		$formatConstraint = new FormatConstraint( '' );
		$this->assertEquals( $expected, $formatConstraint->supportsSnak( $snak ) );
	}

	public function provideCheckSnak() {
		$cases = array();

		$cases[] = array(
			new PropertyValueSnak( 42, new StringValue( 'foo bar' ) ),
			'/foo/',
			true
		);

		$cases[] = array(
			new PropertyValueSnak( 42, new StringValue( 'foo bar' ) ),
			'/baz/',
			false
		);

		$cases[] = array(
			new PropertyValueSnak( 42, new StringValue( 'foo bar' ) ),
			'/o+/',
			true
		);

		return $cases;
	}

	/**
	 * @dataProvider provideCheckSnak
	 *
	 * @param Snak $snak
	 * @param string $format
	 * @param boolean $expected
	 */
	public function testCheckSnak( Snak $snak, $format, $expected ) {
		$formatConstraint = new FormatConstraint( $format );
		$this->assertEquals( $expected, $formatConstraint->checkSnak( $snak, new StatementList() ) );
	}

	public function provideCheckSnakFails() {
		$cases = array();

		$cases[] = array(
			new PropertyNoValueSnak( 42 )
		);

		$cases[] = array(
			new PropertyValueSnak( 42, new NumberValue( 123 ) )
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
		$formatConstraint = new FormatConstraint( '' );
		$formatConstraint->checkSnak( $snak, new StatementList() );
	}

}
