<?php
/**
 * Algolia_Styles class file.
 *
 * @author  TopDev <jovanni.llewellyn@codefutures.com>
 *
 *
 * @package Algolia_Custom_Integration
 */

/**
 * Class Algolia_Styles
 *
 *
 */
class Algolia_Styles {

	/**
	 * Algolia_Styles constructor.
	 *
	 * @author TopDev <jovanni.llewellyn@codefutures.com>
	 *
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'register_styles' ] );
	}

	/**
	 * Register styles.
	 *
	 * @author TopDev <jovanni.llewellyn@codefutures.com>
	 *
	 */
	public function register_styles() {

		wp_register_style(
			'algolia-autocomplete',
			ALGOLIA_PLUGIN_URL . 'css/algolia-autocomplete.css',
			[],
			ALGOLIA_VERSION
		);

		wp_register_style(
			'algolia-instantsearch',
			ALGOLIA_PLUGIN_URL . 'css/algolia-instantsearch.css',
			[],
			ALGOLIA_VERSION
		);
	}
}
