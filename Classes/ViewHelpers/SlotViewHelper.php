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

/**
 * Display one Slot (cell) in the booking table
 *
 * Class SlotViewHelper
 * @package Hri\T3booking\Domain\Model
 */
class SlotViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper
{

    /**
     * name of the tag to be created by this view helper
     *
     * @var string
     */
    protected $tagName = 'td';

    /**
     * register the arguments we might want to use
     */
    public function initializeArguments()
    {
        $this->registerArgument('day', 'integer', 'ID of the day', false);
        $this->registerArgument('time', 'integer', 'ID of the time', false);
        // $slots[$timekey][$day] => array('color' => 'green', 'time' => DateTime)
        $this->registerArgument('slots', 'array', 'array with all booking info', false);
    }

    /**
     * @return string
     */
    public function render()
    {
        $day = ($this->arguments['day'] !== null) ? $this->arguments['day'] : null;
        $time = ($this->arguments['time'] !== null) ? $this->arguments['time'] : null;
        $slots = ($this->arguments['slots'] !== null) ? $this->arguments['slots'] : null;

        $slot = $slots[$time][$day];

        $status = 'green';
        if (($slot['count']) > 500) {
            $status = 'orange';
        }
        if (($slot['count']) > 750) {
            $status = 'red';
        }

        $class = sprintf("day_%d status_%s", $day, $status);
        $this->tag->addAttribute('class', $class);
        $this->tag->setContent($time);
        $this->tag->addAttribute('title', $slot['count']);
        return $this->tag->render();
    }
}