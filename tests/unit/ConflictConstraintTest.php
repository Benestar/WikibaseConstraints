<?php

namespace Wikibase\Test;

use DataValues\NumberValue;
use DataValues\StringValue;
use Wikibase\Constraints\ConflictConstraint;
use Wikibase\DataModel\Snak\PropertyNoValueSnak;
use Wikibase\DataModel\Snak\PropertyValueSnak;
use Wikibase\DataModel\Snak\Snak;
use Wikibase\DataModel\Statement\StatementList;

/**
 * @covers Wikibase\Constraints\ConflictConstraint
 *
 * @license GNU GPL v2+
 * @author Bene* < benestar.wikimedia@gmail.com >
 */
class ConflictConstraintTest extends \PHPUnit_Framework_TestCase {

	private function newInstance() {
		return new ConflictConstraint( new PropertyNoValueSnak( 42 ) );
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

		$conflictingSnak = new PropertyValueSnak( 42, new StringValue( 'conflict' ) );

		$statements = new StatementList();
		$statements->addNewStatement( new PropertyNoValueSnak( 42 ) );
		$statements->addNewStatement( new PropertyValueSnak( 23, new NumberValue( 123 ) ) );

		$cases[] = array(
			new PropertyNoValueSnak( 42 ),
			$conflictingSnak,
			$statements,
			true
		);

		$statements = new StatementList();
		$statements->addNewStatement( new PropertyValueSnak( 42, new StringValue( 'foo bar' ) ) );
		$statements->addNewStatement( new PropertyValueSnak( 23, new NumberValue( 123 ) ) );

		$cases[] = array(
			new PropertyNoValueSnak( 42 ),
			$conflictingSnak,
			$statements,
			true
		);

		$statements = new StatementList();
		$statements->addNewStatement( new PropertyValueSnak( 42, new StringValue( 'conflict' ) ) );
		$statements->addNewStatement( new PropertyValueSnak( 23, new NumberValue( 123 ) ) );

		$cases[] = array(
			new PropertyNoValueSnak( 42 ),
			$conflictingSnak,
			$statements,
			false
		);

		return $cases;
	}

	/**
	 * @dataProvider provideCheckSnak
	 *
	 * @param Snak $snak
	 * @param Snak $conflictingSnak
	 * @param StatementList $statements
	 * @param boolean $expected
	 */
	public function testCheckSnak( Snak $snak, Snak $conflictingSnak, StatementList $statements, $expected ) {
		$conflictConstraint = new ConflictConstraint( $conflictingSnak );
		$this->assertEquals( $expected, $conflictConstraint->checkSnak( $snak, $statements ) );
	}

	public function testGetName() {
		$this->assertEquals( 'conflict', $this->newInstance()->getName() );
	}

}
