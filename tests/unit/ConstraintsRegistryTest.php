<?php

namespace Wikibase\Test;

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

	public function provideGetConstraintsForSnak() {
		$cases = array();

		$cases[] = array(
			new PropertyNoValueSnak( 42 ),
			array( 'c1' )
		);

		$cases[] = array(
			new PropertyNoValueSnak( 32 ),
			array( 'c2', 'c4' )
		);

		$cases[] = array(
			new PropertyNoValueSnak( 10 ),
			array()
		);

		return $cases;
	}

	/**
	 * @dataProvider provideGetConstraintsForSnak
	 *
	 * @param Snak $snak
	 * @param string[] $expectedConstraintNames
	 */
	public function testGetConstraintsForSnak( Snak $snak, array $expectedConstraintNames ) {
		$constraintsRegistry = $this->getConstraintsRegistryWithConstraints();
		$constraints = $constraintsRegistry->getConstraintsForSnak( $snak );
		$constraintNames = array_map( function( Constraint $constraint ) {
			return $constraint->getName();
		}, $constraints );
		$this->assertEquals( $expectedConstraintNames, $constraintNames );
	}

	public function provideApplyConstraints() {
		$cases = array();

		$cases[] = array(
			new PropertyNoValueSnak( 42 ),
			array()
		);

		$cases[] = array(
			new PropertyNoValueSnak( 32 ),
			array( 'c4' )
		);

		$cases[] = array(
			new PropertyNoValueSnak( 10 ),
			array()
		);

		return $cases;
	}

	/**
	 * @dataProvider provideApplyConstraints
	 *
	 * @param Snak $snak
	 * @param string[] $expectedFailures
	 */
	public function testApplyConstraintsForSnak( Snak $snak, array $expectedFailures ) {
		$constraintsRegistry = $this->getConstraintsRegistryWithConstraints();
		$failures = $constraintsRegistry->applyConstraints( $snak, new StatementList() );
		$this->assertEquals( $expectedFailures, $failures );
	}

	private function getConstraintsRegistryWithConstraints() {
		$constraintsRegistry = new ConstraintsRegistry();
		$constraintsRegistry->registerConstraintForPropertyId(
			new PropertyId( 'P42' ),
			$this->getConstraintMock( true, true, 'c1' )
		);
		$constraintsRegistry->registerConstraintForPropertyId(
			new PropertyId( 'P32' ),
			$this->getConstraintMock( true, true, 'c2' )
		);
		$constraintsRegistry->registerConstraintForPropertyId(
			new PropertyId( 'P10' ),
			$this->getConstraintMock( false, true, 'c3' )
		);
		$constraintsRegistry->registerConstraintForPropertyId(
			new PropertyId( 'P32' ),
			$this->getConstraintMock( true, false, 'c4' )
		);
		$constraintsRegistry->registerConstraintForPropertyId(
			new PropertyId( 'P42' ),
			$this->getConstraintMock( false, false, 'c5' )
		);
		return $constraintsRegistry;
	}

	/**
	 * @param boolean $supportsSnak
	 * @param boolean $failes
	 * @param string $name
	 * @return Constraint
	 */
	private function getConstraintMock( $supportsSnak, $failes, $name ) {
		$constraint = $this->getMock( 'Wikibase\Constraints\Constraint' );

		$constraint->expects( $this->any() )
			->method( 'supportsSnak' )
			->will( $this->returnValue( $supportsSnak ) );

		$constraint->expects( $this->any() )
			->method( 'checkSnak' )
			->will( $this->returnValue( $failes ) );

		$constraint->expects( $this->any() )
			->method( 'getName' )
			->will( $this->returnValue( $name ) );

		return $constraint;
	}

}
