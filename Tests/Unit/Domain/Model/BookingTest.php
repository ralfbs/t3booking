<?php

namespace Hri\T3booking\Tests\Unit\Domain\Model;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Ralf Schneider <ralf@hr-interactive.com>, hr-interactive
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Test case for class \Hri\T3booking\Domain\Model\Booking.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Ralf Schneider <ralf@hr-interactive.com>
 */
class BookingTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {
	/**
	 * @var \Hri\T3booking\Domain\Model\Booking
	 */
	protected $subject = NULL;

	protected function setUp() {
		$this->subject = new \Hri\T3booking\Domain\Model\Booking();
	}

	protected function tearDown() {
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function getStartAtReturnsInitialValueForDateTime() {
		$this->assertEquals(
			NULL,
			$this->subject->getStartAt()
		);
	}

	/**
	 * @test
	 */
	public function setStartAtForDateTimeSetsStartAt() {
		$dateTimeFixture = new \DateTime();
		$this->subject->setStartAt($dateTimeFixture);

		$this->assertAttributeEquals(
			$dateTimeFixture,
			'startAt',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getStatisReturnsInitialValueForInteger() {
		$this->assertSame(
			0,
			$this->subject->getStatus()
		);
	}

	/**
	 * @test
	 */
	public function setStatusForIntegerSetsDuration() {
		$this->subject->setStatus(12);

		$this->assertAttributeEquals(
			12,
			'status',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getEndAtReturnsInitialValueForDateTime() {
		$this->assertEquals(
			NULL,
			$this->subject->getEndAt()
		);
	}

	/**
	 * @test
	 */
	public function setEndAtForDateTimeSetsEndAt() {
		$dateTimeFixture = new \DateTime();
		$this->subject->setEndAt($dateTimeFixture);

		$this->assertAttributeEquals(
			$dateTimeFixture,
			'endAt',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getQuantityReturnsInitialValueForInteger() {
		$this->assertSame(
			0,
			$this->subject->getQuantity()
		);
	}

	/**
	 * @test
	 */
	public function setQuantityForIntegerSetsQuantity() {
		$this->subject->setQuantity(12);

		$this->assertAttributeEquals(
			12,
			'quantity',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getUserReturnsInitialValueForFrontendUser() {	}

	/**
	 * @test
	 */
	public function setUserForFrontendUserSetsUser() {	}
}
