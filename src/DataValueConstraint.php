<?php

namespace Wikibase\Constraints;

use DataValues\DataValue;
use InvalidArgumentException;
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
	 * @see Constraint::supportsSnak
	 *
	 * @param Snak $snak
	 * @return boolean
	 */
	public function supportsSnak( Snak $snak ) {
		return $snak instanceof PropertyValueSnak &&
			$this->supportsDataValue( $snak->getDataValue() );
	}

	/**
	 * Returns if this constraint supports the given data value.
	 *
	 * @param DataValue $dataValue
	 * @return boolean
	 */
	protected abstract function supportsDataValue( DataValue $dataValue );

	/**
	 * @see Constraint::checkSnak
	 *
	 * @param Snak $snak
	 * @param StatementList $statements
	 * @return boolean
	 * @throws InvalidArgumentException
	 */
	public function checkSnak( Snak $snak, StatementList $statements ) {
		if ( !$this->supportsSnak( $snak ) ) {
			throw new InvalidArgumentException( 'This constraint only supports value snaks.' );
		}

		return $this->checkDataValue( $snak->getDataValue() );
	}

	/**
	 * Returns if the data value passes this constraint.
	 *
	 * @param DataValue $dataValue
	 * @return boolean
	 */
	protected abstract function checkDataValue( DataValue $dataValue );

}
