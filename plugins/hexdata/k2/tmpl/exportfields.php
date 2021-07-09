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


	<tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_ORDER_BY'); ?>"></td>
        <td width="200"><label><?php echo JText::_('ORDER_BY'); ?></label></td><td>
        <select name="params[orderby]" id="paramsorderby">
            <option value="i.id desc"><?php echo JText::_('lATEST_FIRST'); ?></option>
            <option value="i.id asc" <?php if(@$profile->params->orderby=="i.id asc") echo 'selected="selected"'; ?>><?php echo JText::_('EARLIEST_FIRST'); ?></option>
            <option value="i.ordering asc" <?php if(@$profile->params->orderby=="i.ordering asc") echo 'selected="selected"'; ?>><?php echo JText::_('ORDERING'); ?></option>
            <option value="i.title asc" <?php if(@$profile->params->orderby=="i.title asc") echo 'selected="selected"'; ?>><?php echo JText::_('ALPHABATICALLY'); ?></option>
            <option value="i.hits desc" <?php if(@$profile->params->orderby=="i.hits desc") echo 'selected="selected"'; ?>><?php echo JText::_('MOST_POPULAR'); ?></option>
        </select>
    </td></tr>
    <tr>
     <td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_FILTER_CATEGORY'); ?>"></td>
        <td width="200"><label><?php echo JText::_('FILTER_CATEGORY'); ?></label></td>
        <td><select name="params[catid]" id="paramscatid">
            <option value="0"><?php echo JText::_('ALL_CATS'); ?></option>
            <?php foreach($cats as $cat) : ?>
            <option value="<?php echo $cat->id; ?>" <?php if(@$profile->params->catid==$cat->id) echo 'selected="selected"'; ?>><?php echo $cat->name; ?></option>
            <?php endforeach; ?>
        </select></td>
    </tr>
    <tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_ID'); ?>"></td>
        <td width="200"><label><?php echo JText::_('KEY_ID'); ?></label></td><td>
        <select name="params[fields][id][data]" id="paramsfieldsiddata">
            <option value="include"><?php echo JText::_('INCLUDE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->id->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select>
    </td></tr>
	<tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_TITLE'); ?>"></td>
    	<td width="200"><label><?php echo JText::_('TITLE'); ?></label></td><td>
    	<select name="params[fields][title][data]" id="paramsfieldstitledata">
            <option value="include"><?php echo JText::_('INCLUDE'); ?></option>
        </select>
    </td></tr>
    <tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_ALIAS'); ?>"></td>
        <td width="200"><label><?php echo JText::_('ALIAS'); ?></label></td><td>
        <select name="params[fields][alias][data]" id="paramsfieldsaliasdata">
            <option value="include"><?php echo JText::_('INCLUDE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->alias->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select>
    </td></tr>
    <tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_INTROTEXT'); ?>"></td>
    	<td width="200"><label><?php echo JText::_('INTROTEXT'); ?></label></td><td>
    	<select name="params[fields][introtext][data]" id="paramsfieldsintrotextdata">
            <option value="include"><?php echo JText::_('INCLUDE'); ?></option>
        </select>
    </td></tr>
    <tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_FULLTEXT'); ?>"></td>
        <td width="200"><label><?php echo JText::_('FULLTEXT'); ?></label></td><td>
        <select name="params[fields][fulltext][data]" id="paramsfieldsfulltextdata">
            <option value="include"><?php echo JText::_('INCLUDE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->fulltext->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select>
    </td></tr>
    <tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_STATUS'); ?>"></td>
        <td width="200"><label><?php echo JText::_('STATUS'); ?></label></td><td>
        <select name="params[fields][published][data]" id="paramsfieldspublisheddata">
            <option value="include"><?php echo JText::_('INCLUDE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->published->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select>
    </td></tr>
    <tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_CATEGORY'); ?>"></td>
        <td width="200"><label><?php echo JText::_('CATEGORY'); ?></label></td><td>
        <select name="params[fields][catid][data]" id="paramsfieldscatiddata">
            <option value="id"><?php echo JText::_('ID'); ?></option>
            <option value="title" <?php if(@$profile->params->fields->catid->data=="title") echo 'selected="selected"'; ?>><?php echo JText::_('CAT_TITLE'); ?></option>
        </select>
    </td></tr>
	<tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_CREATED'); ?>"></td>
        <td width="200"><label><?php echo JText::_('CREATED'); ?></label></td><td>
        <select name="params[fields][created][data]" id="paramsfieldscreateddata">
            <option value="include"><?php echo JText::_('INCLUDE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->created->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select>
    </td></tr>
    <tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_CREATED_BY'); ?>"></td>
        <td width="200"><label><?php echo JText::_('CREATED_BY'); ?></label></td><td>
        <select name="params[fields][created_by][data]" id="paramsfieldscreated_bydata">
            <option value="skip" <?php if(@$profile->params->fields->created_by->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
            <option value="id" <?php if(@$profile->params->fields->created_by->data=="id") echo 'selected="selected"'; ?>><?php echo JText::_('ID'); ?></option>
            <option value="username" <?php if(@$profile->params->fields->created_by->data=="username") echo 'selected="selected"'; ?>><?php echo JText::_('USERNAME'); ?></option>
            <option value="email" <?php if(@$profile->params->fields->created_by->data=="email") echo 'selected="selected"'; ?>><?php echo JText::_('EMAIL'); ?></option>
        </select>
    </td></tr>
    <tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_CREATED_BY_ALIAS'); ?>"></td>
        <td width="200"><label><?php echo JText::_('CREATED_BY_ALIAS'); ?></label></td><td>
        <select name="params[fields][created_by_alias][data]" id="paramsfieldscreated_by_aliasdata">
            <option value="include"><?php echo JText::_('INCLUDE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->created_by_alias->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select>
    </td></tr>
    <tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_MODIFIED'); ?>"></td>
        <td width="200"><label><?php echo JText::_('MODIFIED'); ?></label></td><td>
        <select name="params[fields][modified][data]" id="paramsfieldsmodifieddata">
            <option value="include"><?php echo JText::_('INCLUDE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->modified->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select>
    </td></tr>
    <tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_MODIFIED_BY'); ?>"></td>
        <td width="200"><label><?php echo JText::_('MODIFIED_BY'); ?></label></td><td>
        <select name="params[fields][modified_by][data]" id="paramsfieldsmodified_bydata">
            <option value="skip" <?php if(@$profile->params->fields->modified_by->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
            <option value="id" <?php if(@$profile->params->fields->modified_by->data=="id") echo 'selected="selected"'; ?>><?php echo JText::_('ID'); ?></option>
            <option value="username" <?php if(@$profile->params->fields->modified_by->data=="username") echo 'selected="selected"'; ?>><?php echo JText::_('USERNAME'); ?></option>
            <option value="email" <?php if(@$profile->params->fields->modified_by->data=="email") echo 'selected="selected"'; ?>><?php echo JText::_('EMAIL'); ?></option>
        </select>
    </td></tr>
    <tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_PUBLISH_UP'); ?>"></td>
        <td width="200"><label><?php echo JText::_('PUBLISH_UP'); ?></label></td><td>
        <select name="params[fields][publish_up][data]" id="paramsfieldspublish_updata">
            <option value="include"><?php echo JText::_('INCLUDE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->publish_up->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select>
    </td></tr>
    <tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_PUBLISH_DOWN'); ?>"></td>
        <td width="200"><label><?php echo JText::_('PUBLISH_DOWN'); ?></label></td><td>
        <select name="params[fields][publish_down][data]" id="paramsfieldspublish_downdata">
            <option value="include"><?php echo JText::_('INCLUDE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->publish_down->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select>
    </td></tr>
    <tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_GALLERY'); ?>"></td>
        <td width="200"><label><?php echo JText::_('GALLERY'); ?></label></td><td>
        <select name="params[fields][gallery][data]" id="paramsfieldsgallerydata">
            <option value="include"><?php echo JText::_('INCLUDE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->gallery->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select>
    </td></tr>
    <tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_IMAGE_CAPTION'); ?>"></td>
        <td width="200"><label><?php echo JText::_('IMAGE_CAPTION'); ?></label></td><td>
        <select name="params[fields][image_caption][data]" id="paramsfieldsimage_captiondata">
            <option value="include"><?php echo JText::_('INCLUDE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->image_caption->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select>
    </td></tr>
    <tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_IMAGE_CREDIT'); ?>"></td>
        <td width="200"><label><?php echo JText::_('IMAGE_CREDIT'); ?></label></td><td>
        <select name="params[fields][image_credits][data]" id="paramsfieldsimage_creditsdata">
            <option value="include"><?php echo JText::_('INCLUDE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->image_credits->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select>
    </td></tr>
    <tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_VIDEO'); ?>"></td>
        <td width="200"><label><?php echo JText::_('VIDEO'); ?></label></td><td>
        <select name="params[fields][video][data]" id="paramsfieldsvideodata">
            <option value="include"><?php echo JText::_('INCLUDE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->video->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select>
    </td></tr>
    <tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_VIDEO_CAPTION'); ?>"></td>
        <td width="200"><label><?php echo JText::_('VIDEO_CAPTION'); ?></label></td><td>
        <select name="params[fields][video_caption][data]" id="paramsfieldsvideo_captiondata">
            <option value="include"><?php echo JText::_('INCLUDE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->video_caption->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select>
    </td></tr>
    <tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_VIDEO_CREDIT'); ?>"></td>
        <td width="200"><label><?php echo JText::_('VIDEO_CREDIT'); ?></label></td><td>
        <select name="params[fields][video_credits][data]" id="paramsfieldsvideo_creditsdata">
            <option value="include"><?php echo JText::_('INCLUDE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->video_credits->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select>
    </td></tr>
    <tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_ORDERING'); ?>"></td>
        <td width="200"><label><?php echo JText::_('ORDERING'); ?></label></td><td>
        <select name="params[fields][ordering][data]" id="paramsfieldsorderingdata">
            <option value="include"><?php echo JText::_('INCLUDE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->ordering->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select>
    </td></tr>
    <tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_METADESC'); ?>"></td>
        <td width="200"><label><?php echo JText::_('METADESC'); ?></label></td><td>
        <select name="params[fields][metadesc][data]" id="paramsfieldsmetadescdata">
            <option value="include"><?php echo JText::_('INCLUDE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->metadesc->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select>
    </td></tr>
    <tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_METAKEY'); ?>"></td>
        <td width="200"><label><?php echo JText::_('METAKEY'); ?></label></td><td>
        <select name="params[fields][metakey][data]" id="paramsfieldsmetakeydata">
            <option value="include"><?php echo JText::_('INCLUDE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->metakey->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select>
    </td></tr>
    <tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_METADATA'); ?>"></td>
        <td width="200"><label><?php echo JText::_('METADATA'); ?></label></td><td>
        <select name="params[fields][metadata][data]" id="paramsfieldsmetadatadata">
            <option value="include"><?php echo JText::_('INCLUDE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->metadata->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select>
    </td></tr>
    <tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_ACCESS'); ?>"></td>
        <td width="200"><label><?php echo JText::_('ACCESS'); ?></label></td><td>
        <select name="params[fields][access][data]" id="paramsfieldsaccessdata">
            <option value="include"><?php echo JText::_('INCLUDE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->access->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select>
    </td></tr>
    <tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_HITS'); ?>"></td>
        <td width="200"><label><?php echo JText::_('HITS'); ?></label></td><td>
        <select name="params[fields][hits][data]" id="paramsfieldshitsdata">
            <option value="include"><?php echo JText::_('INCLUDE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->hits->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select>
    </td></tr>
    <tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_FEATURED'); ?>"></td>
        <td width="200"><label><?php echo JText::_('FEATURED'); ?></label></td><td>
        <select name="params[fields][featured][data]" id="paramsfieldsfeatureddata">
            <option value="include"><?php echo JText::_('INCLUDE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->featured->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select>
    </td></tr>
    <tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_LANGUAGE'); ?>"></td>
        <td width="200"><label><?php echo JText::_('LANGUAGE'); ?></label></td><td>
        <select name="params[fields][language][data]" id="paramsfieldslanguagedata">
            <option value="include"><?php echo JText::_('INCLUDE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->language->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select>
    </td></tr>
    <tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_PARAMS'); ?>"></td>
        <td width="200"><label><?php echo JText::_('PARAMS'); ?></label></td><td>
        <select name="params[fields][params][data]" id="paramsfieldsparamsdata">
            <option value="include"><?php echo JText::_('INCLUDE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->params->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select>
    </td></tr>
    <tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_PLUGINS'); ?>"></td>
        <td width="200"><label><?php echo JText::_('PLUGINS'); ?></label></td><td>
        <select name="params[fields][plugins][data]" id="paramsfieldspluginsdata">
            <option value="include"><?php echo JText::_('INCLUDE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->plugins->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select>
    </td></tr>
    <tr><td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_EXTRAFIELDS'); ?>"></td>
        <td width="200"><label><?php echo JText::_('EXTRAFIELDS'); ?></label></td><td>
        <select name="params[fields][extra_fields][data]" id="paramsfieldsextra_fieldsdata">
            <option value="include"><?php echo JText::_('INCLUDE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->extra_fields->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select>
    </td></tr>
</ul>