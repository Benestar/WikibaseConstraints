<?php

namespace Wikibase\Constraints;

use Wikibase\DataModel\Statement\StatementList;

/**
 * Description of SingleValueConstraint
 *
 * @since 0.1
 *
 * @license GNU GPL v2+
 * @author Bene* < benestar.wikimedia@gmail.com >
 */
class SingleValueConstraint implements Constraint {

	/**
	 * @see Constraint::validateStatements
	 *
	 * @param StatementList $statements
	 * @return boolean
	 */
	public function validateStatements( StatementList $statements ) {
		return $statements->count() === 1;
	}

	/**
	 * @see Constraint::getName
	 *
	 * @return string
	 */
	public function getName() {
		return 'singlevalue';
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
