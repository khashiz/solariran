<?php
/**
* @package RSSeo!
* @copyright (C) 2016 www.rsjoomla.com
* @license GPL, http://www.gnu.org/copyleft/gpl.html
*/
defined('_JEXEC') or die('Restricted access'); ?>

<div class="center text-center" id="rsseo-links-loader">
	<p><?php echo JText::_('COM_RSSEO_CHECKING_FOR_URLS'); ?></p>
	<?php echo JHtml::image('com_rsseo/loading.gif', '', array(), true); ?>
</div>

<div id="rsseo-external-links" style="display: none;">
	<h3 style="text-align: center;"><?php echo JText::_('COM_RSSEO_PAGE_EXT_LINKS'); ?></h3>
	<table class="table table-striped adminlist">
		<thead>
			<tr>
				<th><?php echo JText::_('COM_RSSEO_URL'); ?></th>
				<th class="center text-center" width="10%"><?php echo JText::_('COM_RSSEO_COUNT'); ?></th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</div>

<div id="rsseo-internal-links" style="display: none;">
	<h3 style="text-align: center;"><?php echo JText::_('COM_RSSEO_PAGE_INT_LINKS'); ?></h3>
	<table class="table table-striped adminlist">
		<thead>
			<tr>
				<th><?php echo JText::_('COM_RSSEO_URL'); ?></th>
				<th class="center text-center" width="10%"><?php echo JText::_('COM_RSSEO_COUNT'); ?></th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</div>