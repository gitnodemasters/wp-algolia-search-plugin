<?php
/**
 * Algolia_Changes_Watcher interface file.
 *
 * @author  TopDev <jovanni.llewellyn@codefutures.com>
 * @since   1.0.0
 *
 * @package Algolia_Custom_Integration
 */

/**
 * Interface Algolia_Changes_Watcher
 *
 * @since 1.0.0
 */
interface Algolia_Changes_Watcher {

	/**
	 * Watch WordPress events.
	 *
	 * @author  TopDev <jovanni.llewellyn@codefutures.com>
	 * @since   1.0.0
	 */
	public function watch();
}
