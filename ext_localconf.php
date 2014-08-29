<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Hri.' . $_EXTKEY,
    'Calendar',
    array(
        'Booking' => 'public, week, day, year',

    ),
    // non-cacheable actions
    array(
        'Booking' => 'public, day, month, year',

    )
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Hri.' . $_EXTKEY,
    'Request',
    array(
        'Booking' => 'new, create, show',

    ),
    // non-cacheable actions
    array(
        'Booking' => 'new, create, show',

    )
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Hri.' . $_EXTKEY,
    'Admincalendar',
    array(
        'Booking' => 'admin',

    ),
    // non-cacheable actions
    array(
        'Booking' => 'admin ',

    )
);


\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Hri.' . $_EXTKEY,
    'Signoff',
    array(
        'Booking' => 'requests, edit, show, create, update, delete',

    ),
    // non-cacheable actions
    array(
        'Booking' => 'requests, edit, create, update, delete, ',
    )
);


\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Hri.' . $_EXTKEY,
    'Bookingslist',
    array(
        'Booking' => 'bookings, edit, show, create, update, delete',

    ),
    // non-cacheable actions
    array(
        'Booking' => 'bookings, edit, create, update, delete, ',
    )
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Hri.' . $_EXTKEY,
    'Json',
    array(
        'Booking' => 'requestsJson, bookingsJson, occupationJson,',

    ),
    // non-cacheable actions
    array(
        'Booking' => 'requestsJson, bookingsJson, occupationJson,',

    )
);

