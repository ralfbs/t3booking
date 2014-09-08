<?php
namespace Hri\T3booking\Service;

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
 * Notification Signal Services
 */
class SignalService extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController implements \TYPO3\CMS\Core\SingletonInterface
{
    /**
     * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManager
     * @inject
     */
    protected $configurationManager;

    /**
     * @param \Hri\T3booking\Domain\Model\Booking $booking
     * @param $signalInformation
     */
    public function handleBookingUpdate(\Hri\T3booking\Domain\Model\Booking $booking, $signalInformation)
    {
        $message = '';
        try {
            $view = $this->createView('Update');
            $view->assign('booking', $booking);
            $message = $view->render();
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $this->log($booking, $signalInformation, $message);
            return;
        }

        /** @var $email \TYPO3\CMS\Core\Mail\MailMessage */

        $email = $this->objectManager->get('TYPO3\\CMS\\Core\\Mail\\MailMessage');
        $message = get_class($email);

        $email->setTo($booking->getUser()->getEmail())
            ->setFrom('webmaster@hr-interactive.de')
            ->setSubject("Buchung bearbeitet");
        // Plain text example
        $email->setBody($message, 'text/plain');

        // HTML Email
        $email->setBody($message, 'text/html');


        try {
            $email->send();
        } catch (\Exception $e) {
            $message .= $e->getMessage();
        }
        $message .= ' isSent: '.$email->isSent();
        $this->log($booking, $signalInformation, $message);
    }

    /**
     * @param \String $emailTemplate
     * @return \TYPO3\CMS\Fluid\View\StandaloneView
     */
    protected function createView($emailTemplate) {
        $extbaseFrameworkConfiguration = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK, 't3booking', 'Bookings');
        $templateRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['templateRootPath']);
        /* @var \TYPO3\CMS\Fluid\View\StandaloneView $view */
        $view = $this->objectManager->get('TYPO3\\CMS\\Fluid\\View\\StandaloneView');
        $templatePathAndFilename = $templateRootPath . 'Email/Update.html';
        $view->setTemplatePathAndFilename($templatePathAndFilename);
        return $view;
    }


    /**
     * @param \Hri\T3booking\Domain\Model\Booking $booking
     * @param $signalInformation
     * @param $message
     */
    protected function log(\Hri\T3booking\Domain\Model\Booking $booking, $signalInformation, $message)
    {

        $date = new \DateTime();
        $log = sprintf("%s: [%s] %s: %s\n", $date->format('d.m.Y: H.i'), $signalInformation, $booking->getUser()->getEmail(), $message);
        $filename = __DIR__ . '/../../../../../slot.log';

        $fp = fopen($filename, "a+");
        fwrite($fp, $log);
        fclose($fp);
    }
}
