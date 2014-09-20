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
		return count( $byPropertyIdGrouper->getByPropertyId( $snak->getPropertyId() ) ) > 1;
	}

	/**
	 * @see Constraint::getName
	 *
	 * @return string
	 */
	public function getName() {
		return 'multivalue';
	}

}
