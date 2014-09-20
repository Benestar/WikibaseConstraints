<?php

namespace Wikibase\Constraints;

use Wikibase\DataModel\Snak\Snak;
use Wikibase\DataModel\Statement\StatementList;

/**
 * Interface for all constraints.
 *
 * @since 0.1
 *
 * @license GNU GPL v2+
 * @author Bene* < benestar.wikimedia@gmail.com >
 */
interface Constraint {

	/**
	 * Returns if this constraint supports the given snak.
	 *
	 * @param Snak $snak
	 * @return boolean
	 */
	public function supportsSnak( Snak $snak );

	/**
	 * Returns if the snak passes this constraint.
	 *
	 * @param Snak $snak
	 * @param StatementList $statements
	 * @return boolean
	 */
	public function checkSnak( Snak $snak, StatementList $statements );

	/**
	 * Returns the unique name of this constraint.
	 *
	 * @return string
	 */
	public function getName();

}
