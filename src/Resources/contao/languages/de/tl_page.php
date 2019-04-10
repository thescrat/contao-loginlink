<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');


/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_page']['loginlink_legend'] 	= 'Login-Link Einstellungen';


/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_page']['loginlink'] 		= array('Erlaube Login mit LoginKey','Anhängen an jede URL möglich! z.B. /index.html?key=L3Tm3lN');
$GLOBALS['TL_LANG']['tl_page']['loginlink_length']	= array('Länge des Keys','Wird automatisch generiert sobald sich ein neuer User registriert');
$GLOBALS['TL_LANG']['tl_page']['loginlink_jumpTo']	= array('Weiterleitungsseite', 'Vorsicht: Wenn eine Seite ausgewählt wurde, wird das Mitglied beim Login per Key immer auf die angegebene Seite weitergeleitet. Wird keine Seite gewählt erfolgt der Login auf der Seite die angegeben wurde!Geschützte Seiten sind nicht möglich. Hierfür den Parameter &redirect= und den Alias der geschützten Seite angeben');
