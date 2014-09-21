<?php

namespace Wikibase\Constraints\Constraint;

use Comparable;
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
class FormatChecker implements DataValueChecker {

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
	 * @see DataValueChecker::supportsDataValue
	 *
	 * @param DataValue $dataValue
	 * @return boolean
	 */
	public function supportsDataValue( DataValue $dataValue ) {
		return $dataValue instanceof StringValue;
	}

	/**
	 * @see DataValueChecker::checkDataValue
	 *
	 * @param DataValue $dataValue
	 * @return boolean
	 * @throws InvalidArgumentException
	 */
	public function checkDataValue( DataValue $dataValue ) {
		if ( !$this->supportsDataValue( $dataValue ) ) {
			throw new InvalidArgumentException( 'Only StringValue objects are supported.' );
		}

		return preg_match( $this->format, $dataValue->getValue() ) === 1;
	}

	/**
	 * @see DataValueChecker::getName
	 *
	 * @return string
	 */
	public function getName() {
		return 'format';
	}

	/**
	 * @see Comparable::equals
	 *
	 * @param FormatChecker $constraint
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
