<?php

namespace Wikibase\Test;

use InvalidArgumentException;
use Wikibase\Constraints\FormatChecker;

/**
 * @covers Wikibase\Constraints\FormatChecker
 *
 * @license GNU GPL v2+
 * @author Bene* < benestar.wikimedia@gmail.com >
 */
class FormatCheckerTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testConstructionFails() {
		new FormatChecker( 123 );
	}

	public function testGetName() {
		$formatConstrain = new FormatChecker( '' );
		$this->assertEquals( 'format', $formatConstrain->getName() );
	}

}
