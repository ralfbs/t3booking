<?php

namespace Hri\T3booking\Tests\Unit\Validation\Validator;

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
class TimeValidatorTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{

    /**
     * @var \Hri\T3booking\Validation\Validator\TimeValidator
     */
    protected $subject = NULL;

    protected function setUp()
    {
        $this->subject = new \Hri\T3booking\Validation\Validator\TimeValidator(array('duration' => 30));
    }

    protected function tearDown()
    {
        unset($this->subject);
    }

    public function testIsValidator()
    {
        $this->assertInstanceOf('\Hri\T3booking\Validation\Validator\TimeValidator', $this->subject);
    }

    public function testBefore8IsNotValid()
    {
        $date = new \DateTime();
        $date->setTime(6, 0);
        $this->assertFalse($this->subject->isValid($date));
    }

    public function testAfter8IsValid()
    {
        $date = new \DateTime();
        $date->setTime(8, 0);
        $this->assertTrue($this->subject->isValid($date));
    }

    public function testAfter23IsNotValid()
    {
        $date = new \DateTime();
        $date->setTime(23, 30);
        $this->assertFalse($this->subject->isValid($date));
    }
    public function test23IsValid()
    {
        $date = new \DateTime();
        $date->setTime(23, 0);
        $this->assertTrue($this->subject->isValid($date));
    }

    public function testOddMinutesIsNotValid()
    {
        $date = new \DateTime();
        $date->setTime(12, 44);

        $this->assertFalse($this->subject->isValid($date), $date->format('d.m.Y H:i:s'));
    }

    public function testHalfHourIsValid()
    {
        $date = new \DateTime();
        $date->setTime(12, 30);
        $this->assertTrue($this->subject->isValid($date));
    }

}