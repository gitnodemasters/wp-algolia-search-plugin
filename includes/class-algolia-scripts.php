<?php
/**
 * Algolia_Scripts class file.
 *
 * @author  TopDev <jovanni.llewellyn@codefutures.com>
 *
 *
 * @package Algolia_Custom_Integration
 */

/**
 * Class Algolia_Scripts
 *
 *
 */
class Algolia_Scripts {

	/**
	 * Algolia_Scripts constructor.
	 *
	 * @author TopDev <jovanni.llewellyn@codefutures.com>
	 *
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'register_scripts' ] );
	}

	/**
	 * Register scripts.
	 *
	 * @author TopDev <jovanni.llewellyn@codefutures.com>
	 *
	 */
	public function register_scripts() {

		$in_footer = Algolia_Utils::get_scripts_in_footer_argument();

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		$ais_suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG
			? '.development'
			: '.production';

		wp_register_script(
			'algolia-search',
			ALGOLIA_PLUGIN_URL . 'js/algoliasearch/dist/algoliasearch-lite.umd.js',
			[
				'jquery',
				'underscore',
				'wp-util',
			],
			ALGOLIA_VERSION,
			$in_footer
		);

		wp_register_script(
			'algolia-autocomplete',
			ALGOLIA_PLUGIN_URL . 'js/autocomplete.js/dist/autocomplete' . $suffix . '.js',
			[
				'jquery',
				'underscore',
				'wp-util',
				'algolia-search',
			],
			ALGOLIA_VERSION,
			$in_footer
		);

		wp_register_script(
			'algolia-autocomplete-noconflict',
			ALGOLIA_PLUGIN_URL . 'js/autocomplete-noconflict.js',
			[
				'algolia-autocomplete',
			],
			ALGOLIA_VERSION,
			$in_footer
		);

		wp_register_script(
			'algolia-instantsearch',
			ALGOLIA_PLUGIN_URL . 'js/instantsearch.js/dist/instantsearch' . $ais_suffix . $suffix . '.js',
			[
				'jquery',
				'underscore',
				'wp-util',
				'algolia-search',
			],
			ALGOLIA_VERSION,
			$in_footer
		);
	}
}
