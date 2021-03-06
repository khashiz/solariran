<?php
/**
 * @package	HikaShop for Joomla!
 * @version	4.4.1
 * @author	hikashop.com
 * @copyright	(C) 2010-2021 HIKARI SOFTWARE. All rights reserved.
 * @license	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
defined('_JEXEC') or die('Restricted access');
?><?php
$tmpl = hikaInput::get()->getWord('tmpl', '');
$module_id = (int)$this->params->get('id', 0);

if(!in_array($tmpl, array('component', 'ajax', 'raw'))) {
	$events = ($this->cart_type == 'cart') ? '["cart.updated","checkout.cart.updated"]' : '"wishlist.updated"';
?>
<script type="text/javascript">
window.Oby.registerAjax(<?php echo $events; ?>, function(params) {
	var o = window.Oby, el = document.getElementById('hikashop_cart_<?php echo $module_id; ?>');
	if(!el) return;
	if(params && params.resp && (params.resp.ret === 0 || params.resp.module == <?php echo (int)$module_id; ?>)) return;
	if(params && params.type && params.type != '<?php echo $this->cart_type; ?>') return;
	o.addClass(el, "hikashop_checkout_loading");
	o.xRequest("<?php echo hikashop_completeLink('product&task=cart&module_id='.$module_id . '&module_type='.$this->cart_type, true, false, true); ?>", {update: el, mode:'POST', data:'return_url=<?php echo urlencode(base64_encode(hikashop_currentURL('return_url'))); ?>'}, function(xhr){
		o.removeClass(el, "hikashop_checkout_loading");
	});
});
</script>
<?php
} elseif(!headers_sent()){
	header('X-Robots-Tag: noindex');
}

$group = (int)$this->config->get('group_options', 0);
$small_cart = (int)$this->params->get('small_cart', 0);
$link_to_product = (int)$this->params->get('link_to_product_page', 1);
$spinner_css="";
if (!empty($small_cart)) $spinner_css="small_spinner small_cart";

if(empty($this->rows)) {
	$hidecart = (int)$this->params->get('hide_cart', 0);
	$desc = trim($this->params->get('msg'));
	if((empty($desc) && $desc != '0') || $hidecart == 0)
		$desc = ($this->cart_type == 'cart') ? '<a class="uk-text-gray hoverAccent" href="'.JURI::base().'cart" title="'.JTEXT::_('CART_EMPTY').'" data-uk-tooltip="offset: 19; animation: uk-animation-slide-bottom-small;"><img width="18" height="18" data-uk-svg src="'.JURI::base().'images/sprite.svg#shopping-cart"></a>' : JText::_('WISHLIST_EMPTY');
	if($hidecart == 2)
		$desc = '';

	if(empty($desc) && $desc != '0' && $tmpl == 'component') {
		if(!headers_sent())
			header('Content-Type: text/css; charset=utf-8');
		exit;
	}

	if(!empty($desc))
		echo $this->notice_html;

	if(!in_array($tmpl, array('component', 'ajax', 'raw'))) {
?>
<div data-uk-kh id="hikashop_cart_<?php echo $module_id; ?>" class="hikashop_cart">
<?php
	}
?>
	<div class="hikashop_checkout_loading_elem"></div>
	<div class="hikashop_checkout_loading_spinner <?php echo $spinner_css ?>"></div>
<?php
	if(!empty($desc))
		echo $desc;

	if(!in_array($tmpl, array('component', 'ajax', 'raw'))) {
?>
</div>
<?php
	}

	return;
}


$css_button = $this->config->get('css_button', 'hikabtn');
$css_button_checkout = $this->config->get('css_button_checkout', 'hikashop_cart_proceed_to_checkout');

if($this->params->get('print_cart', 0)) {
	$print_button = $this->popup->display(
		'<i class="fas fa-print"></i>',
		'HIKA_PRINT', hikashop_completeLink('cart&task=printcart&cid='.$this->element->cart_id, true),
		'hikashop_print_popup', 760, 480, 'title="'.JText::_('HIKA_PRINT').'"', '', 'link'
	);
}
$this->setLayout('cart_module_price');
$this->params->set('show_quantity_field', 0);

if(!in_array($tmpl, array('component', 'ajax', 'raw'))) {
?>
<div id="hikashop_cart_<?php echo $module_id; ?>" class="hikashop_cart">
<?php
}
?>
	<div class="hikashop_checkout_loading_elem"></div>
	<div class="hikashop_checkout_loading_spinner <?php echo $spinner_css ?>"></div>
<?php

echo $this->notice_html;
if(!empty($this->element->messages)) {
	foreach($this->element->messages as $msg) {
		if(empty($msg['type']))
			$msg['type'] = 'success';
		hikashop_display($msg['msg'], $msg['type']);
	}
}
$text = '';
if(!empty($small_cart)) {
	$price_name  = '';
	if(!$this->params->get('show_shipping', 0) && isset($this->total->prices[0]->price_value_without_shipping)){
		$price_name = '_without_shipping';
	}
	if(!$this->params->get('show_coupon', 0) && isset($this->total->prices[0]->price_value_without_discount)){
		$price_name = '_without_discount';
	}
	$price = '';
	if($this->params->get('price_with_tax')){
		$var_name = 'price_value'.$price_name.'_with_tax';
		$price .= $this->currencyClass->format(@$this->total->prices[0]->$var_name, $this->total->prices[0]->price_currency_id);
	}
	if($this->params->get('price_with_tax')==2){
		$price .= JText::_('PRICE_BEFORE_TAX');
	}
	if($this->params->get('price_with_tax')==2||!$this->params->get('price_with_tax')){
		$var_name = 'price_value'.$price_name;
		$price .= $this->currencyClass->format(@$this->total->prices[0]->price_value, $this->total->prices[0]->price_currency_id);
	}
	if($this->params->get('price_with_tax')==2){
		$price .= JText::_('PRICE_AFTER_TAX');
	}
	if((int)$this->params->get('show_cart_quantity', 1)) {
		$qty = 0;
		foreach($this->element->cart_products as $i => $row) {
			if(empty($row->cart_product_quantity) && $this->element->cart_type == 'cart')
				continue;
			if($group && $row->cart_product_option_parent_id)
				continue;

			$qty += $row->cart_product_quantity;
		}

		if($this->params->get('show_price')){
			if($qty == 1 && JText::_('X_ITEM_FOR_X') != 'X_ITEM_FOR_X') {
				$text = JText::sprintf('X_ITEM_FOR_X', $qty, $price);
			} else {
				$text = JText::sprintf('X_ITEMS_FOR_X', $qty, $price);
			}
		}else{
			if($qty == 1)
				$text = JText::sprintf('X_ITEM', $qty);
			else
				$text = JText::sprintf('X_ITEMS', $qty);
		}
	} else {
		if($this->params->get('show_price'))
			$text = JText::sprintf('TOTAL_IN_CART_X', $price);
		else
			$text = JText::_('MINI_CART_PROCEED_TO_CHECKOUT');
	}
	unset($this->row);

	$extra_data = '';
	if($this->element->cart_type == 'cart') {
		$link = $this->url_checkout;
	} else {
		$link = hikashop_completeLink('cart&task=showcart&cart_id='.$this->element->cart_id.'&cart_type='.$this->element->cart_type . $this->cart_itemid);
	}
	if($small_cart == 2) {
		$extra_data .= ' onclick="if(window.hikashop.toggleOverlayBlock(\'hikashop_cart_dropdown_'.$module_id.'\')) return false;"';
	}elseif($small_cart == 3) {
		$extra_data .= ' ontouchend="window.hikashop.toggleOverlayBlock(\'hikashop_cart_dropdown_'.$module_id.'\', \'hover\'); return false;" onmouseover="window.hikashop.toggleOverlayBlock(\'hikashop_cart_dropdown_'.$module_id.'\', \'hover\'); return false;"';
	}
?>
	<a class="hikashop_small_cart_checkout_link uk-position-relative uk-display-inline-block hoverAccent" href="<?php echo $link; ?>"<?php echo $extra_data; ?>>
        <img src="<?php echo JURI::base().'images/sprite.svg#shopping-cart' ?>" width="18" height="18" data-uk-svg>
        <span class="cartIndicator"></span>
	</a>
<?php
	if($this->element->cart_type == 'cart' && $small_cart == 1 && $this->params->get('print_cart', 0)) {
?>		<span class="hikashop_checkout_cart_print_link">
<?php		echo $print_button;
?>		</span>
<?php
	}

	if($this->element->cart_type == 'cart' && $small_cart == 1 && $this->params->get('show_cart_delete', 1)) {
		$delete = hikashop_completeLink('product&task=cleancart');
?>
	<a class="hikashop_small_cart_clean_link" title="<?php echo JText::_('EMPTY_THE_CART'); ?>" href="<?php echo $delete; ?>" onclick="window.location='<?php echo $delete. (strpos($delete, '?') ? '&amp;' : '?') .'return_url='; ?>'+window.btoa(window.location); return false;">
		<i class="fa fa-times-circle"></i>
	</a>
<?php
	}

	if($this->element->cart_type == 'cart' && $small_cart == 1 && $this->params->get('show_cart_proceed', 1)) {
?>
	<a class="<?php echo $css_button . ' ' . $css_button_checkout; ?>" href="<?php echo $this->url_checkout; ?>" onclick="if(this.disable) return false; this.disable = true;"><span><?php
		echo JText::_('PROCEED_TO_CHECKOUT');
	?></span></a>
<?php
	}

	if($small_cart == 1) {
?>
</div>
<?php
		return;
	}

	$alignment = '';
	$v = (int)$this->params->get('dropdown_left', 0);
	if($v != 0) $alignment .= 'left:'.(-$v).'px;';
	$v = (int)$this->params->get('dropdown_right', 0);
	if($v != 0) $alignment .= 'right:'.(-$v).'px;';
?>
	<div class="hikashop_cart_dropdown_container cartDrop" data-uk-drop="offset: 26; animation: uk-animation-slide-bottom-small; pos: bottom-left">
	<div class="hikashop_cart_dropdown_content uk-card uk-card-default uk-box-shadow-small uk-border-rounde" id="hikashop_cart_dropdown_<?php echo $module_id; ?>">
<?php
}
$shows = array(
	'price' => (int)$this->params->get('show_price', 1),
	'coupon' => (int)$this->params->get('show_coupon', 0),
	'shipping' => (int)$this->params->get('show_shipping', 0),
	'payment' => (int)$this->params->get('show_payment', 0),
	'taxes' => (int)$this->params->get('show_taxes', 0),
);
$columns = array(
	'image' => (int)$this->params->get('image_in_cart', 0),
	'name' => (int)$this->params->get('show_cart_product_name', 1),
	'quantity' => (int)$this->params->get('show_cart_quantity', 1),
	'price' => (int)$shows['price'],
	'delete' => (int)$this->params->get('show_cart_delete', 1)
);
$nb_columns = 0;
foreach($columns as $c) {
	if(!empty($c))
		$nb_columns++;
}

?>
        <div class="cartContainer">
            <form action="<?php echo hikashop_completeLink('product&task=updatecart'.$this->url_itemid, false, true); ?>" method="post" name="hikashop_<?php echo $this->element->cart_type; ?>_form" onsubmit="if(window.hikashop) return window.hikashop.submitCartModule(this, 'hikashop_cart_<?php echo $module_id; ?>', '<?php echo $this->element->cart_type; ?>');">
                <div class="uk-padding-small">
                    <div>
                        <div class="uk-grid-small" data-uk-grid>
                            <div class="uk-width-expand">
                                <span class="uk-text-muted hoverAccent uk-text-tiny font f600 hikashop_small_cart_total_title uk-hid uk-text-tiny"><?php echo JText::sprintf('X_ITEMS', $qty); ?></span>
                            </div>
                            <div class="uk-width-auto">
                                <a href="<?php echo JRoute::_("index.php?Itemid=167"); ?>" class="uk-text-muted hoverAccent uk-text-tiny font f600"><?php echo JText::sprintf('SEECART'); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="uk-margin-remove">
                <div class="uk-padding-small">
                    <?php if(!empty($shows['price']) && $this->element->cart_type == 'cart') { $colspan = $nb_columns - (empty($columns['delete']) ? 1 : 2); ?>
                        <?php if(!empty($shows['taxes']) && isset($this->total->prices[0])) {
                            if ($this->config->get('detailed_tax_display') && !empty($this->total->prices[0]->taxes)) {
                                foreach($this->displayingPrices->taxes as $taxname => $taxdata){
                                    ?>
                                    <tr>
                                        <?php if($colspan > 0) { ?>
                                            <td class="hikashop_cart_module_tax_title" colspan="<?php echo $colspan; ?>">
                                                <?php echo hikashop_translate($taxname); ?></td>
                                        <?php } ?>
                                        <td class="hikashop_cart_module_tax_value">
                                            <?php echo $this->currencyClass->format($taxdata->tax_amount, $this->displayingPrices->price_currency_id); ?>
                                        </td>
                                    </tr>
                                <?php } } else { ?>
                                <tr>
                                    <?php if($colspan > 0) { ?>
                                        <td class="hikashop_cart_module_tax_title" colspan="<?php echo $colspan; ?>"><?php
                                            echo JText::_('TAXES');
                                            ?></td>
                                    <?php 		} ?>
                                    <td class="hikashop_cart_module_tax_value"><?php
                                        $taxes = round($this->displayingPrices->total->price_value_with_tax - $this->displayingPrices->total->price_value, $this->currencyClass->getRounding($this->displayingPrices->price_currency_id));
                                        echo $this->currencyClass->format($taxes, $this->displayingPrices->price_currency_id);
                                        ?></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    <?php } ?>
                    <div>
                        <div class="uk-grid-small uk-child-width-1-1 uk-grid-divider" data-uk-grid>
                        <?php
                        $group = $this->config->get('group_options', 0);
                        $width = (int)$this->config->get('cart_thumbnail_x', 70);
                        $height = (int)$this->config->get('cart_thumbnail_y', 70);
                        $image_options = array(
                            'default' => true,
                            'forcesize' => $this->config->get('image_force_size', true),
                            'scale' => $this->config->get('image_scale_mode','inside')
                        );

                        $k = 0;
                        foreach($this->element->products as $k => $product) {
                            if($group && !empty($product->cart_product_option_parent_id))
                                continue;
                            if(empty($product->cart_product_quantity) || substr($k,0,1) === 'p')
                                continue;

                            $cart_product = $this->element->cart_products[$k];
                            ?>
                            <div>
                                <div data-uk-grid class="uk-grid-small row<?php echo $k; ?>">
                                    <?php if(!empty($columns['image'])) { ?>
                                        <div class="hikashop_cart_module_product_image hikashop_cart_value uk-width-auto">
                                            <?php
                                            $img = $this->imageHelper->getThumbnail(@$product->images[0]->file_path, array('width' => $width, 'height' => $height), $image_options);
                                            if($img->success) {
                                                $attributes = '';
                                                if($img->external)
                                                    $attributes = ' width="'.$img->req_width.'" height="'.$img->req_height.'"';
                                                ?>
                                                <div class="uk-border-rounded uk-box-shadow-small uk-overflow-hidden">
                                                    <img class="hikashop_product_cart_image" title="<?php echo $this->escape(@$product->images[0]->file_description); ?>" alt="<?php echo $this->escape(@$product->images[0]->file_name); ?>" src="<?php echo $img->url; ?>" <?php echo $attributes; ?>/>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                    <div class="uk-width-expand">
                                        <div class="uk-height-1-1 uk-flex uk-flex-column uk-flex-between">
                                            <?php if(!empty($columns['name'])) { ?>
                                                <div class="hikashop_cart_module_product_name_value hikashop_cart_value">
                                                    <?php if($link_to_product == 1) { ?><a class="uk-display-block uk-text-tiny hoverAccent f600 font" href="<?php echo hikashop_contentLink('product&task=show&cid='.$product->product_id.'&name='.$product->alias.$this->url_itemid, $product);?>"><?php } ?>
                                                        <?php echo $product->product_name; ?>
                                                        <?php if ($this->config->get('show_code')) { ?>
                                                            <span class="hikashop_product_code_cart"><?php echo $product->product_code; ?></span>
                                                        <?php } ?>
                                                        <?php if($link_to_product == 1) { ?></a><?php } ?>
                                                    <?php
                                                    $html = '';
                                                    if(hikashop_level(2) && !empty($this->itemFields)) {
                                                        foreach($this->itemFields as $field) {
                                                            $namekey = $field->field_namekey;
                                                            if(empty($cart_product->$namekey) || !strlen($cart_product->$namekey))
                                                                continue;
                                                            $html .= '<p class="hikashop_cart_item_'.$namekey.'">' .
                                                                $this->fieldsClass->getFieldName($field) . ': ' .
                                                                $this->fieldsClass->show($field, $cart_product->$namekey) .
                                                                '</p>';
                                                        }
                                                    }
                                                    if($group) {
                                                        foreach($this->element->products as $j => $optionElement) {
                                                            if($optionElement->cart_product_option_parent_id != $product->cart_product_id)
                                                                continue;
                                                            if(!empty($optionElement->variant_name)) {
                                                                $text = $optionElement->variant_name;
                                                            } elseif(empty($optionElement->characteristics_text)){
                                                                $text = $optionElement->product_name;
                                                            } else {
                                                                $text = $optionElement->characteristics_text;
                                                            }
                                                            $html .= '<p class="hikashop_cart_option_name">'. $text . '</p>';
                                                        }
                                                    }
                                                    if(!empty($html)) {
                                                        ?>
                                                        <div class="hikashop_cart_product_custom_item_fields"><?php
                                                            echo $html;
                                                            ?></div>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                            <?php } ?>
                                            <div class="uk-text-tiny">
                                                <div>
                                                    <div data-uk-grid>
                                                        <?php if(!empty($columns['price'])) {
                                                            if($group) {
                                                                foreach($this->element->products as $j => $optionElement) {
                                                                    if($optionElement->cart_product_option_parent_id != $product->cart_product_id)
                                                                        continue;
                                                                    if(empty($optionElement->prices[0]))
                                                                        continue;
                                                                    if(!isset($product->prices[0])) {
                                                                        $product->prices[0] = new stdClass();
                                                                        $product->prices[0]->price_value = 0;
                                                                        $product->prices[0]->price_value_with_tax = 0;
                                                                        $product->prices[0]->price_currency_id = hikashop_getCurrency();
                                                                    }
                                                                    foreach(get_object_vars($product->prices[0]) as $key => $value) {
                                                                        if(strpos($key, 'price_value') === false)
                                                                            continue;
                                                                        if(is_object($value)) {
                                                                            foreach(get_object_vars($value) as $key2 => $var2) {
                                                                                $product->prices[0]->$key->$key2 += @$optionElement->prices[0]->$key->$key2;
                                                                            }
                                                                        } else {
                                                                            $product->prices[0]->$key += @$optionElement->prices[0]->$key;
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                            <div class="hikashop_cart_module_product_price_value hikashop_cart_value uk-width-expand">
                                                                <?php
                                                                $this->row =& $product;
                                                                $this->unit = false;
                                                                $this->cart_product_price = true;

                                                                $price_with_tax_option = $this->params->get('price_with_tax');
                                                                if(!empty($shows['taxes']) && $this->params->get('price_with_tax') == 1)
                                                                    $this->params->set('price_with_tax',0);

                                                                if($this->params->get('show_discount', 3) == 3 && isset($this->default_params['show_discount'])) {
                                                                    $this->params->set('show_discount', (int)$this->default_params['show_discount']);
                                                                }

                                                                echo $this->loadTemplate();

                                                                if(!empty($shows['taxes']) && $price_with_tax_option == 1)
                                                                    $this->params->set('price_with_tax',$price_with_tax_option);
                                                                ?>
                                                            </div>
                                                        <?php } ?>
                                                        <?php if(!empty($columns['delete'])) {
                                                            $delete_url = hikashop_completeLink('product&task=updatecart&cart_id='.(int)$this->element->cart_id.'&cart_product_id='.(int)$product->cart_product_id.'&quantity=0');
                                                            $delete_url .= ((strpos($delete_url, '?') === false) ? '?' : '&') . 'return_url='.urlencode(base64_encode(urldecode($this->params->get('url'))));
                                                            ?>
                                                            <div class="hikashop_cart_module_product_delete_value hikashop_cart_value uk-width-auto uk-flex uk-flex-bottom">
                                                                <div>
                                                                    <a href="<?php echo $delete_url; ?>" data-cart-id="<?php echo (int)$this->element->cart_id; ?>" data-cart-type="<?php echo $this->escape($this->element->cart_type); ?>" data-cart-product-id="<?php echo (int)$product->cart_product_id; ?>" onclick="if(window.hikashop) { return window.hikashop.deleteFromCart(this, null, 'hikashop_cart_<?php echo $module_id; ?>'); }" title="<?php echo JText::_('HIKA_DELETE'); ?>" class="uk-text-danger" data-uk-tooltip="offset: 5;">
                                                                        <img src="<?php echo JURI::base().'images/sprite.svg#trash'; ?>" width="16" height="16" data-uk-svg>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if(!empty($columns['quantity'])) { ?>
                                        <div class="uk-hidden hikashop_cart_module_product_quantity_value hikashop_cart_value"><?php
                                            $this->row =& $product;
                                            $this->quantityLayout = $this->cartHelper->getProductQuantityLayout($this->row);
                                            echo $this->loadHkLayout('quantity', array(
                                                'id_prefix' => 'hikashop_cart_'.$module_id.'_quantity_field',
                                                'quantity_fieldname' => 'item['.$product->cart_product_id.'][cart_product_quantity]',
                                                'onchange_script' => 'console.log(this.value); window.hikashop.checkQuantity(this); if(this.value == '.(int)$product->cart_product_quantity.'){ return; } if(this.form.onsubmit && !this.form.onsubmit()) return; this.form.submit();',
                                            ));
                                            ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php $k = 1 - $k; } ?>
                        </div>
                    </div>
                </div>
                <hr class="uk-margin-remove">
                <div class="uk-padding-small">
                    <div>
                        <div class="uk-grid-small uk-child-width-1-2" data-uk-grid>
                            <div class="uk-width-expand uk-flex uk-flex-middle">
                                <?php
                                if($this->params->get('price_with_tax', 3) == 3) {
                                    $this->params->set('price_with_tax', (int)$this->config->get('price_with_tax'));
                                }
                                $total_price = '';
                                if($this->params->get('price_with_tax')){
                                    $total_price .= $this->currencyClass->format($this->displayingPrices->total->price_value_with_tax, $this->displayingPrices->price_currency_id);
                                }
                                if($this->params->get('price_with_tax')==2){
                                    $total_price .= JText::_('PRICE_BEFORE_TAX');
                                }
                                if($this->params->get('price_with_tax')==2||!$this->params->get('price_with_tax')){
                                    $total_price .= $this->currencyClass->format($this->displayingPrices->total->price_value, $this->displayingPrices->price_currency_id);
                                }
                                if($this->params->get('price_with_tax')==2){
                                    $total_price .= JText::_('PRICE_AFTER_TAX');
                                }
                                ?>
                                <div>
                                    <span class="uk-display-block uk-text-muted uk-text-tiny font f500"><?php echo JText::sprintf('CART_PRODUCT_TOTAL_PRICE'); ?></span>
                                    <span class="hikashop_product_price_full uk-display-block">
                                        <span class="hikashop_product_price hikashop_product_price_0 uk-text-small uk-text-secondary f600 font"><?php echo $total_price; ?></span>
                                    </span>
                                </div>
                            </div>
                            <?php if($this->element->cart_type == 'cart' && $this->params->get('show_cart_proceed', 1)) { ?>
                                <div class="uk-width-auto">
                                    <a href="<?php echo $this->url_checkout; ?>" onclick="if(this.disable) return false; this.disable = true;" class="uk-button uk-button-success uk-width-1-1 uk-box-shadow-small uk-border-rounded font uk-height-1-1"><?php echo JText::sprintf('CHECKOUT'); ?></a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php if(!empty($shows['coupon']) && !empty($this->element->coupon)) { ?>
                    <div>
                        <?php if($colspan > 0) { ?>
                            <td class="hikashop_cart_module_coupon_title" colspan="<?php echo $colspan; ?>"><?php echo JText::_('HIKASHOP_COUPON'); ?></td>
                        <?php } ?>
                        <td class="hikashop_cart_module_coupon_value">
                            <?php
                            if(!$this->params->get('price_with_tax'))
                                echo $this->currencyClass->format(@$this->element->coupon->discount_value_without_tax * -1, @$this->element->coupon->discount_currency_id);
                            else
                                echo $this->currencyClass->format(@$this->element->coupon->discount_value * -1, @$this->element->coupon->discount_currency_id);
                            ?>
                        </td>
                    </div>
                <?php } ?>
                <?php if(!empty($shows['payment']) && !empty($this->element->payment) && $this->element->payment->payment_price !== null) { ?>
                    <div>
                        <?php if($colspan > 0) { ?>
                            <td class="hikashop_cart_module_payment_title" colspan="<?php echo $colspan; ?>">
                                <?php echo JText::_('HIKASHOP_PAYMENT'); ?>
                            </td>
                        <?php } ?>
                        <td class="hikashop_cart_module_payment_value">
                            <?php echo $this->currencyClass->format($this->payment_price, $this->total->prices[0]->price_currency_id); ?>
                        </td>
                    </div>
                <?php } ?>
                <?php if(!empty($shows['shipping']) && !empty($this->element->shipping) && $this->shipping_price !== null) { ?>
                    <div>
                        <?php if($colspan > 0) { ?>
                            <td class="hikashop_cart_module_shipping_title" colspan="<?php echo $colspan; ?>">
                                <?php echo JText::_('HIKASHOP_SHIPPING'); ?>
                            </td>
                        <?php } ?>
                        <td class="hikashop_cart_module_shipping_value">
                            <?php echo $this->currencyClass->format($this->shipping_price, $this->total->prices[0]->price_currency_id); ?>
                        </td>
                    </div>
                <?php } ?>


		<input type="hidden" name="option" value="<?php echo HIKASHOP_COMPONENT; ?>"/>
		<input type="hidden" name="ctrl" value="product"/>
		<input type="hidden" name="task" value="updatecart"/>
		<input type="hidden" name="cart_type" value="<?php echo $this->cart_type; ?>"/>
		<input type="hidden" name="url" value="<?php echo $this->escape($this->params->get('url')); ?>"/>
<?php
if($this->params->get('show_cart_quantity', 1)) {
?>
		<noscript>
			<input type="submit" class="<?php echo $css_button; ?>" name="refresh" value="<?php echo JText::_('REFRESH_CART');?>"/>
		</noscript>
<?php
}
?>
	</form>
        </div>


        <?php

if(!empty($this->extraData->bottom)) { echo implode("\r\n", $this->extraData->bottom); }

if(in_array($small_cart, array(2, 3))) {
?>
	</div>
	</div>
<?php
}

if(!in_array($tmpl, array('component', 'ajax', 'raw'))) {
?>
</div>
<?php
}
