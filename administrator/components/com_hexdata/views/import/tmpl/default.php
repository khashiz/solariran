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

$profileid = JRequest::getInt('profileid', 0);

?>

<script type="text/javascript">
	
	Joomla.submitbutton = function(task) {
		if (task == 'cancel') {
			
			Joomla.submitform(task, document.getElementById('adminForm'));
		} else {
			
			var form = document.adminForm;
			
			if(form.profileid.value == "")	{
				alert("<?php echo JText::_('PLZ_SELECT_PROFILE'); ?>");
				return false;
			}
			
			<?php if(!is_file(JPATH_ADMINISTRATOR.'/components/com_hexdata/uploads/data.csv')) : ?>
			
			if($hd('input[name="file"]').val() == "")	{
				alert("<?php echo JText::_('PLZ_SELECT_FILE'); ?>");
				return false;				
			}
			else	{
				var fileExt = $hd('input[name="file"]').val();
				fileExt = fileExt.substring(fileExt.lastIndexOf('.'));
				
				if(fileExt != ".csv")	{
					alert("<?php echo JText::_('ONLY_CSV'); ?>");
					return false;
				}
			}
			
			<?php endif; ?>
			
			Joomla.submitform(task, document.getElementById('adminForm'));
			
		}
	}


</script>

<div id="hexdatapanel">

<form action="index.php?option=com_hexdata&view=import" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
<div class="col100">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'DETAILS' ); ?></legend>
<table class="adminform table table-striped">
<tr>
  <td>
    <label class="hasTip required"><?php echo JText::_('PROFILE'); ?></label></td>
    <td><select name="profileid" id="profileid">
    	<option value=""><?php echo JText::_('SELECT_PROFILE'); ?></option>
	<?php	for($i=0;$i<count($this->profiles);$i++)	{	?>
	
		<option value="<?php echo $this->profiles[$i]->id; ?>" <?php if($profileid==$this->profiles[$i]->id) echo 'selected="selected"'; ?>><?php echo $this->profiles[$i]->title; ?></option>
	
	<?php	}	?>
	</select>
  </td>
  </tr>
  <tr>
    <td><label class="hasTip required"><?php echo JText::_('CSV_FILE'); ?></label></td>
    <td><input type="file" name="file" id="file" class="inputbox required" size="50" accept="application/csv" />
    <?php if(is_file(JPATH_ADMINISTRATOR.'/components/com_hexdata/uploads/data.csv')) : ?>
    	<a href="<?php echo JURI::root().'administrator/components/com_hexdata/uploads/data.csv'; ?>"><span class="label">data.csv</span></a>
    <?php endif; ?>
    </td>
  </tr>
</table>
	</fieldset>
</div>
<div class="clr"></div>
<?php echo JHTML::_( 'form.token' ); ?>
<input type="hidden" name="option" value="com_hexdata" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="view" value="import" />
</form>

</div>