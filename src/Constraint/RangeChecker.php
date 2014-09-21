<?php

namespace Wikibase\Constraints\Constraint;

use Comparable;
use DataValues\DataValue;
use InvalidArgumentException;

/**
 * Description of RangeConstraint
 *
 * @since 0.1
 *
 * @license GNU GPL v2+
 * @author Bene* < benestar.wikimedia@gmail.com >
 */
class RangeChecker implements DataValueChecker {

	/**
	 * @var DataValue
	 */
	private $minValue;

	/**
	 * @var DataValue
	 */
	private $maxValue;

	/**
	 * @param DataValue $minValue
	 * @param DataValue $maxValue
	 * @throws InvalidArgumentException
	 */
	public function __construct( DataValue $minValue, DataValue $maxValue ) {
		$this->assertCorrectValues( $minValue, $maxValue );

		$this->minValue = $minValue;
		$this->maxValue = $maxValue;
	}

	private function assertCorrectValues( DataValue $minValue, DataValue $maxValue ) {
		if ( $minValue->getType() !== $maxValue->getType() ) {
			throw new InvalidArgumentException( '$minValue and $maxValue must have the same type.' );
		}

		if ( $minValue->getSortKey() > $maxValue->getSortKey() ) {
			throw new InvalidArgumentException( '$minValue must not be greater then $maxValue' );
		}
	}

	/**
	 * @see DataValueChecker::supportsDataValue
	 *
	 * @param DataValue $dataValue
	 * @return boolean
	 */
	public function supportsDataValue( DataValue $dataValue ) {
		return $dataValue->getType() === $this->minValue->getType();
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
			throw new InvalidArgumentException( 'Only values of the same type as the boundaries are accepted.' );
		}

		$minKey = $this->minValue->getSortKey();
		$maxKey = $this->maxValue->getSortKey();
		$key = $dataValue->getSortKey();

		return $minKey <= $key && $key <= $maxKey;
	}

	/**
	 * @see DataValueChecker::getName
	 *
	 * @return string
	 */
	public function getName() {
		return 'range';
	}

	/**
	 * @see Comparable::equals
	 *
	 * @param RangeChecker $constraint
	 * @return boolean
	 */
	public function equals( $constraint ) {
		if ( $constraint === $this ) {
			return true;
		}

		if ( !( $constraint instanceof self ) ) {
			return false;
		}

		return $this->minValue->equals( $constraint->minValue ) &&
			$this->maxValue->equals( $constraint->maxValue );
	}

}
