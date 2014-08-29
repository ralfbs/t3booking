<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$GLOBALS['TCA']['tx_t3booking_domain_model_booking'] = array(
	'ctrl' => $GLOBALS['TCA']['tx_t3booking_domain_model_booking']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'hidden, start_at, status, end_at, quantity, user',
	),
	'types' => array(
		'1' => array('showitem' => 'hidden;;1, start_at, status, end_at, quantity, user, '),
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
		
	),
);
