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

jimport('joomla.application.component.modellist');

class HexdataModelProfiles extends JModelList
{
    
    var $_total = null;
	var $_pagination = null;
	
	function __construct()
	{
		parent::__construct();
 
        $mainframe = JFactory::getApplication();
		
		$context			= 'com_hexdata.profiles.list.'; 
        // Get pagination request variables
        $limit = $mainframe->getUserStateFromRequest($context.'limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart = $mainframe->getUserStateFromRequest( $context.'limitstart', 'limitstart', 0, 'int' );
		
        // In case limit has been changed, adjust it
        $limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);
 
        $this->setState('limit', $limit);
        $this->setState('limitstart', $limitstart);

		$array = JRequest::getVar('cid',  0, '', 'array');
		$this->setId((int)$array[0]);
	}
	
	function _buildQuery()
	{
		$query = 'select i.*, e.name as plugin, e.element, concat("plg_", e.folder, "_", e.element) as extension FROM #__hd_profiles as i left join #__extensions as e on e.extension_id=i.pluginid';

		return $query;
	}
	
	function setId($id)
	{
		// Set id and wipe data
		$this->_id		= $id;
		$this->_data	= null;
	}
	
	function getItem()
    {
		
		$query = 'select i.*, e.name as plugin, e.element, concat("plg_", e.folder, "_", e.element) as extension FROM #__hd_profiles as i left join #__extensions as e on e.extension_id=i.pluginid where i.id = '.(int)$this->_id;
		$this->_db->setQuery( $query );
		$item = $this->_db->loadObject();
		
		if(empty($item))	{
			$item = new stdClass();
			$item->id = null;
			$item->title = null;
			$item->pluginid = 0;
			$item->params = '';
		}
		
		$item->params = json_decode($item->params);
		
		return $item;
    }
	
	function getItems()
    {
        if(empty($this->_data))	{
		
			$query = $this->_buildQuery();
			$orderby = $this->_buildItemOrderBy();
			$query .= $orderby;
			
			$this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));
		
		}
		echo $this->_db->getErrorMsg();
        return $this->_data;
    }
	
	function getTotal()
  	{
        // Load the content if it doesn't already exist
        if (empty($this->_total)) {
            $query = $this->_buildQuery();
            $this->_total = $this->_getListCount($query);    
        }
        return $this->_total;
  	}
	
	function getPagination()
  	{
        // Load the content if it doesn't already exist
        if (empty($this->_pagination)) {
            jimport('joomla.html.pagination');
            $this->_pagination = new JPagination($this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );
        }
        return $this->_pagination;
  	}
	
	function _buildItemOrderBy()
	{
        $mainframe = JFactory::getApplication();
		
		$context			= 'com_hexdata.profiles.list.';
 
        $filter_order     = $mainframe->getUserStateFromRequest( $context.'filter_order', 'filter_order', 'i.id', 'cmd' );
        $filter_order_Dir = $mainframe->getUserStateFromRequest( $context.'filter_order_Dir', 'filter_order_Dir', 'desc', 'word' );
 
        $orderby = ' group by i.id order by '.$filter_order.' '.$filter_order_Dir . ' ';
 
        return $orderby;
	}

	function store()
	{
    	
		// Check for request forgeries
		JRequest::checkToken() or jexit( JText::_('INVALID_TOKEN') );
		
    	$post = JRequest::get( 'post' );
		
		$row = $this->getTable();
		
		$row->load($post['id']);
		
		if (!$row->bind( $post ))	{
        	$this->setError($row->getError());
			return false;
		}
		
		if (!$row->check())	{
        	$this->setError($row->getError());
			return false;
		}
		
		if (!$row->store())	{
        	$this->setError($row->getError());
			return false;
		}
		
		if(!$post['id'])	{
			$post['id'] = $row->id;
			JRequest::setVar('id', $post['id']);
		}
			
		return true;
			
	}
	
	/**
	 * Method to delete record(s)
	 *
	 * @access	public
	 * @return	boolean	True on success
	 */
	function delete()
	{
		
		// Check for request forgeries
		JRequest::checkToken() or jexit( JText::_('INVALID_TOKEN') );
		
		$cids = JRequest::getVar( 'cid', array(), 'post', 'array' );

		if (count( $cids ) < 1) {
			$this->setError( JText::_( 'SELECT_MIN', true ) );
			return false;
		}
		
		$row =  $this->getTable();

		foreach ($cids as $id)
		{
			
			if(!$row->delete($id))	{
				$this->setError($row->getError());
				return false;
				
			}

		}
		
		return true;
		
	}
	
	//fetches all the plugins available
	function getPlugins()
	{
		
		$query = 'select extension_id, name, element, folder from #__extensions where type = "plugin" and folder = "hexdata"';
		$this->_db->setQuery( $query );
		$items = $this->_db->loadObjectList();
		
		return $items;
		
	}
	
	//get the profile object with the associated plugin info
	function getProfile()
	{
		
		$id = JRequest::getInt('profileid', 0);
		
		$query = 'select i.*, e.element as plugin from #__hd_profiles as i join #__extensions as e on i.pluginid=e.extension_id where i.id = '.$id;
		$this->_db->setQuery( $query );
		$item = $this->_db->loadObject();
		
		return $item;
		
	}
	
}

?>