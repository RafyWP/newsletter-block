<?php
/**
 * Plugin Name:       Newsletter Block
 * Description:       Create a customizable newsletter subscription form with an email input field and submit button in the WordPress editor.
 * Requires at least: 6.6
 * Requires PHP:      7.2
 * Version:           1.0.0
 * Author:            DevPress
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       newsletter-block
 *
 * @package           devpress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Registers all block assets so that they can be enqueued through the block editor
 * in the corresponding context.
 */
function devpress_newsletter_block_block_init() {
	$dir = __DIR__;

	$index_js = 'index.js';
	wp_register_script(
		'devpress-newsletter-block-block-editor',
		plugins_url( $index_js, __FILE__ ),
		array(
			'wp-block-editor',
			'wp-blocks',
			'wp-i18n',
			'wp-element',
		),
		filemtime( "$dir/$index_js" )
	);
	wp_set_script_translations( 'devpress-newsletter-block-block-editor', 'newsletter-block' );

	$editor_css = 'editor.css';
	wp_register_style(
		'devpress-newsletter-block-block-editor',
		plugins_url( $editor_css, __FILE__ ),
		array(),
		filemtime( "$dir/$editor_css" )
	);

	$style_css = 'style.css';
	wp_register_style(
		'devpress-newsletter-block-block',
		plugins_url( $style_css, __FILE__ ),
		array(),
		filemtime( "$dir/$style_css" )
	);

	register_block_type(
		$dir,
		array(
			'editor_script' => 'devpress-newsletter-block-block-editor',
			'editor_style'  => 'devpress-newsletter-block-block-editor',
			'style'         => 'devpress-newsletter-block-block',
		)
	);
}

add_action( 'init', 'devpress_newsletter_block_block_init' );

include_once plugin_dir_path( __FILE__ ) . 'includes/LeadsCpt.php';

if ( class_exists( 'LeadsCPT' ) ) {
    new LeadsCPT();
}

include_once plugin_dir_path( __FILE__ ) . 'includes/StagesTax.php';

if ( class_exists( 'StagesTax' ) ) {
    new StagesTax();
}

include_once plugin_dir_path( __FILE__ ) . 'includes/LeadsCF.php';

if ( class_exists( 'LeadsCF' ) ) {
    new LeadsCF();
}
