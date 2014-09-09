<?php
namespace Hri\T3booking\Domain\Validator;

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
 * Booking Validator
 */
class BookingValidator extends \TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator
{

    /**
     * @param mixed $object
     */
    public function isValid($object)
    {
        $ret = true;
        /* @var \Hri\T3booking\Domain\Model\Booking $object */
        if (!$object instanceof \Hri\T3booking\Domain\Model\Booking) {
            return true;
        }
        try {
            $start = (int)$object->getStartAt()->getTimestamp();
            $end = (int)$object->getEndAt()->getTimestamp();
        } catch (Exception $e) {
            $this->result->forProperty('startAt')->addError(new \TYPO3\CMS\Extbase\Error\Error("Zeiten ungültig",811));
            $ret = false;
        }
        // Startzeit nach Endzeit?
        if ($start >= $end) {
            $this->result->forProperty('startAt')->addError(new \TYPO3\CMS\Extbase\Error\Error("Zeiten ungültig",812));
            $ret = false;
        }
        if ($object->getQuantity() <= 0) {
            $this->result->forProperty('quantity')->addError(new \TYPO3\CMS\Extbase\Error\Error("Ungültige Anzahl",813));
            $ret = false;
        }
        if ($object->getQuantity() > 750) {
            $this->result->forProperty('quantity')->addError(new \TYPO3\CMS\Extbase\Error\Error("Maximale Anzahl zu diesem Zeitpunkt 750 Personen",814));
            $ret = false;
        }



        // $this->result->forProperty('quantity')->addError(new \TYPO3\CMS\Extbase\Error\Error('Das geht ja mal gar nicht'));
        return $ret;
    }

}