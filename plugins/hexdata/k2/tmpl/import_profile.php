<?php
/*------------------------------------------------------------------------
# HexData K2 Plugin
# ------------------------------------------------------------------------
# author    Team WDMtech
# copyright Copyright (C) 2014 www.wdmtech.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.wdmtech.com
# Technical Support:  Forum - http://www.wdmtech.com/support-forum
-----------------------------------------------------------------------*/
// No direct access
defined('_JEXEC') or die('Restricted access');
				
$date = JFactory::getDate();

?>

<script type="text/javascript">

Joomla.submitbutton = function(task) {
	if (task == 'close') {
		Joomla.submitform(task, document.getElementById('adminForm'));
	} else {
		
		var form = document.adminForm;
		
		if($hd('select[name="fields[title]"]').val() == "")	{
			alert('<?php echo JText::_('PLZ_SELECT_TITLE'); ?>');
			return false;
		}
		
		if($hd('select[name="fields[catid]"]').val() == "")	{
			alert('<?php echo JText::_('PLZ_SELECT_CAT'); ?>');
			return false;
		}	
		
		Joomla.submitform(task, document.getElementById('adminForm'));
					
	}
}

function triggerit()
{
	
	var JTooltips = new Tips($$('.hasTip'), { maxTitleChars: 50, fixed: false});
	
}

function jSelectUser_updateUser(id, title)
{
	
	$hd('.created_by_label').html(title);
	$hd('input[name="created_by"]').val(id);
	$hd('.userdialog').hide('slow');
	
}

$hd(function()	{
			 
	$hd('.modal_jform_created_by').unbind('click').click(function(event)	{
		event.preventDefault();
		if($hd('.userdialog').length==0)
				$hd('#hexdatapanel').prepend('<div class="userdialog" />');
		
		$hd('.userdialog').html($hd('<iframe width="770" height="465" />').attr("src", $hd(this).attr('href'))).show('slow');
	});
	
});

</script>
	
