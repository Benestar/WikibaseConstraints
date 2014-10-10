<?php

namespace Wikibase\Constraints\Constraint;

use Comparable;
use DataValues\DataValue;
use Wikibase\Constraints\Constraint\Constraint;
use Wikibase\DataModel\Snak\PropertyValueSnak;
use Wikibase\DataModel\Statement\Statement;
use Wikibase\DataModel\Statement\StatementList;

/**
 * Description of DiffRangeConstraint
 *
 * @since 0.2
 *
 * @license GNU GPL v2+
 * @author Bene* < benestar.wikimedia@gmail.com >
 */
class DiffRangeConstraint implements Constraint {

	/**
	 * @var DataValue
	 */
	private $diff;

	public function __construct( DataValue $diff ) {
		$this->diff = $diff;
	}

	/**
	 * @see Constraint::validateStatements
	 *
	 * @param StatementList $statements
	 * @return boolean
	 */
	public function validateStatements( StatementList $statements ) {
		foreach ( $statements as $lhs ) {
			foreach ( $statements as $rhs ) {
				if ( !$this->checkDiff( $lhs, $rhs ) ) {
					return false;
				}
			}
		}

		return true;
	}

	private function checkDiff( Statement $lhs, Statement $rhs ) {
		$lhsSnak = $lhs->getMainSnak();
		$rhsSnak = $rhs->getMainSnak();

		if ( !( $lhsSnak instanceof PropertyValueSnak ) || !( $rhsSnak instanceof PropertyValueSnak ) ) {
			return true;
		}

		$diff = abs( $lhsSnak->getDataValue()->getSortKey() - $rhsSnak->getDataValue()->getSortKey() );
		return $diff <= $this->diff->getSortKey();
	}

	/**
	 * @see Constraint::getName
	 *
	 * @return string
	 */
	public function getName() {
		return 'diffrange';
	}

	/**
	 * @see Comparable::equals
	 *
	 * @param DiffRangeConstraint $constraint
	 * @return boolean
	 */
	public function equals( $constraint ) {
		if ( $constraint === $this ) {
			return true;
		}

		if ( !( $constraint instanceof self ) ) {
			return false;
		}

		return $this->diff->equals( $constraint->diff );
	}

}
