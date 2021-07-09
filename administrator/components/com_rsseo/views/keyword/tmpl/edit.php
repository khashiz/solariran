<?php
/**
* @package RSSeo!
* @copyright (C) 2016 www.rsjoomla.com
* @license GPL, http://www.gnu.org/copyleft/gpl.html
*/
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.formvalidator');
JHtml::_('behavior.keepalive'); ?>

<form action="<?php echo JRoute::_('index.php?option=com_rsseo&view=keyword&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm" autocomplete="off" class="form-validate form-horizontal">
	<?php echo $this->form->renderField('keyword'); ?>
	<?php echo $this->form->renderField('bold'); ?>
	<?php echo $this->form->renderField('underline'); ?>
	<?php echo $this->form->renderField('limit'); ?>
	<?php echo $this->form->renderField('link'); ?>
	<?php echo $this->form->renderField('attributes'); ?>

	<?php echo JHTML::_('form.token'); ?>
	<input type="hidden" name="task" value="" />
	<?php echo $this->form->getInput('id'); ?>
	<?php echo JHTML::_('behavior.keepalive'); ?>
</form>