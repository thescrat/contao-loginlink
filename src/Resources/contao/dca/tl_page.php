<?php

use \Contao\CoreBundle\DataContainer\PaletteManipulator;


$GLOBALS['TL_DCA']['tl_page']['palettes']['__selector__'][] = 'loginlink';
$GLOBALS['TL_DCA']['tl_page']['subpalettes']['loginlink'] = '';


// Palette
PaletteManipulator::create()
    ->addLegend('loginlink_legend', 'protected_legend', PaletteManipulator::POSITION_BEFORE, true)
    ->addField('loginlink', 'loginlink_legend', PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('root', 'tl_page')
    ->applyToPalette('rootfallback', 'tl_page');
;

// Subpalette
PaletteManipulator::create()
    ->addField('loginlink_jumpTo', 'loginlink')
    ->applyToSubpalette('loginlink','tl_page')
;


/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_page']['fields']['loginlink'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_page']['loginlink'],
    'exclude'   => true,
    'inputType' => 'checkbox',
    'eval'      => ['submitOnChange' => true, 'tl_class' => 'w50'],
    'sql'       => ['type' => 'string', 'length' => 1, 'notnull' => true, 'fixed' => true, 'default' => '']
];
$GLOBALS['TL_DCA']['tl_page']['fields']['loginlink_jumpTo'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_page']['loginlink_jumpTo'],
    'exclude'   => true,
    'inputType' => 'pageTree',
    'eval'      => ['fieldType'=>'radio', 'tl_class'=>'clr w50'],
    'sql'       => "int(10) unsigned NOT NULL default '0'",
];



