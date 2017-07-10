<?php
/**
 * This file is the custom ads post type archive template.
 *
 */
// Add ads body class
add_filter( 'body_class', 'tgt_add_ads_cpt_body_class' );
function tgt_add_ads_cpt_body_class( $classes ) {
	$classes[] = 'filterable-ads';
	return $classes;
}
// Force full width content layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
// Remove the breadcrumb navigation
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
// Reposition Title and Description on Ads taxonomy Archives
remove_action( 'genesis_before_loop', 'genesis_do_taxonomy_title_description', 15 );
add_action( 'genesis_before_content', 'genesis_do_taxonomy_title_description' );
// Ads Categories Filter Row
add_action( 'genesis_before_loop', 'tgt_isotope_filter' );
function tgt_isotope_filter() {
	// Display only on the CPT Archive
	if ( is_post_type_archive( 'ads' ) )
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
}
// Wrap Ads items in a custom div - opening
add_action( 'genesis_before_loop', 'tgt_ads_content_opening_div' );
function tgt_ads_content_opening_div() {
	echo '<div class="tgt-ads-content"><!-- .gutter-sizer empty element, only used for horizontal gap --><div class="gutter-sizer"></div>';
}
// Add category names in post class
add_filter( 'post_class', 'tgt_ads_category_class' );
function tgt_ads_category_class( $classes ) {
	$terms = get_the_terms( get_the_ID(), 'sector' );
	if( $terms ) foreach ( $terms as $term )
		$classes[] = $term->slug;
	return $classes;
}
// Remove entry header (having entry title and post info)
remove_action( 'genesis_entry_header', 'genesis_do_post_format_image', 4 );
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
// Remove post content
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
// Remove post image (coming from Theme settings)
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
// Add featured image
add_action( 'genesis_entry_content', 'tgt_ads_grid_image' );
function tgt_ads_grid_image() {
	
	if ( $image = genesis_get_image( 'format=url&size=ads-image-single' ) ) {
		?><div class="tgt-ads-image"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php echo wp_get_attachment_image(get_field('ad_image'),'ads-image-single'); ?><h1 class="entry-title" itemprop="headline"><?php the_title(); ?></h1></a></div><?php

	}
}
// Remove entry footer (having entry meta)
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
// Show Ads Type hyperlinked terms in Post Meta. This is useful if entry footer is being shown.
add_filter( 'genesis_post_meta', 'tgt_post_meta_filter' );
function tgt_post_meta_filter( $post_meta ) {
	$post_meta = '[post_terms taxonomy="sector" before=""]';
	return $post_meta;
}
// Wrap Ads items in a custom div - closing
add_action('genesis_after_loop', 'tgt_ads_content_closing_div' );
function tgt_ads_content_closing_div() {
	echo "</div>";
}
// Reposition Post Navigation (Previous / Next or Numeric). This is for Ads taxonomy archives
remove_action( 'genesis_after_endwhile', 'genesis_posts_nav' );
add_action( 'genesis_after_content', 'genesis_posts_nav' );
// Display 'back to ads' link and Title on Ads taxonomy archives
add_action( 'genesis_after_content', 'tgt_taxonomy_page_additions' );
function tgt_taxonomy_page_additions() {
	if ( is_tax( 'sector' ) || is_tax( 'ad_type' ) ) {
		echo '<a class="tgt-back-button button" href="' . get_bloginfo( 'url' ) . "/" . __('ads', 'tgt-ads-cpt') . '"/">&laquo; ' . __('Back to Full Ads', 'tgt-ads-cpt') . '</a>';
		global $wp_query;
	}
}
genesis();