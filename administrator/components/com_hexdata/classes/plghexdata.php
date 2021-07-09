<?php
/*------------------------------------------------------------------------
# HexData Plugin Class
# ------------------------------------------------------------------------
# author    Team WDMtech
# copyright Copyright (C) 2014 www.wdmtech.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.wdmtech.com
# Technical Support:  Forum - http://www.wdmtech.com/support-forum
-----------------------------------------------------------------------*/
// No direct access
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.plugin.plugin' );

/**
 * Joomla! HexData Plugin
 *
 * @package		Joomla
 * @subpackage	Plugin
 */
class  plgHexdata extends JPlugin
{
	
	function getProfile()
	{
		$db = JFactory::getDbo();
		
		$profileid = JRequest::getInt('profileid', 0);
		
		$query = 'select i.*, e.name as plugin, e.element, concat("plg_", e.folder, "_", e.element) as extension, count(f.id) as fields FROM #__hd_profiles as i left join #__extensions as e on e.extension_id=i.pluginid left join #__hd_profile_field as f on (i.id=f.profileid) where i.id = '.$db->quote($profileid);
		$db->setQuery( $query );
		$profile = $db->loadObject();
		
		if(!empty($profile))
			$profile->params = json_decode($profile->params);
		
		return $profile;
		
	}
	
}