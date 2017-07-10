<?php
/**
 * This file adds the custom ads post type single post template.
	Author: TargetIMC
	Author URI: https://targetimc.com/
	Text Domain: tgt-ads-cpt
	

 */

//* Force Sidebar content layout
//add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
add_filter ( 'genesis_pre_get_option_site_layout', '__genesis_return_content_sidebar');

//* Remove the breadcrumb navigation
// remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

// Remove Page title
remove_action('genesis_entry_header', 'genesis_do_post_title');
// Remove edit link
add_filter ( 'genesis_edit_post_link' , '__return_false' );

//* Remove the post info function
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );

//* Remove the author box on single posts
remove_action( 'genesis_after_entry', 'genesis_do_author_box_single', 8 );

//* Remove the post meta function
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

// Remove Skip Links
remove_action ( 'genesis_before_header', 'genesis_skip_links', 5 );
// Dequeue Skip Links Script
add_action( 'wp_enqueue_scripts', 'tgt_dequeue_skip_links' );
// Show Custom Content in the content area
remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'tgt_display_ads_acf' );
// Add custom body class
add_filter( 'body_class', 'tgt_body_class' );


function tgt_display_ads_acf() {
	echo '<div class="tgt-ads-container">';
	echo '<div class="tgt-ads-img-sidebar-wrap">';


	if (get_field('ad_image')) {	
		$ad_image = get_field('ad_image');
		$image_size = 'ads-image-single';
		
		echo '<div id="tgt-ads-lightbox" class="tgt-ads-image-single first">';
		echo '<a href="' . wp_get_attachment_url( $ad_image) . '" data-featherlight="image">' . wp_get_attachment_image( $ad_image, $image_size ) . '</a>';
		echo '</div>';	
	}
	
	echo '<div class="tgt-ads-sidebar">';

		if (get_field('sale_expires_on')) { //expires on
			echo '<div class="tgt-ads-expires">';
				echo __('Expires<br/>on','tgt-ads-cpt');
				echo '<div class="tgt-ads-expiration-date">'. get_field('sale_expires_on') . '</div>';
			echo '</div>';
		}

		if( have_rows('social_networks') ) { //social networks
			while( have_rows('social_networks') ): the_row();  
					$facebook = get_sub_field('facebook'); 
					$twitter = get_sub_field('twitter'); 
					$email = get_sub_field('e-mail'); 
					echo '<div class="tgt-ads-social"><ul>';
					echo '<li><a href="' . $facebook . '"target="_blank"><img src=' . plugins_url( 'images/facebook.png', dirname(__FILE__) ) . '></img></a></li>';
					echo '<li><a href="' . $twitter . '"target="_blank"><img src=' . plugins_url( 'images/twitter.png', dirname(__FILE__) ) . '></img></a></li>';
					echo '<li><a href="' . $$email . '"target="_blank"><img src=' . plugins_url( 'images/gmail.png', dirname(__FILE__) ) . '></img></a></li>';

					echo '</ul>';
					echo '<div class="tgt-ads-social-title">' . __('Social Networks', 'tgt-ads-cpt') . '</div>';
					echo '<div class="tgt-ads-share">' . __('Share<br/>with<br/>friends', 'tgt-ads-cpt') . '</div>';

			echo '</div>'; //tgt-ads-social
			endwhile; 
		}

		echo '<div class="tgt-ads-price">';
			if (get_field('sale_price')) { //sale price
				echo '<div class="tgt-ads-sale-price">' . round(get_field('sale_price'),2) . " " . __('€', 'tgt-ads-cpt') . '</div>';
			}

			if (get_field('normal_price')) { //normal price
				echo '<div class="tgt-ads-normal-price">' . __('Before:', 'tgt-ads-cpt') . " " . round(get_field('normal_price'),2) . " " . __('€', 'tgt-ads-cpt') . '</div>';
			}
		echo '</div>'; //tgt-ads-price
	echo '</div>'; //tgt-ads-sidebar
	echo '</div>'; //tgt-ads-img-sidebar-wrap
	
	// Display Title
	$title = apply_filters( 'genesis_post_title_text', get_the_title() ); 
	echo '<div class="tgt-ads-title">';
		echo '<h1 class="entry-title">' . $title . '</h1>';
	echo '</div/>';
	// Display Center
	if(get_field('center')) { //short description
		echo '<div class="tgt-ads-center">';
			echo __('Center:', 'tgt-ads-cpt') . " " . '<a href="' . get_field('center_url') . '"target="_blank">' . get_field('center') . '</a>';
		echo '</div>';
	}
	
	// Display Taxonomies
	echo '<div class="tgt-ads-custom-taxonomy">';
		echo '<div class="tgt-ads-tax-sector">';
			echo get_the_term_list( $post->ID, 'sector',  __('Sector: ', 'tgt-ads-cpt'), ', ', '' );
		echo '</div>';
		echo '<div class="tgt-ads-tax-ad-type">';
			echo get_the_term_list( $post->ID, 'ad_type', __('Ad Type: ', 'tgt-ads-cpt'), ', ', '' );
		echo '</div>';
	echo '</div>';

	
	if(get_field('short_description')) { //short description
		echo '<div class="tgt-ads-short-description">' . get_field('short_description') . '</div>';
	}
	
	if(get_field('description')) { //description
		
		echo '<div class="tgt-ads-description">' . '<h3>' . __('Description:', 'tgt-ads-cpt') . '</h3>' . get_field('description') . '</div>';
	}
	
	/* Google Map Lightbox*/
	echo '<div class="tgt-ads-map">';
		echo '<a class="tgt-ads-button" href="#" data-featherlight="#tgt-ads-map-lightbox">' . __('Where are we', 'tgt-ads-cpt') . '</a>';
			echo '<div id="tgt-ads-map-lightbox">';
				if( get_field('localization') ){ ?>
						 <iframe width="600" height="450" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.ca/maps?center=<?php the_field('localization'); ?>&q=<?php the_field('localization'); ?>&z=14&size=600x450&output=embed&iwloc=near"></iframe>
				<?php }
		echo '</div>'; //#tgt-ads-map-lightbox
	echo '</div>'; //tgt-ads-map
			echo '<a class="tgt-back-button button" href="' . get_bloginfo( 'url' ) . "/" . __('ads', 'tgt-ads-cpt') . '"/">&laquo; ' . __('Back to Full Ads', 'tgt-ads-cpt') . '</a>';
	echo '</div>'; //tgt-ads-container
}	



