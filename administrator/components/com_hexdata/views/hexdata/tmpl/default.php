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
defined('_JEXEC') or die('Restricted access'); ?>

<div id="hexdatapanel">

<div class="adminform">
	<div class="cpanel-left">
		<div class="cpanel">
        	<div class="icon-wrapper">
                <!--<div class="icon">
                    <a href="index.php?option=com_hexdata&view=config"><img src="components/com_hexdata/assets/images/icon-48-config.png" alt="<?php echo JText::_('CONFIG'); ?>" /><span><?php echo JText::_('CONFIG'); ?></span></a>
                </div>-->
                <div class="icon">
                    <a href="index.php?option=com_hexdata&view=profiles"><img src="../media/com_hexdata/images/icon-48-profiles.png" alt="<?php echo JText::_('PROFILES'); ?>" /><span><?php echo JText::_('PROFILES'); ?></span></a>
                </div>
				<div class="icon">
                    <a href="index.php?option=com_hexdata&view=import"><img src="../media/com_hexdata/images/icon-48-import.png" alt="<?php echo JText::_('IMPORT'); ?>" /><span><?php echo JText::_('IMPORT'); ?></span></a>
                </div>
            </div>
		</div>
	</div>
	<div class="cpanel-right">
    
	<?php
        
        $title = JText::_( 'WELCOME_HEXDATA' );
		
		echo JHtml::_('tabs.start', 'panel-tabs');
		
		echo JHtml::_('tabs.panel', $title, 'cpanel-panel-hexdata');
		        
        echo JText::_('WELCOME_HEXDATA_TEXT');
        
        echo JHtml::_('tabs.end');
		
    ?>
        
	</div>
	
<div class="clr"></div></div>