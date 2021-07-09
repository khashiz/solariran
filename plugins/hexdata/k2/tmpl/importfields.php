<?php
/*------------------------------------------------------------------------
# HexData K2 Plugin
# ------------------------------------------------------------------------
# author    Team WDMtech
# copyright Copyright (C) 2013 wwww.wdmtech.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.wdmtech.com
# Technical Support:  Forum - http://www.wdmtech.com/support-forum
-----------------------------------------------------------------------*/
// No direct access
defined('_JEXEC') or die('Restricted access');

?>


	<tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_ID'); ?>"></td>
        <td width="200"><label><?php echo JText::_('ID'); ?></label></td><td>
        <select name="params[fields][id][data]" id="paramsfieldsiddata">
            <option value="file"><?php echo JText::_('DATA_FILE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->id->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select>
    </td></tr>
	<tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_TITLE'); ?>"></td>
    	<td width="200"><label><?php echo JText::_('TITLE'); ?></label></td><td>
    	<select name="params[fields][title][data]" id="paramsfieldstitledata">
            <option value="file"><?php echo JText::_('DATA_FILE'); ?></option>
        </select>
    </td></tr>
    <tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_ALIAS'); ?>"></td>
        <td width="200"><label><?php echo JText::_('ALIAS'); ?></label></td><td>
        <select name="params[fields][alias][data]" id="paramsfieldsaliasdata">
            <option value="file"><?php echo JText::_('DATA_FILE'); ?></option>
            <option value="title" <?php if(@$profile->params->fields->alias->data=="title") echo 'selected="selected"'; ?>><?php echo JText::_('USE_TITLE'); ?></option>
        </select>
    </td></tr>
    <tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_INTROTEXT'); ?>"></td>
    	<td width="200"><label><?php echo JText::_('INTROTEXT'); ?></label></td><td>
    	<select name="params[fields][introtext][data]" id="paramsfieldsintrotextdata">
            <option value="file"><?php echo JText::_('DATA_FILE'); ?></option>
        </select>
    </td></tr>
    <tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_FULLTEXT'); ?>"></td>
        <td width="200"><label><?php echo JText::_('FULLTEXT'); ?></label></td><td>
        <select name="params[fields][fulltext][data]" id="paramsfieldsfulltextdata">
            <option value="file"><?php echo JText::_('DATA_FILE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->fulltext->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select>
    </td></tr>
    <tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_STATUS'); ?>"></td>
        <td width="200"><label><?php echo JText::_('STATUS'); ?></label></td><td>
        <select name="params[fields][published][data]" id="paramsfieldspublisheddata">
            <option value="file"><?php echo JText::_('DATA_FILE'); ?></option>
            <option value="ask" <?php if(@$profile->params->fields->published->data=="ask") echo 'selected="selected"'; ?>><?php echo JText::_('ASK'); ?></option>
        </select>
    </td></tr>
    <tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_CATEGORY'); ?>"></td>
        <td width="200"><label><?php echo JText::_('CATEGORY'); ?></label></td><td>
        <select name="params[fields][catid][data]" id="paramsfieldscatiddata">
            <option value="file"><?php echo JText::_('DATA_FILE'); ?></option>
            <option value="ask" <?php if(@$profile->params->fields->catid->data=="ask") echo 'selected="selected"'; ?>><?php echo JText::_('ASK'); ?></option>
        </select> <span class="option_block"></span>
    </td></tr>
	<tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_CREATED'); ?>"></td>
        <td width="200"><label><?php echo JText::_('CREATED'); ?></label></td><td>
        <select name="params[fields][created][data]" id="paramsfieldscreateddata">
            <option value="file"><?php echo JText::_('DATA_FILE'); ?></option>
            <option value="ask" <?php if(@$profile->params->fields->created->data=="ask") echo 'selected="selected"'; ?>><?php echo JText::_('ASK'); ?></option>
        </select>
    </td></tr>
    <tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_CREATED_BY'); ?>"></td>
        <td width="200"><label><?php echo JText::_('CREATED_BY'); ?></label></td><td>
        <select name="params[fields][created_by][data]" id="paramsfieldscreated_bydata">
            <option value="file"><?php echo JText::_('DATA_FILE'); ?></option>
            <option value="ask" <?php if(@$profile->params->fields->created_by->data=="ask") echo 'selected="selected"'; ?>><?php echo JText::_('ASK'); ?></option>
        </select> <span class="option_block"></span>
    </td></tr>
    <tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_CREATED_BY_ALIAS'); ?>"></td>
        <td width="200"><label><?php echo JText::_('CREATED_BY_ALIAS'); ?></label></td><td>
        <select name="params[fields][created_by_alias][data]" id="paramsfieldscreated_by_aliasdata">
            <option value="file"><?php echo JText::_('DATA_FILE'); ?></option>
            <option value="ask" <?php if(@$profile->params->fields->created_by_alias->data=="ask") echo 'selected="selected"'; ?>><?php echo JText::_('ASK'); ?></option>
        </select>
    </td></tr>
    <tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_MODIFIED'); ?>"></td>
        <td width="200"><label><?php echo JText::_('MODIFIED'); ?></label></td><td>
        <select name="params[fields][modified][data]" id="paramsfieldsmodifieddata">
            <option value="file"><?php echo JText::_('DATA_FILE'); ?></option>
            <option value="current"><?php echo JText::_('CURRENT_TIME'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->modified->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select>
    </td></tr>
    <tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_MODIFIED_BY'); ?>"></td>
        <td width="200"><label><?php echo JText::_('MODIFIED_BY'); ?></label></td><td>
        <select name="params[fields][modified_by][data]" id="paramsfieldsmodified_bydata">
            <option value="file"><?php echo JText::_('DATA_FILE'); ?></option>
            <option value="loggedin"><?php echo JText::_('LOGGEDIN'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->modified_by->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select> <span class="option_block"></span>
    </td></tr>
    <tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_PUBLISH_UP'); ?>"></td>
        <td width="200"><label><?php echo JText::_('PUBLISH_UP'); ?></label></td><td>
        <select name="params[fields][publish_up][data]" id="paramsfieldspublish_updata">
            <option value="file"><?php echo JText::_('DATA_FILE'); ?></option>
            <option value="ask" <?php if(@$profile->params->fields->publish_up->data=="ask") echo 'selected="selected"'; ?>><?php echo JText::_('ASK'); ?></option>
        </select>
    </td></tr>
    <tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_PUBLISH_DOWN'); ?>"></td>
        <td width="200"><label><?php echo JText::_('PUBLISH_DOWN'); ?></label></td><td>
        <select name="params[fields][publish_down][data]" id="paramsfieldspublish_downdata">
            <option value="file"><?php echo JText::_('DATA_FILE'); ?></option>
            <option value="ask" <?php if(@$profile->params->fields->publish_down->data=="ask") echo 'selected="selected"'; ?>><?php echo JText::_('ASK'); ?></option>
        </select>
    </td></tr>
    <tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_GALLERY'); ?>"></td>
        <td width="200"><label><?php echo JText::_('GALLERY'); ?></label></td><td>
        <select name="params[fields][gallery][data]" id="paramsfieldsgallerydata">
            <option value="file"><?php echo JText::_('DATA_FILE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->images->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select>
    </td></tr>
    <tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_IMAGE_CAPTION'); ?>"></td>
        <td width="200"><label><?php echo JText::_('IMAGE_CAPTION'); ?></label></td><td>
        <select name="params[fields][image_caption][data]" id="paramsfieldsimage_captiondata">
            <option value="file"><?php echo JText::_('DATA_FILE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->image_caption->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select>
    </td></tr>
    <tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_IMAGE_CREDIT'); ?>"></td>
        <td width="200"><label><?php echo JText::_('IMAGE_CREDIT'); ?></label></td><td>
        <select name="params[fields][image_credits][data]" id="paramsfieldsimage_creditsdata">
            <option value="file"><?php echo JText::_('DATA_FILE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->image_credits->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select>
    </td></tr>
    <tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_VIDEO'); ?>"></td>
        <td width="200"><label><?php echo JText::_('VIDEO'); ?></label></td><td>
        <select name="params[fields][video][data]" id="paramsfieldsvideodata">
            <option value="file"><?php echo JText::_('DATA_FILE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->video->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select>
    </td></tr>
    <tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_VIDEO_CAPTION'); ?>"></td>
        <td width="200"><label><?php echo JText::_('VIDEO_CAPTION'); ?></label></td><td>
        <select name="params[fields][video_caption][data]" id="paramsfieldsvideo_captiondata">
            <option value="file"><?php echo JText::_('DATA_FILE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->video_caption->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select>
    </td></tr>
    <tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_VIDEO_CREDIT'); ?>"></td>
        <td width="200"><label><?php echo JText::_('VIDEO_CREDIT'); ?></label></td><td>
        <select name="params[fields][video_credits][data]" id="paramsfieldsvideo_creditsdata">
            <option value="file"><?php echo JText::_('DATA_FILE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->video_credits->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select>
    </td></tr>
    <tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_ORDERING'); ?>"></td>
        <td width="200"><label><?php echo JText::_('ORDERING'); ?></label></td><td>
        <select name="params[fields][ordering][data]" id="paramsfieldsorderingdata">
            <option value="file"><?php echo JText::_('DATA_FILE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->ordering->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select>
    </td></tr>
    <tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_METADESC'); ?>"></td>
        <td width="200"><label><?php echo JText::_('METADESC'); ?></label></td><td>
        <select name="params[fields][metadesc][data]" id="paramsfieldsmetadescdata">
            <option value="file"><?php echo JText::_('DATA_FILE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->metadesc->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select>
    </td></tr>
    <tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_METAKEY'); ?>"></td>
        <td width="200"><label><?php echo JText::_('METAKEY'); ?></label></td><td>
        <select name="params[fields][metakey][data]" id="paramsfieldsmetakeydata">
            <option value="file"><?php echo JText::_('DATA_FILE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->metakey->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select>
    </td></tr>
    <tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_METADATA'); ?>"></td>
        <td width="200"><label><?php echo JText::_('METADATA'); ?></label></td><td>
        <select name="params[fields][metadata][data]" id="paramsfieldsmetadatadata">
            <option value="file"><?php echo JText::_('DATA_FILE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->metadata->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select>
    </td></tr>
    <tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_ACCESS'); ?>"></td>
        <td width="200"><label><?php echo JText::_('ACCESS'); ?></label></td><td>
        <select name="params[fields][access][data]" id="paramsfieldsaccessdata">
            <option value="file"><?php echo JText::_('DATA_FILE'); ?></option>
            <option value="ask" <?php if(@$profile->params->fields->access->data=="ask") echo 'selected="selected"'; ?>><?php echo JText::_('ASK'); ?></option>
        </select>
    </td></tr>
    <tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_HITS'); ?>"></td>
        <td width="200"><label><?php echo JText::_('HITS'); ?></label></td><td>
        <select name="params[fields][hits][data]" id="paramsfieldshitsdata">
            <option value="file"><?php echo JText::_('DATA_FILE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->hits->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select>
    </td></tr>
    <tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_FEATURED'); ?>"></td>
        <td width="200"><label><?php echo JText::_('FEATURED'); ?></label></td><td>
        <select name="params[fields][featured][data]" id="paramsfieldsfeatureddata">
            <option value="file"><?php echo JText::_('DATA_FILE'); ?></option>
            <option value="ask" <?php if(@$profile->params->fields->featured->data=="ask") echo 'selected="selected"'; ?>><?php echo JText::_('ASK'); ?></option>
        </select>
    </td></tr>
    <tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_LANGUAGE'); ?>"></td>
        <td width="200"><label><?php echo JText::_('LANGUAGE'); ?></label></td><td>
        <select name="params[fields][language][data]" id="paramsfieldslanguagedata">
            <option value="file"><?php echo JText::_('DATA_FILE'); ?></option>
            <option value="ask" <?php if(@$profile->params->fields->language->data=="ask") echo 'selected="selected"'; ?>><?php echo JText::_('ASK'); ?></option>
        </select>
    </td></tr>
    <tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_PARAMS'); ?>"></td>
        <td width="200"><label><?php echo JText::_('PARAMS'); ?></label></td><td>
        <select name="params[fields][params][data]" id="paramsfieldsparamsdata">
            <option value="file"><?php echo JText::_('DATA_FILE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->params->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select>
    </td></tr>
    <tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_PLUGINS'); ?>"></td>
        <td width="200"><label><?php echo JText::_('PLUGINS'); ?></label></td><td>
        <select name="params[fields][plugins][data]" id="paramsfieldspluginsdata">
            <option value="file"><?php echo JText::_('DATA_FILE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->plugins->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select>
    </td></tr>
    <tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_EXTRAFIELDS'); ?>"></td>
        <td width="200"><label><?php echo JText::_('EXTRAFIELDS'); ?></label></td><td>
        <select name="params[fields][extra_fields][data]" id="paramsfieldsextra_fieldsdata">
            <option value="file"><?php echo JText::_('DATA_FILE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->extra_fields->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select>
    </td></tr>
</ul>