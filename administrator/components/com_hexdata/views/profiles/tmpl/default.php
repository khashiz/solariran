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

?>

<form action="index.php?option=com_hexdata&view=profiles" method="post" name="adminForm" id="adminForm">

<div id="editcell">
    <table class="adminlist table">
    <thead>
			<tr>
				<th width="10" align="left">
					<?php echo JText::_( 'Num' ); ?>
				</th>
				<th width="3%">
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->items ); ?>);" />
				</th>
				<th class="title">
					<?php echo JHTML::_('grid.sort', 'PROFILE', 'i.title', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
                <th class="title" width="200">
					<?php echo JHTML::_('grid.sort', 'PLUGIN', 'e.name', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
                <th width="100" nowrap="nowrap">
					<?php echo JText::_('IMPORT'); ?>
				</th>
                <th width="100" nowrap="nowrap">
					<?php echo JText::_('EXPORT'); ?>
				</th>
				<th width="10" nowrap="nowrap">
					<?php echo JHTML::_('grid.sort', 'ID', 'i.id', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
			</tr>
		</thead>

	<tfoot>
    <tr>
      <td colspan="7"><?php echo $this->pagination->getListFooter(); ?></td>
    </tr>
  	</tfoot>

    <?php
    $k = 0;
	
	$lang = JFactory::getLanguage();
	
    for ($i=0, $n=count( $this->items ); $i < $n; $i++)
    {
        $row = $this->items[$i];
		$checked    = JHTML::_( 'grid.id', $i, $row->id );
		
		$lang->load($this->items[$i]->extension . '.sys', JPATH_SITE.'/plugins/hexdata/'.$this->items[$i]->element, null, false, false);
		
        ?>
        <tr class="<?php echo "row$k"; ?>">
            <td><?php echo $this->pagination->getRowOffset($i); ?></td>
			
			<td align="center"><?php echo $checked; ?></td>

            <td><a href="index.php?option=com_hexdata&view=profiles&task=edit&cid[]=<?php echo $row->id; ?>"><?php	echo $row->title;	?></a></td>
            <td align="center"><?php echo JText::_($row->plugin); ?></td>
			<td align="center"><a href="index.php?option=com_hexdata&view=import&profileid=<?php echo $row->id; ?>"><?php echo JText::_('IMPORT'); ?></a></td>
            <td align="center"><a href="index.php?option=com_hexdata&view=profiles&task=export&profileid=<?php echo $row->id; ?>"><?php echo JText::_('EXPORT'); ?></a></td>
            <td><?php echo $row->id; ?></td>
        </tr>
        <?php
        $k = 1 - $k;
    }
    ?>
    </table>
</div>
 <?php echo JHTML::_( 'form.token' ); ?>
<input type="hidden" name="option" value="com_hexdata" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="view" value="profiles" />
<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />

</form>
