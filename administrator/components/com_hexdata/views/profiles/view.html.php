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
defined('_JEXEC') or die(); 

class HexdataViewProfiles extends JViewLegacy
{
    
    function display($tpl = null)
    {
		
		$mainframe = JFactory::getApplication();
		$context			= 'com_hexdata.profiles.list.';
		$layout = JRequest::getCmd('layout', '');
		
		$filter_order     = $mainframe->getUserStateFromRequest( $context.'filter_order', 'filter_order', 'id', 'cmd' );
        $filter_order_Dir = $mainframe->getUserStateFromRequest( $context.'filter_order_Dir', 'filter_order_Dir', 'desc', 'word' );
        
		$this->config = $this->get('Config');
		
		if($layout == 'form')	{
        	
			$this->item = $this->get('Item');
			$isNew		= ($this->item->id < 1);
			
			$this->plugins = $this->get('Plugins');
			
			/*JPluginHelper::importPlugin('hexdata', $this->item->element);
			$dispatcher = JDispatcher::getInstance();
			
			try{
				ob_start();
				$dispatcher->trigger('onEditProfile', array($this->item));
				$this->html = mb_convert_encoding(ob_get_contents(), 'UTF-8');
				ob_end_clean();
			}catch(Exception $e){
				jerror::raiseWarning('', $e->getMessage());
				$mainframe->redirect('index.php?option=com_hexdata&view=profiles');
			}*/
			
			if($isNew)
				JToolBarHelper::title( JText::_( 'PROFILE' ).' <small><small>'.JText::_('NEW').'</small></small>', 'profiles' );
			
			else	{
				JToolBarHelper::title( JText::_( 'PROFILE' ).' <small><small>'.JText::_('EDIT').'</small></small>', 'profiles' );
			}
			
			JToolBarHelper::apply();
			JToolBarHelper::save();
			JToolBarHelper::cancel();
			
		}
		
		else	{
		
			JToolBarHelper::title( JText::_( 'PROFILES' ), 'profiles' );
			JToolBarHelper::deleteList(JText::_('DELETE_CONFIRM'));
        	JToolBarHelper::editList();
        	JToolBarHelper::addNew();
			
			$this->items = $this->get('Items');
			
			$this->pagination = $this->get('Pagination');
						
	
			// Table ordering.
			$this->lists['order_Dir'] = $filter_order_Dir;
			$this->lists['order']     = $filter_order;
			
		}
		
		parent::display($tpl);
        
    }
  
  
}
