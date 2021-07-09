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

	<tr>
     <td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_ORDER_BY'); ?>"></td>
        <td width="200"><label><?php echo JText::_('ORDER_BY'); ?></label></td>
        <td><select name="params[orderby]" id="paramsorderby">
            <option value="i.id desc"><?php echo JText::_('LATEST_FIRST'); ?></option>
            <option value="i.id asc" <?php if(@$profile->params->orderby=="i.id asc") echo 'selected="selected"'; ?>><?php echo JText::_('EARLIEST_FIRST'); ?></option>
            <option value="i.ordering asc" <?php if(@$profile->params->orderby=="i.ordering asc") echo 'selected="selected"'; ?>><?php echo JText::_('ORDERING'); ?></option>
            <option value="i.title asc" <?php if(@$profile->params->orderby=="i.title asc") echo 'selected="selected"'; ?>><?php echo JText::_('ALPHABATICALLY'); ?></option>
            <option value="i.hits desc" <?php if(@$profile->params->orderby=="i.hits desc") echo 'selected="selected"'; ?>><?php echo JText::_('MOST_POPULAR'); ?></option>
        </select></td>
    </tr>
    <tr>
     <td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_FILTER_CATEGORY'); ?>"></td>
        <td width="200"><label><?php echo JText::_('FILTER_CATEGORY'); ?></label></td>
        <td><select name="params[catid]" id="paramscatid">
            <option value="0"><?php echo JText::_('ALL_CATS'); ?></option>
            <?php foreach($cats as $cat) : ?>
            <option value="<?php echo $cat->id; ?>" <?php if(@$profile->params->catid==$cat->id) echo 'selected="selected"'; ?>><?php echo $cat->title; ?></option>
            <?php endforeach; ?>
        </select></td>
    </tr>
    <tr>
     <td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_ID'); ?>"></td>
        <td width="200"><label><?php echo JText::_('ID'); ?></label></td>
        <td><select name="params[fields][id][data]" id="paramsfieldsiddata">
            <option value="include"><?php echo JText::_('INCLUDE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->id->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select></td>
    </tr>
	<tr>
     <td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_TITLE'); ?>"></td>
    	<td width="200"><label><?php echo JText::_('TITLE'); ?></label></td>
    	<td><select name="params[fields][title][data]" id="paramsfieldstitledata">
            <option value="include"><?php echo JText::_('INCLUDE'); ?></option>
        </select></td>
    </tr>
    <tr>
     <td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_ALIAS'); ?>"></td>
        <td width="200"><label><?php echo JText::_('ALIAS'); ?></label></td>
        <td><select name="params[fields][alias][data]" id="paramsfieldsaliasdata">
            <option value="include"><?php echo JText::_('INCLUDE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->alias->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select></td>
    </tr>
    <tr>
     <td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_INTROTEXT'); ?>"></td>
    	<td width="200"><label><?php echo JText::_('INTROTEXT'); ?></label></td>
    	<td><select name="params[fields][introtext][data]" id="paramsfieldsintrotextdata">
            <option value="include"><?php echo JText::_('INCLUDE'); ?></option>
        </select></td>
    </tr>
    <tr>
     <td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_FULLTEXT'); ?>"></td>
        <td width="200"><label><?php echo JText::_('FULLTEXT'); ?></label></td>
        <td><select name="params[fields][fulltext][data]" id="paramsfieldsfulltextdata">
            <option value="include"><?php echo JText::_('INCLUDE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->fulltext->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select></td>
    </tr>
    <tr>
     <td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_STATUS'); ?>"></td>
        <td width="200"><label><?php echo JText::_('STATUS'); ?></label></td>
        <td><select name="params[fields][state][data]" id="paramsfieldsstatedata">
            <option value="include"><?php echo JText::_('INCLUDE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->state->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select></td>
    </tr>
    <tr>
     <td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_CATEGORY'); ?>"></td>
        <td width="200"><label><?php echo JText::_('CATEGORY'); ?></label></td>
        <td><select name="params[fields][catid][data]" id="paramsfieldscatiddata">
            <option value="id"><?php echo JText::_('ID'); ?></option>
            <option value="title" <?php if(@$profile->params->fields->catid->data=="title") echo 'selected="selected"'; ?>><?php echo JText::_('CAT_TITLE'); ?></option>
        </select></td>
    </tr>
	<tr>
     <td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_CREATED'); ?>"></td>
        <td width="200"><label><?php echo JText::_('CREATED'); ?></label></td>
        <td><select name="params[fields][created][data]" id="paramsfieldscreateddata">
            <option value="include"><?php echo JText::_('INCLUDE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->created->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select></td>
    </tr>
    <tr>
     <td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_CREATED_BY'); ?>"></td>
        <td width="200"><label><?php echo JText::_('CREATED_BY'); ?></label></td>
        <td><select name="params[fields][created_by][data]" id="paramsfieldscreated_bydata">
            <option value="skip" <?php if(@$profile->params->fields->created_by->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
            <option value="id" <?php if(@$profile->params->fields->created_by->data=="id") echo 'selected="selected"'; ?>><?php echo JText::_('ID'); ?></option>
            <option value="username" <?php if(@$profile->params->fields->created_by->data=="username") echo 'selected="selected"'; ?>><?php echo JText::_('USERNAME'); ?></option>
            <option value="email" <?php if(@$profile->params->fields->created_by->data=="email") echo 'selected="selected"'; ?>><?php echo JText::_('EMAIL'); ?></option>
        </select></td>
    </tr>
    <tr>
     <td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_CREATED_BY_ALIAS'); ?>"></td>
        <td width="200"><label><?php echo JText::_('CREATED_BY_ALIAS'); ?></label></td>
        <td><select name="params[fields][created_by_alias][data]" id="paramsfieldscreated_by_aliasdata">
            <option value="include"><?php echo JText::_('INCLUDE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->created_by_alias->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select></td>
    </tr>
    <tr>
     <td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_MODIFIED'); ?>"></td>
        <td width="200"><label><?php echo JText::_('MODIFIED'); ?></label></td>
        <td><select name="params[fields][modified][data]" id="paramsfieldsmodifieddata">
            <option value="include"><?php echo JText::_('INCLUDE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->modified->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select></td>
    </tr>
    <tr>
     <td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_MODIFIED_BY'); ?>"></td>
        <td width="200"><label><?php echo JText::_('MODIFIED_BY'); ?></label></td>
        <td><select name="params[fields][modified_by][data]" id="paramsfieldsmodified_bydata">
            <option value="skip" <?php if(@$profile->params->fields->modified_by->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
            <option value="id" <?php if(@$profile->params->fields->modified_by->data=="id") echo 'selected="selected"'; ?>><?php echo JText::_('ID'); ?></option>
            <option value="username" <?php if(@$profile->params->fields->modified_by->data=="username") echo 'selected="selected"'; ?>><?php echo JText::_('USERNAME'); ?></option>
            <option value="email" <?php if(@$profile->params->fields->modified_by->data=="email") echo 'selected="selected"'; ?>><?php echo JText::_('EMAIL'); ?></option>
        </select></td>
    </tr>
    <tr>
     <td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_PUBLISH_UP'); ?>"></td>
        <td width="200"><label><?php echo JText::_('PUBLISH_UP'); ?></label></td>
        <td><select name="params[fields][publish_up][data]" id="paramsfieldspublish_updata">
            <option value="include"><?php echo JText::_('INCLUDE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->publish_up->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select></td>
    </tr>
    <tr>
     <td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_PUBLISH_DOWN'); ?>"></td>
        <td width="200"><label><?php echo JText::_('PUBLISH_DOWN'); ?></label></td>
        <td><select name="params[fields][publish_down][data]" id="paramsfieldspublish_downdata">
            <option value="include"><?php echo JText::_('INCLUDE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->publish_down->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select></td>
    </tr>
    <tr>
     <td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_IMAGES'); ?>"></td>
        <td width="200"><label><?php echo JText::_('IMAGES'); ?></label></td>
        <td><select name="params[fields][images][data]" id="paramsfieldsimagesdata">
            <option value="include"><?php echo JText::_('INCLUDE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->images->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select></td>
    </tr>
    <tr>
     <td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_URLS'); ?>"></td>
        <td width="200"><label><?php echo JText::_('URLS'); ?></label></td>
        <td><select name="params[fields][urls][data]" id="paramsfieldsurlsdata">
            <option value="include"><?php echo JText::_('INCLUDE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->urls->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select></td>
    </tr>
    <tr>
     <td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_ATTRIBS'); ?>"></td>
        <td width="200"><label><?php echo JText::_('ATTRIBS'); ?></label></td>
        <td><select name="params[fields][attribs][data]" id="paramsfieldsattribsdata">
            <option value="include"><?php echo JText::_('INCLUDE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->attribs->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select></td>
    </tr>
    <tr>
     <td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_VERSION'); ?>"></td>
        <td width="200"><label><?php echo JText::_('VERSION'); ?></label></td>
        <td><select name="params[fields][version][data]" id="paramsfieldsversiondata">
            <option value="include"><?php echo JText::_('INCLUDE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->version->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select></td>
    </tr>
    <tr>
     <td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_ORDERING'); ?>"></td>
        <td width="200"><label><?php echo JText::_('ORDERING'); ?></label></td>
        <td><select name="params[fields][ordering][data]" id="paramsfieldsorderingdata">
            <option value="include"><?php echo JText::_('INCLUDE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->ordering->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select></td>
    </tr>
    <tr>
     <td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_METADESC'); ?>"></td>
        <td width="200"><label><?php echo JText::_('METADESC'); ?></label></td>
        <td><select name="params[fields][metadesc][data]" id="paramsfieldsmetadescdata">
            <option value="include"><?php echo JText::_('INCLUDE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->metadesc->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select></td>
    </tr>
    <tr>
     <td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_METAKEY'); ?>"></td>
        <td width="200"><label><?php echo JText::_('METAKEY'); ?></label></td>
        <td><select name="params[fields][metakey][data]" id="paramsfieldsmetakeydata">
            <option value="include"><?php echo JText::_('INCLUDE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->metakey->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select></td>
    </tr>
    <tr>
     <td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_ACCESS'); ?>"></td>
        <td width="200"><label><?php echo JText::_('ACCESS'); ?></label></td>
        <td><select name="params[fields][access][data]" id="paramsfieldsaccessdata">
            <option value="include"><?php echo JText::_('INCLUDE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->access->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select></td>
    </tr>
    <tr>
     <td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_HITS'); ?>"></td>
        <td width="200"><label><?php echo JText::_('HITS'); ?></label></td>
        <td><select name="params[fields][hits][data]" id="paramsfieldshitsdata">
            <option value="include"><?php echo JText::_('INCLUDE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->hits->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select></td>
    </tr>
    <tr>
     <td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_METADATA'); ?>"></td>
        <td width="200"><label><?php echo JText::_('METADATA'); ?></label></td>
        <td><select name="params[fields][metadata][data]" id="paramsfieldsmetadatadata">
            <option value="include"><?php echo JText::_('INCLUDE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->metadata->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select></td>
    </tr>
    <tr>
     <td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_FEATURED'); ?>"></td>
        <td width="200"><label><?php echo JText::_('FEATURED'); ?></label></td>
        <td><select name="params[fields][featured][data]" id="paramsfieldsfeatureddata">
            <option value="include"><?php echo JText::_('INCLUDE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->featured->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select></td>
    </tr>
    <tr>
     <td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_LANGUAGE'); ?>"></td>
        <td width="200"><label><?php echo JText::_('LANGUAGE'); ?></label></td>
        <td><select name="params[fields][language][data]" id="paramsfieldslanguagedata">
            <option value="include"><?php echo JText::_('INCLUDE'); ?></option>
            <option value="skip" <?php if(@$profile->params->fields->language->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
        </select></td>
    </tr>
    <tr>
     <td width="20"><img class="hasTip" border="0" alt="Tooltip" src="../media/com_hexdata/images/tooltip.png" title="<?php echo JText::_('TT_ARTICLE_PERMISSIONS'); ?>"></td>
        <td width="200"><label><?php echo JText::_('ARTICLE_PERMISSIONS'); ?></label></td>
        <td><select name="params[fields][asset_id][data]" id="paramsfieldsasset_iddata">
            <option value="skip" <?php if(@$profile->params->fields->asset_id->data=="skip") echo 'selected="selected"'; ?>><?php echo JText::_('SKIP'); ?></option>
            <option value="asset_id" <?php if(@$profile->params->fields->asset_id->data=="asset_id") echo 'selected="selected"'; ?>><?php echo JText::_('Asset ID'); ?></option>
            <option value="rules" <?php if(@$profile->params->fields->asset_id->data=="rules") echo 'selected="selected"'; ?>><?php echo JText::_('RULES'); ?></option>
        </select></td>
    </tr>