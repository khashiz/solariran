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

class HexdataViewImport extends JViewLegacy
{    
    function display($tpl = null)
    {
		
		$mainframe = JFactory::getApplication();
		$document = JFactory::getDocument();
		
		$layout = JRequest::getCmd('layout', '');
		
		if($layout=="import")	{
			
			$document->addScript(JURI::root().'media/com_hexdata/js/jquery.ui.datepicker.js');
			$document->addStyleSheet(JURI::root().'media/com_hexdata/css/jquery.ui.theme.css');
			$document->addStyleSheet(JURI::root().'media/com_hexdata/css/jquery.ui.datepicker.css');
			
			jimport('joomla.html.pane');
			
			$this->profile = $this->get('Profile');			
			
			JToolBarHelper::title( $this->profile->title.' '.JText::_( 'IMPORT' ), 'import' );
			JToolBarHelper::apply('import_now', JText::_('IMPORT_NOW'));
			JToolBarHelper::cancel('close');
		
		}
		
		else	{
			
			JToolBarHelper::title( JText::_( 'IMPORT_DATA' ), 'import' );
			JToolBarHelper::apply('importready', JText::_('CONTINUE'));
			JToolBarHelper::cancel();
			
			$this->profiles = $this->get('Profiles');
		
		}
							
		parent::display($tpl);
        
    }
  
  
}
