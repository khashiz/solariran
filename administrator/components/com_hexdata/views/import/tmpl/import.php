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

$profileid = JRequest::getInt('profileid', 0);

?>

<script type="text/javascript">

<?php if(!$this->profile->id) : ?>

alert('<?php echo JText::_('PLZ_SELECT_PROFILE'); ?>');

<?php else : ?>

$hd(function()	{
	
	import_profile();
	
});

function import_profile()	{
				
	$hd.ajax({
		  url: "index.php",
		  type: "POST",
		  data: {'option':'com_hexdata', 'view':'profiles', 'task':'plugintaskajax', 'plugin':'<?php echo $this->profile->plugin; ?>.onImportProfile', 'profileid':<?php echo (int)$this->profile->id; ?>, "<?php echo JSession::getFormToken(); ?>":1, 'abase':1},
		  beforeSend: function()	{
			$hd(".loading").show();
		  },
		  complete: function()	{
			$hd(".loading").hide();
		  },
		  success: function(res)	{
			
			$hd('.importdatablock').html(res);
			
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

<?php endif; ?>

</script>

<div id="hexdatapanel">

<form action="index.php?option=com_hexdata&view=import" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">

<div class="importdatablock"></div>

<div class="clr"></div>
<?php echo JHTML::_( 'form.token' ); ?>
<input type="hidden" name="option" value="com_hexdata" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="view" value="import" />
<input type="hidden" name="profileid" value="<?php echo $this->profile->id; ?>" />
</form>

</div>