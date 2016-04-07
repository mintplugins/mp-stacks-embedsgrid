<?php
/**
 * This page contains functions for modifying the metabox for embedsgrid as a media type
 *
 * @embed http://mintplugins.com/doc/
 * @since 1.0.0
 *
 * @package    MP Stacks EmbedsGrid
 * @subpackage Functions
 *
 * @copyright   Copyright (c) 2016, Mint Plugins
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @author      Philip Johnston
 */
 
/**
 * Add EmbedsGrid as a Media Type to the dropdown
 *
 * @since    1.0.0
 * @embed     http://mintplugins.com/doc/
 * @param    array $args See embed for description.
 * @return   void
 */
function mp_stacks_embedsgrid_create_meta_box(){
		
	/**
	 * Array which stores all info about the new metabox
	 *
	 */
	$mp_stacks_embedsgrid_add_meta_box = array(
		'metabox_id' => 'mp_stacks_embedsgrid_metabox', 
		'metabox_title' => __( '"EmbedsGrid" Content-Type', 'mp_stacks_embedsgrid'), 
		'metabox_posttype' => 'mp_brick', 
		'metabox_context' => 'advanced', 
		'metabox_priority' => 'low',
		'metabox_content_via_ajax' => true,
	);
	
	/**
	 * Array which stores all info about the options within the metabox
	 *
	 */
	$mp_stacks_embedsgrid_items_array = array(
	
		//Use this to add new options at this point with the filter hook
		'embedsgrid_meta_hook_anchor_0' => array( 'field_type' => 'hook_anchor'),
		
		'embedsgrid_embeds_showhider' => array(
			'field_id'			=> 'embedsgrid_embeds_showhider',
			'field_title' 	=> __( 'Embeds', 'mp_stacks_embedsgrid'),
			'field_description' 	=> __( '', 'mp_stacks_embedsgrid' ),
			'field_type' 	=> 'showhider',
			'field_value' => '',
		),
		
		'embedsgrid_embed_code' => array(
			'field_id'			=> 'embedsgrid_embed_code',
			'field_title' 	=> __( 'Embed Code (HTML)', 'mp_stacks_embedsgrid'),
			'field_description' 	=> __( 'Enter the embed code for this grid item.', 'mp_stacks_embedsgrid' ),
			'field_type' 	=> 'html',
			'field_value' => '',
			'field_showhider' => 'embedsgrid_embeds_showhider',
			'field_repeater' => 'embedsgrid_embeds_repeater',
		),
		
		'embedsgrid_embed_code_title' => array(
			'field_id'			=> 'embedsgrid_embed_code_title',
			'field_title' 	=> __( 'Title (Optional)', 'mp_stacks_embedsgrid'),
			'field_description' 	=> __( 'If you\'d like a title to appear with this embed, enter it here.', 'mp_stacks_embedsgrid' ),
			'field_type' 	=> 'textbox',
			'field_value' => '',
			'field_showhider' => 'embedsgrid_embeds_showhider',
			'field_repeater' => 'embedsgrid_embeds_repeater',
		),
		
		'embedsgrid_embed_code_description' => array(
			'field_id'			=> 'embedsgrid_embed_code_description',
			'field_title' 	=> __( 'Description (Optional)', 'mp_stacks_embedsgrid'),
			'field_description' 	=> __( 'If you\'d like a description to appear with this embed, enter it here.', 'mp_stacks_embedsgrid' ),
			'field_type' 	=> 'textarea',
			'field_value' => '',
			'field_showhider' => 'embedsgrid_embeds_showhider',
			'field_repeater' => 'embedsgrid_embeds_repeater',
		),
		
		
		'embedsgrid_design_showhider' => array(
			'field_id'			=> 'embedsgrid_design_showhider',
			'field_title' 	=> __( 'Grid Design Settings', 'mp_stacks_embedsgrid'),
			'field_description' 	=> __( '', 'mp_stacks_embedsgrid' ),
			'field_type' 	=> 'showhider',
			'field_value' => '',
		),
		'embedsgrid_layout_showhider' => array(
			'field_id'			=> 'embedsgrid_layout_settings',
			'field_title' 	=> __( 'Grid Layout Settings', 'mp_stacks_embedsgrid'),
			'field_description' 	=> __( '', 'mp_stacks_embedsgrid' ),
			'field_type' 	=> 'showhider',
			'field_value' => '',
			'field_showhider' => 'embedsgrid_design_showhider',
		),
		'embedsgrid_posts_per_row' => array(
			'field_id'			=> 'embedsgrid_per_row',
			'field_title' 	=> __( 'Embeds Per Row', 'mp_stacks_embedsgrid'),
			'field_description' 	=> __( 'How many posts do you want from left to right before a new row starts? Default 3', 'mp_stacks_embedsgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '3',
			'field_showhider' => 'embedsgrid_layout_settings',
		),
		'embedsgrid_posts_per_page' => array(
			'field_id'			=> 'embedsgrid_per_page',
			'field_title' 	=> __( 'Total Embeds', 'mp_stacks_embedsgrid'),
			'field_description' 	=> __( 'How many posts do you want to show entirely? Default: 9', 'mp_stacks_embedsgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '9',
			'field_showhider' => 'embedsgrid_layout_settings',
		),
		'embedsgrid_post_spacing' => array(
			'field_id'			=> 'embedsgrid_post_spacing',
			'field_title' 	=> __( 'Embed Spacing', 'mp_stacks_embedsgrid'),
			'field_description' 	=> __( 'How much space would you like to have in between each post in pixels? Default 20', 'mp_stacks_embedsgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '20',
			'field_showhider' => 'embedsgrid_layout_settings',
		),
		'embedsgrid_post_inner_margin' => array(
			'field_id'			=> 'embedsgrid_post_inner_margin',
			'field_title' 	=> __( 'Embed Inner Margin', 'mp_stacks_embedsgrid'),
			'field_description' 	=> __( 'How much space would you like to have between the outer edge of each download and the download\'s inner content? Default 0', 'mp_stacks_embedsgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '0',
			'field_showhider' => 'embedsgrid_layout_settings',
		),
		'embedsgrid_masonry' => array(
			'field_id'			=> 'embedsgrid_masonry',
			'field_title' 	=> __( 'Use Masonry?', 'mp_stacks_embedsgrid'),
			'field_description' 	=> __( 'Would you like to use Masonry for the layout? Masonry is similar to how Pinterest posts are laid out.', 'mp_stacks_embedsgrid' ),
			'field_type' 	=> 'checkbox',
			'field_value' => 'embedsgrid_masonry',
			'field_showhider' => 'embedsgrid_layout_settings',
		),
		
		//Use this to add new options at this point with the filter hook
		'embedsgrid_meta_hook_anchor_2' => array( 'field_type' => 'hook_anchor'),
		
		//Use this to add new options at this point with the filter hook
		'embedsgrid_meta_hook_anchor_3' => array( 'field_type' => 'hook_anchor'),
		
	);
	
	
	/**
	 * Custom filter to allow for add-on plugins to hook in their own data for add_meta_box array
	 */
	$mp_stacks_embedsgrid_add_meta_box = has_filter('mp_stacks_embedsgrid_meta_box_array') ? apply_filters( 'mp_stacks_embedsgrid_meta_box_array', $mp_stacks_embedsgrid_add_meta_box) : $mp_stacks_embedsgrid_add_meta_box;
	
	/**
	 * Custom filter to allow for add on plugins to hook in their own extra fields 
	 */
	$mp_stacks_embedsgrid_items_array = has_filter('mp_stacks_embedsgrid_items_array') ? apply_filters( 'mp_stacks_embedsgrid_items_array', $mp_stacks_embedsgrid_items_array) : $mp_stacks_embedsgrid_items_array;
	
	/**
	 * Create Metabox class
	 */
	global $mp_stacks_embedsgrid_meta_box;
	$mp_stacks_embedsgrid_meta_box = new MP_CORE_Metabox($mp_stacks_embedsgrid_add_meta_box, $mp_stacks_embedsgrid_items_array);
}
add_action('mp_brick_ajax_metabox', 'mp_stacks_embedsgrid_create_meta_box');
add_action('wp_ajax_mp_stacks_embedsgrid_metabox_content', 'mp_stacks_embedsgrid_create_meta_box');