<?php
namespace Hri\T3booking\Validation\Validator;

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
class TimeValidator extends \TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator
{

    /**
     * This contains the supported options, their default values, types and descriptions.
     *
     * @var array
     */
    protected $supportedOptions = array('duration' => 30);

    /**
     * @param mixed $property
     * @return boolean
     */
    public function isValid($property)
    {
        /** @var $property \DateTime */

        $start = new \DateTime();
        $start->setTime(8, 0);
        if ($start->getTimestamp() > $property->getTimestamp()) {
            $this->addError('Früheste Buchung ab 8:00 möglich', 1411999101);
            return false;
        }
        $end = new \DateTime();
        $end->setTime(23, 0);
        if ($end->getTimestamp() < $property->getTimestamp()) {
            $this->addError('Späteste Buchung bis 23:00 möglich', 1411999201);
            return false;
        }

        if ($this->options['duration']) {
            $delta = $property->getTimestamp() - $start->getTimestamp();
            $modulus = $delta % ($this->options['duration'] * 60);
            if ($modulus > 1) {
                $this->addError('Anfang und Ende nur zur vollen oder halben Stunde möglich', 1411998803);
                return false;
            }
        }

        return true;
    }

}