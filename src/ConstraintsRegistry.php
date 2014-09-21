<?php

namespace Wikibase\Constraints;

use OutOfBoundsException;
use Wikibase\Constraints\Constraint\Constraint;
use Wikibase\DataModel\ByPropertyIdGrouper;
use Wikibase\DataModel\Entity\PropertyId;
use Wikibase\DataModel\Statement\StatementList;

/**
 * Description of ConstraintsRegistry
 *
 * @since 0.1
 *
 * @license GNU GPL v2+
 * @author Bene* < benestar.wikimedia@gmail.com >
 */
class ConstraintsRegistry {

	/**
	 * @var ConstraintList[]
	 */
	private $constraintsPerProperty = array();

	/**
	 * Registers a constraint in this registry for the given property id.
	 *
	 * @param PropertyId $propertyId
	 * @param Constraint $constraint
	 */
	public function registerConstraint( PropertyId $propertyId, Constraint $constraint ) {
		$idSerialization = $propertyId->getSerialization();

		if ( !isset( $this->constraintsPerProperty[$idSerialization] ) ) {
			$this->constraintsPerProperty[$idSerialization] = new ConstraintList();
		}

		$this->constraintsPerProperty[$idSerialization]->addConstraint( $constraint );
	}

	/**
	 * Returns the constraints registered for the given property id.
	 *
	 * @param PropertyId $propertyId
	 * @return ConstraintList
	 * @throws OutOfBoundsException
	 */
	public function getConstraints( PropertyId $propertyId ) {
		$idSerialization = $propertyId->getSerialization();

		if ( !isset( $this->constraintsPerProperty[$idSerialization] ) ) {
			throw new OutOfBoundsException( "No constraints have been registered for $idSerialization" );
		}

		return $this->constraintsPerProperty[$idSerialization];
	}

	/**
	 * Checks if there are constraints registered for the given property id.
	 *
	 * @param PropertyId $propertyId
	 * @return boolean
	 */
	public function hasConstraints( PropertyId $propertyId ) {
		return isset( $this->constraintsPerProperty[$propertyId->getSerialization()] );
	}

	/**
	 * Applies all constraints for the given statements
	 * and returns the list of constraints which failed.
	 *
	 * @param StatementList $statements
	 * @return string[]
	 */
	public function applyConstraints( StatementList $statements ) {
		$byPropertyIdGrouper = new ByPropertyIdGrouper( $statements );
		$failures = array();

		foreach ( $this->constraintsPerProperty as $idSerialization => $constraints ) {
			$propertyId = new PropertyId( $idSerialization );
			if ( $byPropertyIdGrouper->hasPropertyId( $propertyId ) ) {
				$statementsForProperty = $byPropertyIdGrouper->getByPropertyId( $propertyId );
				$failuresForProperty = $constraints->applyConstraints( new StatementList( $statementsForProperty ) );
				if ( !empty( $failuresForProperty ) ) {
					$failures[$idSerialization] = $failuresForProperty;
				}
			}
		}

		return $failures;
	}

}
