<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

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
    'Signoff',
    array(
        'Booking' => 'requests, edit, show, create, update, delete, new, confirm',

    ),
    // non-cacheable actions
    array(
        'Booking' => 'requests, edit, show,create, update, delete, new, confirm',
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
        'Json' => 'requests, bookings, occupations,',

    ),
    // non-cacheable actions
    array(
        'Booking' => 'requests, bookings, occupations,',

    )
);

