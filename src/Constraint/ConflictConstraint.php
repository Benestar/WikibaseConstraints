<?php

namespace Wikibase\Constraints\Constraint;

use Wikibase\DataModel\Snak\Snak;
use Wikibase\DataModel\Statement\StatementList;

/**
 * Description of ConflictConstraint
 *
 * @since 0.1
 *
 * @license GNU GPL v2+
 * @author Bene* < benestar.wikimedia@gmail.com >
 */
class ConflictConstraint implements Constraint {

	/**
	 * @var Snak
	 */
	private $snak;

	public function __construct( Snak $snak ) {
		$this->snak = $snak;
	}

	/**
	 * @see Constraint::validateStatements
	 *
	 * @param StatementList $statements
	 * @return boolean
	 */
	public function validateStatements( StatementList $statements ) {
		foreach ( $statements as $statement ) {
			if ( $statement->getMainSnak()->equals( $this->snak ) ) {
				return false;
			}
		}

		return true;
	}

	/**
	 * @see Constraint::getName
	 *
	 * @return string
	 */
	public function getName() {
		return 'conflict';
	}

	/**
	 * @see Comparable::equals
	 *
	 * @param ConflictConstraint $constraint
	 * @return boolean
	 */
	public function equals( $constraint ) {
		if ( $constraint === $this ) {
			return true;
		}

		if ( !( $constraint instanceof self ) ) {
			return false;
		}

		return $this->snak->equals( $constraint->snak );
	}

}
