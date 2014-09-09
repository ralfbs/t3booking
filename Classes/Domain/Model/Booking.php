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
class Booking extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

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
     * Categories
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category>
     */
    protected $categories;

    /**
     * comment
     *
     * @var string
     */
    protected $comment = '';

    /**
     * createdAt
     *
     * @var \DateTime
     */
    protected $createdAt = NULL;

    /**
     * confirmAt
     *
     * @var \DateTime
     */
    protected $confirmAt = NULL;

    /**
     * confirmBy
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
     */
    protected $confirmBy = 0;

    /**
     * confirmComment
     *
     * @var string
     */
    protected $confirmComment = '';

    /**
     * resource
     *
     * @var \Hri\t3booking\Domain\Model\Resource
     */
    protected $resource = NULL;

    /**
     * classification
     *
     * @var \Hri\t3booking\Domain\Model\Classification
     */
    protected $classification = NULL;
    /**
     * Returns the startAt
     *
     * @return \DateTime $startAt
     */
    public function getStartAt()
    {
        return $this->startAt;
    }

    /**
     * Sets the startAt
     *
     * @param \DateTime $startAt
     * @return void
     */
    public function setStartAt(\DateTime $startAt)
    {
        $this->startAt = $startAt;
    }

    /**
     * Returns the Status
     *
     * @return \integer $status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Sets the status
     *
     * @param \integer $status
     * @return void
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Returns the endAt
     *
     * @return \DateTime $endAt
     */
    public function getEndAt()
    {
        return $this->endAt;
    }

    /**
     * Sets the endAt
     *
     * @param \DateTime $endAt
     * @return void
     */
    public function setEndAt(\DateTime $endAt)
    {
        $this->endAt = $endAt;
    }

    /**
     * Returns the quantity
     *
     * @return integer $quantity
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Sets the quantity
     *
     * @param integer $quantity
     * @return void
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * Returns the user
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FrontendUser $user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Sets the user
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FrontendUser $user
     * @return void
     */
    public function setUser(\TYPO3\CMS\Extbase\Domain\Model\FrontendUser $user)
    {
        $this->user = $user;
    }

    /**
     * Adds a Category
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\Category $category
     * @return void
     */
    public function addCategory(\TYPO3\CMS\Extbase\Domain\Model\Category $category)
    {
        $this->categories->attach($category);
    }

    /**
     * Removes a Category
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\Category $categoryToRemove The Category to be removed
     * @return void
     */
    public function removeCategory(\TYPO3\CMS\Extbase\Domain\Model\Category $categoryToRemove)
    {
        $this->categories->detach($categoryToRemove);
    }

    /**
     * Returns the categories
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category>  $categories
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Sets the categories
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category>  $categories
     * @return void
     */
    public function setCategories(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $categories)
    {
        $this->categories = $categories;
    }


    /**
     * Returns the comment
     *
     * @return string comment
     */
    public function getComment() {
        return $this->comment;
    }

    /**
     * Sets the comment
     *
     * @param string $comment
     * @return string comment
     */
    public function setComment($comment) {
        $this->comment = $comment;
    }

    /**
     * Returns the createdAt
     *
     * @return \DateTime $createdAt
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * Sets the createdAt
     *
     * @param \DateTime $createdAt
     * @return void
     */
    public function setCreatedAt(\DateTime $createdAt) {
        $this->createdAt = $createdAt;
    }

    /**
     * Returns the confirmAt
     *
     * @return \DateTime $confirmAt
     */
    public function getConfirmAt() {
        return $this->confirmAt;
    }

    /**
     * Sets the confirmAt
     *
     * @param \DateTime $confirmAt
     * @return void
     */
    public function setConfirmAt(\DateTime $confirmAt) {
        $this->confirmAt = $confirmAt;
    }

    /**
     * Returns the confirmBy
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FrontendUser $confirmBy
     */
    public function getConfirmBy() {
        return $this->confirmBy;
    }

    /**
     * Sets the confirmBy
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FrontendUser $confirmBy
     * @return void
     */
    public function setConfirmBy(\TYPO3\CMS\Extbase\Domain\Model\FrontendUser $confirmBy) {
        $this->confirmBy = $confirmBy;
    }

    /**
     * Returns the confirmComment
     *
     * @return string $confirmComment
     */
    public function getConfirmComment() {
        return $this->confirmComment;
    }

    /**
     * Sets the confirmComment
     *
     * @param string $confirmComment
     * @return void
     */
    public function setConfirmComment($confirmComment) {
        $this->confirmComment = $confirmComment;
    }

    /**
     * Returns the resource
     *
     * @return \Hri\t3booking\Domain\Model\Resource $resource
     */
    public function getResource() {
        return $this->resource;
    }

    /**
     * Sets the resource
     *
     * @param \Hri\t3booking\Domain\Model\Resource $resource
     * @return void
     */
    public function setResource(\Hri\t3booking\Domain\Model\Resource $resource) {
        $this->resource = $resource;
    }

    /**
     * Returns the classification
     *
     * @return \Hri\t3booking\Domain\Model\Classification classification
     */
    public function getClassification() {
        return $this->classification;
    }

    /**
     * Sets the classification
     *
     * @param \Hri\t3booking\Domain\Model\Classification $classification
     * @return \Hri\t3booking\Domain\Model\Classification classification
     */
    public function setClassification(\Hri\t3booking\Domain\Model\Classification $classification) {
        $this->classification = $classification;
    }


}