<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');



/**
 * System configuration
 */
$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] .= ';{login_link_legend},login_link_autoKey,login_link_defaultKeyLength';


array_insert($GLOBALS['TL_DCA']['tl_settings'],count($GLOBALS['TL_DCA']['tl_settings']),array
(
	// PALETTES
	'palettes'	=> array
	(
		'__selector__'      => array
		(
		),
	),


	// FIELDS
	'fields'	=> array
	(
		'login_link_autoKey' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['login_link_autoKey'],
			'inputType'                 => 'checkbox',
			'eval'                    => array('tl_class'=>'clr')
		),
		'login_link_defaultKeyLength' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['login_link_defaultKeyLength'],
			'default'				=> '15',
			'inputType'        => 'select',
			'options'				=> range(10,50),
			'eval'                    => array('tl_class'=>'clr')
		),
	)
));