//* Previous and Next Post navigation
add_action('genesis_after_entry', 'tgt_custom_post_nav');
function tgt_custom_post_nav() {

	echo '<div class="prev-next-post-links">';
		previous_post_link('<div class="previous-post-link">&laquo; %link</div>', '<strong>%title</strong>' );
		next_post_link('<div class="next-post-link">%link &raquo;</div>', '<strong>%title</strong>' );
	echo '</div>';

}

//*Suport Functions
function tgt_body_class( $classes ) {
	$classes[] = 'tgt-ads';
	return $classes;
}

function tgt_dequeue_skip_links() {
	wp_dequeue_script( 'skip-links' );
}

//* ACF Google Maps Tweak */
add_shortcode('my-google-map', 'simple_google_map');
function simple_google_map() { // Google Map Tweak
    ob_start(); 
    if( get_field('localization') ): ?>
         <iframe width="600" height="450" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.ca/maps?center=<?php the_field('localization'); ?>&q=<?php the_field('localization'); ?>&z=14&size=600x450&output=embed&iwloc=near"></iframe>
		<?php endif; 
		$output = ob_get_clean();
    return $output;
}
 

/* Enque Scripts */
add_action( 'wp_enqueue_scripts', 'sk_enqueue_featherlight' );
function sk_enqueue_featherlight() {
	wp_enqueue_style( 'featherlight-css', plugins_url( 'css/featherlight.min.css', dirname(__FILE__) ) );
	wp_enqueue_script( 'featherlight', plugins_url( 'js/featherlight.min.js', dirname(__FILE__) ) , array( 'jquery' ), '1.5.0', true );
}
genesis();