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
class JsonController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * bookingRepository
     *
     * @var \Hri\T3booking\Domain\Repository\BookingRepository
     * @inject
     */
    protected $bookingRepository = NULL;


    /**
     *
     */
    public function initializeAction()
    {

    }


    /**
     * find all occupations Json 5000
     */
    public function availabilitiesAction()
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
            $occupation['className'] = 'green';
            $occupation['title'] = ''; //"genügend freie Plätze";
            if ($slot['quantity'] > 500) {
                $occupation['color'] = '#cc8400';
                $occupation['className'] = 'orange';
                $occupation['title'] = ''; //'weniger als 250 Plätze frei';
            }
            if ($slot['quantity'] > 750) {
                $occupation['color'] = '#cc0000';
                $occupation['className'] = 'red';
                $occupation['title'] = ''; // 'ausgebucht';
            }
            $occupations[] = $occupation;
        }
        return json_encode($occupations);

    }


    /**
     * find all occupations
     */
    public function occupationsAction()
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
     * find all Requests
     * type=5001
     */
    public function requestsAction()
    {
        $bookings = $this->bookingRepository->findAllFutureRequests();
        $events = array();
        /* @var \Hri\T3booking\Domain\Model\Booking $booking */
        foreach ($bookings as $booking) {
            $event['start'] = $booking->getStartAt()->format(\DateTime::ISO8601);
            $event['end'] = $booking->getEndAt()->format(\DateTime::ISO8601);
            $event['title'] = $this->getTitle($booking);
            $event['tooltip'] = 'Anfrage: ' . $this->getTitle($booking);
            if ($booking->getConfirmComment()) {
                $event['tooltip'] .= ': ' . $booking->getConfirmComment();
            }
            $events[] = $event;
        }
        return json_encode($events);
    }

    /**
     * find all Bookings
     * type=5002
     */
    public function bookingsAction()
    {
        $bookings = $this->bookingRepository->findAllFutureConfirmed();
        $events = array();
        /* @var \Hri\T3booking\Domain\Model\Booking $booking */
        foreach ($bookings as $booking) {
            $event['start'] = $booking->getStartAt()->format(\DateTime::ISO8601);
            $event['end'] = $booking->getEndAt()->format(\DateTime::ISO8601);
            $event['title'] = $this->getTitle($booking);
            $event['title'] = $this->getTitle($booking);
            $event['tooltip'] = 'Buchung: ' . $this->getTitle($booking);
            if ($booking->getConfirmComment()) {
                $event['tooltip'] .= ': ' . $booking->getConfirmComment();
            }
            $events[] = $event;
        }
        return json_encode($events);
    }


    /**
     * @param \Hri\T3booking\Domain\Model\Booking $booking
     * @return \String
     */
    protected function getTitle(\Hri\T3booking\Domain\Model\Booking $booking)
    {
        $company = '';
        if ($booking->getUser() instanceof \TYPO3\CMS\Extbase\Domain\Model\FrontendUser) {
            $company = $booking->getUser()->getCompany();
        }

        $getTitle = sprintf("%s | %s | %s Personen", $company, $booking->getClassification(), $booking->getQuantity());
        return $getTitle;
    }
}