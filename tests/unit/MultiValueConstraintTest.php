<?php

namespace Wikibase\Test;

use DataValues\NumberValue;
use DataValues\StringValue;
use Wikibase\Constraints\MultiValueConstraint;
use Wikibase\DataModel\Snak\PropertyNoValueSnak;
use Wikibase\DataModel\Snak\PropertyValueSnak;
use Wikibase\DataModel\Snak\Snak;
use Wikibase\DataModel\Statement\StatementList;

/**
 * @covers Wikibase\Constraints\MultiValueConstraint
 *
 * @license GNU GPL v2+
 * @author Bene* < benestar.wikimedia@gmail.com >
 */
class MultiValueConstraintTest extends \PHPUnit_Framework_TestCase {

	private function newInstance() {
		return new MultiValueConstraint();
	}

	public function provideSupportsSnak() {
		$cases = array();

		$cases[] = array(
			new PropertyNoValueSnak( 42 ),
			true
		);

		$cases[] = array(
			new PropertyValueSnak( 42, new StringValue( 'foo' ) ),
			true
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

		$statements = new StatementList();
		$statements->addNewStatement( new PropertyNoValueSnak( 42 ) );
		$statements->addNewStatement( new PropertyNoValueSnak( 42 ) );
		$statements->addNewStatement( new PropertyNoValueSnak( 23 ) );

		$cases[] = array(
			new PropertyNoValueSnak( 42 ),
			$statements,
			true
		);

		$cases[] = array(
			new PropertyNoValueSnak( 23 ),
			$statements,
			false
		);

		$cases[] = array(
			new PropertyNoValueSnak( 11 ),
			$statements,
			false
		);

		return $cases;
	}

	/**
	 * @dataProvider provideCheckSnak
	 *
	 * @param Snak $snak
	 * @param StatementList $statements
	 * @param boolean $expected
	 */
	public function testCheckSnak( Snak $snak, StatementList $statements, $expected ) {
		$this->assertEquals( $expected, $this->newInstance()->checkSnak( $snak, $statements ) );
	}

	public function testGetName() {
		$this->assertEquals( 'multivalue', $this->newInstance()->getName() );
	}

}
