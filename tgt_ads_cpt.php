<?php 
/*
	Plugin Name: TargetIMC Ads CPT & Taxonomies
	Plugin URI: https://targetimc.com/
	Description: This plugin registers 'ads' post type and its taxonomies. You can use <strong>[ads-shortcode]</strong> in your text widgets or pages to display ads. *** If ACF is active this plugin will deactivate it and install ACF Pro. ***
	Author: TargetIMC
	Author URI: https://targetimc.com/
	Text Domain: tgt-ads-cpt
	Domain Path: /languages

	Version: 1.0.0

	License: GPL-2.0+
	License URI: http://www.opensource.org/licenses/gpl-license.php
*/


// Translation
function tgt_translation()  {

	// Add theme support for Translation
load_plugin_textdomain( 'tgt-ads-cpt', FALSE, basename( dirname( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'tgt_translation' );


/**
 * Include CSS file
 */
function tgt_ads_enque_css() {
    wp_register_style( 'tgt-ads-style',  plugin_dir_url( __FILE__ ) . 'css/ads-style.css' );
    wp_enqueue_style( 'tgt-ads-style' );
		// Load Isotope & imagesLoaded and initialize Isotope
		wp_enqueue_script( 'isotope', plugin_dir_url( __FILE__ ) .  'js/isotope.pkgd.min.js', array( 'jquery' ), '2.2.2', true );
		wp_enqueue_script( 'imagesLoaded', plugin_dir_url( __FILE__ ) . 'js/imagesloaded.pkgd.min.js', '', '3.2.0', true );
		wp_enqueue_script( 'isotope_init', plugin_dir_url( __FILE__ ) . 'js/isotope_init.js', array( 'isotope', 'imagesLoaded' ), '1.0.0', true );
		wp_enqueue_script( 'isotope_init', plugin_dir_url( __FILE__ ) . 'js/isotope_cafe_init.js', array( 'isotope', 'imagesLoaded' ), '1.0.0', true );	
}
add_action( 'wp_enqueue_scripts', 'tgt_ads_enque_css' );

/* Add Image Size */
add_image_size( 'ads-image-single', 600, 1200, FALSE );


// Register Custom Post Type
function tgt_ads_custom_post_type() {

	$labels = array(
		'name'                  => _x( 'Ads', 'Post Type General Name', 'tgt-ads-cpt' ),
		'singular_name'         => _x( 'Ad', 'Post Type Singular Name', 'tgt-ads-cpt' ),
		'menu_name'             => __( 'Ads', 'tgt-ads-cpt' ),
		'name_admin_bar'        => __( 'Ads', 'tgt-ads-cpt' ),
		'archives'              => __( 'Item Archives', 'tgt-ads-cpt' ),
		'attributes'            => __( 'Item Attributes', 'tgt-ads-cpt' ),
		'parent_item_colon'     => __( 'Parent Item:', 'tgt-ads-cpt' ),
		'all_items'             => __( 'All Items', 'tgt-ads-cpt' ),
		'add_new_item'          => __( 'Add New Item', 'tgt-ads-cpt' ),
		'add_new'               => __( 'Add New', 'tgt-ads-cpt' ),
		'new_item'              => __( 'New Item', 'tgt-ads-cpt' ),
		'edit_item'             => __( 'Edit Item', 'tgt-ads-cpt' ),
		'update_item'           => __( 'Update Item', 'tgt-ads-cpt' ),
		'view_item'             => __( 'View Item', 'tgt-ads-cpt' ),
		'view_items'            => __( 'View Items', 'tgt-ads-cpt' ),
		'search_items'          => __( 'Search Item', 'tgt-ads-cpt' ),
		'not_found'             => __( 'Not found', 'tgt-ads-cpt' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'tgt-ads-cpt' ),
		'featured_image'        => __( 'Featured Image', 'tgt-ads-cpt' ),
		'set_featured_image'    => __( 'Set featured image', 'tgt-ads-cpt' ),
		'remove_featured_image' => __( 'Remove featured image', 'tgt-ads-cpt' ),
		'use_featured_image'    => __( 'Use as featured image', 'tgt-ads-cpt' ),
		'insert_into_item'      => __( 'Insert into item', 'tgt-ads-cpt' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'tgt-ads-cpt' ),
		'items_list'            => __( 'Items list', 'tgt-ads-cpt' ),
		'items_list_navigation' => __( 'Items list navigation', 'tgt-ads-cpt' ),
		'filter_items_list'     => __( 'Filter items list', 'tgt-ads-cpt' ),
	);
	$args = array(
		'label'                 => __( 'Ad', 'tgt-ads-cpt' ),
		'description'           => __( 'Advertising custom post type', 'tgt-ads-cpt' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'custom-fields', ),
		'taxonomies'            => array( 'ad_type', 'sector' ),
		'rewrite' 							=> array( 'slug' => __( 'ads', 'tgt-ads-cpt' ) ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-media-spreadsheet',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
	);
	register_post_type( 'ads', $args );

}
add_action( 'init', 'tgt_ads_custom_post_type', 0 );

// Register Custom Taxonomy
function tgt_ad_type() {

	$labels = array(
		'name'                       => _x( 'Types of Ads', 'Taxonomy General Name', 'tgt-ads-cpt' ),
		'singular_name'              => _x( 'Type of Ad', 'Taxonomy Singular Name', 'tgt-ads-cpt' ),
		'menu_name'                  => __( 'Type of Ad', 'tgt-ads-cpt' ),
		'all_items'                  => __( 'All Items', 'tgt-ads-cpt' ),
		'parent_item'                => __( 'Parent Item', 'tgt-ads-cpt' ),
		'parent_item_colon'          => __( 'Parent Item:', 'tgt-ads-cpt' ),
		'new_item_name'              => __( 'New Item Name', 'tgt-ads-cpt' ),
		'add_new_item'               => __( 'Add New Item', 'tgt-ads-cpt' ),
		'edit_item'                  => __( 'Edit Item', 'tgt-ads-cpt' ),
		'update_item'                => __( 'Update Item', 'tgt-ads-cpt' ),
		'view_item'                  => __( 'View Item', 'tgt-ads-cpt' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'tgt-ads-cpt' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'tgt-ads-cpt' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'tgt-ads-cpt' ),
		'popular_items'              => __( 'Popular Items', 'tgt-ads-cpt' ),
		'search_items'               => __( 'Search Items', 'tgt-ads-cpt' ),
		'not_found'                  => __( 'Not Found', 'tgt-ads-cpt' ),
		'no_terms'                   => __( 'No items', 'tgt-ads-cpt' ),
		'items_list'                 => __( 'Items list', 'tgt-ads-cpt' ),
		'items_list_navigation'      => __( 'Items list navigation', 'tgt-ads-cpt' ),
	);
	$args = array(
		'labels'                     => $labels,
		'rewrite' 									 => array( 'slug' => __( 'ad_type', 'tgt-ads-cpt' ) ),
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => false,
	);
	register_taxonomy( 'ad_type', array( 'ads' ), $args );

}
add_action( 'init', 'tgt_ad_type', 0 );

// Register Custom Taxonomy
function tgt_sector() {

	$labels = array(
		'name'                       => _x( 'Sectors', 'Taxonomy General Name', 'tgt-ads-cpt' ),
		'singular_name'              => _x( 'Sector', 'Taxonomy Singular Name', 'tgt-ads-cpt' ),
		'menu_name'                  => __( 'Sectors', 'tgt-ads-cpt' ),
		'all_items'                  => __( 'All Items', 'tgt-ads-cpt' ),
		'parent_item'                => __( 'Parent Item', 'tgt-ads-cpt' ),
		'parent_item_colon'          => __( 'Parent Item:', 'tgt-ads-cpt' ),
		'new_item_name'              => __( 'New Item Name', 'tgt-ads-cpt' ),
		'add_new_item'               => __( 'Add New Item', 'tgt-ads-cpt' ),
		'edit_item'                  => __( 'Edit Item', 'tgt-ads-cpt' ),
		'update_item'                => __( 'Update Item', 'tgt-ads-cpt' ),
		'view_item'                  => __( 'View Item', 'tgt-ads-cpt' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'tgt-ads-cpt' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'tgt-ads-cpt' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'tgt-ads-cpt' ),
		'popular_items'              => __( 'Popular Items', 'tgt-ads-cpt' ),
		'search_items'               => __( 'Search Items', 'tgt-ads-cpt' ),
		'not_found'                  => __( 'Not Found', 'tgt-ads-cpt' ),
		'no_terms'                   => __( 'No items', 'tgt-ads-cpt' ),
		'items_list'                 => __( 'Items list', 'tgt-ads-cpt' ),
		'items_list_navigation'      => __( 'Items list navigation', 'tgt-ads-cpt' ),
	);
	$args = array(
		'labels'                     => $labels,
		'rewrite' 									 => array( 'slug' => __( 'sector', 'tgt-ads-cpt' ) ),
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => false,
	);
	register_taxonomy( 'sector', array( 'ads' ), $args );
}
add_action( 'init', 'tgt_sector', 0 );


/* INCLUDES ACF PRO
------------------------------------------------------*/
/* Checks to see if “is_plugin_active” function exists and if not load the php file that includes that function */
if ( ! function_exists( 'is_plugin_active' ) ) {
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

/* Checks to see if the acf plugin is activated and deactivate it */
if ( is_plugin_active( 'advanced-custom-fields/acf.php') )  {
	 deactivate_plugins( 'advanced-custom-fields/acf.php');
}

/* Checks to see if the acf pro plugin is activated */
if ( !is_plugin_active('advanced-custom-fields-pro/acf.php') ) {
	/* Include Advanced Custom Fields in Plugins */
	include_once('advanced-custom-fields-pro/acf.php');

	define( 'ACF_LITE', false ); //Hide ACF form Admin
}

// Include Custom Fields
include_once( 'tgt-ads-cpt-fields.php' );

/* Google Maps */
function my_acf_init() {
	
	acf_update_setting('google_api_key', 'AIzaSyA-ddUbPJx7v_fn9IBYD2TsI3lQozsfXw0');
}

add_action('acf/init', 'my_acf_init');
/* Templates 
------------------------------------------------------*/
/* Filter the single_template*/
add_filter( 'single_template', 'tgt_custom_post_type_template' );
function tgt_custom_post_type_template($single_template) {
     global $post;

     if ($post->post_type == 'ads' ) {
          $single_template = dirname( __FILE__ ) . '/templates/single-ads.php';
     }
     return $single_template;
     wp_reset_postdata();
}


/**
 * Template Redirect
 * Use archive-portfolio.php for portfolio category and tag taxonomy archives.
 */
add_filter( 'template_include', 'sk_template_redirect' );
function sk_template_redirect( $template ) {

	if ( is_post_type_archive( 'ads' ) || is_tax( 'sector' ) || is_tax( 'ad_type' ) )
		$template = dirname( __FILE__ ) . '/templates/archive-ads.php';
	return $template;

}

add_action( 'pre_get_posts', 'sk_change_portfolio_posts_per_page' );
/**
 * Set all the entries to appear on Portfolio archive page
 * 
 * @link http://www.billerickson.net/customize-the-wordpress-query/
 * @param object $query data
 *
 */
function sk_change_portfolio_posts_per_page( $query ) {
	
	if( $query->is_main_query() && !is_admin() && is_post_type_archive( 'ads' ) ) {
			$query->set( 'posts_per_page', '-1' );
	}
}

/* Shortcut of Ads Archive 
-----------------------------------------------------------*/
add_shortcode('ads-shortcode', 'tgt_filterable_ads');
// CPT Categories Filter Row
function tgt_filterable_ads() {
	echo '<div class="tgtads-container">';
		$terms = get_terms( 'sector' );
		$count = count( $terms ); $i=0;
		if ( $count > 0 ) { ?>
			<div class="tgt-ads-cats filter clearfix">
				<button class="active" data-filter="*"><?php _e('All', 'tgt-ads-cpt'); ?></button>
				<?php foreach ( $terms as $term ) : ?>
					<button data-filter=".<?php echo $term->slug; ?>"><?php echo $term->name; ?></button>
				<?php endforeach; ?>
			</div><!-- /tgt-ads-cats -->
		<?php }
		// CPT Items
		echo '<div class="filterable-ads tgt-ads-content"><!-- .gutter-sizer empty element, only used for horizontal gap --><div class="gutter-sizer"></div>';
			// WP_Query arguments
			$args = array (
				'post_type' => array( 'ads' ),
				'posts_per_page' => '8',
			);
			// The Query
			$query = new WP_Query( $args );
			// The Loop
			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
					$query->the_post();
					$terms = get_the_terms( get_the_ID(), 'sector' );
					if ( $terms && ! is_wp_error( $terms ) ) {
						$classes = array();
						foreach ( $terms as $term ) {
							$classes[] = $term->slug;
						}
						$portfolio_category_classes = join( " ", $classes );
					}
					?>

					<article class="entry <?php echo $portfolio_category_classes; ?>">
						<div class="entry-content" itemprop="text">
							<div class="tgt-ads-image"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php echo wp_get_attachment_image(get_field('ad_image'),'ads-image-single'); ?><h1 class="entry-title" itemprop="headline"><?php the_title(); ?></h1></a></div>
						</div>
					</article>
				<?php }
				
				
			} else {
				// no posts found
			}
	
			// Restore original Post Data
			wp_reset_postdata();

/* Back to CPT Acrchive Button
-----------------------------------*/
echo "</div>";
	echo '<a class="tgt-back-button button" href="' . get_bloginfo( 'url' ) . "/" . __('ads', 'tgt-ads-cpt') . '"/">&laquo; ' . __('View all Ads', 'tgt-ads-cpt') . '</a>';
echo '</div>';
}

