<?php

namespace Wikibase\Constraints\Constraint;

use Comparable;
use DataValues\DataValue;

/**
 * Description of DataValueChecker
 *
 * @since 0.1
 *
 * @license GNU GPL v2+
 * @author Bene* < benestar.wikimedia@gmail.com >
 */
interface DataValueChecker extends Comparable {

	/**
	 * Returns if this constraint supports the given data value.
	 *
	 * @param DataValue $dataValue
	 * @return boolean
	 */
	public function supportsDataValue( DataValue $dataValue );

	/**
	 * Returns if the data value passes this constraint.
	 *
	 * @param DataValue $dataValue
	 * @return boolean
	 */
	public function checkDataValue( DataValue $dataValue );

	/**
	 * Returns the unique name of this DataValueChecker.
	 *
	 * @return string
	 */
	public function getName();

}
