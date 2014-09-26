<?php

namespace Wikibase\Constraints;

use DataValues\DataValue;
use Wikibase\Constraints\Constraint\ConflictConstraint;
use Wikibase\Constraints\Constraint\DataValueConstraint;
use Wikibase\Constraints\Constraint\FormatChecker;
use Wikibase\Constraints\Constraint\MultiValueConstraint;
use Wikibase\Constraints\Constraint\OneOfChecker;
use Wikibase\Constraints\Constraint\RangeChecker;
use Wikibase\Constraints\Constraint\SingleValueConstraint;
use Wikibase\Constraints\Constraint\SnakConstraint;
use Wikibase\DataModel\Snak\Snak;

/**
 * Description of ConstraintFactory
 *
 * @since 0.2
 *
 * @license GNU GPL v2+
 * @author Bene* < benestar.wikimedia@gmail.com >
 */
class ConstraintFactory {

	/**
	 * @since 0.2
	 *
	 * @param Snak $snak
	 * @return SnakConstraint
	 */
	public function newSnakConstraint( Snak $snak ) {
		return new SnakConstraint( $snak );
	}

	/**
	 * @since 0.2
	 *
	 * @param Snak $snak
	 * @return ConflictConstraint
	 */
	public function newConflictConstraint( Snak $snak ) {
		return new ConflictConstraint( $snak );
	}

	/**
	 * @since 0.2
	 *
	 * @return SingleValueConstraint
	 */
	public function newSingleValueConstraint() {
		return new SingleValueConstraint();
	}

	/**
	 * @since 0.2
	 *
	 * @return MultiValueConstraint
	 */
	public function newMultiValueConstraint() {
		return new MultiValueConstraint();
	}

	/**
	 * @since 0.2
	 *
	 * @param string $format
	 * @return DataValueConstraint
	 *
	 * @throws InvalidArgumentException
	 */
	public function newFormatConstraint( $format ) {
		$formatChecker = new FormatChecker( $format );
		return new DataValueConstraint( $formatChecker );
	}

	/**
	 * @since 0.2
	 *
	 * @param DataValue[] $dataValues
	 * @return DataValueConstraint
	 *
	 * @throws InvalidArgumentException
	 */
	public function newOneOfConstraint( array $dataValues ) {
		$oneOfChecker = new OneOfChecker( $dataValues );
		return new DataValueConstraint( $oneOfChecker );
	}

	/**
	 * @since 0.2
	 *
	 * @param DataValue $minVal
	 * @param DataValue $maxVal
	 * @return DataValueConstraint
	 *
	 * @throws InvalidArgumentException
	 */
	public function newRangeConstraint( DataValue $minVal, DataValue $maxVal ) {
		$rangeChecker = new RangeChecker( $minVal, $maxVal );
		return new DataValueConstraint( $rangeChecker );
	}

}
