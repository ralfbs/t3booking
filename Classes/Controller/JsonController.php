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
     * SingalSlotDispatcher
     * @var \TYPO3\CMS\Extbase\SignalSlot\Dispatcher
     * @inject
     */
    protected $signalSlotDispatcher;


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
     * requests - alle offenen Anfragen auflisten
     *
     * @return void
     */
    public function listAction()
    {
        $bookings = $this->bookingRepository->findAllFuture();
        $this->view->assign('bookings', $bookings);
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
        $this->bookingRepository->add($newBooking);
        $this->flashMessageContainer->add('Neue Anfrage erhalten', null, \TYPO3\CMS\Core\Messaging\FlashMessage::OK);
        $this->redirect('public');
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
        $this->bookingRepository->update($booking);
        $this->signalSlotDispatcher->dispatch(__CLASS__, 'bookingUpdate', array('booking' => $booking));
        $this->redirect('requests');
    }

    /**
     * Admin delete
     *
     * @param \Hri\T3booking\Domain\Model\Booking $booking
     * @return void
     */
    public function deleteAction(\Hri\T3booking\Domain\Model\Booking $booking)
    {
        $this->bookingRepository->remove($booking);
        $this->redirect('requests');
    }


    /**
     * action public Calendar
     *
     * @return void
     */
    public function publicAction()
    {
        $date = new \DateTime;

        $this->view->assign('today', $date);
    }


    /**
     * action admin Calendar
     *
     * @return void
     */
    public function adminAction()
    {
        $date = new \DateTime;

        $this->view->assign('today', $date);
    }



    /**
     * find all occupations
     */
    public function occupationJsonAction()
    {
        $date = new \DateTime;

        // Monday 8:00
        $startAt = new \DateTime("8:00");
        $startAt->setISODate($date->format('Y'), $date->format('W'), 1);

        // Sunday 23:00
        $endAt = new \DateTime("23:00");
        $endAt->setISODate($date->format('Y'), $date->format('W'), 7);

        $interval = new \DateInterval('PT30M');


        // Sumarize the bookings per slot
        $slots = array();
        $bookings = $this->bookingRepository->findAllFutureConfirmed();
        $previousTimestamp = 0;
        /* @var \Hri\T3booking\Domain\Model\Booking $booking */
        foreach ($bookings as $booking) {
            $temp = clone $booking->getStartAt();
            while ($temp->getTimestamp() < $booking->getEndAt()->getTimestamp()) {
                $timestamp = $temp->getTimestamp();
                $slots[$timestamp]['quantity'] += $booking->getQuantity();
                $slots[$timestamp]['start'] = $temp->format(\DateTime::ISO8601);
                $temp = $temp->add($interval);
                $slots[$timestamp]['end'] = $temp->format(\DateTime::ISO8601);

                /*
                // if we have the same capacity as before summarize
                if ($slots[$previousTimestamp]['quantity'] == $slots[$timestamp]['quantity']) {
                    $slots[$previousTimestamp]['end'] = $temp->format(\DateTime::ISO8601);
                    unset ($slots[$timestamp]);
                } else {
                    $previousTimestamp = $timestamp;
                }
                */
            }
        }

        // convert
        $occupations = array();
        foreach ($slots as $slot) {
            $occupation['start'] = $slot['start'];
            $occupation['end'] = $slot['end'];
            $occupation['color'] = '#eee';
            $occupation['className'] = 'orange';
            $occupation['title'] = $slot['quantity']; // "über 250 Plätze frei";
            if ($slot['quantity'] > 500) {
                $occupation['color'] = '#cc8400';
                $occupation['className'] = 'orange';
                $occupation['title'] = $slot['quantity']; // 'bis 250 Plätze frei';
            }
            if ($slot['quantity'] > 750) {
                $occupation['color'] = '#cc0000';
                $occupation['className'] = 'red';
                $occupation['title'] = $slot['quantity']; //  'ausgebucht';
            }
            $occupations[] = $occupation;
        }
        return json_encode($occupations);

    }

    /**
     * find all occupations
     * type=5002
     */
    public function bookingsJsonAction()
    {
        $bookings = $this->bookingRepository->findAllFutureConfirmed();
        $events = array();
        /* @var \Hri\T3booking\Domain\Model\Booking $booking */
        foreach ($bookings as $booking) {
            $event['start'] = $booking->getStartAt()->format(\DateTime::ISO8601);
            $event['end'] = $booking->getEndAt()->format(\DateTime::ISO8601);
            $event['title'] = $booking->getQuantity();
            $events[] = $event;
        }
        return json_encode($events);
    }


    /**
     * find all occupations
     * type=5001
     */
    public function requestsJsonAction()
    {
        $bookings = $this->bookingRepository->findAllFutureRequests();
        $events = array();
        /* @var \Hri\T3booking\Domain\Model\Booking $booking */
        foreach ($bookings as $booking) {
            $event['start'] = $booking->getStartAt()->format(\DateTime::ISO8601);
            $event['end'] = $booking->getEndAt()->format(\DateTime::ISO8601);
            $event['title'] = $booking->getQuantity();
            $events[] = $event;
        }
        return json_encode($events);
    }

}