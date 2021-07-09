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

function validateit()	{
		
	if($hd('select[name="params[table]"]').val() == "")	{
		alert("<?php echo JText::_('PLZ_SELECT_TABLE'); ?>");
		return false;
	}
	
	var blank = true;
	
	$hd('select.field_type').each(function(index)	{
		
		if($hd(this).val() != "skip")	{
			blank=false;
			return false;
		}
		
	});
	
	if(blank==true)	{
		alert("<?php echo JText::_('PLZ_SELECT_FIELD_TO_IMPORT_DATA'); ?>");
		return false;		
	}
	
	return true;

}

$hd(function()	{
		
	$hd('select[name="params[table]"]').on('change', function(event)	{
		load_columns($hd(this).val());
	});
	
	$hd(document).on('change', 'select.field_type', function(event)	{
		
		var html = '';
		
		var column = $hd(this).parent().parent().data('column');
		
		switch ($hd(this).val())	{
			
			case 'file':
				
				html += '<span class="format_block"><select name="fields['+column+'][format]">'
							+'<option value="string"><?php echo JText::_('STRING'); ?></option>'
							+'<option value="date"><?php echo JText::_('DATE'); ?></option>'
							+'<option value="number"><?php echo JText::_('NUMBER'); ?></option>'
							+'<option value="urlsafe"><?php echo JText::_('URLSAFE'); ?></option>'
						+'</select></span>';
				
			break;
				
			case 'defined':
				
				html += '<span class="default_block"><input name="fields['+column+'][default]" id="fields'+column+'default" value="" /></span>';
				
			break;
			
			case 'reference':
							
				html += ' <span class="table_block"><select class="field_table" data-column="'+column+'" name="fields['+column+'][table]"><option value=""><?php echo JText::_('SELECT_TABLE'); ?></option>';
				
				html += '<?php
	
					for($i=0;$i<count($tables);$i++)	:
					
						$table = str_replace($dbprefix, '#__', $tables[$i]);
					
						echo '<option value="'.$table.'">'.$table.'</option>';
					
				endfor;	?>';
				
				html += '</select></span>';
				
				html += ' <span class="column_block"> <span class="label"><?php echo JText::_('REFERENCED_COLUMN'); ?></span> <select name="fields['+column+'][reftext]"></select></span>';
			
			break;
			
			default :
				
			break;
		
		}
		
		$hd(this).parent().find('div.field_options').html(html);
		
	});
	
	$hd(document).on('change', 'select.field_table', function(event)	{
		
		var that = this;
		
		var column = $hd(this).parent().parent().parent().parent().data('column');
		var table = $hd(this).val();
		
		$hd.ajax({
			  url: "index.php",
			  type: "POST",
			  dataType: "json",
			  data: {'option':'com_hexdata', 'view':'profiles', 'task':'plugintaskajax', 'plugin':'custom.load_refer_columns', 'table':table, 'column':column, 'profileid':<?php echo (int)$item->id; ?>, "<?php echo JSession::getFormToken(); ?>":1, 'abase':1},
			  beforeSend: function()	{
				$hd(".loading").show();
			  },
			  complete: function()	{
				$hd(".loading").hide();
			  },
			  success: function(res)	{
				
				if(res.result = "success")
					$hd(that).parent().parent().find('span.column_block').html(res.html);
				else
					alert(res.error);
				
			  },
			  error: function(jqXHR, textStatus, errorThrown)	{
				  alert(textStatus);				  
			  }
		});
		
	});

});

function triggerit()
{
	
	load_columns($hd('select[name="params[table]"]').val());
	
}

function load_columns(val, block)	{
		
	if(val == "")	{
		$hd('.col_block').html('');
	}
	else	{
		
		$hd.ajax({
			  url: "index.php",
			  type: "POST",
			  dataType: "json",
			  data: {'option':'com_hexdata', 'view':'profiles', 'task':'plugintaskajax', 'plugin':'custom.load_columns', 'table':val, 'profileid':<?php echo (int)$item->id; ?>, "<?php echo JSession::getFormToken(); ?>":1, 'abase':1},
			  beforeSend: function()	{
				$hd(".loading").show();
			  },
			  complete: function()	{
				$hd(".loading").hide();
			  },
			  success: function(res)	{
				
				if(res.result = "success")
					$hd('.col_block').html(res.html);
				else
					alert(res.error);
				
			  },
			  error: function(jqXHR, textStatus, errorThrown)	{
				  alert(textStatus);				  
			  }
		});
		
	}
	
}

</script>
<table class="adminform table table-striped">
	<tr>
    <td width="200"><label class="hasTip required"><?php echo JText::_('TABLE'); ?></label></td>
    <td><select name="params[table]" id="paramstable">
    	<option value=""><?php echo JText::_('SELECT_TABLE'); ?></option>
	<?php
	
		for($i=0;$i<count($tables);$i++)	{
		
		$table = str_replace($dbprefix, '#__', $tables[$i]);
		
	?>
		
        <option value="<?php echo $table; ?>" <?php if($table==@$item->params->table) echo 'selected="selected"'; ?>>
        <?php echo $table; ?>
        </option>
		
	<?php	}	?>
	</select></td>
  </tr>
  <table class="adminform table table-striped col_block"></table>
</table>