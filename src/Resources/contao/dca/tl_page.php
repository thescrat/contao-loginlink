<?php

/**
 * Palettes
 */
$GLOBALS['TL_DCA']['tl_page']['palettes']['__selector__'][] = 'loginlink';
$GLOBALS['TL_DCA']['tl_page']['subpalettes']['loginlink'] = 'loginlink_length,loginlink_jumpTo';

\Contao\CoreBundle\DataContainer\PaletteManipulator::create()
    ->addLegend('loginlink_legend', 'layout_legend', \Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_BEFORE, true)
    ->addField(['loginlink'], 'loginlink_legend', \Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('root', 'tl_page')
;


/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_page']['fields']['loginlink'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_page']['loginlink'],
    'exclude'   => true,
    'inputType' => 'checkbox',
    'eval'      => ['submitOnChange' => true, 'tl_class' => 'w50 m12'],
    'sql'       => ['type' => 'string', 'length' => 1, 'notnull' => true, 'fixed' => true, 'default' => '']
];
$GLOBALS['TL_DCA']['tl_page']['fields']['loginlink_length'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_page']['loginlink_length'],
    'exclude'   => true,
    'default'   => '30',
    'inputType' => 'select',
    'options'	=> range(10,50),
    'eval'      => ['tl_class' => 'w50 clr'],
    'sql'       => ['type' => 'string', 'length' => 2, 'notnull' => true, 'fixed' => true, 'default' => '30']
];
$GLOBALS['TL_DCA']['tl_page']['fields']['loginlink_jumpTo'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_page']['loginlink_jumpTo'],
    'exclude'   => true,
    'inputType' => 'pageTree',
    'eval'      => ['fieldType'=>'radio', 'tl_class'=>'clr w50'],
    'sql'       => "int(10) unsigned NOT NULL default '0'",
];



