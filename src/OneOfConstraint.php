<?php

namespace Wikibase\Constraints;

use DataValues\DataValue;
use InvalidArgumentException;

/**
 * Description of OneOfConstraint
 *
 * @since 0.1
 *
 * @license GNU GPL v2+
 * @author Bene* < benestar.wikimedia@gmail.com >
 */
class OneOfConstraint implements DataValueConstraint {

	/**
	 * @var DataValue[]
	 */
	private $values;

	/**
	 * @param DataValue[] $values
	 * @throws InvalidArgumentException
	 */
	public function __construct( array $values ) {
		$this->assertAreDataValues( $values );
		$this->values = $values;
	}

	private function assertAreDataValues( array $values ) {
		foreach ( $values as $value ) {
			if ( !( $value instanceof DataValue ) ) {
				throw new InvalidArgumentException( 'Only DataValue objects are allowed.' );
			}
		}
	}

	/**
	 * @see DataValueConstraint::supportsDataValue
	 *
	 * @param DataValue $dataValue
	 * @return boolean
	 */
	public function supportsDataValue( DataValue $dataValue ) {
		return true;
	}

	/**
	 * @see DataValueConstraint::checkDataValue
	 *
	 * @param DataValue $dataValue
	 * @return boolean
	 */
	public function checkDataValue( DataValue $dataValue ) {
		foreach ( $this->values as $value ) {
			if ( $dataValue->equals( $value ) ) {
				return true;
			}
		}

		return false;
	}

}
