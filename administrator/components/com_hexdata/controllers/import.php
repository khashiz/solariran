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


class HexdataControllerImport extends HexdataController
{
	/**
	 * constructor (registers additional tasks to methods)
	 * @return void
	 */
	function __construct()
	{
		parent::__construct();
		
		JRequest::setVar( 'view', 'import' );
	
	}
 
	function importready()	{
	
		JRequest::checkToken() or jexit( JText::_('INVALID_TOKEN') );
		
		$profileid = JRequest::getInt('profileid', 0);
		
		$model = $this->getModel('import');
		
		if($model->get_csv_fields())	{
			$this->setRedirect('index.php?option=com_hexdata&view=import&layout=import&profileid='.$profileid);
		}
		else	{
			jerror::raiseWarning('', $model->getError());
			$this->setRedirect('index.php?option=com_hexdata&view=import');
		}
	
	}
	
	function plugintaskajax()
	{
		
		$plugin = explode('.', JRequest::getVar('plugin', ''));
		
		if(count($plugin)==2)	{
		
			JPluginHelper::importPlugin('hexdata', $plugin[0]);
			$dispatcher = JDispatcher::getInstance();
			
			try{
				$dispatcher->trigger($plugin[1]);
			}catch(Exception $e){
				jexit('{"result":"error", "error":"'.$e->getMessage().'"}');
			}
		
		}
		
	}
		
	function import_now()	{
	
		JRequest::checkToken() or jexit( JText::_('INVALID_TOKEN') );
		
		$model = $this->getModel('import');		
		$profile = $model->getProfile();
		
		JPluginHelper::importPlugin('hexdata', $profile->plugin);
		$dispatcher = JDispatcher::getInstance();
		
		try{
			$return = $dispatcher->trigger('startImport');
			$msg = JText::sprintf('IMPORT_SUCCESS', $return[0]);
			$this->setRedirect('index.php?option=com_hexdata&view=import', $msg);
		}catch(Exception $e){
			jerror::raiseWarning('', $e->getMessage());
			$this->setRedirect('index.php?option=com_hexdata&view=import&layout=import&profileid='.$profile->id);
		}
	
	}
	
	/**
	 * cancel an action
	 * @return void
	 */
	function cancel()
	{
		$msg = JText::_( 'OP_CANCEL' );
		$this->setRedirect( 'index.php?option=com_hexdata', $msg );
	}
	
	/**
	 * cancel an action
	 * @return void
	 */
	function close()
	{
		$msg = JText::_( 'OP_CANCEL' );
		$this->setRedirect( 'index.php?option=com_hexdata&view=import', $msg );
	}

}