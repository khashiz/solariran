<?php
/*------------------------------------------------------------------------
# HexData Custom Plugin
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

<script type="text/javascript">

Joomla.submitbutton = function(task) {
	if (task == 'close') {
		
		Joomla.submitform(task, document.getElementById('adminForm'));
	} else {
		
		var form = document.adminForm;
		
		$hd('select[name="csvfield[]"]').each(function()	{
		
			if($hd(this).val() != "")
				Joomla.submitform(task, document.getElementById('adminForm'));
		
		});
		
		return false;
					
	}
}

</script>
<div class="col100">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'DETAILS' ); ?></legend>
        <table class="adminform table table-striped adminformlist">
        <?php foreach($fields as $field) : ?>
        <?php
			$params = json_decode($field->params);
			if($params->type=="defined") :
				echo '<input type="hidden" name="profilefield[]" value="'.$field->id.'" /><input type="hidden" name="csvfield[]" value="1" />';
			else :
		?>
          <tr>
            <td width="200"><label class="hasTip"><?php echo $field->column; ?><input type="hidden" name="profilefield[]" value="<?php echo $field->id; ?>" /></label></td>
            <td><select name="csvfield[]">
                <option value=""><?php echo JText::_('SELECT_FIELD'); ?></option>
                <?php for($i=0;$i<count($csvfields);$i++) : ?>
                    <option value="<?php echo $i; ?>" <?php if(strtolower($field->column)==strtolower($csvfields[$i])) echo 'selected="selected"'; ?>><?php echo $csvfields[$i]; ?></option>
                <?php endfor; ?>
            </select></td>
          </tr>
        <?php endif; ?>
        <?php endforeach; ?>
        </table>
	</fieldset>
</div>