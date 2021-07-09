<?php
/**
* @package RSSeo!
* @copyright (C) 2016 www.rsjoomla.com
* @license GPL, http://www.gnu.org/copyleft/gpl.html
*/
defined('_JEXEC') or die('Restricted access'); ?>
<?php if (is_array($this->content)) { ?>
	<fieldset class="options-form">
		<legend><?php echo JText::_('COM_RSSEO_GA_CONTENT'); ?></legend>
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th><?php echo JText::_('COM_RSSEO_GA_CONTENT_PAGE'); ?></th>
					<th class="center text-center"><?php echo JText::_('COM_RSSEO_GA_CONTENT_PAGEVISITS'); ?></th>
					<th class="center text-center"><?php echo JText::_('COM_RSSEO_GA_CONTENT_UNIQUEPAGEVISITS'); ?></th>
					<th class="center text-center"><?php echo JText::_('COM_RSSEO_GA_CONTENT_AVGTIME'); ?></th>
					<th class="center text-center"><?php echo JText::_('COM_RSSEO_GA_CONTENT_BOUNCERATE'); ?></th>
					<th class="center text-center"><?php echo JText::_('COM_RSSEO_GA_CONTENT_EXITS'); ?></th>
				</tr>
			</thead>
			<tbody>
			<?php if (!empty($this->content)) { ?>
			<?php foreach ($this->content as $i => $result) { ?>
				<tr class="row<?php echo $i % 2; ?>">
					<td><?php echo $result->page; ?></td>
					<td class="center text-center"><?php echo $result->pageviews; ?></td>
					<td class="center text-center"><?php echo $result->upageviews; ?></td>
					<td class="center text-center"><?php echo $result->avgtimesite; ?></td>
					<td class="center text-center"><?php echo $result->bouncerate; ?></td>
					<td class="center text-center"><?php echo $result->exits; ?></td>
				</tr>
			<?php } ?>
			<?php } ?>
			</tbody>
		</table>
	</fieldset>
<?php } else echo $this->content; ?>