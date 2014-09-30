<?php
namespace Hri\T3booking\Controller;

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
 * BookingController
 */
class CalendarController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * action public Calendar - each slot shows summarized occupation & capacity
     *
     * @return void
     */
    public function publicAction()
    {
        $date = new \DateTime;

        $this->view->assign('today', $date);
    }


    /**
     * action admin Calendar - each booking is listed individu
     *
     * @return void
     */
    public function adminAction()
    {
        $date = new \DateTime;

        $this->view->assign('today', $date);
    }

    /**
     * action admin Calendar - each booking is listed individu
     *
     * @return void
     */
    public function bookingsAction()
    {
        $date = new \DateTime;

        $this->view->assign('today', $date);
    }



}