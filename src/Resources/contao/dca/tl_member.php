<?php

$GLOBALS['TL_DCA']['tl_member']['palettes'] = str_replace('{account_legend}', '{loginLink_legend},loginLink,loginLinkGen;{account_legend}', $GLOBALS['TL_DCA']['tl_member']['palettes']);

array_insert($GLOBALS['TL_DCA']['tl_member']['fields'],count($GLOBALS['TL_DCA']['tl_member']['fields']),array
(
	'loginLink'         => array
	(
		'label'     	=>  &$GLOBALS['TL_LANG']['tl_member']['loginLink'],
		'inputType'     => 'text',
		'eval'      	=> array('minlength'=> 10, 'unique' => true, 'tl_class'=>'w50'),
		'sql'		    => "varchar(255) NOT NULL default ''"
	),
	'loginLinkGen'   => array
	(
		'label'     	=> &$GLOBALS['TL_LANG']['tl_member']['loginLinkGen'],
		'inputType'     => 'checkbox',
		'eval'      	=> array('tl_class'=>'clr', 'submitOnChange'=>true),
		'save_callback' => array
			(
				array('tl_loginLink','loginLinkGen')
			),
		'sql' 	=> "int(1) unsigned NOT NULL default '0'"
	),

));

class tl_loginLink extends Backend
{
	protected $authKey = '';

	public function loginLinkGen($varValue, DataContainer $dc)
	{
		if($varValue)
		{
		    $this->authKey = substr(uniqid(mt_rand()).uniqid(mt_rand()),0,50);

			\Database::getInstance()->prepare('UPDATE tl_member SET loginLink = ? WHERE id = ?')->execute($this->authKey, $dc->id);
		}
		return 0; // reset checkbox
	}
}