<?php

use Contao\CoreBundle\DataContainer\PaletteManipulator;
use Contao\ArrayUtil;

PaletteManipulator::create()
    ->addLegend('login_link_legend', 'cron_legend', PaletteManipulator::POSITION_AFTER)
    ->addField('login_link_autoKey', 'login_link_legend', PaletteManipulator::POSITION_APPEND)
    ->addField('login_link_readonly', 'login_link_legend', PaletteManipulator::POSITION_APPEND)
    ->addField('login_link_generateCheckbox', 'login_link_legend', PaletteManipulator::POSITION_APPEND)
    ->addField('login_link_defaultKeyLength', 'login_link_legend', PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('default', 'tl_settings');

ArrayUtil::arrayInsert($GLOBALS['TL_DCA']['tl_settings'], count($GLOBALS['TL_DCA']['tl_settings']),
[
    // FIELDS
    'fields' =>
    [
        'login_link_autoKey' =>
        [
            'label' => &$GLOBALS['TL_LANG']['tl_settings']['login_link_autoKey'],
            'inputType' => 'checkbox',
            'eval' => ['tl_class' => 'clr']
        ],
        'login_link_readonly' =>
        [
            'label' => &$GLOBALS['TL_LANG']['tl_settings']['login_link_readonly'],
            'inputType' => 'checkbox',
            'eval' => ['tl_class' => 'clr']
        ],
        'login_link_generateCheckbox' =>
        [
            'label' => &$GLOBALS['TL_LANG']['tl_settings']['login_link_generateCheckbox'],
            'inputType' => 'checkbox',
            'eval' => ['tl_class' => 'clr']
        ],
        'login_link_defaultKeyLength' =>
        [
            'label' => &$GLOBALS['TL_LANG']['tl_settings']['login_link_defaultKeyLength'],
            'default' => '25',
            'inputType' => 'select',
            'options' => range(10, 50),
            'eval' => ['tl_class' => 'clr']
        ],
    ]
]);
