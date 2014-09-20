<?php

namespace Wikibase\Constraints;

use DataValues\DataValue;
use DataValues\StringValue;
use InvalidArgumentException;

/**
 * Description of FormatConstraint
 *
 * @since 0.1
 *
 * @license GNU GPL v2+
 * @author Bene* < benestar.wikimedia@gmail.com >
 */
class FormatConstraint extends DataValueConstraint {

	/**
	 * @var string
	 */
	private $format;

	/**
	 * @param string $format
	 * @throws InvalidArgumentException
	 */
	public function __construct( $format ) {
		if ( !is_string( $format ) ) {
			throw new InvalidArgumentException( '$format must be of type string' );
		}

		$this->format = $format;
	}

	/**
	 * @see DataValueConstraint::supportsDataValue
	 *
	 * @param DataValue $dataValue
	 * @return boolean
	 */
	protected function supportsDataValue( DataValue $dataValue ) {
		return $dataValue instanceof StringValue;
	}

	/**
	 * @see DataValueConstraint::checkDataValue
	 *
	 * @param DataValue $dataValue
	 * @return boolean
	 */
	protected function checkDataValue( DataValue $dataValue ) {
		return preg_match( $this->format, $dataValue->getValue() ) === 1;
	}

	/**
	 * @see Constraint::getName
	 *
	 * @return string
	 */
	public function getName() {
		return 'format';
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

		return $this->format === $constraint->format;
	}

}
