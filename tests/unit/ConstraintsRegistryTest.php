<?php

namespace Wikibase\Test;

use OutOfBoundsException;
use Wikibase\Constraints\Constraint;
use Wikibase\Constraints\ConstraintsRegistry;
use Wikibase\DataModel\Entity\PropertyId;
use Wikibase\DataModel\Snak\PropertyNoValueSnak;
use Wikibase\DataModel\Snak\Snak;
use Wikibase\DataModel\Statement\StatementList;

/**
 * @covers Wikibase\Constraints\ConstraintsRegistry
 *
 * @license GNU GPL v2+
 * @author Bene* < benestar.wikimedia@gmail.com >
 */
class ConstraintsRegistryTest extends \PHPUnit_Framework_TestCase {

	public function provideGetConstraintsForPropertyId() {
		$cases = array();

		$cases[] = array(
			new PropertyId( 'P42' ),
			array( 'c1', 'c5' )
		);

		$cases[] = array(
			new PropertyId( 'P32' ),
			array( 'c2', 'c4' )
		);

		$cases[] = array(
			new PropertyId( 'P10' ),
			array( 'c3' )
		);

		return $cases;
	}

	/**
	 * @dataProvider provideGetConstraintsForPropertyId
	 *
	 * @param ProperyId $propertyId
	 * @param string[] $expectedConstraintNames
	 */
	public function testGetConstraintsForPropertyId( PropertyId $propertyId, array $expectedConstraintNames ) {
		$constraintRegistry = $this->getConstraintsRegistryWithConstraints();
		$constraints = $constraintRegistry->getConstraints( $propertyId );
		$constraintNames = array_map( function( Constraint $constraint ) {
			return $constraint->getName();
		}, $constraints->toArray() );
		$this->assertEquals( $expectedConstraintNames, $constraintNames );
	}

	/**
	 * @expectedException OutOfBoundsException
	 */
	public function testGetConstraintsForPropertyIdFails() {
		$constraintRegistry = $this->getConstraintsRegistryWithConstraints();
		$constraintRegistry->getConstraints( new PropertyId( 'P11' ) );
	}

	public function testHasConstraintsForPropertyId() {
		$constraintRegistry = $this->getConstraintsRegistryWithConstraints();
		$this->assertTrue( $constraintRegistry->hasConstraints( new PropertyId( 'P42' ) ) );
		$this->assertTrue( $constraintRegistry->hasConstraints( new PropertyId( 'P10' ) ) );
		$this->assertFalse( $constraintRegistry->hasConstraints( new PropertyId( 'P11' ) ) );
	}

	public function provideApplyConstraints() {
		$cases = array();

		$statements = new StatementList();

		$cases[] = array(
			$statements,
			array()
		);

		$statements = new StatementList();
		$statements->addNewStatement( new PropertyNoValueSnak( 11 ) );

		$cases[] = array(
			$statements,
			array()
		);

		$statements = new StatementList();
		$statements->addNewStatement( new PropertyNoValueSnak( 42 ) );
		$statements->addNewStatement( new PropertyNoValueSnak( 10 ) );
		$statements->addNewStatement( new PropertyNoValueSnak( 11 ) );

		$cases[] = array(
			$statements,
			array()
		);

		$statements = new StatementList();
		$statements->addNewStatement( new PropertyNoValueSnak( 42 ) );
		$statements->addNewStatement( new PropertyNoValueSnak( 11 ) );
		$statements->addNewStatement( new PropertyNoValueSnak( 12 ) );

		$cases[] = array(
			$statements,
			array( 'P12' => array( 'c6' ) )
		);

		$statements = new StatementList();
		$statements->addNewStatement( new PropertyNoValueSnak( 42 ) );
		$statements->addNewStatement( new PropertyNoValueSnak( 32 ) );
		$statements->addNewStatement( new PropertyNoValueSnak( 11 ) );

		$cases[] = array(
			$statements,
			array( 'P32' => array( 'c2', 'c4' ) )
		);

		$statements = new StatementList();
		$statements->addNewStatement( new PropertyNoValueSnak( 42 ) );
		$statements->addNewStatement( new PropertyNoValueSnak( 32 ) );
		$statements->addNewStatement( new PropertyNoValueSnak( 12 ) );

		$cases[] = array(
			$statements,
			array(
				'P32' => array( 'c2', 'c4' ),
				'P12' => array( 'c6' )
			)
		);

		return $cases;
	}

	/**
	 * @dataProvider provideApplyConstraints
	 *
	 * @param StatementList $statements
	 * @param string[] $expectedFailures
	 */
	public function testApplyConstraints( StatementList $statements, $expectedFailures ) {
		$constraintsRegistry = $this->getConstraintsRegistryWithConstraints();
		$failures = $constraintsRegistry->applyConstraints( $statements );
		$this->assertEquals( $expectedFailures, $failures );
	}

	private function getConstraintsRegistryWithConstraints() {
		$constraintsRegistry = new ConstraintsRegistry();
		$constraintsRegistry->registerConstraint(
			new PropertyId( 'P42' ),
			$this->getConstraintMock( true, 'c1' )
		);
		$constraintsRegistry->registerConstraint(
			new PropertyId( 'P32' ),
			$this->getConstraintMock( false, 'c2' )
		);
		$constraintsRegistry->registerConstraint(
			new PropertyId( 'P10' ),
			$this->getConstraintMock( true, 'c3' )
		);
		$constraintsRegistry->registerConstraint(
			new PropertyId( 'P32' ),
			$this->getConstraintMock( false, 'c4' )
		);
		$constraintsRegistry->registerConstraint(
			new PropertyId( 'P42' ),
			$this->getConstraintMock( true, 'c5' )
		);
		$constraintsRegistry->registerConstraint(
			new PropertyId( 'P12' ),
			$this->getConstraintMock( false, 'c6' )
		);
		return $constraintsRegistry;
	}

	/**
	 * @param boolean $failure
	 * @param string $name
	 * @return Constraint
	 */
	private function getConstraintMock( $failure, $name ) {
		$constraint = $this->getMock( 'Wikibase\Constraints\Constraint' );

		$constraint->expects( $this->any() )
			->method( 'validateStatements' )
			->will( $this->returnValue( $failure ) );

		$constraint->expects( $this->any() )
			->method( 'getName' )
			->will( $this->returnValue( $name ) );

		return $constraint;
	}

}
