<?php
namespace Hri\T3booking\Tests\Unit\Controller;
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
 * Test case for class Hri\T3booking\Controller\BookingController.
 *
 * @author Ralf Schneider <ralf@hr-interactive.com>
 */
class BookingControllerTest extends \TYPO3\CMS\Extbase\Tests\Unit\BaseTestCase
{

    /**
     * @var \Hri\T3booking\Controller\BookingController
     */
    protected $subject = NULL;

    protected function setUp()
    {
        $this->subject = $this->getMock('Hri\\T3booking\\Controller\\BookingController', array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);

        $this->classificationRepository = $this->getMock('Hri\\T3booking\\Domain\\Repository\\ClassificationRepository', array('findAll'), array(), '', FALSE);
        $this->inject($this->subject, 'classificationRepository', $this->classificationRepository);
    }

    protected function tearDown()
    {
        unset($this->subject);
    }


    /**
     * @test
     */
    public function showActionAssignsTheGivenBookingToView()
    {
        $booking = new \Hri\T3booking\Domain\Model\Booking();

        $view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
        $this->inject($this->subject, 'view', $view);
        $view->expects($this->once())->method('assign')->with('booking', $booking);

        $this->subject->showAction($booking);
    }

    /**
     * @test
     */
    public function newActionAssignsTheGivenBookingToView()
    {
        $booking = new \Hri\T3booking\Domain\Model\Booking();

        $this->classificationRepository->expects($this->once())->method('findAll');

        $view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
        $view->expects($this->exactly(2))->method('assign');
        $this->inject($this->subject, 'view', $view);

        $this->subject->newAction($booking);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenBookingToBookingRepository()
    {
        $booking = new \Hri\T3booking\Domain\Model\Booking();

        $allClassifications = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);

        $classificationRepository = $this->getMock('Hri\\T3booking\\Domain\\Repository\\ClassificationRepository', array('findAll'), array(), '', FALSE);
        $classificationRepository->expects($this->once())->method('findAll')->will($this->returnValue($allClassifications));
        $this->inject($this->subject, 'classificationRepository', $classificationRepository);

        $allFrontendUsers = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);

        $frontendUserRepository = $this->getMock('Hri\\T3booking\\Domain\\Repository\\FrontendUserRepository', array('findByUid'), array(), '', FALSE);
        $frontendUserRepository->expects($this->once())->method('findAll')->will($this->returnValue($allFrontendUsers));
        $this->inject($this->subject, 'frontendUserRepository', $frontendUserRepository);

        $bookingRepository = $this->getMock('Hri\\T3booking\\Domain\\Repository\\BookingRepository', array('add'), array(), '', FALSE);
        $bookingRepository->expects($this->once())->method('add')->with($booking);
        $this->inject($this->subject, 'bookingRepository', $bookingRepository);

        $persistenceRepository = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager', array('persistAll'), array(), '', FALSE);
        $persistenceRepository->expects($this->once())->method('persistAll');
        $this->inject($this->subject, 'persistenceRepository', $persistenceRepository);

        $this->subject->createAction($booking);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenBookingToView()
    {
        $booking = new \Hri\T3booking\Domain\Model\Booking();

        $view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
        $this->inject($this->subject, 'view', $view);
        $view->expects($this->once())->method('assign')->with('booking', $booking);

        $this->subject->editAction($booking);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenBookingInBookingRepository()
    {
        $booking = new \Hri\T3booking\Domain\Model\Booking();

        $bookingRepository = $this->getMock('Hri\\T3booking\\Domain\\Repository\\BookingRepository', array('update'), array(), '', FALSE);
        $bookingRepository->expects($this->once())->method('update')->with($booking);
        $this->inject($this->subject, 'bookingRepository', $bookingRepository);

        $this->subject->updateAction($booking);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenBookingFromBookingRepository()
    {
        $booking = new \Hri\T3booking\Domain\Model\Booking();

        $bookingRepository = $this->getMock('Hri\\T3booking\\Domain\\Repository\\BookingRepository', array('remove'), array(), '', FALSE);
        $bookingRepository->expects($this->once())->method('remove')->with($booking);
        $this->inject($this->subject, 'bookingRepository', $bookingRepository);

        $this->subject->deleteAction($booking);
    }
}
