<?php

namespace Wikibase\Constraints;

use Wikibase\DataModel\Entity\EntityId;

/**
 * Interface to access statements from arbitrary items.
 *
 * @since 0.2
 *
 * @license GNU GPL v2+
 * @author Bene* < benestar.wikimedia@gmail.com >
 */
interface StatementListProvider {

	/**
	 * Returns a list of statements for the given entity id.
	 *
	 * @since 0.2
	 *
	 * @param EntityId $entityId
	 * @return StatementList
	 */
	public function getStatementsForEntityId( EntityId $entityId );

}
