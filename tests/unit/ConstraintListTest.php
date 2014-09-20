<?php

namespace Wikibase\Test;

use InvalidArgumentException;
use Wikibase\Constraints\ConstraintList;
use Wikibase\Constraints\MultiValueConstraint;
use Wikibase\Constraints\SingleValueConstraint;
use Wikibase\DataModel\Snak\PropertyNoValueSnak;
use Wikibase\DataModel\Statement\StatementList;

/**
 * @covers Wikibase\Constraints\ConstraintList
 *
 * @license GNU GPL V2+
 * @author Bene* < benestar.wikimedia@gmail.com >
 */
class ConstraintListTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testConstructionFails() {
		new ConstraintList( array( null ) );
	}

	public function testApplyConstraints() {
		$statements = new StatementList();
		$statements->addNewStatement( new PropertyNoValueSnak( 42 ) );

		$constraintList = new ConstraintList( array( new SingleValueConstraint() ) );
		$this->assertEmpty( $constraintList->applyConstraints( $statements ) );

		$statements->addNewStatement( new PropertyNoValueSnak( 42 ) );
		$this->assertEquals( array( 'singlevalue' ), $constraintList->applyConstraints( $statements ) );

		$statements = new StatementList();
		$constraintList->addConstraint( new MultiValueConstraint() );
		$this->assertEquals( array( 'singlevalue', 'multivalue' ), $constraintList->applyConstraints( $statements ) );
	}

	public function testGetIterator() {
		$constraintList = new ConstraintList( array(
			new SingleValueConstraint(),
			new MultiValueConstraint()
		) );
		$this->assertEquals( 2, $constraintList->getIterator()->count() );
	}

	public function testToArray() {
		$array = array( new SingleValueConstraint(), new MultiValueConstraint() );
		$constraintList = new ConstraintList( $array );
		$this->assertEquals( $array, $constraintList->toArray() );
	}

	public function testCount() {
		$constraintList = new ConstraintList();
		$this->assertEquals( 0, $constraintList->count() );

		$constraintList->addConstraint( new SingleValueConstraint() );
		$this->assertEquals( 1, $constraintList->count() );

		$constraintList->addConstraint( new MultiValueConstraint() );
		$this->assertEquals( 2, $constraintList->count() );
	}

	public function testEquals() {
		$constraintList1 = new ConstraintList( array( new SingleValueConstraint() ) );
		$constraintList2 = new ConstraintList( array( new SingleValueConstraint() ) );

		$this->assertTrue( $constraintList1->equals( $constraintList2 ) );
	}

	public function testNotEquals() {
		$constraintList1 = new ConstraintList( array( new SingleValueConstraint() ) );
		$constraintList2 = new ConstraintList( array( new MultiValueConstraint() ) );

		$this->assertFalse( $constraintList1->equals( $constraintList2 ) );
	}

	public function testIsEmpty() {
		$constraintList = new ConstraintList();
		$this->assertTrue( $constraintList->isEmpty() );
	}

	public function testIsNotEmpty() {
		$constraintList = new ConstraintList( array( new SingleValueConstraint() ) );
		$this->assertFalse( $constraintList->isEmpty() );
	}

}
