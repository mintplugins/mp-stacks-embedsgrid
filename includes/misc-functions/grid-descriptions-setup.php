<?php 
/**
 * This file contains the function which set up the Descriptions in the Grid
 *
 * To use this for additional Text Overlays in a grid, duplicate this file 
 * 1. Find and replace "embedsgrid" with your plugin's prefix
 * 2. Find and replace "description" with your desired text overlay name
 * 3. Make custom changes to the mp_stacks_embedsgrid_description function about what is displayed.
 *
 * @since 1.0.0
 *
 * @package    MP Stacks EmbedsGrid
 * @subpackage Functions
 *
 * @copyright  Copyright (c) 2016, Mint Plugins
 * @license    http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @author     Philip Johnston
 */

/**
 * Add the meta options for the Grid Descriptions to the EmbedsGrid Metabox
 *
 * @access   public
 * @since    1.0.0
 * @param    Void
 * @param    $items_array Array - The existing Meta Options in this Array
 * @return   Array - All of the placement optons needed for Description
 */
function mp_stacks_embedsgrid_description_meta_options( $items_array ){		
	
	//Description Settings
	$new_fields = array(
		//Description
		'embedsgrid_description_showhider' => array(
			'field_id'			=> 'embedsgrid_description_settings',
			'field_title' 	=> __( 'Description Settings', 'mp_stacks_embedsgrid'),
			'field_description' 	=> __( '', 'mp_stacks_embedsgrid' ),
			'field_type' 	=> 'showhider',
			'field_value' => '',
			'field_showhider' => 'embedsgrid_design_showhider',
		),
		'embedsgrid_description_show' => array(
			'field_id'			=> 'embedsgrid_description_show',
			'field_title' 	=> __( 'Show Descriptions?', 'mp_stacks_embedsgrid'),
			'field_description' 	=> __( 'Do you want to show the Descriptions for these posts?', 'mp_stacks_embedsgrid' ),
			'field_type' 	=> 'checkbox',
			'field_value' => 'embedsgrid_description_show',
			'field_showhider' => 'embedsgrid_description_settings',
		),
		'embedsgrid_description_placement' => array(
			'field_id'			=> 'embedsgrid_description_placement',
			'field_title' 	=> __( 'Description Placement', 'mp_stacks_embedsgrid'),
			'field_description' 	=> __( 'Where would you like to place the description? Default: Above Image, Left', 'mp_stacks_embedsgrid' ),
			'field_type' 	=> 'select',
			'field_value' => 'above_image_left',
			'field_select_values' => mp_stacks_get_text_position_options(array( 
				'above' => true,
				'over' => false,
				'below' => true,
			)),
			'field_showhider' => 'embedsgrid_description_settings',
		),
		'embedsgrid_description_color' => array(
			'field_id'			=> 'embedsgrid_description_color',
			'field_title' 	=> __( 'Description Color', 'mp_stacks_embedsgrid'),
			'field_description' 	=> __( 'Select the color the descriptions will be (leave blank for theme default)', 'mp_stacks_embedsgrid' ),
			'field_type' 	=> 'colorpicker',
			'field_value' => '',
			'field_showhider' => 'embedsgrid_description_settings',
		),
		'embedsgrid_description_size' => array(
			'field_id'			=> 'embedsgrid_description_size',
			'field_title' 	=> __( 'Description Size', 'mp_stacks_embedsgrid'),
			'field_description' 	=> __( 'Enter the text size the descriptions will be. Default: 15', 'mp_stacks_embedsgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '15',
			'field_showhider' => 'embedsgrid_description_settings',
		),
		'embedsgrid_description_lineheight' => array(
			'field_id'			=> 'embedsgrid_description_lineheight',
			'field_title' 	=> __( 'Description Line Height', 'mp_stacks_embedsgrid'),
			'field_description' 	=> __( 'Enter the line height for the description text. Default: 19', 'mp_stacks_embedsgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '19',
			'field_showhider' => 'embedsgrid_description_settings',
		),
		
		'embedsgrid_description_google_font' => array(
			'field_id'			=> 'embedsgrid_description_google_font',
			'field_title' 	=> __( 'Google Font Name', 'mp_stacks'),
			'field_description' 	=> 'Enter the name of the Google Font to use for this Text <br /><a class="button" href="https://www.google.com/fonts" target="_blank">Browse Google Fonts<div  style="margin-top: 3.3px; margin-left: 5px;" class="dashicons dashicons-share-alt2"></div></a>',
			'field_type' 	=> 'textbox',
			'field_value' => '',
			'field_placeholder' => __( 'Google Font Name', 'mp_stacks_googlefonts' ),
			'field_showhider' => 'embedsgrid_description_settings',
		),
		'embedsgrid_description_google_font_weight_style' => array(
			'field_id'			=> 'embedsgrid_description_google_font_weight_style',
			'field_title' 	=> __( 'Font Weight/Style', 'mp_stacks'),
			'field_description' 	=> 'Set the weight of this font (If available for your chosen font)',
			'field_type' 	=> 'select',
			'field_select_values' => array( 
				'100' => 'Thin', 
				'200' => 'Extra-Light', 
				'300' => 'Light', 
				'400' => 'Normal', 
				'500' => 'Medium', 
				'600' => 'Semi-Bold', 
				'700' => 'Bold',
				'900' => 'Ultra-Bold', 
			),
			'field_value' => '',
			'field_showhider' => 'embedsgrid_description_settings',
		),
		
		'embedsgrid_description_spacing' => array(
			'field_id'			=> 'embedsgrid_description_spacing',
			'field_title' 	=> __( 'Descriptions\' Spacing', 'mp_stacks_embedsgrid'),
			'field_description' 	=> __( 'How much space should there be between the description anything directly above it? Default: 10', 'mp_stacks_embedsgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '10',
			'field_showhider' => 'embedsgrid_description_settings',
		),
		'embedsgrid_description_word_limit' => array(
			'field_id'			=> 'embedsgrid_description_word_limit',
			'field_title' 	=> __( 'Word Limit for Description', 'mp_stacks_embedsgrid'),
			'field_description' 	=> __( 'How many words should be displayed before the "Read More" embed is shown. Default: All words are shown.', 'mp_stacks_embedsgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '',
			'field_showhider' => 'embedsgrid_description_settings',
		),
		//Description animation stuff
		'embedsgrid_description_animation_desc' => array(
			'field_id'			=> 'embedsgrid_description_animation_description',
			'field_title' 	=> __( 'Animate the Description upon Mouse-Over', 'mp_stacks_embedsgrid'),
			'field_description' 	=> __( 'Add keyframe animations to apply to the description and play upon mouse-over.', 'mp_stacks_embedsgrid' ),
			'field_type' 	=> 'basictext',
			'field_value' => '',
			'field_showhider' => 'embedsgrid_description_settings',
		),
		'embedsgrid_description_animation_repeater_description' => array(
			'field_id'			=> 'embedsgrid_description_animation_repeater_description',
			'field_title' 	=> __( 'KeyFrame', 'mp_stacks_embedsgrid'),
			'field_description' 	=> NULL,
			'field_type' 	=> 'textbox',
			'field_repeater' => 'embedsgrid_description_animation_keyframes',
			'field_showhider' => 'embedsgrid_description_settings',
		),
		'embedsgrid_description_animation_length' => array(
			'field_id'			=> 'animation_length',
			'field_title' 	=> __( 'Animation Length', 'mp_stacks_embedsgrid'),
			'field_description' 	=> __( 'Set the length between this keyframe and the previous one in milliseconds. Default: 500', 'mp_stacks_embedsgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '500',
			'field_repeater' => 'embedsgrid_description_animation_keyframes',
			'field_showhider' => 'embedsgrid_description_settings',
			'field_container_class' => 'mp_animation_length',
		),
		'embedsgrid_description_animation_opacity' => array(
			'field_id'			=> 'opacity',
			'field_title' 	=> __( 'Opacity', 'mp_stacks_embedsgrid'),
			'field_description' 	=> __( 'Set the opacity percentage at this keyframe. Default: 100', 'mp_stacks_embedsgrid' ),
			'field_type' 	=> 'input_range',
			'field_value' => '100',
			'field_repeater' => 'embedsgrid_description_animation_keyframes',
			'field_showhider' => 'embedsgrid_description_settings',
		),
		'embedsgrid_description_animation_rotation' => array(
			'field_id'			=> 'rotateZ',
			'field_title' 	=> __( 'Rotation', 'mp_stacks_embedsgrid'),
			'field_description' 	=> __( 'Set the rotation degree angle at this keyframe. Default: 0', 'mp_stacks_embedsgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '0',
			'field_repeater' => 'embedsgrid_description_animation_keyframes',
			'field_showhider' => 'embedsgrid_description_settings',
		),
		'embedsgrid_description_animation_x' => array(
			'field_id'			=> 'translateX',
			'field_title' 	=> __( 'X Position', 'mp_stacks_embedsgrid'),
			'field_description' 	=> __( 'Set the X position, in relation to its starting position, at this keyframe. The unit is pixels. Default: 0', 'mp_stacks_embedsgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '0',
			'field_repeater' => 'embedsgrid_description_animation_keyframes',
			'field_showhider' => 'embedsgrid_description_settings',
		),
		'embedsgrid_description_animation_y' => array(
			'field_id'			=> 'translateY',
			'field_title' 	=> __( 'Y Position', 'mp_stacks_embedsgrid'),
			'field_description' 	=> __( 'Set the Y position, in relation to its starting position, at this keyframe. The unit is pixels. Default: 0', 'mp_stacks_embedsgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '0',
			'field_repeater' => 'embedsgrid_description_animation_keyframes',
			'field_showhider' => 'embedsgrid_description_settings',
		),
		//Description Background
		'embedsgrid_description_bg_showhider' => array(
			'field_id'			=> 'embedsgrid_description_background_settings',
			'field_title' 	=> __( 'Description Background Settings', 'mp_stacks_embedsgrid'),
			'field_description' 	=> __( '', 'mp_stacks_embedsgrid' ),
			'field_type' 	=> 'showhider',
			'field_value' => '',
			'field_showhider' => 'embedsgrid_design_showhider',
		),
		'embedsgrid_description_bg_show' => array(
			'field_id'			=> 'embedsgrid_description_background_show',
			'field_title' 	=> __( 'Show Description Backgrounds?', 'mp_stacks_embedsgrid'),
			'field_description' 	=> __( 'Do you want to show a background color behind the description?', 'mp_stacks_embedsgrid' ),
			'field_type' 	=> 'checkbox',
			'field_value' => '',
			'field_showhider' => 'embedsgrid_description_background_settings',
		),
		'embedsgrid_description_bg_size' => array(
			'field_id'			=> 'embedsgrid_description_background_padding',
			'field_title' 	=> __( 'Description Background Size', 'mp_stacks_embedsgrid'),
			'field_description' 	=> __( 'How many pixels bigger should the Description Background be than the Text? Default: 5', 'mp_stacks_embedsgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '5',
			'field_showhider' => 'embedsgrid_description_background_settings',
		),
		'embedsgrid_description_bg_color' => array(
			'field_id'			=> 'embedsgrid_description_background_color',
			'field_title' 	=> __( 'Description Background Color', 'mp_stacks_embedsgrid'),
			'field_description' 	=> __( 'What color should the description background be? Default: #FFF (White)', 'mp_stacks_embedsgrid' ),
			'field_type' 	=> 'colorpicker',
			'field_value' => '#FFF',
			'field_showhider' => 'embedsgrid_description_background_settings',
		),
		'embedsgrid_description_bg_opacity' => array(
			'field_id'			=> 'embedsgrid_description_background_opacity',
			'field_title' 	=> __( 'Description Background Opacity', 'mp_stacks_embedsgrid'),
			'field_description' 	=> __( 'Set the opacity percentage? Default: 100', 'mp_stacks_embedsgrid' ),
			'field_type' 	=> 'input_range',
			'field_value' => '100',
			'field_showhider' => 'embedsgrid_description_background_settings',
		),

	);
	
	return mp_core_insert_meta_fields( $items_array, $new_fields, 'embedsgrid_meta_hook_anchor_2' );

}
add_filter( 'mp_stacks_embedsgrid_items_array', 'mp_stacks_embedsgrid_description_meta_options', 90 );

/**
 * Add the placement options for the Description using placement options filter hook
 *
 * @access   public
 * @since    1.0.0
 * @param    Void
 * @param    $post_id Int - The ID of the Brick
 * @return   Array - All of the placement optons needed for Description
 */
function mp_stacks_embedsgrid_description_placement_options( $placement_options, $post_id ){
	
	//Show Post Descriptions
	$placement_options['description_show'] = mp_core_get_post_meta($post_id, 'embedsgrid_description_show');

	//Descriptions Placement
	$placement_options['description_placement'] = mp_core_get_post_meta($post_id, 'embedsgrid_description_placement', 'above_image_left');
	
	//get word limit for exceprts
	$placement_options['word_limit'] = mp_core_get_post_meta($post_id, 'embedsgrid_description_word_limit', 20);
	
	return $placement_options;	
}
add_filter( 'mp_stacks_embedsgrid_placement_options', 'mp_stacks_embedsgrid_description_placement_options', 10, 2 );

/**
 * Get the HTML for the description in the grid
 *
 * @access   public
 * @since    1.0.0
 * @post_id  $post_id Int - The ID of the post to get the description of
 * @return   $html_output String - A string holding the html for a description in the grid
 */
function mp_stacks_embedsgrid_description( $embed ){
	
	$description_html_output = mp_stacks_grid_highlight_text_html( array( 
		'class_name' => 'mp-stacks-embedsgrid-item-description',
		'output_string' => isset( $embed['embedsgrid_embed_code_description'] ) ? $embed['embedsgrid_embed_code_description'] : NULL, 
	) );
	
	return $description_html_output;
	
}

/**
 * Hook the Title to the "Below" position in the grid
 *
 * @access   public
 * @since    1.0.0
 * @param    $embed Int - The ID of the post
 * @return   $html_output String - A string holding the html for text over a featured image in the grid
 */
function mp_stacks_embedsgrid_description_below_over_callback( $embedsgrid_output, $embedsgrid_embeds_repeat, $options ){
	
	//If we should show the description below the image
	if ( strpos( $options['description_placement'], 'below') !== false && $options['description_show']){
		
		$description_html_output = '<div class="mp-stacks-embedsgrid-description">' . mp_stacks_embedsgrid_description( $embedsgrid_embeds_repeat ) . '</div>';
		
		return $embedsgrid_output . $description_html_output;
	}
	
	return $embedsgrid_output;
	
}
add_filter( 'mp_stacks_embedsgrid_below', 'mp_stacks_embedsgrid_description_below_over_callback', 10, 3 );

/**
 * Hook the Title to the "Above" position in the grid
 *
 * @access   public
 * @since    1.0.0
 * @param    $embed Int - The ID of the post
 * @return   $html_output String - A string holding the html for text over a featured image in the grid
 */
function mp_stacks_embedsgrid_description_above_over_callback( $embedsgrid_output, $embedsgrid_embeds_repeat, $options ){
	
	//If we should show the description below the image
	if ( strpos( $options['description_placement'], 'above') !== false && $options['description_show']){
		
		$description_html_output = '<div class="mp-stacks-embedsgrid-description">' . mp_stacks_embedsgrid_description( $embedsgrid_embeds_repeat ) . '</div>';
		
		return $embedsgrid_output . $description_html_output;
	}
	
	return $embedsgrid_output;
	
}
add_filter( 'mp_stacks_embedsgrid_above', 'mp_stacks_embedsgrid_description_above_over_callback', 10, 3 );

/**
 * Add the JS for the description to PostGrid's HTML output
 *
 * @access   public
 * @since    1.0.0
 * @param    $existing_filter_output String - Any output already returned to this filter previously
 * @param    $post_id String - the ID of the Brick where all the meta is saved.
 * @param    $meta_prefix String - the prefix to put before each meta_field key to differentiate it from other plugins. :EG "embedsgrid"
 * @return   $new_grid_output - the existing grid output with additional thigns added by this function.
 */
function mp_stacks_embedsgrid_description_animation_js( $existing_filter_output, $post_id, $meta_prefix ){
	
	if ( $meta_prefix != 'embedsgrid' ){
		return $existing_filter_output;	
	}
					
	//Get JS output to animate the descriptions on mouse over and out
	$description_animation_js = mp_core_js_mouse_over_animate_child( '#mp-brick-' . $post_id . ' .mp-stacks-grid-item', '.mp-stacks-embedsgrid-item-description-holder', mp_core_get_post_meta( $post_id, 'embedsgrid_description_animation_keyframes', array() ), true, true, 'mp-brick-' . $post_id ); 

	return $existing_filter_output .= $description_animation_js;
}
add_filter( 'mp_stacks_grid_js', 'mp_stacks_embedsgrid_description_animation_js', 10, 3 );
		
/**
 * Add the CSS for the description to EmbedsGrid's CSS
 *
 * @access   public
 * @since    1.0.0
 * @param    $css_output String - The CSS that exists already up until this filter has run
 * @return   $css_output String - The incoming CSS with our new CSS for the description appended.
 */
function mp_stacks_embedsgrid_description_css( $css_output, $post_id ){
	
	$description_css_defaults = array(
		'color' => NULL,
		'size' => 15,
		'lineheight' => 19,
		'padding_top' => 10, //aka 'spacing'
		'background_padding' => 5,
		'background_color' => '#fff',
		'background_opacity' => 100,
		'placement_string' => 'above_image_left',
	);

	return $css_output .= mp_stacks_grid_text_css( $post_id, 'embedsgrid_description', 'mp-stacks-embedsgrid-item-description', $description_css_defaults );
}
add_filter('mp_stacks_embedsgrid_css', 'mp_stacks_embedsgrid_description_css', 10, 2);

/**
 * Add the Google Fonts for the Grid Excertpts
 *
 * @param    $css_output          String - The incoming CSS output coming from other things using this filter
 * @param    $post_id             Int - The post ID of the brick
 * @param    $first_content_type  String - The first content type chosen for this brick
 * @param    $second_content_type String - The second content type chosen for this brick
 * @return   $css_output          String - A string holding the css the brick
 */
function mp_stacks_embedsgrid_description_google_font( $css_output, $post_id, $first_content_type, $second_content_type ){
	
	if ( $first_content_type != 'embedsgrid' && $second_content_type != 'embedsgrid' ){
		return $css_output;	
	}
	
	global $mp_stacks_footer_inline_css, $mp_core_font_families;
	
	//Default settings for the MP Core Google Font Class
	$mp_core_google_font_args = array( 'echo_google_font_css' => false, 'wrap_in_style_tags' => false );
	
	$embedsgrid_description_googlefont = mp_core_get_post_meta( $post_id, 'embedsgrid_description_google_font' );
	$embedsgrid_description_googlefontweight = mp_core_get_post_meta( $post_id, 'embedsgrid_description_google_font_weight_style' );
	
	//If a font name has been entered
	if ( !empty( $embedsgrid_description_googlefont ) ){
		
		//Check if a font extra (weight) has been selected and add it if so.
		$embedsgrid_description_googlefontweight = isset($embedsgrid_description_googlefontweight) && !empty( $embedsgrid_description_googlefontweight ) ? ':' . $embedsgrid_description_googlefontweight : NULL;
		$embedsgrid_description_googlefont = $embedsgrid_description_googlefont . $embedsgrid_description_googlefontweight;
	
		//Load the Google Font using the Google Font Class in MP Core
		new MP_CORE_Font( $embedsgrid_description_googlefont, $embedsgrid_description_googlefont, $mp_core_google_font_args );
		$mp_stacks_footer_inline_css[$embedsgrid_description_googlefont] = $mp_core_font_families[$embedsgrid_description_googlefont];
		
		//Return the incoming css string plus css to apply this font family to all paragraph tags
		$css_output .=  '#mp-brick-' . $post_id . ' .mp-stacks-embedsgrid-item-description, #mp-brick-' . $post_id . ' .mp-stacks-embedsgrid-item-description * { font-family: \'' . $embedsgrid_description_googlefont . '\';}';
	
	}
	
	return $css_output;	
}
add_filter('mp_brick_additional_css', 'mp_stacks_embedsgrid_description_google_font', 10, 4);	