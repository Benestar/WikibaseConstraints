<?php

namespace Wikibase\Constraints;

use Wikibase\DataModel\Entity\PropertyId;
use Wikibase\DataModel\Snak\Snak;
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
	 * @var Constraint[][]
	 */
	private $constraints = array();

	/**
	 * Registers a constraint in this registry for the given property id.
	 *
	 * @param PropertyId $propertyId
	 * @param Constraint $constraint
	 */
	public function registerConstraintForPropertyId( PropertyId $propertyId, Constraint $constraint ) {
		$idSerialization = $propertyId->getSerialization();
		if ( isset( $this->constraints[$idSerialization] ) ) {
			$this->constraints[$idSerialization][] = $constraint;
		} else {
			$this->constraints[$idSerialization] = array( $constraint );
		}
	}

	/**
	 * Returns all constraints for the given snak.
	 *
	 * @param Snak $snak
	 * @return Constraint[]
	 */
	public function getConstraintsForSnak( Snak $snak ) {
		$idSerialization = $snak->getPropertyId()->getSerialization();
		$constraints = array();

		if ( isset( $this->constraints[$idSerialization] ) ) {
			foreach ( $this->constraints[$idSerialization] as $constraint ) {
				if ( $constraint->supportsSnak( $snak ) ) {
					$constraints[] = $constraint;
				}
			}
		}

		return $constraints;
	}

	/**
	 * Applies all constraints for the given snak and
	 * returns the list of constraints which failed.
	 *
	 * @param Snak $snak
	 * @param StatementList $statements
	 * @return string[]
	 */
	public function applyConstraints( Snak $snak, StatementList $statements ) {
		$constraints = $this->getConstraintsForSnak( $snak );
		$failures = array();

		foreach ( $constraints as $constraint ) {
			if ( !$constraint->checkSnak( $snak, $statements ) ) {
				$failures[] = $constraint->getName();
			}
		}

		return $failures;
	}

}