<div class="width-60 fltlft">

    <fieldset class="adminform">
        <legend><?php echo JText::_('EDIT_K2'); ?></legend>
        
        <ul class="adminformlist">
        	<li>
            	<label class="required" for="jform_title"><?php echo JText::_('TITLE'); ?></label>
                <select class="inputbox" id="fieldstitle" name="fields[title]">
                <?php echo $this->csvoptions(JText::_('TITLE')); ?>
                </select>
			</li>
            
            <?php if($profile->params->fields->alias->data <> "title") : ?>
            
            <li>
            	<label class="required" for="jform_alias"><?php echo JText::_('ALIAS'); ?></label>
                <select class="inputbox" id="fieldsalias" name="fields[alias]">
                	<?php echo $this->csvoptions(JText::_('ALIAS')); ?>
                </select>
			</li>
            
            <?php endif; ?>
            
            <li>
            	<label class="required" for="jform_alias"><?php echo JText::_('CATEGORY'); ?></label>
                <select class="inputbox" id="fieldscatid" name="fields[catid]">
            
            <?php
            
			if($profile->params->fields->catid->data == "ask") :
			
			$query = 'select id, title from #__categories where extension = "com_content" order by title asc';
			$db->setQuery( $query );
			$cats = $db->loadObjectList();
			
            ?>
            
            <?php foreach($cats as $cat) : ?>
                    
                <option value="<?php echo $cat->id; ?>"><?php echo $cat->title; ?></option>
                
            <?php endforeach; ?>
            
            <?php else : ?>
            <?php echo $this->csvoptions(JText::_('CATEGORY')); ?>
            <?php endif; ?>
            
            	</select>
			</li>
            
            <li>
            	<label class="required" for="jform_published"><?php echo JText::_('STATUS'); ?></label>
                <select class="inputbox" id="fieldspublished" name="fields[published]">
            
            <?php	if($profile->params->fields->published->data == "ask") :    ?>
                                
                <option value="1"><?php echo JText::_('PUBLISHED'); ?></option>
                <option value="0"><?php echo JText::_('UNPUBLISHED'); ?></option>
                            
            <?php else : ?>
            <?php echo $this->csvoptions(JText::_('STATUS')); ?>
            <?php endif; ?>
            
            	</select>
			</li>
            
            <li>
            	<label class="required" for="jform_access"><?php echo JText::_('ACCESS'); ?></label>
            	<select class="inputbox" id="fieldsaccess" name="fields[access]">
            <?php
            
			if($profile->params->fields->access->data == "ask") :
                                
                $options = JHtml::_('access.assetgroups', 'access', 1);
				
				foreach($options as $option) :
					echo '<option value="'.$option->value.'">'.$option->text.'</option>';
				endforeach;
                
            else : ?>
            <?php echo $this->csvoptions(JText::_('ACCESS')); ?>
            <?php endif; ?>
            
            	</select>
			</li>
            
            <?php if($profile->params->fields->ordering->data <> "skip") : ?>
            
            <li>
            	<label class="required" for="jform_ordering"><?php echo JText::_('ORDERING'); ?></label>
                <select class="inputbox" id="fieldsordering" name="fields[ordering]">
                	
                    <?php echo $this->csvoptions(JText::_('ORDERING')); ?>
                    
                </select>
			</li>
            
            <?php endif; ?>
            
            <li>
            	<label class="required" for="jform_featured"><?php echo JText::_('FEATURED'); ?></label>
                <select class="inputbox" id="fieldsfeatured" name="fields[featured]">
            
            <?php	if($profile->params->fields->featured->data == "ask") :    ?>
                                
                <option value="1"><?php echo JText::_('JYES'); ?></option>
                <option value="0"><?php echo JText::_('JNO'); ?></option>
                            
            <?php else : ?>
            <?php echo $this->csvoptions(JText::_('FEATURED')); ?>
            <?php endif; ?>
            
            	</select>
			</li>
            
            <li>
            	<label class="required" for="jform_language"><?php echo JText::_('LANGUAGE'); ?></label>
            	<select class="inputbox" id="fieldslanguage" name="fields[language]">
            <?php
            
			if($profile->params->fields->language->data == "ask") :
                                
               echo JHtml::_('select.options', JHtml::_('contentlanguage.existing', true, true), 'value', 'text', '*');
                
            else : ?>
            <?php echo $this->csvoptions(JText::_('LANGUAGE')); ?>
            <?php endif; ?>
            
            	</select>
			</li>
            
            <li>
            	<label class="required" for="jform_id"><?php echo JText::_('ID'); ?></label>
            <?php
            
			if($profile->params->fields->id->data == "ask") :
                                
               echo '<span class="label">'.JText::_('AUTO_INCREMENT').'</span>';
                
            else : ?>
            
            <select class="inputbox" id="fieldsid" name="fields[id]">
			<?php echo $this->csvoptions(JText::_('ID')); ?>
            </select>
            
            <?php endif; ?>
            	
			</li>
            
            <li>
            	<label class="required" for="jform_introtext"><?php echo JText::_('INTROTEXT'); ?></label>
            	<select class="inputbox" id="fieldsintrotext" name="fields[introtext]">
                <?php echo $this->csvoptions(JText::_('INTROTEXT')); ?>
                </select>
            </li>
            
            <?php if($profile->params->fields->fulltext->data <> "skip") : ?>
            
            <li>
            	<label class="required" for="jform_fulltext"><?php echo JText::_('FULLTEXT'); ?></label>
            	<select class="inputbox" id="fieldsfulltext" name="fields[fulltext]">
                <?php echo $this->csvoptions(JText::_('FULLTEXT')); ?>
                </select>
            </li>
            
            <?php endif; ?>
            
            <?php if($profile->params->fields->params->data <> "skip") : ?>
            
            <li>
            	<label class="required" for="jform_params"><?php echo JText::_('PARAMS'); ?></label>
            	<select class="inputbox" id="fieldsparams" name="fields[params]">
                <?php echo $this->csvoptions(JText::_('PARAMS')); ?>
                </select>
            </li>
            
            <?php endif; ?>
            
            <?php if($profile->params->fields->extra_fields->data <> "skip") : ?>
            
            <li>
            	<label class="required" for="jform_extra_fields"><?php echo JText::_('EXTRAFIELDS'); ?></label>
            	<select class="inputbox" id="fieldsextra_fields" name="fields[extra_fields]">
                <?php echo $this->csvoptions(JText::_('EXTRAFIELDS')); ?>
                </select>
            </li>
            
            <?php endif; ?>
            
            <?php if($profile->params->fields->plugins->data <> "skip") : ?>
            
            <li>
            	<label class="required" for="jform_plugins"><?php echo JText::_('PLUGINS'); ?></label>
            	<select class="inputbox" id="fieldsplugins" name="fields[plugins]">
                <?php echo $this->csvoptions(JText::_('PLUGINS')); ?>
                </select>
            </li>
            
            <?php endif; ?>
            
        </ul>
        
    </fieldset>

