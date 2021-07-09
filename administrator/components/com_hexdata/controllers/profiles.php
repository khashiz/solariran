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
defined( '_JEXEC' ) or die( 'Restricted access' );


class  HexdataControllerProfiles extends HexdataController
{
	/**
	 * constructor (registers additional tasks to methods)
	 * @return void
	 */
	function __construct()
	{
		parent::__construct();
		
		$this->model = $this->getModel('profiles');
		
		JRequest::setVar( 'view', 'profiles' );
	
		// Register Extra tasks
		$this->registerTask( 'add'  , 	'edit' );

	}

	/**
	 * display the edit form
	 * @return void
	 */
	function edit()
	{
		JRequest::setVar( 'view', 'profiles' );
		JRequest::setVar( 'layout', 'form'  );
		JRequest::setVar('hidemainmenu', 1);
		
		parent::display();
	}

	/**
	 * save a record (and redirect to main page)
	 * @return void
	 */
	function save()
	{
		
		if($this->model->store()) {
			$msg = JText::_( 'PROFILE_SAVED' );
			$this->setRedirect( 'index.php?option=com_hexdata&view=profiles', $msg );
		} else {
			jerror::raiseWarning('', $this->model->getError());
			$this->setRedirect( 'index.php?option=com_hexdata&view=profiles');
		}

	}
	
	function apply()
	{
		
		if($this->model->store()) {
			$msg = JText::_( 'PROFILE_SAVED' );
			$this->setRedirect( 'index.php?option=com_hexdata&view=profiles&task=edit&cid[]='.JRequest::getInt('id', 0), $msg );
		} else {
			jerror::raiseWarning('', $this->model->getError());
			$this->setRedirect( 'index.php?option=com_hexdata&view=profiles&task=edit&cid[]='.JRequest::getInt('id', 0) );
		}

	}

	/**
	 * remove record(s)
	 * @return void
	 */
	function remove()
	{
		
		if($this->model->delete()) {
			$msg = JText::_( 'RECORDS_DELETED' );
			$this->setRedirect( 'index.php?option=com_hexdata&view=profiles', $msg );
		} else {
			jerror::raiseWarning('', $this->model->getError());
			$this->setRedirect( 'index.php?option=com_hexdata&view=profiles');
		}
		
	}

	/**
	 * cancel editing a record
	 * @return void
	 */
	function cancel()
	{
		$msg = JText::_( 'OP_CANCEL' );
		$this->setRedirect( 'index.php?option=com_hexdata&view=profiles', $msg );
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
		
	function export()
	{
				
		$model = $this->getModel('profiles');		
		$profile = $model->getProfile();
		
		JPluginHelper::importPlugin('hexdata', $profile->plugin);
		$dispatcher = JDispatcher::getInstance();
		
		try{
			$dispatcher->trigger('startExport');
			jexit(/*JText::_('INTERNAL_SERVER_ERROR')*/);
		}catch(Exception $e){
			jerror::raiseWarning('', $e->getMessage());
			$this->setRedirect('index.php?option=com_hexdata&view=profiles');
		}
			
	}
	
}