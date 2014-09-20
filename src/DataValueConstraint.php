<?php

namespace Wikibase\Constraints;

use Wikibase\DataModel\Snak\PropertyValueSnak;
use Wikibase\DataModel\Snak\Snak;
use Wikibase\DataModel\Statement\StatementList;

/**
 * Description of DataValueConstraint
 *
 * @since 0.1
 *
 * @license GNU GPL v2+
 * @author Bene* < benestar.wikimedia@gmail.com >
 */
class DataValueConstraint implements Constraint {

	/**
	 * @var DataValueChecker
	 */
	private $dataValueChecker;

	public function __construct( DataValueChecker $dataValueChecker ) {
		$this->dataValueChecker = $dataValueChecker;
	}

	/**
	 * @see Constraint::validateStatements
	 *
	 * @param StatementList $statements
	 * @return boolean
	 */
	public function validateStatements( StatementList $statements ) {
		foreach ( $statements as $statement ) {
			if ( !$this->validateSnak( $statement->getMainSnak() ) ) {
				return false;
			}
		}

		return true;
	}

	private function validateSnak( Snak $snak ) {
		if ( !( $snak instanceof PropertyValueSnak ) ) {
			return true;
		}

		$dataValue = $snak->getDataValue();

		if ( !$this->dataValueChecker->supportsDataValue( $dataValue ) ) {
			return true;
		}

		return $this->dataValueChecker->checkDataValue( $dataValue );
	}

	/**
	 * @see Constraint::getName
	 *
	 * @return string
	 */
	public function getName() {
		return $this->dataValueChecker->getName();
	}

	/**
	 * @see Comparable::equals
	 *
	 * @param DataValueConstraint $constraint
	 * @return boolean
	 */
	public function equals( $constraint ) {
		if ( $constraint === $this ) {
			return true;
		}

		if ( !( $constraint instanceof self ) ) {
			return false;
		}

		return $this->dataValueChecker->equals( $constraint->dataValueChecker );
	}

}