</div>
    
<div class="width-40 fltrt">
	<?php echo JHtml::_('sliders.start', 'content-sliders', array('useCookie'=>1)); ?>
    	<?php echo JHtml::_('sliders.panel', JText::_('K2_OPTIONS'), 'publishing-details'); ?>
        <fieldset class="panelform">
        <h3><?php echo JText::_('PUBLISHING_OPTIONS'); ?></h3>
        <ul class="adminformlist">
        	
            <li>
                <label><?php echo JText::_('CREATED_BY'); ?></label>
            
            <?php if($profile->params->fields->created_by->data == "ask") : ?>
            
                <span class="created_by_label label"></span> <a class="modal_jform_created_by label" href="index.php?option=com_users&view=users&layout=modal&tmpl=component&field=updateUser" title="<?php echo JText::_('SELECT_USER'); ?>"><?php echo JText::_('SELECT_USER'); ?></a>
                <input type="hidden" name="fields[created_by]" value="" />
            
            <?php else : ?>
            
            <select class="inputbox" id="fieldscreated_by" name="fields[created_by]">
			<?php echo $this->csvoptions(JText::_('CREATED_BY')); ?>
            </select>
            
            <?php endif; ?>
            
            </li>
            
            <li>
                <label><?php echo JText::_('CREATED_BY_ALIAS'); ?></label>
            
            <?php if($profile->params->fields->created_by_alias->data == "ask") : ?>
                
                <input class="inputbox" type="text" size="20" name="fields[created_by_alias]" value="" />
            
            <?php else : ?>
            
            <select class="inputbox" id="fieldscreated_by_alias" name="fields[created_by_alias]">
			<?php echo $this->csvoptions(JText::_('CREATED_BY_ALIAS')); ?>
            </select>
            
            <?php endif; ?>
            
            </li>
            
            <li>
                <label><?php echo JText::_('CREATED'); ?></label>
            
            <?php if($profile->params->fields->created->data == "ask") : ?>
            
            <script type="text/javascript">
            
				$hd( "#fieldscreated" ).datepicker({
					dateFormat: 'yy-mm-dd 00:00:00',
					showOn: "button",
					buttonImage: "../media/com_hexdata/images/calendar.gif",
					buttonImageOnly: true
				});
			 
			 </script>
            
            <input type="text" name="fields[created]" id="fieldscreated" value="<?php echo $date->toSql(); ?>" class="inputbox" />
            
            <?php else : ?>
            
            <select class="inputbox" id="fieldscreated" name="fields[created]">
			<?php echo $this->csvoptions(JText::_('CREATED')); ?>
            </select>
            
            <?php endif; ?>
            
            </li>
            
            <li>
                <label><?php echo JText::_('PUBLISH_UP'); ?></label>
            
            <?php if($profile->params->fields->publish_up->data == "ask") : ?>
            
            <script type="text/javascript">
            
				$hd( "#fieldspublish_up" ).datepicker({
					dateFormat: 'yy-mm-dd 00:00:00',
					showOn: "button",
					buttonImage: "../media/com_hexdata/images/calendar.gif",
					buttonImageOnly: true
				});
			 
			 </script>
            
            <input type="text" name="fields[publish_up]" id="fieldspublish_up" value="<?php echo $date->toSql(); ?>" class="inputbox" />
            
            <?php else : ?>
            
            <select class="inputbox" id="fieldspublish_up" name="fields[publish_up]">

			<?php echo $this->csvoptions(JText::_('PUBLISH_UP')); ?>
            </select>
            
            <?php endif; ?>
            
            </li>
            
            <li>
                <label><?php echo JText::_('PUBLISH_DOWN'); ?></label>
            
            <?php if($profile->params->fields->created->data == "ask") : ?>
            
            <script type="text/javascript">
            
				$hd( "#fieldspublish_down" ).datepicker({
					dateFormat: 'yy-mm-dd 00:00:00',
					showOn: "button",
					buttonImage: "../media/com_hexdata/images/calendar.gif",
					buttonImageOnly: true
				});
			 
			 </script>
            
            <input type="text" name="fields[publish_down]" id="fieldspublish_down" value="0000-00-00 00:00:00" class="inputbox" />
            
            <?php else : ?>
            
            <select class="inputbox" id="fieldspublish_down" name="fields[publish_down]">
			<?php echo $this->csvoptions(JText::_('PUBLISH_DOWN')); ?>
            </select>
            
            <?php endif; ?>
            
            </li>
            
            <?php	if($profile->params->fields->modified_by->data == "loggedin") : ?>
            
            <li>
            	<label class="required" for="jform_modified_by"><?php echo JText::_('MODIFIED_BY'); ?></label>
                                
                <?php $user = JFactory::getUser(); echo '<span class="label">'.$user->name.'</span>'; ?>
            </li>
                
            <?php	else : ?>
            
            <li>
            	<label><?php echo JText::_('MODIFIED_BY'); ?></label>
                <select class="inputbox" id="fieldsmodified_by" name="fields[modified_by]">
                <?php echo $this->csvoptions(JText::_('MODIFIED_BY')); ?>
                </select>
            </li>
            
            <?php endif; ?>
            
            <?php if($profile->params->fields->modified->data == "current") : ?>
            
            <li>
                <label><?php echo JText::_('MODIFIED'); ?></label>
            
            	<?php echo '<span class="label">'.$date->toSql().'</span>'; ?>
            </li>
            
            <?php else : ?>
            
            <li>
                <label><?php echo JText::_('MODIFIED'); ?></label>
            
                <select class="inputbox" id="fieldsmodified" name="fields[modified]">
                <?php echo $this->csvoptions(JText::_('MODIFIED')); ?>
                </select>
            
            </li>
            
            <?php endif; ?>
            
             <?php if($profile->params->fields->hits->data <> "skip") : ?>
            
            <li>
            	<label><?php echo JText::_('HITS'); ?></label>
                <select class="inputbox" id="fieldshits" name="fields[hits]">
                	<?php echo $this->csvoptions(JText::_('HITS')); ?>
                </select>
			</li>
            
            <?php endif; ?>
            
        </ul>
        </fieldset>
        
        <?php if($profile->params->fields->gallery->data <> "skip" or $profile->params->fields->image_caption->data <> "skip" or $profile->params->fields->video->data <> "skip") : ?>
                
        <fieldset class="panelform">
        	<h3><?php echo JText::_('IMAGE_N_VIDEOS'); ?></h3>
            <ul class="adminformlist">
            
            <?php if($profile->params->fields->gallery->data <> "skip") : ?>
            
            	<li>
                    <label><?php echo JText::_('GALLERY'); ?></label>
                    <select class="inputbox" id="fieldsgallery" name="fields[gallery]">
                        <?php echo $this->csvoptions(JText::_('GALLERY')); ?>
                    </select>
                </li>
                
                <?php endif; ?>
                
                <?php if($profile->params->fields->image_caption->data <> "skip") : ?>
            
            	<li>
                    <label class="hasTip" ><?php echo JText::_('IMAGE_CAPTION'); ?></label>
                    <select class="inputbox" id="fieldsimage_caption" name="fields[image_caption]">
                        <?php echo $this->csvoptions(JText::_('IMAGE_CAPTION')); ?>
                    </select>
                </li>
                
                <?php endif; ?>
                
                <?php if($profile->params->fields->image_caption->data <> "skip") : ?>
            
            	<li>
                    <label class="hasTip" ><?php echo JText::_('IMAGE_CREDIT'); ?></label>
                    <select class="inputbox" id="fieldsimage_credits" name="fields[image_credits]">
                        <?php echo $this->csvoptions(JText::_('IMAGE_CREDIT')); ?>
                    </select>
                </li>
                
                <?php endif; ?>
                
                <?php if($profile->params->fields->video->data <> "skip") : ?>
            
            	<li>
                    <label class="hasTip" ><?php echo JText::_('VIDEO'); ?></label>
                    <select class="inputbox" id="fieldsvideo" name="fields[video]">
                        <?php echo $this->csvoptions(JText::_('VIDEO')); ?>
                    </select>
                </li>
                
                <?php endif; ?>
                
                <?php if($profile->params->fields->video_caption->data <> "skip") : ?>
            
            	<li>
                    <label class="hasTip" ><?php echo JText::_('VIDEO_CAPTION'); ?></label>
                    <select class="inputbox" id="fieldsvideo" name="fields[video]">
                        <?php echo $this->csvoptions(JText::_('VIDEO_CAPTION')); ?>
                    </select>
                </li>
                
                <?php endif; ?>
                
                <?php if($profile->params->fields->image_caption->data <> "skip") : ?>
            
            	<li>
                    <label class="hasTip" ><?php echo JText::_('VIDEO_CREDIT'); ?></label>
                    <select class="inputbox" id="fieldsvideo_credits" name="fields[video_credits]">
                        <?php echo $this->csvoptions(JText::_('VIDEO_CREDIT')); ?>
                    </select>
                </li>
                
                <?php endif; ?>
                
            </ul>
        </fieldset>
        
        <?php endif; ?>
        
        <?php if($profile->params->fields->metakey->data <> "skip" or $profile->params->fields->urls->data <> "skip") : ?>
                
        <fieldset class="panelform">
        	<h3><?php echo JText::_('METADATA_OPTIONS'); ?></h3>
            <ul class="adminformlist">
            
            <?php if($profile->params->fields->metadesc->data <> "skip") : ?>
            
            	<li>
                    <label><?php echo JText::_('METADESC'); ?></label>
                    <select class="inputbox" id="fieldsmetadesc" name="fields[metadesc]">
                        <?php echo $this->csvoptions(JText::_('METADATA_OPTIONS')); ?>
                    </select>
                </li>
                
                <?php endif; ?>
            
            <?php if($profile->params->fields->metakey->data <> "skip") : ?>
            
            	<li>
                    <label><?php echo JText::_('METAKEY'); ?></label>
                    <select class="inputbox" id="fieldsmetakey" name="fields[metakey]">
                        <?php echo $this->csvoptions(JText::_('METAKEY')); ?>
                    </select>
                </li>
                
                <?php endif; ?>
                
                <?php if($profile->params->fields->metadata->data <> "skip") : ?>
            
            	<li>
                    <label class="hasTip" title="<?php echo JText::_('JSON_FORMAT'); ?>"><?php echo JText::_('METADATA'); ?></label>
                    <select class="inputbox" id="fieldsmetadata" name="fields[metadata]">
                        <?php echo $this->csvoptions(JText::_('METADATA')); ?>
                    </select>
                </li>
                
                <?php endif; ?>
                
            </ul>
        </fieldset>
        
        <?php endif; ?>
        
    <?php echo JHtml::_('sliders.end'); ?>

</div>

<div class="clr"></div>