<?php

namespace Wikibase\Constraints;

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
class RangeConstraint extends DataValueConstraint {

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
		$this->assertHaveCorrectTypes( $minValue, $maxValue );

		$this->minValue = $minValue;
		$this->maxValue = $maxValue;
	}

	private function assertHaveCorrectTypes( DataValue $minValue, DataValue $maxValue ) {
		if ( $minValue->getType() !== $maxValue->getType() ) {
			throw new InvalidArgumentException( '$minValue and $maxValue must have the same type.' );
		}
	}

	/**
	 * @see DataValueConstraint::supportsDataValue
	 *
	 * @param DataValue $dataValue
	 * @return boolean
	 */
	protected function supportsDataValue( DataValue $dataValue ) {
		return $dataValue->getType() === $this->minValue->getType();
	}

	/**
	 * @see DataValueConstraint::checkDataValue
	 *
	 * @param DataValue $dataValue
	 * @return boolean
	 */
	protected function checkDataValue( DataValue $dataValue ) {
		$minKey = $this->minValue->getSortKey();
		$maxKey = $this->maxValue->getSortKey();
		$key = $dataValue->getSortKey();

		return $minKey < $key && $key < $maxKey;
	}

}