<?php

namespace Wikibase\Constraints;

use ArrayIterator;
use Comparable;
use Countable;
use InvalidArgumentException;
use IteratorAggregate;
use Traversable;
use Wikibase\DataModel\Statement\StatementList;

/**
 * List of constraints
 *
 * @since 0.1
 *
 * @license GNU GPL v2+
 * @author Bene* < benestar.wikimedia@gmail.com >
 */
class ConstraintList implements IteratorAggregate, Comparable, Countable  {

	/**
	 * @var Constraint[]
	 */
	private $constraints;

	/**
	 * @param Constraint[] $constraints
	 * @throws InvalidArgumentException
	 */
	public function __construct( array $constraints = array() ) {
		$this->assertAreConstraints( $constraints );
		$this->constraints = $constraints;
	}

	private function assertAreConstraints( array $constraints ) {
		foreach ( $constraints as $constraint ) {
			if ( !( $constraint instanceof Constraint ) ) {
				throw new InvalidArgumentException( 'All elements need to implement Constraint.' );
			}
		}
	}

	/**
	 * Adds a constraint to this list of constraints.
	 *
	 * @param Constraint $constraint
	 */
	public function addConstraint( Constraint $constraint ) {
		$this->constraints[] = $constraint;
	}

	/**
	 * Applies all constraints for the given statements
	 * and returns the list of constraints which failed.
	 *
	 * @param StatementList $statements
	 * @return string[]
	 */
	public function applyConstraints( StatementList $statements ) {
		$failures = array();

		foreach ( $this->constraints as $constraint ) {
			if ( !$constraint->validateStatements( $statements ) ) {
				$failures[] = $constraint->getName();
			}
		}

		return $failures;
	}

	/**
	 * @return Traversable
	 */
	public function getIterator() {
		return new ArrayIterator( $this->constraints );
	}

	/**
	 * @return Constraint[]
	 */
	public function toArray() {
		return $this->constraints;
	}

	/**
	 * @see Countable::count
	 *
	 * @return int
	 */
	public function count() {
		return count( $this->constraints );
	}

	/**
	 * @see Comparable::equals
	 *
	 * @param mixed $constraintList
	 *
	 * @return bool
	 */
	public function equals( $constraintList ) {
		if ( !( $constraintList instanceof self ) ) {
			return false;
		}

		if ( $this->count() !== $constraintList->count() ) {
			return false;
		}

		return $this->constraintsEqual( $constraintList->constraints );
	}

	private function constraintsEqual( array $constraints ) {
		reset( $constraints );

		foreach ( $this->constraints as $constraint ) {
			if ( !$constraint->equals( current( $constraints ) ) ) {
				return false;
			}

			next( $constraints );
		}

		return true;
	}

	/**
	 * @return bool
	 */
	public function isEmpty() {
		return empty( $this->constraints );
	}

}
