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


class TableProfiles extends JTable
{
    /**
     * Primary Key
     *
     * @var int
     */
    var $id = null;
 
    /**
     * @var string
     */
    
    var $title = null;
	var $pluginid = null;
	var $params = null;
    
    function TableProfiles( &$db ) {
        parent::__construct('#__hd_profiles', 'id', $db);
    }
	
	function bind($array, $ignore = '')
	{
		
		return parent::bind($array, $ignore);
		
	}
	
	function check()
	{
		
		$this->id = intval($this->id);
		$this->pluginid = intval($this->pluginid);
		$this->params = json_encode($this->params);
		
		if(empty($this->title))	{
			$this->setError( JText::_('PLZ_ENTER_TITLE') );
			return false;
		}
		
		if(empty($this->pluginid))	{
			$this->setError( JText::_('PLZ_SELECT_PLUGIN') );
			return false;
		}
		
		/*$query = 'select count(*) from #__hexdata_profiles where id <> '.$this->id.' and pluginid = '.$this->pluginid;
		$this->_db->setQuery( $query );
		$count = $this->_db->loadResult();
		
		if($count<1)	{
			$this->setError(JText::_(''));
			return false;
		}
		
		//get primary key of the selected table
		$query = 'SHOW KEYS FROM '.$this->_db->quoteName($this->table).' WHERE Key_name = "PRIMARY"';
		$this->_db->setQuery( $query );
		$key = $this->_db->loadObject();
		*/
		
		if($this->_db->getErrorNum())	{
			$this->setError( $this->_db->getErrorMsg() );
			return false;
		}
		
		//$this->primary = $key->Column_name;
		
		return parent::check();
		
	}
	
	function store($updateNulls = false)
	{
		
		if(!parent::store($updateNulls))	{
			return false;
		}
		
		$profile = $this->getProfile();
		
		JPluginHelper::importPlugin('hexdata', $profile->plugin);
		$dispatcher = JDispatcher::getInstance();
		
		try{
			$dispatcher->trigger('onSaveProfile', array($this->id));
			return true;
		}catch(Exception $e){
			$this->setError($e->getMessage());
			return false;
		}
				
		return true;
		
	}
	
	function delete($oid=null)
	{
		
		$this->id = $oid;
		
		$profile = $this->getProfile();
		
		if(empty($profile))	{
			$this->setError(JText::_('PROFILE_NOT_FOUND'));
			return false;
		}
		
		if(!parent::delete($oid))	{
			return false;
		}
		
		JPluginHelper::importPlugin('hexdata', $profile->plugin);
		$dispatcher = JDispatcher::getInstance();
		
		try{
			$dispatcher->trigger('onDeleteProfile', array($oid));
			return true;
		}catch(Exception $e){
			$this->setError($e->getMessage());
			return false;
		}
		
	}
	
	//get the profile object with the associated plugin info
	function getProfile()
	{
				
		$query = 'select i.*, e.element as plugin from #__hd_profiles as i join #__extensions as e on i.pluginid=e.extension_id where i.id = '.(int)$this->id;
		$this->_db->setQuery( $query );
		$item = $this->_db->loadObject();
		
		return $item;
		
	}
	
}
