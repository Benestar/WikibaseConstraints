<?php

namespace Wikibase\Constraints;

use Comparable;
use Wikibase\DataModel\Statement\StatementList;

/**
 * Interface for all constraints.
 *
 * @since 0.1
 *
 * @license GNU GPL v2+
 * @author Bene* < benestar.wikimedia@gmail.com >
 */
interface Constraint extends Comparable {

	/**
	 * Checks if the listed statements pass this constraint.
	 *
	 * @param StatementList $statements
	 * @return boolean
	 */
	public function validateStatements( StatementList $statements );

	/**
	 * Returns the unique name of this constraint.
	 *
	 * @return string
	 */
	public function getName();

}
