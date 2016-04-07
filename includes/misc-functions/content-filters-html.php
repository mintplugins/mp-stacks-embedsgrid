<?php 
/**
 * This file contains the function which hooks to a brick's content output
 *
 * @since 1.0.0
 *
 * @package    MP Stacks EmbedsGrid
 * @subpackage Functions
 *
 * @copyright  Copyright (c) 2015, Mint Plugins
 * @license    http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @author     Philip Johnston
 */
 
/**
 * This function hooks to the brick output. If it is supposed to be a 'embedsgrid', then it will output the embedsgrid
 *
 * @access   public
 * @since    1.0.0
 * @return   void
 */
function mp_stacks_brick_content_output_embedsgrid( $default_content_output, $mp_stacks_content_type, $post_id ){
	
	//If this stack content type is NOT set to be a embedsgrid	
	if ($mp_stacks_content_type != 'embedsgrid'){
		
		return $default_content_output;
		
	}
	
	//Because we run the same function for this and for "Load More" ajax, we call a re-usable function which returns the output
	$embedsgrid_output = mp_stacks_embedsgrid_output( $post_id );
	
	//Return
	return $embedsgrid_output['embedsgrid_output'] . $embedsgrid_output['load_more_button'] . $embedsgrid_output['embedsgrid_after'];

}
add_filter('mp_stacks_brick_content_output', 'mp_stacks_brick_content_output_embedsgrid', 10, 3);

/**
 * Output more posts using ajax
 *
 * @access   public
 * @since    1.0.0
 * @return   void
 */
function mp_embedsgrid_ajax_load_more(){
	
	if ( !isset( $_POST['mp_stacks_grid_post_id'] ) || !isset( $_POST['mp_stacks_grid_offset'] ) ){
		return;	
	}
	
	$post_id = $_POST['mp_stacks_grid_post_id'];
	$post_offset = $_POST['mp_stacks_grid_offset'];

	//Because we run the same function for this and for "Load More" ajax, we call a re-usable function which returns the output
	$embedsgrid_output = mp_stacks_embedsgrid_output( $post_id, true, $post_offset );
	
	echo json_encode( array(
		'items' => $embedsgrid_output['embedsgrid_output'],
		'button' => $embedsgrid_output['load_more_button'],
		'animation_trigger' => $embedsgrid_output['animation_trigger']
	) );
	
	die();
			
}
add_action( 'wp_ajax_mp_stacks_embedsgrid_load_more', 'mp_embedsgrid_ajax_load_more' );
add_action( 'wp_ajax_nopriv_mp_stacks_embedsgrid_load_more', 'mp_embedsgrid_ajax_load_more' );

/**
 * Run the Grid Loop and Return the HTML Output, Load More Button, and Animation Trigger for the Grid
 *
 * @access   public
 * @since    1.0.0
 * @param    Void
 * @param    $post_id Int - The ID of the Brick
 * @param    $loading_more string - If we are loading more through ajax, this will be true, Defaults to false.
 * @param    $post_offset Int - The number of posts deep we are into the loop (if doing ajax). If not doing ajax, set this to 0;
 * @return   Array - HTML output from the Grid Loop, The Load More Button, and the Animation Trigger in an array for usage in either ajax or not.
 */
