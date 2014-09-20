<?php

namespace Wikibase\Constraints;

use Wikibase\DataModel\Snak\Snak;
use Wikibase\DataModel\Statement\StatementList;

/**
 * Description of SnakConstraint
 *
 * @since 0.1
 *
 * @license GNU GPL v2+
 * @author Bene* < benestar.wikimedia@gmail.com >
 */
class SnakConstraint implements Constraint {

	/**
	 * @var Snak
	 */
	private $snak;

	public function __construct( Snak $snak ) {
		$this->snak = $snak;
	}

	/**
	 * @see Constraint::supportsSnak
	 *
	 * @param Snak $snak
	 * @return boolean
	 */
	public function supportsSnak( Snak $snak ) {
		return true;
	}

	/**
	 * @see Constraint::checkSnak
	 *
	 * @param Snak $snak
	 * @param StatementList $statements
	 * @return boolean
	 */
	public function checkSnak( Snak $snak, StatementList $statements ) {
		foreach ( $statements as $statement ) {
			if ( $statement->getMainSnak()->equals( $this->snak ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * @see Constraint::getName
	 *
	 * @return string
	 */
	public function getName() {
		return 'snak';
	}

}
