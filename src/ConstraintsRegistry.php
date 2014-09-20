<?php

namespace Wikibase\Constraints;

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
	public function registerConstraintForPropertyId( PropertyId $propertyId, Constraint $constraint ) {
		$idSerialization = $propertyId->getSerialization();
		if ( !isset( $this->constraintsPerProperty[$idSerialization] ) ) {
			$this->constraintsPerProperty[$idSerialization] = new ConstraintList();
		}
		$this->constraintsPerProperty[$idSerialization]->addConstraint( $constraint );
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

		foreach ( $this->constraintsPerProperty as $propertyId => $constraintList ) {
			$statementsForProperty = $byPropertyIdGrouper->getByPropertyId( new PropertyId( $propertyId ) );
			$failures[$propertyId] = $constraintList->applyConstraints( $statementsForProperty );
		}

		return $failures;
	}

}
