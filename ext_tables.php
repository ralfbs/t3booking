<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    $_EXTKEY,
    'Calendar',
    'Calender'
);


\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    $_EXTKEY,
    'Bookings',
    'Bookings, Requests & Lists'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    $_EXTKEY,
    'Json',
    'JSON encoded Data'
);


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Buchung');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_t3booking_domain_model_booking', 'EXT:t3booking/Resources/Private/Language/locallang_csh_tx_t3booking_domain_model_booking.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_t3booking_domain_model_booking');
$GLOBALS['TCA']['tx_t3booking_domain_model_booking'] = array(
    'ctrl' => array(
        'title' => 'LLL:EXT:t3booking/Resources/Private/Language/locallang_db.xlf:tx_t3booking_domain_model_booking',
        'label' => 'start_at',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'dividers2tabs' => TRUE,

        'delete' => 'deleted',
        'enablecolumns' => array(
            'disabled' => 'hidden',

        ),
        'searchFields' => 'start_at,status,end_at,quantity,user,',
        'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Booking.php',
        'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_t3booking_domain_model_booking.gif'
    ),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::makeCategorizable(
    $_EXTKEY,
    'tx_t3booking_domain_model_booking'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::makeCategorizable('t3booking','tx_t3booking_domain_model_booking');


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_t3booking_domain_model_resource', 'EXT:t3booking/Resources/Private/Language/locallang_csh_tx_t3booking_domain_model_resource.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_t3booking_domain_model_resource');
$GLOBALS['TCA']['tx_t3booking_domain_model_resource'] = array(
    'ctrl' => array(
        'title'	=> 'LLL:EXT:t3booking/Resources/Private/Language/locallang_db.xlf:tx_t3booking_domain_model_resource',
        'label' => 'name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'dividers2tabs' => TRUE,

        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => array(
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ),
        'searchFields' => 'name,capacity,',
        'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Resource.php',
        'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_t3booking_domain_model_resource.gif'
    ),
);



// Flexform hinzufügen: Kalendar
$pluginSignature = "t3booking_calendar";
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:t3booking/Configuration/FlexForms/Calendar.xml');

// FlexForm: Bookingslist
$pluginSignature = "t3booking_bookings";
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:t3booking/Configuration/FlexForms/Bookings.xml');
