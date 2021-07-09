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

JHtml::_('behavior.tooltip');

?>

<script type="text/javascript">
	
	Joomla.submitbutton = function(task) {
		if (task == 'cancel') {
			
			Joomla.submitform(task, document.getElementById('adminForm'));
		} else {
			
			var form = document.adminForm;
		
			if(form.title.value == "")	{
				alert("<?php echo JText::_('PLZ_ENTER_TITLE'); ?>");
				return false;
			}
			
			if(form.pluginid.value == 0)	{
				alert("<?php echo JText::_('PLZ_SELECT_PLUGIN'); ?>");
				return false;
			}
			
			if(typeof(validateit) == 'function')	{
                
				if(!validateit())
					return false;
				
			}
						
			Joomla.submitform(task, document.getElementById('adminForm'));
			
		}
	}
	
$hd(function()	{
	
	edit_profile($hd('select[name="pluginid"]').val());
		
	$hd('select[name="pluginid"]').on('change', function(event)	{
		edit_profile($hd(this).val());
	});
	
});

function edit_profile(val)	{
		
	if(val == 0)	{
		$hd('.plugin_block').html('');
	}
	else	{
		
		val = val.split(':');
		
		$hd.ajax({
			  url: "index.php",
			  type: "POST",
			  data: {'option':'com_hexdata', 'view':'profiles', 'task':'plugintaskajax', 'plugin':val[1]+'.onEditProfile', 'profileid':<?php echo (int)$this->item->id; ?>, "<?php echo JSession::getFormToken(); ?>":1, 'abase':1},
			  beforeSend: function()	{
				$hd(".loading").show();
			  },
			  complete: function()	{
				$hd(".loading").hide();
			  },
			  success: function(res)	{
				
				$hd('.plugin_block').html(res);
				
				if(typeof(triggerit) == 'function')	{
                
					if(!triggerit())
						return false;
					
				}
				
			  },
			  error: function(jqXHR, textStatus, errorThrown)	{
				  alert(textStatus);				  
			  }
		});
		
	}
	
}
	
</script>

<div id="hexdatapanel">

<form action="index.php?option=com_hexdata&view=profiles" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
<div class="col100">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'DETAILS' ); ?></legend>
<table class="adminform table table-striped">
<tr>
  <td width="200">
    <label class="required"><?php echo JText::_('PLUGIN'); ?></label></td>
    
    <?php
    
	$lang = JFactory::getLanguage();
	
	/*if($this->item->pluginid) :

		$extension = $this->item->extension.'.sys';
		$lang->load($extension, JPATH_SITE.'/plugins/hexdata/'.$this->item->element, null, false, false);
		
		echo '<span class="label">'.JText::_($this->item->plugin).'</span>';
	
	else :*/
	
	?>
    
   <td> <select name="pluginid" id="pluginid">
    	<option value="0"><?php echo JText::_('SELECT_PLUGIN'); ?></option>
	<?php
		
		for($i=0;$i<count($this->plugins);$i++)	:
			$extension = 'plg_' . $this->plugins[$i]->folder . '_' . $this->plugins[$i]->element;
			$lang->load($extension . '.sys', JPATH_SITE.'/plugins/hexdata/'.$this->plugins[$i]->element, null, false, false);
		?>
		
			<option value="<?php echo $this->plugins[$i]->extension_id.':'.$this->plugins[$i]->element; ?>" <?php if($this->plugins[$i]->extension_id==$this->item->pluginid) echo 'selected="selected"'; ?>>
			<?php echo JText::_($this->plugins[$i]->name); ?>
			</option>
		
	<?php	endfor;	?>
	</select>
    <?php // endif; ?>
    </td>
    </tr>
  <tr>
    <td><label class="required"><?php echo JText::_('TITLE'); ?></label></td>
    <td><input type="text" name="title" id="title" class="inputbox required" value="<?php echo $this->item->title; ?>" size="50" /></td>
  </tr>
  <table class="adminform table table-striped plugin_block"><tr><td colspan="2"><?php echo JText::_('PLUGIN_PARAM_LOAD_HERE'); ?></td></tr></table>
</table>
	</fieldset>
</div>
<div class="clr"></div>
<?php echo JHTML::_( 'form.token' ); ?>
<input type="hidden" name="option" value="com_hexdata" />
<input type="hidden" name="id" value="<?php echo $this->item->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="view" value="profiles" />
</form>

</div>