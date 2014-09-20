<?php

namespace Wikibase\Constraints;

use Wikibase\DataModel\ByPropertyIdGrouper;
use Wikibase\DataModel\Snak\Snak;
use Wikibase\DataModel\Statement\StatementList;

/**
 * Description of MultiValueConstraint
 *
 * @since 0.1
 *
 * @license GNU GPL v2+
 * @author Bene* < benestar.wikimedia@gmail.com >
 */
class MultiValueConstraint implements Constraint {

	/**
	 * @see Constraint::supportsSnak
	 *
	 * @param Snak $snak
	 * @return boolean
	 */
	public function supportsSnak( Snak $snak ) {
		return true;
	}

	/**
	 * @see Constraint::checkSnak
	 *
	 * @param Snak $snak
	 * @param StatementList $statements
	 * @return boolean
	 */
	public function checkSnak( Snak $snak, StatementList $statements ) {
		$byPropertyIdGrouper = new ByPropertyIdGrouper( $statements );
		$propertyId = $snak->getPropertyId();

		if ( !$byPropertyIdGrouper->hasPropertyId( $propertyId ) ) {
			return false;
		}

		return count( $byPropertyIdGrouper->getByPropertyId( $propertyId ) ) > 1;
	}

	/**
	 * @see Constraint::getName
	 *
	 * @return string
	 */
	public function getName() {
		return 'multivalue';
	}

	/**
	 * @see Comparable::equals
	 *
	 * @param mixed $constraint
	 * @return boolean
	 */
	public function equals( $constraint ) {
		if ( $constraint === $this ) {
			return true;
		}

		if ( !( $constraint instanceof self ) ) {
			return false;
		}

		return true;
	}

}
