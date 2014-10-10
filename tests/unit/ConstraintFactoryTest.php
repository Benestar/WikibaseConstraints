<?php

namespace Wikibase\Test;

use DataValues\NumberValue;
use Wikibase\Constraints\Constraint\ConflictConstraint;
use Wikibase\Constraints\Constraint\DataValueConstraint;
use Wikibase\Constraints\Constraint\DiffRangeConstraint;
use Wikibase\Constraints\Constraint\FormatChecker;
use Wikibase\Constraints\Constraint\MultiValueConstraint;
use Wikibase\Constraints\Constraint\OneOfChecker;
use Wikibase\Constraints\Constraint\RangeChecker;
use Wikibase\Constraints\Constraint\SingleValueConstraint;
use Wikibase\Constraints\Constraint\SnakConstraint;
use Wikibase\Constraints\ConstraintFactory;
use Wikibase\DataModel\Snak\PropertyNoValueSnak;

/**
 * @covers Wikibase\Constraints\ConstraintFactory
 *
 * @license GNU GPL v2+
 * @author Bene* < benestar.wikimedia@gmail.com >
 */
class ConstraintFactoryTest extends \PHPUnit_Framework_TestCase {

	public function testNewSnakConstraint() {
		$constraintFactory = new ConstraintFactory();
		$snak = new PropertyNoValueSnak( 42 );
		$constraint = $constraintFactory->newSnakConstraint( $snak );

		$this->assertInstanceOf( 'Wikibase\Constraints\Constraint\SnakConstraint', $constraint );
		$this->assertEquals( new SnakConstraint( $snak ), $constraint );
	}

	public function testNewConflictConstraint() {
		$constraintFactory = new ConstraintFactory();
		$snak = new PropertyNoValueSnak( 42 );
		$constraint = $constraintFactory->newConflictConstraint( $snak );

		$this->assertInstanceOf( 'Wikibase\Constraints\Constraint\ConflictConstraint', $constraint );
		$this->assertEquals( new ConflictConstraint( $snak ), $constraint );
	}

	public function testNewSingleValueConstraint() {
		$constraintFactory = new ConstraintFactory();
		$constraint = $constraintFactory->newSingleValueConstraint();

		$this->assertInstanceOf( 'Wikibase\Constraints\Constraint\SingleValueConstraint', $constraint );
		$this->assertEquals( new SingleValueConstraint(), $constraint );
	}

	public function testNewMultiValueConstraint() {
		$constraintFactory = new ConstraintFactory();
		$constraint = $constraintFactory->newMultiValueConstraint();

		$this->assertInstanceOf( 'Wikibase\Constraints\Constraint\MultiValueConstraint', $constraint );
		$this->assertEquals( new MultiValueConstraint(), $constraint );
	}

	public function testNewDiffRangeConstraint() {
		$constraintFactory = new ConstraintFactory();
		$constraint = $constraintFactory->newDiffRangeConstraint( new NumberValue( 42 ) );

		$this->assertInstanceOf( 'Wikibase\Constraints\Constraint\DiffRangeConstraint', $constraint );
		$this->assertEquals( new DiffRangeConstraint( new NumberValue( 42 ) ), $constraint );
	}

	public function testNewFormatConstraint() {
		$constraintFactory = new ConstraintFactory();
		$constraint = $constraintFactory->newFormatConstraint( 'foo bar' );

		$this->assertInstanceOf( 'Wikibase\Constraints\Constraint\DataValueConstraint', $constraint );
		$this->assertEquals( new DataValueConstraint( new FormatChecker( 'foo bar' ) ), $constraint );
	}

	public function testNewOneOfConstraint() {
		$constraintFactory = new ConstraintFactory();
		$constraint = $constraintFactory->newOneOfConstraint( array( new NumberValue( 42 ) ) );

		$this->assertInstanceOf( 'Wikibase\Constraints\Constraint\DataValueConstraint', $constraint );
		$this->assertEquals( new DataValueConstraint( new OneOfChecker( array( new NumberValue( 42 ) ) ) ), $constraint );
	}

	public function testNewRangeConstraint() {
		$constraintFactory = new ConstraintFactory();
		$constraint = $constraintFactory->newRangeConstraint( new NumberValue( 1 ), new NumberValue( 2 ) );

		$this->assertInstanceOf( 'Wikibase\Constraints\Constraint\DataValueConstraint', $constraint );
		$this->assertEquals( new DataValueConstraint( new RangeChecker( new NumberValue( 1 ), new NumberValue( 2 ) ) ), $constraint );
	}

}
