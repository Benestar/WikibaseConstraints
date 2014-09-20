<?php

namespace Wikibase\Constraints;

use DataValues\DataValue;
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
abstract class DataValueConstraint implements Constraint {

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

		if ( $this->supportsDataValue( $dataValue ) ) {
			return $this->checkDataValue( $dataValue );
		}
	}

	/**
	 * Returns if this constraint supports the given data value.
	 *
	 * @param DataValue $dataValue
	 * @return boolean
	 */
	protected abstract function supportsDataValue( DataValue $dataValue );

	/**
	 * Returns if the data value passes this constraint.
	 *
	 * @param DataValue $dataValue
	 * @return boolean
	 */
	protected abstract function checkDataValue( DataValue $dataValue );

}
