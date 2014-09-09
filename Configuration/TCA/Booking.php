<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

$GLOBALS['TCA']['tx_t3booking_domain_model_booking'] = array(
    'ctrl' => $GLOBALS['TCA']['tx_t3booking_domain_model_booking']['ctrl'],
    'interface' => array(
        'showRecordFieldList' => 'hidden, start_at, end_at, quantity, status, user, comment, created_at, confirm_at, confirm_by, confirm_comment, resource, classification,',
    ),
    'types' => array(
        '1' => array('showitem' => 'hidden;;1, start_at, end_at, quantity, status, user, comment, created_at, confirm_at, confirm_by, confirm_comment, resource, classification,'),
    ),
    'palettes' => array(
        '1' => array('showitem' => ''),
    ),
    'columns' => array(

        'hidden' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
            'config' => array(
                'type' => 'check',
            ),
        ),

        'start_at' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:t3booking/Resources/Private/Language/locallang_db.xlf:tx_t3booking_domain_model_booking.start_at',
            'config' => array(
                'type' => 'input',
                'size' => 10,
                'eval' => 'datetime',
                'checkbox' => 1,
                'default' => time()
            ),
        ),
        'end_at' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:t3booking/Resources/Private/Language/locallang_db.xlf:tx_t3booking_domain_model_booking.end_at',
            'config' => array(
                'type' => 'input',
                'size' => 10,
                'eval' => 'datetime',
                'checkbox' => 1,
                'default' => time()
            ),
        ),
        'quantity' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:t3booking/Resources/Private/Language/locallang_db.xlf:tx_t3booking_domain_model_booking.quantity',
            'config' => array(
                'type' => 'input',
                'size' => 4,
                'eval' => 'int'
            )
        ),
        'status' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:t3booking/Resources/Private/Language/locallang_db.xlf:tx_t3booking_domain_model_booking.status',
            'config' => array(
                'type' => 'input',
                'size' => 6,
                'checkbox' => 1,
                'default' => 0
            )
        ),
        'user' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:t3booking/Resources/Private/Language/locallang_db.xlf:tx_t3booking_domain_model_booking.user',
            'config' => array(
                'type' => 'select',
                'foreign_table' => 'fe_users',
                'minitems' => 0,
                'maxitems' => 1,
            ),
        ),
        'comment' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:t3booking/Resources/Private/Language/locallang_db.xlf:tx_t3booking_domain_model_booking.comment',
            'config' => array(
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            )
        ),
        'created_at' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:t3booking/Resources/Private/Language/locallang_db.xlf:tx_t3booking_domain_model_booking.created_at',
            'config' => array(
                'type' => 'input',
                'size' => 10,
                'eval' => 'datetime',
                'checkbox' => 1,
                'default' => time()
            ),
        ),
        'resource' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:t3booking/Resources/Private/Language/locallang_db.xlf:tx_t3booking_domain_model_booking.resource',
            'config' => array(
                'type' => 'select',
                'foreign_table' => 'tx_t3booking_domain_model_resource',
                'minitems' => 0,
                'maxitems' => 1,
            ),
        ),
        'classification' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:t3booking/Resources/Private/Language/locallang_db.xlf:tx_t3booking_domain_model_booking.classification',
            'config' => array(
                'type' => 'select',
                'foreign_table' => 'tx_t3booking_domain_model_classification',
                'minitems' => 0,
                'maxitems' => 1,
            ),
        ),
        'confirm_at' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:t3booking/Resources/Private/Language/locallang_db.xlf:tx_t3booking_domain_model_booking.confirm_at',
            'config' => array(
                'type' => 'input',
                'size' => 10,
                'eval' => 'datetime',
                'checkbox' => 1,
                'default' => time()
            ),
        ),
        'confirm_by' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:t3booking/Resources/Private/Language/locallang_db.xlf:tx_t3booking_domain_model_booking.confirm_by',
            'config' => array(
                'type' => 'select',
                'foreign_table' => 'fe_users',
                'minitems' => 0,
                'maxitems' => 1,
            ),
        ),
        'confirm_comment' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:t3booking/Resources/Private/Language/locallang_db.xlf:tx_t3booking_domain_model_booking.confirm_comment',
            'config' => array(
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            )
        ),

    ),
);
