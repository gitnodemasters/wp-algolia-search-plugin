<?php
/**
 * Algolia_Search_Client_Factory class file.
 *
 *
 * @package Algolia_Custom_Integration
 */

use Algolia\AlgoliaSearch\Algolia;
use Algolia\AlgoliaSearch\SearchClient;
use Algolia\AlgoliaSearch\Support\UserAgent;

/**
 * Class Algolia_Search_Client_Factory
 *
 *
 */
class Algolia_Search_Client_Factory {

	/**
	 * Create an Algolia SearchClient.
	 *
	 * @author TopDev <jovanni.llewellyn@codefutures.com>
	 *
	 *
	 * @param string $app_id  The Algolia Application ID.
	 * @param string $api_key The Algolia API Key.
	 *
	 * @return SearchClient
	 */
	public static function create( string $app_id, string $api_key ): SearchClient {

		$integration_name = (string) apply_filters(
			'algolia_ua_integration_name',
			'WP Search with Algolia'
		);

		$integration_version = (string) apply_filters(
			'algolia_ua_integration_version',
			ALGOLIA_VERSION
		);

		UserAgent::addCustomUserAgent(
			$integration_name,
			$integration_version
		);

		global $wp_version;

		UserAgent::addCustomUserAgent(
			'WordPress',
			$wp_version
		);

		$http_client = Algolia_Http_Client_Interface_Factory::create();

		Algolia::setHttpClient( $http_client );

		return SearchClient::create(
			(string) $app_id,
			(string) $api_key
		);
	}
}
