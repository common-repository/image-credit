<?php
/*
Plugin Name: Image Credit
Plugin URI: https://tyler.menez.es/
Description: Adds a credit field for images.
Version: 1.0
Author: Tyler Menezes
Author URI: https://tyler.menez.es/
License: GPL2

=====

Copyright (c) 2011 Tyler Menezes (email: tyler@menez.es)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

define('WP_IMAGE_CREDIT_META_NAME', '_wp_attachment_image_credit');
define('WP_IMAGE_CREDIT_META_NAME_LINK', WP_IMAGE_CREDIT_META_NAME . '_link');

add_filter('attachment_fields_to_edit', 'wp_image_credit_add_fields', 10, 2);
function wp_image_credit_add_fields($form_fields, $post){

	if(substr($post->post_mime_type, 0, 5) != "image"){
		return $form_fields;
	}

	$credit = $_POST['attachments'][$post->ID]['credit'];
	if( empty($credit) ){
		$credit = get_post_meta($post->ID, WP_IMAGE_CREDIT_META_NAME, true);
		if( empty($credit) ){
			$credit = '';
		}
	}else{
		update_post_meta($post->ID, WP_IMAGE_CREDIT_META_NAME, $credit);
	}

	$form_fields['credit'] = array(
		'label'      => __('Credit'),
		'value'      => $credit,
	);
	
	$credit_link = $_POST['attachments'][$post->ID]['credit_link'];
	if( empty($credit_link) ){
		$credit_link = get_post_meta($post->ID, WP_IMAGE_CREDIT_META_NAME_LINK, true);
		if( empty($credit_link) ){
			$credit_link = '';
		}
	}else{
		update_post_meta($post->ID, WP_IMAGE_CREDIT_META_NAME_LINK, $credit_link);
	}
	
	$form_fields['credit_link'] = array(
		'label'      => __('Credit URL'),
		'value'      => $credit_link,
		'helps'		 => __('A link to the creator\'s website.'),
	);
	
	return $form_fields;
}

add_filter( 'img_caption_shortcode', 'wp_image_credit_img_caption_shortcode', 10, 3 );
function wp_image_credit_img_caption_shortcode($attr, $content, $html){

	$content = (object)$content;
	$credit = wp_image_credit_get_credit_link(substr($content->id, strpos($content->id, "_") + 1));

	$result = <<<END
	<div id="{$content->id}" class="wp-caption {$content->align}" style="width: {$content->width}px">{$html}</span><p class="wp-caption-text">$credit {$content->caption}</p></div>
END;
	
	return $result;
}

function wp_image_credit_get_credit_link($id){
	$credit = get_post_meta($id, WP_IMAGE_CREDIT_META_NAME, true);
	
	
	
	if( empty($credit) ){
		return false;
	}
	
	$credit_link = get_post_meta($id, WP_IMAGE_CREDIT_META_NAME_LINK, true);
	if( !empty($credit_link) ){
		$credit = '<a href="' . $credit_link . '">' . $credit . '</a>';
	}
	
	$credit = '<span class="credit image-credit image-credit-' . $id . '">' . $credit . "</span>";
	
	return $credit;
}

add_filter('image_send_to_editor','wp_image_credit_image_send_to_editor',10,2);
function wp_image_credit_image_send_to_editor($html, $id){

	$thePost = get_post($id, "OBJECT");
	
	if($thePost->post_excerpt){
		return $html;
	}

	$credit = wp_image_credit_get_credit_link($id);
	if($credit === false){
		return $html;
	}
	
	$html .= $credit;
	return $html;
}

?>