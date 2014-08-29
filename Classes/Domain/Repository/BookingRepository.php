<?php
namespace Hri\T3booking\Domain\Repository;

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
 * The repository for Bookings
 */
class BookingRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{


    /**
     * Find only future Events
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findAllFuture()
    {
        // find only values from today onwards
        $today = new \DateTime('0:00');
        $query = $this->createQuery();
        $query = $query->matching($query->greaterThanOrEqual('start_at', $today->getTimestamp()));
        return $query->execute();
    }


    /**
     * Find only future booked
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findAllFutureConfirmed()
    {
        // find only values from today onwards
        $today = new \DateTime('0:00');
        $query = $this->createQuery();
        $query = $query->matching(
            $query->logicalAnd(
                $query->greaterThanOrEqual('start_at', $today->getTimestamp()),
                $query->equals('status', 1)));
        return $query->execute();
    }

    /**
     * Find only future booked
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findAllFutureRequests()
    {
        // find only values from today onwards
        $today = new \DateTime('0:00');
        $query = $this->createQuery();
        $query = $query->matching(
            $query->logicalAnd(
                $query->greaterThanOrEqual('start_at', $today->getTimestamp()),
                $query->equals('status', 0)));
        return $query->execute();
    }
}