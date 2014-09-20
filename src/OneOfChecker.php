<?php

namespace Wikibase\Constraints;

use Comparable;
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
class OneOfChecker implements DataValueChecker {

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
	 * @see DataValueChecker::supportsDataValue
	 *
	 * @param DataValue $dataValue
	 * @return boolean
	 */
	public function supportsDataValue( DataValue $dataValue ) {
		return true;
	}

	/**
	 * @see DataValueChecker::checkDataValue
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

	/**
	 * @see DataValueChecker::getName
	 *
	 * @return string
	 */
	public function getName() {
		return 'oneof';
	}

	/**
	 * @see Comparable::equals
	 *
	 * @param OneOfChecker $constraint
	 * @return boolean
	 */
	public function equals( $constraint ) {
		if ( $constraint === $this ) {
			return true;
		}

		if ( !( $constraint instanceof self ) ) {
			return false;
		}

		return $this->dataValuesEqual( $constraint->values );
	}

	private function dataValuesEqual( array $values ) {
		reset( $values );

		foreach ( $this->values as $value ) {
			if ( !$value->equals( current( $values ) ) ) {
				return false;
			}

			next( $values );
		}

		return true;
	}

}
