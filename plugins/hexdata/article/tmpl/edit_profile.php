<?php
/*------------------------------------------------------------------------
# HexData Joomla Article Plugin
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

$hd(function()	{
	
	$hd(document).on('change', 'select#paramsfieldscatiddata', function(event)	{
		
		checkcat(this);
		
	});
	
	$hd(document).on('change', 'select#paramsfieldscreated_bydata', function(event)	{
		
		checkcreated_by(this);
		
	});
	
	$hd(document).on('change', 'select#paramsfieldsmodified_bydata', function(event)	{
		
		checkmodified_by(this);
		
	});
	
	
	$hd(document).on('change', 'select#paramstype', function(event)	{
		
		loadfields();
		
	});

});

function checkcat(that)
{
	
	if($hd('select#paramstype').val() == "import")	{
	
		var html = '';
					
		if($hd(that).val()=="file")	{
							
			html += '<select name="params[fields][catid][format]">'
						+'<option value="id"><?php echo JText::_('CAT_ID'); ?></option>'
						+'<option value="title"<?php if(@$profile->params->fields->catid->format=="title") echo ' selected="selected"'; ?>><?php echo JText::_('CAT_TITLE'); ?></option>'
					+'</select>';
		
		}
		
		$hd(that).parent().find('span.option_block').html(html);
	
	}
	
}

function checkcreated_by(that)
{
	
	if($hd('select#paramstype').val() == "import")	{
	
		var html = '';
					
		if($hd(that).val()=="file")	{
							
			html += '<select name="params[fields][created_by][format]">'
						+'<option value="id"><?php echo JText::_('ID'); ?></option>'
						+'<option value="username"<?php if(@$profile->params->fields->created_by->format=="username") echo ' selected="selected"'; ?>><?php echo JText::_('USERNAME'); ?></option>'
						+'<option value="email"<?php if(@$profile->params->fields->created_by->format=="email") echo ' selected="selected"'; ?>><?php echo JText::_('EMAIL'); ?></option>'
					+'</select>';
		
		}
		
		$hd(that).parent().find('span.option_block').html(html);
	
	}
	
}

function checkmodified_by(that)
{
	
	if($hd('select#paramstype').val() == "import")	{
	
		var html = '';
					
		if($hd(that).val()=="file")	{
							
			html += '<select name="params[fields][modified_by][format]">'
						+'<option value="id"><?php echo JText::_('ID'); ?></option>'
						+'<option value="username"<?php if(@$profile->params->fields->modified_by->format=="username") echo ' selected="selected"'; ?>><?php echo JText::_('USERNAME'); ?></option>'
						+'<option value="email"<?php if(@$profile->params->fields->modified_by->format=="email") echo ' selected="selected"'; ?>><?php echo JText::_('EMAIL'); ?></option>'
					+'</select>';
		
		}
		
		$hd(that).parent().find('span.option_block').html(html);
	
	}
	
}

function triggerit()
{
	
	loadfields();
	
}

function loadfields()
{
	
	$hd.ajax({
		  url: "index.php",
		  type: "POST",
		  data: {'option':'com_hexdata', 'view':'profiles', 'task':'plugintaskajax', 'plugin':'article.load_fields', 'type':$hd('select#paramstype').val(), 'profileid':<?php echo (int)$profile->id; ?>, "<?php echo JSession::getFormToken(); ?>":1, 'abase':1},
		  beforeSend: function()	{
			$hd(".loading").show();
		  },
		  complete: function()	{
			$hd(".loading").hide();
		  },
		  success: function(res)	{
			
			$hd('.fields_block').html(res);
			
			checkcat($hd('select#paramsfieldscatiddata'));
			checkcreated_by($hd('select#paramsfieldscreated_bydata'));
			checkmodified_by($hd('select#paramsfieldsmodified_bydata'));
			
			var JTooltips = new Tips($$('.hasTip'), { maxTitleChars: 50, fixed: false});
			
		  },
		  error: function(jqXHR, textStatus, errorThrown)	{
			  alert(textStatus);				  
		  }
	});
	
}

</script>

<legend class="article_options"><?php echo JText::_( 'ATTRIBS' ); ?></legend>

<table class="adminform table table-striped plugin_block">
	<tr>
    <td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_TYPE'); ?>"></td>
        <td width="200"><label><?php echo JText::_('TYPE'); ?></label></td>
        <td><select name="params[type]" id="paramstype">
            <option value="import"><?php echo JText::_('IMPORT'); ?></option>
            <option value="export" <?php if(@$profile->params->type=="export") echo 'selected="selected"'; ?>><?php echo JText::_('EXPORT'); ?></option>
        </select></td>
    </tr>
    <tr>
    <table class="adminform table table-striped fields_block">&nbsp;</table></tr>
</table>

<input type="hidden" name="params[table]" id="paramstable" value="#__content" />