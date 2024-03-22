<?php
/**
 * Plugin's bootstrap file to launch the plugin.
 *
 * @wordpress-plugin
 * Plugin Name: Block-a-saurus
 * Plugin URI:  https://alphaparticle.com/blockasaurus
 * Description: A Gutenberg block that lets users play the T-rex game from Chrome right within a post!
 * Version:     1.0.1
 * Author:      Alpha Particle
 * Author URI:  https://alphaparticle.com/
 * Text Domain: blockasaurus
 * Domain Path: /languages
 * License:     GPL2+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

add_action( 'enqueue_block_editor_assets', 'bas_editor_assets' );
add_action( 'enqueue_block_assets', 'bas_frontend_assets' );

/**
 * Enqueue the block's assets for the editor.
 *
 * `wp-blocks`: includes block type registration and related functions.
 * `wp-element`: includes the WordPress Element abstraction for describing the structure of your blocks.
 * `wp-i18n`: To internationalize the block's text.
 *
 * @since 1.0.0
 */
function bas_editor_assets() {
	// Scripts.
	wp_enqueue_script(
		'bas-basic-script', // Handle.
		plugins_url( 'dist/block.build.js', __FILE__ ),
		array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'wp-components' ),
		filemtime( plugin_dir_path( __FILE__ ) . 'src/js/block.js' ),
		true
	);

	wp_localize_script(
		'bas-basic-script',
		'bas_data',
		array(
			'cover_image_url' => plugins_url( 'src/img/dino-cover.png', __FILE__ )
		)
	);

	// Styles.
	wp_enqueue_style(
		'bas-basic-styles', // Handle.
		plugins_url( 'src/css/editor.css', __FILE__ ),
		array( 'wp-edit-blocks' ),
		filemtime( plugin_dir_path( __FILE__ ) . 'src/css/editor.css' )
	);
}

/**
 * Enqueue the block's assets for the frontend.
 *
 * @since 1.0.0
 */
function bas_frontend_assets() {
	$id = get_the_id();

	if ( has_block( 'blockasaurus/blockasaurus', $id ) ) {
		// Styles.
		wp_enqueue_style(
			'bas-basic-frontend', // Handle.
			plugins_url( 'src/css/style.css', __FILE__ ),
			array(),
			filemtime( plugin_dir_path( __FILE__ ) . 'src/css/style.css' )
		);

		wp_enqueue_script(
			'bas-dino-frontend', // Handle.
			plugins_url( 'dist/dino.build.js', __FILE__ ),
			array( 'jquery' ),
			filemtime( plugin_dir_path( __FILE__ ) . 'dist/dino.build.js' ),
			true
		);
	}
}
