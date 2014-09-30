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
class EmailService extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController implements \TYPO3\CMS\Core\SingletonInterface
{
    /**
     * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManager
     * @inject
     */
    protected $configurationManager;

    /**
     * @var array
     */
    protected $settings;

    /**
     * @var \TYPO3\CMS\Core\Log\Logger
     */
    protected $logger;

    /**
     * @var \TYPO3\CMS\Core\Mail\MailMessage
     */
    protected $mailMessage;


    /**
     * initialize this object
     */
    public function init()
    {
        $this->settings = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS, 't3booking', 'Bookings');

        $this->logger = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Core\Log\LogManager')->getLogger(__CLASS__);

        $this->mailMessage = $this->objectManager->get('TYPO3\\CMS\\Core\\Mail\\MailMessage');
        $this->mailMessage->setFrom($this->settings['emailFromAddress'], $this->settings['emailFromName']);
    }


    /**
     * @param \Hri\T3booking\Domain\Model\Booking $booking
     * @param $signalInformation
     */
    public function handleBookingRequest(\Hri\T3booking\Domain\Model\Booking $booking, $signalInformation)
    {
        $this->init();

        $this->mailMessage->setSubject($this->settings['emailSubjectRequest']);
        $this->processMail($booking, 'Create');
    }


    /**
     * @param \Hri\T3booking\Domain\Model\Booking $booking
     * @param $signalInformation
     */
    public function handleBookingConfirm(\Hri\T3booking\Domain\Model\Booking $booking, $signalInformation)
    {
        $this->init();

        $this->mailMessage->setSubject($this->settings['emailSubjectConfirm']);
        $this->processMail($booking, 'Confirm');
    }


    /**
     * @param \Hri\T3booking\Domain\Model\Booking $booking
     * @param $signalInformation
     */
    public function handleBookingUpdate(\Hri\T3booking\Domain\Model\Booking $booking, $signalInformation)
    {
        $this->init();

        $this->mailMessage->setSubject($this->settings['emailSubjectUpdate']);
        $this->processMail($booking, 'Update');
    }


    /**
     * @param \Hri\T3booking\Domain\Model\Booking $booking
     * @param $signalInformation
     */
    public function handleBookingDelete(\Hri\T3booking\Domain\Model\Booking $booking, $signalInformation)
    {
        $this->init();

        $this->mailMessage->setSubject($this->settings['emailSubjectDelete']);
        $this->processMail($booking, 'Delete');
    }


    /**
     * @param \Hri\T3booking\Domain\Model\Booking $booking
     * @param string $template
     */
    protected function processMail(\Hri\T3booking\Domain\Model\Booking $booking, $template = 'Create')
    {
        if (!$booking->getUser()) {
            $this->logger->info('no user assigned to booking');
            return;
        }

        try {
            $view = $this->createView($template);
            $view->assign('booking', $booking);
            $message = $view->render();
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $this->logger->error($message);
            return;
        }
        $this->mailMessage->setBody($message, 'text/html');
        $this->mailMessage->setBody(strip_tags($message), 'text/plain');

        $this->mailMessage->addTo($booking->getUser()->getEmail(), $booking->getUser()->getName());

        try {
            $this->mailMessage->send();
        } catch (\Exception $e) {
            $message .= $e->getMessage();
            $this->logger->error($message);
            return;
        }
        $this->logger->info($this->mailMessage->getBody());
    }


    /**
     * @param \String $emailTemplate
     * @return \TYPO3\CMS\Fluid\View\StandaloneView
     */
    protected function createView($emailTemplate, $ext = 'html')
    {
        $extbaseFrameworkConfiguration = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK, 't3booking', 'Bookings');
        $templateRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['templateRootPath']);
        $layoutRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['layoutRootPath']);

        /* @var \TYPO3\CMS\Fluid\View\StandaloneView $view */
        $view = $this->objectManager->get('TYPO3\\CMS\\Fluid\\View\\StandaloneView');
        $templatePathAndFilename = $templateRootPath . "Email/{$emailTemplate}.{$ext}";
        $view->setTemplatePathAndFilename($templatePathAndFilename);
        $view->setLayoutRootPath($layoutRootPath);
        return $view;
    }

    /**
     * @param $signalInformation
     * @param $message
     */
    protected function log($message)
    {
        $date = new \DateTime();
        $log = sprintf("%s: %s\n", $date->format('d.m.Y: H.i'), $message);
        $filename = PATH_site . '/typo3temp/logs/slot.log';

        $fp = fopen($filename, "a+");
        fwrite($fp, $log);
        fclose($fp);
    }
}
