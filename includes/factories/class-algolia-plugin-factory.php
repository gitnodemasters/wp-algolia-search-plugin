<?php
/**
 * Algolia_Plugin_Factory class file.
 *
 *
 * @package Algolia_Custom_Integration
 */

/**
 * Class Algolia_Plugin_Factory
 *
 * Responsible for creating a shared instance of the main Algolia_Plugin object.
 *
 *
 */
class Algolia_Plugin_Factory {

	/**
	 * Create and return a shared instance of the Algolia_Plugin.
	 *
	 * @author TopDev <jovanni.llewellyn@codefutures.com>
	 *
	 *
	 * @return Algolia_Plugin The shared plugin instance.
	 */
	public static function create(): Algolia_Plugin {

		/**
		 * The static instance to share, else null.
		 *
		 *
		 *
		 * @var null|Algolia_Plugin $plugin
		 */
		static $plugin = null;

		if ( null !== $plugin ) {
			return $plugin;
		}

		$plugin = new Algolia_Plugin();

		return $plugin;
	}
}
