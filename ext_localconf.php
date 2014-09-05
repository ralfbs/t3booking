<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Hri.' . $_EXTKEY,
    'Bookings',
    array(
        'Booking' => 'requests, bookings, new, create, edit, show, update, delete, confirm',

    ),
    // non-cacheable actions
    array(
        'Booking' => 'requests, bookings, new, create, edit, show, update, delete, confirm',
    )
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Hri.' . $_EXTKEY,
    'Calendar',
    array(
        'Calendar' => 'public, admin',

    ),
    // non-cacheable actions
    array(
        // 'Calendar' => 'public',

    )
);


\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Hri.' . $_EXTKEY,
    'Json',
    array(
        'Json' => 'requests, bookings, occupations,',

    ),
    // non-cacheable actions
    array(
        'Booking' => 'requests, bookings, occupations,',

    )
);

