<?php
/*------------------------------------------------------------------------
# com_hexdata - HexData
# ------------------------------------------------------------------------
# author    Team WDMtech
# copyright Copyright (C) 2014 www.wdmtech.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.wdmtech.com
# Technical Support:  Forum - http://www.wdmtech.com/support-forum
-----------------------------------------------------------------------*/
// No direct access
defined('_JEXEC') or die('Restricted access');

// Access check
$user = JFactory::getUser();
if (!$user->authorise('core.manage', 'com_hexdata')) {
	return JError::raiseError(403, JText::_('JERROR_ALERTNOAUTHOR'));
}

//import the assets css, js
$document = JFactory::getDocument();
$document->addStyleSheet(JURI::root().'media/com_hexdata/css/adminstyle.css');
$document->addScript(JURI::root().'media/com_hexdata/js/jquery.js');
$document->addScript(JURI::root().'media/com_hexdata/js/noconflict.js');
$document->addScript(JURI::root().'media/com_hexdata/js/jqueryui.js');

$js = '$hd(function() {$hd("#hexdatapanel").prepend("<div class=\"loading\"><div class=\"loading-icon\"><div></div></div></div>"); });';
$document->addScriptDeclaration($js);

$controller = JRequest::getWord('view', 'hexdata');

// Require the base controller
require_once( JPATH_ADMINISTRATOR.'/components/com_hexdata/controller.php' );
 
// Require specific controller if requested
if($controller) {
    $path = JPATH_ADMINISTRATOR.'/components/com_hexdata/controllers/'.$controller.'.php';
    if (file_exists($path)) {
        require_once $path;
    } else {
        $controller = '';
    }
}

// Create the controller
$classname    = 'HexdataController'.$controller;
$controller   = new $classname( );
 
// Perform the Request task
$controller->execute( JRequest::getVar( 'task' ) );

// Redirect if set by the controller
$controller->redirect();

echo '<div class="copyright" align="center"><a href="http://www.wdmtech.com/hexdata" target="_blank">HexData 1.1.0</a> by <a href="http://www.wdmtech.com" target="_blank">WDMtech</a></div>';