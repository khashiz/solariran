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

class HexdataController extends JControllerLegacy
{
	
	function display($cachable = false, $urlparams = false)
	{
		
		$this->showToolbar();
		
		parent::display();
		
	}
	
	function showToolbar()
	{
		
		$view = JRequest::getVar('view', 'hexdata');

		//Adding the submenus
		JSubMenuHelper::addEntry( '<span class="add_item hasTip" title="'.JText::_('DASHBOARD').'">'.JText::_('DASHBOARD').'</span>' , 'index.php?option=com_hexdata&view=hexdata', $view == 'hexdata' );
		
		JSubMenuHelper::addEntry( '<span class="add_item hasTip" title="'.JText::_('PROFILES').'">'.JText::_('PROFILES').'</span>' , 'index.php?option=com_hexdata&view=profiles', $view == 'profiles' );
		
		JSubMenuHelper::addEntry( '<span class="add_item hasTip" title="'.JText::_('IMPORT').'">'.JText::_('IMPORT').'</span>' , 'index.php?option=com_hexdata&view=import', $view == 'import' );
		
	}

}