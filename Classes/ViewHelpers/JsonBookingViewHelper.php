<?php
namespace Hri\T3booking\ViewHelpers;

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
use Hri\T3booking\Domain\Model\Booking;

/**
 * Display one Booking (slot) in the booking table
 *
 * Class JsonBookingViewHelper
 * @package Hri\T3booking\Domain\Model
 */
class JsonBookingViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     * register the arguments we might want to use
     */
    public function initializeArguments()
    {
        $this->registerArgument('event', 'object', 'One event from the database');;
    }

    /**
     * @return string
     */
    public function render()
    {
        /* @var Booking $event */
        $event = ($this->arguments['event'] !== null) ? $this->arguments['event'] : null;

        $out = sprintf("start: '%s', end: '%s', title: '%s'",
            $event->getStartAt()->format(\DateTime::ISO8601),
            $event->getEndAt()->format(\DateTime::ISO8601), 'backgroundColor');

        return $out;
    }
}