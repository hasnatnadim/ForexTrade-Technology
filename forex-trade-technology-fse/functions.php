<?php
if (!defined('ABSPATH')) { exit; }
function ftt_fse_setup() { add_theme_support('wp-block-styles'); add_theme_support('responsive-embeds'); add_theme_support('editor-styles'); add_editor_style('assets/css/site.css'); add_theme_support('custom-logo', array('height'=>64,'width'=>220,'flex-height'=>true,'flex-width'=>true)); add_theme_support('title-tag'); register_nav_menus(array('primary'=>'Primary Navigation','footer'=>'Footer Navigation')); }
add_action('after_setup_theme','ftt_fse_setup');
function ftt_fse_assets() { $css=get_theme_file_path('/assets/css/site.css'); wp_enqueue_style('ftt-fse-site',get_theme_file_uri('/assets/css/site.css'),array(),file_exists($css)?filemtime($css):'5.4.2'); $js=get_theme_file_path('/assets/js/site-enhancements.js'); if(file_exists($js)) wp_enqueue_script('ftt-fse-enhancements',get_theme_file_uri('/assets/js/site-enhancements.js'),array(),filemtime($js),true); }
add_action('wp_enqueue_scripts','ftt_fse_assets');


/* Responsive blog archive, category, search and single-post component styles. */
function ftt_fse_blog_system_assets() {
    if ( is_home() || is_archive() || is_single() || is_search() || is_page( 'blog' ) ) {
        $blog_css_path = get_theme_file_path( '/assets/css/blog-system.css' );
        wp_enqueue_style(
            'ftt-fse-blog-system',
            get_theme_file_uri( '/assets/css/blog-system.css' ),
            array( 'ftt-fse-site' ),
            file_exists( $blog_css_path ) ? filemtime( $blog_css_path ) : '5.4.2.2'
        );
    }
}
add_action( 'wp_enqueue_scripts', 'ftt_fse_blog_system_assets', 20 );


/* Keep the Recent Articles loop free of the post currently being read. The class check
 * keeps this targeted to the related-post loop and works even on core versions before
 * the Query Loop's built-in excludeCurrent query flag was added.
 */
function ftt_fse_exclude_current_related_post( $query, $block, $page = 1 ) {
    $class_name = isset( $block['attrs']['className'] ) ? (string) $block['attrs']['className'] : '';
    if ( false === strpos( ' ' . $class_name . ' ', ' ftt-related-query ' ) || ! is_singular( 'post' ) ) {
        return $query;
    }
    $current_post_id = get_queried_object_id();
    if ( $current_post_id ) {
        $excluded = isset( $query['post__not_in'] ) ? (array) $query['post__not_in'] : array();
        $excluded[] = (int) $current_post_id;
        $query['post__not_in'] = array_values( array_unique( array_map( 'intval', $excluded ) ) );
    }
    return $query;
}
add_filter( 'query_loop_block_query_vars', 'ftt_fse_exclude_current_related_post', 10, 3 );

function ftt_fse_blog_system_editor_styles() {
    add_editor_style( 'assets/css/blog-system.css' );
}
add_action( 'after_setup_theme', 'ftt_fse_blog_system_editor_styles', 20 );