function mp_stacks_embedsgrid_output( $post_id, $loading_more = false, $post_offset = 0 ){
	
	global $wp_query;
	
	//Enqueue all js scripts used by grids.
	mp_stacks_grids_enqueue_frontend_scripts( 'embedsgrid' );
	
	//Get this Brick Info
	$post = get_post($post_id);
	
	$embedsgrid_output = NULL;
	
	//Get the repeater which we will loop through
	$embedsgrid_embeds_repeater = mp_core_get_post_meta($post_id, 'embedsgrid_embeds_repeater' );
	
	//Item per row
	$embedsgrid_per_row = mp_core_get_post_meta($post_id, 'embedsgrid_per_row', '3');
	
	//Item per page
	$embedsgrid_per_page = mp_core_get_post_meta($post_id, 'embedsgrid_per_page', '9');
		
	//Get the options for the grid placement - we pass this to the action filters for text placement
	$grid_placement_options = apply_filters( 'mp_stacks_embedsgrid_placement_options', NULL, $post_id );
	
	//Get the JS for animating items - only needed the first time we run this - not on subsequent Ajax requests.
	if ( !$loading_more ){
		
		//Here we set javascript for this grid
		$embedsgrid_output .= apply_filters( 'mp_stacks_grid_js', NULL, $post_id, 'embedsgrid' );
						
	}
	
	//Grid Container Output
	$embedsgrid_output .= !$loading_more ? '<div class="mp-stacks-grid mp-stacks-embedsgrid ' . apply_filters( 'mp_stacks_grid_classes', NULL, $post_id, 'embedsgrid' ) . '" ' . apply_filters( 'mp_stacks_grid_attributes', NULL, $post_id, 'embedsgrid' ) . '>' : NULL;
	
	$total_posts = count( $embedsgrid_embeds_repeater );
	
	$css_output = NULL;
	
	//Loop through the stack group		
	if ( is_array( $embedsgrid_embeds_repeater ) ) { 
		
		$loop_counter = 1;
		
		//Loop through each link repeater (-1 because it starts at 0)
		for ( $x = $post_offset; $x <= $total_posts-1; $x++ ) {
						
			$class_string = NULL;
			$class_string = apply_filters( 'mp_stacks_grid_item_classes', $class_string, $post_id, 'embedsgrid' ); 
			$embedsgrid_output .= '<div class="mp-stacks-grid-item ' . $class_string . '"><div class="mp-stacks-grid-item-inner">';
				
				//Filter Hook to output HTML into the "Above" position 
				$above_output = apply_filters( 'mp_stacks_embedsgrid_above', NULL, $embedsgrid_embeds_repeater[$x], $grid_placement_options );
				
				if ( !empty( $above_output ) ){	
				
					//Below Embed Area Container:
					$embedsgrid_output .= '<div class="mp-stacks-grid-item-above-image-holder">';
					
						//Filter Hook to output HTML into the "Below" position 
						$embedsgrid_output .= $above_output;
				
					$embedsgrid_output .= '</div>';
				}
				
				//This is the actual embed code
				$embedsgrid_output .= '<div class="mp-stacks-grid-item-embed-code">';
				
					$embedsgrid_output .= str_replace( '&#039;', "'", html_entity_decode( $embedsgrid_embeds_repeater[$x]['embedsgrid_embed_code'] ) );
				
				$embedsgrid_output .= '</div>';
				
				//Filter Hook to output HTML into the "Below" position 
				$below_output = apply_filters( 'mp_stacks_embedsgrid_below', NULL, $embedsgrid_embeds_repeater[$x], $grid_placement_options );
				
				if ( !empty( $below_output ) ){	
									
					//Below Embed Area Container:
					$embedsgrid_output .= '<div class="mp-stacks-grid-item-below-image-holder">';
					
						//Filter Hook to output HTML into the "Below" position 
						$embedsgrid_output .= $below_output;
				
					$embedsgrid_output .= '</div>';
				}
			
			$embedsgrid_output .= '</div></div>';
			
			//Increment Offset
			$post_offset = $post_offset + 1;
			
			//If we've reached our postsperpage limit (if we are at a multiple of 3)
			if ( $loop_counter == $embedsgrid_per_page ){
				break;
			}
			
			//Increment Loop COunter
			$loop_counter = $loop_counter + 1;
			
		}
	}
	
	//If we're not doing ajax, add the stuff to close the embedsgrid container and items needed after
	if ( !$loading_more ){
		$embedsgrid_output .= '</div>';
	}
	
	
	//jQuery Trigger to reset all embedsgrid animations to their first frames
	$animation_trigger = '<script type="text/javascript">jQuery(document).ready(function($){ $(document).trigger("mp_core_animation_set_first_keyframe_trigger"); });</script>';
	
	//Assemble args for the load more output
	$load_more_args = array(
		 'meta_prefix' => 'embedsgrid',
		 'total_posts' => $total_posts, 
		 'posts_per_page' => $embedsgrid_per_page, 
		 'paged' => false, 
		 'post_offset' => $post_offset,
		 'brick_slug' => $post->post_name
	);
	
	return array(
		'embedsgrid_output' => $embedsgrid_output,
		'load_more_button' => apply_filters( 'mp_stacks_embedsgrid_load_more_html_output', $load_more_html = NULL, $post_id, $load_more_args ),
		'animation_trigger' => $animation_trigger,
		'embedsgrid_after' => '<div class="mp-stacks-grid-item-clearedfix"></div><div class="mp-stacks-grid-after"></div>'
	);
		
}