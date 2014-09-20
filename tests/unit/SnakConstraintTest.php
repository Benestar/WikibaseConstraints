<?php

namespace Wikibase\Test;

use DataValues\NumberValue;
use DataValues\StringValue;
use Wikibase\Constraints\SnakConstraint;
use Wikibase\DataModel\Snak\PropertyNoValueSnak;
use Wikibase\DataModel\Snak\PropertyValueSnak;
use Wikibase\DataModel\Snak\Snak;
use Wikibase\DataModel\Statement\StatementList;

/**
 * @covers Wikibase\Constraints\SnakConstraint
 *
 * @license GNU GPL v2+
 * @author Bene* < benestar.wikimedia@gmail.com >
 */
class SnakConstraintTest extends \PHPUnit_Framework_TestCase {

	private function newInstance() {
		return new SnakConstraint( new PropertyNoValueSnak( 42 ) );
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

		$requiredSnak = new PropertyValueSnak( 42, new StringValue( 'required' ) );

		$statements = new StatementList();
		$statements->addNewStatement( new PropertyNoValueSnak( 42 ) );
		$statements->addNewStatement( new PropertyValueSnak( 23, new NumberValue( 123 ) ) );

		$cases[] = array(
			new PropertyNoValueSnak( 42 ),
			$requiredSnak,
			$statements,
			false
		);

		$statements = new StatementList();
		$statements->addNewStatement( new PropertyValueSnak( 42, new StringValue( 'foo bar' ) ) );
		$statements->addNewStatement( new PropertyValueSnak( 23, new NumberValue( 123 ) ) );

		$cases[] = array(
			new PropertyNoValueSnak( 42 ),
			$requiredSnak,
			$statements,
			false
		);

		$statements = new StatementList();
		$statements->addNewStatement( new PropertyValueSnak( 42, new StringValue( 'required' ) ) );
		$statements->addNewStatement( new PropertyValueSnak( 23, new NumberValue( 123 ) ) );

		$cases[] = array(
			new PropertyNoValueSnak( 42 ),
			$requiredSnak,
			$statements,
			true
		);

		return $cases;
	}

	/**
	 * @dataProvider provideCheckSnak
	 *
	 * @param Snak $snak
	 * @param Snak $requiredSnak
	 * @param StatementList $statements
	 * @param boolean $expected
	 */
	public function testCheckSnak( Snak $snak, Snak $requiredSnak, StatementList $statements, $expected ) {
		$snakConstraint = new SnakConstraint( $requiredSnak );
		$this->assertEquals( $expected, $snakConstraint->checkSnak( $snak, $statements ) );
	}

	public function testGetName() {
		$this->assertEquals( 'snak', $this->newInstance()->getName() );
	}

}
