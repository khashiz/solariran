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
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die(); 

class HexdataViewHexdata extends JViewLegacy
{
    
    function display($tpl = null)
    {
		
		$document =  JFactory::getDocument();
		
		$bar = JToolBar::getInstance('toolbar');
		
		JToolBarHelper::title( JText::_( 'HexData' ), 'hexdata' );
		$bar->appendButton('Link', 'import', JText::_('IMPORT_NOW'), 'index.php?option=com_hexdata&view=import');
		JToolBarHelper::help('help', true);
				
		parent::display($tpl);
		        
    }
  
  
}
