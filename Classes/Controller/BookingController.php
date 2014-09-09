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
use Hri\T3booking\Domain\Model\Booking;


/**
 * BookingController
 */
class BookingController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * bookingRepository
     *
     * @var \Hri\T3booking\Domain\Repository\BookingRepository
     * @inject
     */
    protected $bookingRepository = NULL;


    /**
     * classificationRepository
     *
     * @var \Hri\T3booking\Domain\Repository\ClassificationRepository
     * @inject
     */
    protected $classificationRepository = NULL;


    /**
     * userRepository
     *
     * @var \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository
     * @inject
     */
    protected $frontendUserRepository;


    /**
     * SingalSlotDispatcher
     * @var \TYPO3\CMS\Extbase\SignalSlot\Dispatcher
     * @inject
     */
    protected $signalSlotDispatcher;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
     * @inject
     */
    protected $persistenceManager;

    /**
     *
     */
    public function initializeAction()
    {
        // this configures the parsing
        if (isset($this->arguments['newBooking'])) {
            $this->arguments['newBooking']
                ->getPropertyMappingConfiguration()
                ->forProperty('startAt')
                ->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter',
                    \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd.m.Y H:i');

            $this->arguments['newBooking']
                ->getPropertyMappingConfiguration()
                ->forProperty('endAt')
                ->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter',
                    \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd.m.Y H:i');

        }

        // this configures the parsing
        if (isset($this->arguments['booking'])) {
            $this->arguments['booking']
                ->getPropertyMappingConfiguration()
                ->forProperty('startAt')
                ->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter',
                    \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd.m.Y H:i');

            $this->arguments['booking']
                ->getPropertyMappingConfiguration()
                ->forProperty('endAt')
                ->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter',
                    \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd.m.Y H:i');
        }
    }


    /**
     * New: Öffentliche Anfrage
     *
     * @param \Hri\T3booking\Domain\Model\Booking $newBooking
     * @ignorevalidation $newBooking
     * @return void
     */
    public function newAction(\Hri\T3booking\Domain\Model\Booking $newBooking = NULL)
    {
        $classifications = $this->classificationRepository->findAll();
        $this->view->assign('classifications', $classifications);
        $this->view->assign('newBooking', $newBooking);
    }

    /**
     * Create: Öffentliche Anfrage speichern
     *
     * @param \Hri\T3booking\Domain\Model\Booking $newBooking
     * @return void
     */
    public function createAction(\Hri\T3booking\Domain\Model\Booking $newBooking)
    {
        $newBooking->setStatus(\Hri\T3booking\Domain\Model\Booking::REQUEST);
        $user = $GLOBALS['TSFE']->fe_user->user;
        $feuser = $this->frontendUserRepository->findByUid($user['uid']);
        if ($feuser instanceof \TYPO3\CMS\Extbase\Domain\Model\FrontendUser) {
            $newBooking->setUser($feuser);
        }
        $newBooking->setCreatedAt(new \DateTime());
        $this->bookingRepository->add($newBooking);
        $this->persistenceManager->persistAll();

        $this->signalSlotDispatcher->dispatch(__CLASS__, 'bookingCreate', array('booking' => $newBooking));

        $flashMessage = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_t3booking.flashmessage.request', 't3booking');
        $this->flashMessageContainer->add($flashMessage, null, \TYPO3\CMS\Core\Messaging\FlashMessage::OK);
        // $this->redirect('show', null, null, array('booking' => $newBooking));

        $uri = $this->uriBuilder->setTargetPageUid($GLOBALS['TSFE']->id)->build();
        $this->redirectToURI($uri);
    }


    /**
     * Admin: requests - alle offenen Anfragen auflisten
     *
     * @return void
     */
    public function requestsAction()
    {
        $bookings = $this->bookingRepository->findAllFutureRequests();
        $this->view->assign('bookings', $bookings);
    }

    /**
     * Admin: bookings - alle fixen Buchungen auflisten
     *
     * @return void
     */
    public function bookingsAction()
    {
        $bookings = $this->bookingRepository->findAllFutureConfirmed();
        $this->view->assign('bookings', $bookings);
    }

    /**
     * requests - alle auflisten
     *
     * @return void
     */
    public function listAction()
    {
        $bookings = $this->bookingRepository->findAllFuture();
        $this->view->assign('bookings', $bookings);
    }

    /**
     * Admin: Show
     *
     * @param \Hri\T3booking\Domain\Model\Booking $booking
     * @return void
     */
    public function showAction(\Hri\T3booking\Domain\Model\Booking $booking)
    {
        $this->view->assign('booking', $booking);
    }


    /**
     * Admin: Edit
     *
     * @param \Hri\T3booking\Domain\Model\Booking $booking
     * @ignorevalidation $booking
     * @return void
     */
    public function editAction(\Hri\T3booking\Domain\Model\Booking $booking)
    {
        $this->view->assign('booking', $booking);
    }

    /**
     * Admin: Update
     *
     * @param \Hri\T3booking\Domain\Model\Booking $booking
     * @return void
     */
    public function updateAction(\Hri\T3booking\Domain\Model\Booking $booking)
    {
        $flashMessage = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_t3booking.flashmessage.update', 't3booking');
        $this->flashMessageContainer->add($flashMessage, null, \TYPO3\CMS\Core\Messaging\FlashMessage::OK);
        $this->bookingRepository->update($booking);
        $this->signalSlotDispatcher->dispatch(__CLASS__, 'bookingUpdate', array('booking' => $booking));

        $uri = $this->uriBuilder->setTargetPageUid($GLOBALS['TSFE']->id)->build();
        $this->redirectToURI($uri);
    }

    /**
     * Admin delete
     *
     * @param \Hri\T3booking\Domain\Model\Booking $booking
     * @return void
     */
    public function deleteAction(\Hri\T3booking\Domain\Model\Booking $booking)
    {
        $flashMessage = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_t3booking.flashmessage.delete', 't3booking');
        $this->flashMessageContainer->add($flashMessage, null, \TYPO3\CMS\Core\Messaging\FlashMessage::OK);
        $this->bookingRepository->remove($booking);
        $this->signalSlotDispatcher->dispatch(__CLASS__, 'bookingDelete', array('booking' => $booking));

        $uri = $this->uriBuilder->setTargetPageUid($GLOBALS['TSFE']->id)->build();
        $this->redirectToURI($uri);
    }


    /**
     * Admin delete
     *
     * @param \Hri\T3booking\Domain\Model\Booking $booking
     * @return void
     */
    public function confirmAction(\Hri\T3booking\Domain\Model\Booking $booking)
    {
        $user = $GLOBALS['TSFE']->fe_user->user;
        $feuser = $this->frontendUserRepository->findByUid($user['uid']);
        if ($feuser instanceof \TYPO3\CMS\Extbase\Domain\Model\FrontendUser) {
            $booking->setConfirmBy($feuser);
        }
        $booking->setConfirmAt(new \DateTime());
        $flashMessage = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_t3booking.flashmessage.confirm', 't3booking');
        $this->flashMessageContainer->add($flashMessage, null, \TYPO3\CMS\Core\Messaging\FlashMessage::OK);
        $booking->setStatus(Booking::CONFIRMED);
        $this->bookingRepository->update($booking);
        $this->signalSlotDispatcher->dispatch(__CLASS__, 'bookingConfirm', array('booking' => $booking));

        $uri = $this->uriBuilder->setTargetPageUid($GLOBALS['TSFE']->id)->build();
        $this->redirectToURI($uri);
    }

}