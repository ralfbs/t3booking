<?php
namespace Hri\T3booking\Domain\Model;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2014 Ralf Schneider <ralf@hr-interactive.com>, hr-interactive
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
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
 * Booking
 */
class Booking extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

    /**
     * Anfrage
     */
    const REQUEST = 0;

    /**
     * Bestätigter Termin
     */
    const CONFIRMED = 1;


	/**
	 * Starzeitpunkt der Buchung
	 *
	 * @var \DateTime
	 */
	protected $startAt = NULL;

	/**
	 * status
	 *
	 * @var \integer
	 */
	protected $status = 0;

	/**
	 * Endzeitpunkt der Buchung
	 *
	 * @var \DateTime
	 */
	protected $endAt = NULL;

	/**
	 * Quantity to be booked
	 *
	 * @var integer
	 */
	protected $quantity = 0;

	/**
	 * user
	 *
	 * @var \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
	 */
	protected $user = NULL;

	/**
	 * Returns the startAt
	 *
	 * @return \DateTime $startAt
	 */
	public function getStartAt() {
		return $this->startAt;
	}

	/**
	 * Sets the startAt
	 *
	 * @param \DateTime $startAt
	 * @return void
	 */
	public function setStartAt(\DateTime $startAt) {
		$this->startAt = $startAt;
	}

	/**
	 * Returns the Status
	 *
	 * @return \integer $status
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * Sets the status
	 *
	 * @param \integer $status
	 * @return void
	 */
	public function setStatus($status) {
		$this->status = $status;
	}

	/**
	 * Returns the endAt
	 *
	 * @return \DateTime $endAt
	 */
	public function getEndAt() {
		return $this->endAt;
	}

	/**
	 * Sets the endAt
	 *
	 * @param \DateTime $endAt
	 * @return void
	 */
	public function setEndAt(\DateTime $endAt) {
		$this->endAt = $endAt;
	}

	/**
	 * Returns the quantity
	 *
	 * @return integer $quantity
	 */
	public function getQuantity() {
		return $this->quantity;
	}

	/**
	 * Sets the quantity
	 *
	 * @param integer $quantity
	 * @return void
	 */
	public function setQuantity($quantity) {
		$this->quantity = $quantity;
	}

	/**
	 * Returns the user
	 *
	 * @return \TYPO3\CMS\Extbase\Domain\Model\FrontendUser $user
	 */
	public function getUser() {
		return $this->user;
	}

	/**
	 * Sets the user
	 *
	 * @param \TYPO3\CMS\Extbase\Domain\Model\FrontendUser $user
	 * @return void
	 */
	public function setUser(\TYPO3\CMS\Extbase\Domain\Model\FrontendUser $user) {
		$this->user = $user;
	}

}