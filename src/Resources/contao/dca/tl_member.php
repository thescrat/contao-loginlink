<?php


use Contao\CoreBundle\DataContainer\PaletteManipulator;
use Contao\ArrayUtil;
use Contao\Config;

ArrayUtil::arrayInsert($GLOBALS['TL_DCA']['tl_member']['fields'],count($GLOBALS['TL_DCA']['tl_member']['fields']),array
(
	'loginLink'         =>
	[
		'label'     	=>  &$GLOBALS['TL_LANG']['tl_member']['loginLink'],
		'inputType'     => 'text',
		'eval'      	=> ['minlength'=> 10, 'unique' => true, 'tl_class'=>'w50'],
        'load_callback' =>
        [
            ['tl_loginLink','onLoadGenerateKey']
        ],
		'sql'		    => "varchar(255) NOT NULL default ''"
	],
	'loginLinkGen'   =>
	[
		'label'     	=> &$GLOBALS['TL_LANG']['tl_member']['loginLinkGen'],
		'inputType'     => 'checkbox',
		'eval'      	=> ['tl_class'=>'clr', 'submitOnChange'=>true],
		'save_callback' =>
        [
            ['tl_loginLink','generateNewLoginKey']
        ],
		'sql' 	=> "int(1) unsigned NOT NULL default '0'"
	],
));

$palette = PaletteManipulator::create()
    ->addLegend('loginLink_legend', 'account_legend', PaletteManipulator::POSITION_BEFORE)
    ->addField('loginLink', 'loginLink_legend', PaletteManipulator::POSITION_APPEND);

// if Checkbox-Generator is set (Settings)
Config::get('login_link_generateCheckbox') ?
    $palette->addField('loginLinkGen', 'loginLink_legend', PaletteManipulator::POSITION_APPEND) : '';

$palette->applyToPalette('default', 'tl_member');

class tl_loginLink extends Backend
{
	protected $authKey = '';

    protected function generateUniqueKey(){

        // set default-length
        $intLength = null != Config::get('login_link_defaultKeyLength') ? Config::get('login_link_defaultKeyLength') : 25;
        $strKey = substr(uniqid(mt_rand()).uniqid(mt_rand()),0,$intLength);

        if(null == MemberModel::findBy('loginLink',$strKey))
            return $strKey;

        $this->generateUniqueKey();
		}

    public function onLoadGenerateKey($varValue, DataContainer $dc){

            //check if key exist AND autokey is set (Settings)
            if(!strlen($varValue) && Config::get('login_link_autoKey'))
                return $this->generateUniqueKey();
            return $varValue;
    }

	public function generateNewLoginKey($varValue, DataContainer $dc)
	{
		if($varValue):
            $objMember = MemberModel::findById($dc->id);
            $objMember->loginLink = $this->generateUniqueKey();
            $objMember->save();
		endif;
		return 0; // reset checkbox
	}
}
