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

jimport('joomla.application.component.modellist');

class HexdataModelImport extends JModelList
{

    var $_total = null;
	var $_pagination = null;
	function __construct()
	{
		parent::__construct();
		

	}
	
	function getProfile()
	{
		
		$id = JRequest::getInt('profileid', 0);
		
		$query = 'select i.*, e.element as plugin from #__hd_profiles as i join #__extensions as e on i.pluginid=e.extension_id where i.id = '.$id;
		$this->_db->setQuery( $query );
		$item = $this->_db->loadObject();
		
		return $item;
		
	}
	
	function getProfiles()
	{
		
		$query = 'select * from #__hd_profiles order by title asc';
		$this->_db->setQuery( $query );
		$items = $this->_db->loadObjectList();
		
		return $items;
		
	}
	
	function get_csv_fields()
	{
		
		$dir = JPATH_ADMINISTRATOR.'/components/com_hexdata/uploads/data.csv';
		
		jimport('joomla.filesystem.file');
		
		$file = JRequest::getVar("file", null, 'FILES', 'array');
	
		$file_name    = str_replace(' ', '', JFile::makeSafe($file['name']));		
		$file_tmp     = $file["tmp_name"];
	
		$ext = strrchr($file_name, '.');
		
		if(filesize($file_tmp) == 0 and is_file($dir))	{
			return true;
		}
	
		if(filesize($file_tmp) == 0)	{
			$this->setError(JText::_('PLZ_SELECT_FILE'));
			return false;
		}
		
		if($ext <> '.csv')	{
			$this->setError(JText::_('ONLY_CSV'));
			return false;
		}
		
		if(!move_uploaded_file($file_tmp, $dir))	{
			$this->setError(JText::_('FILE_NOT_UPLOADED'));
			return false;
		}
		
		return true;
		
	}
  
}
