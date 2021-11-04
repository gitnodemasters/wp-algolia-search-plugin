<?php
/**
 * Algolia_Admin_Page_Autocomplete class file.
 *
 * @author  TopDev <jovanni.llewellyn@codefutures.com>
 * @since   1.0.0
 *
 * @package Algolia_Custom_Integration
 */

/**
 * Class Algolia_Admin_Page_Autocomplete
 *
 * @since 1.0.0
 */
class Algolia_Admin_Page_Autocomplete {

	/**
	 * Admin page slug.
	 *
	 * @author TopDev <jovanni.llewellyn@codefutures.com>
	 * @since  1.0.0
	 *
	 * @var string
	 */
	private $slug = 'algolia';

	/**
	 * Admin page capabilities.
	 *
	 * @author TopDev <jovanni.llewellyn@codefutures.com>
	 * @since  1.0.0
	 *
	 * @var string
	 */
	private $capability = 'manage_options';

	/**
	 * Admin page section.
	 *
	 * @author TopDev <jovanni.llewellyn@codefutures.com>
	 * @since  1.0.0
	 *
	 * @var string
	 */
	private $section = 'algolia_section_autocomplete';

	/**
	 * Admin page option group.
	 *
	 * @author TopDev <jovanni.llewellyn@codefutures.com>
	 * @since  1.0.0
	 *
	 * @var string
	 */
	private $option_group = 'algolia_autocomplete';

	/**
	 * The Algolia_Settings object.
	 *
	 * @author TopDev <jovanni.llewellyn@codefutures.com>
	 * @since  1.0.0
	 *
	 * @var Algolia_Settings
	 */
	private $settings;

	/**
	 * The Algolia_Autocomplete_Config object.
	 *
	 * @since 1.0.0
	 *
	 * @var Algolia_Autocomplete_Config
	 */
	private $autocomplete_config;

	/**
	 * Algolia_Admin_Page_Autocomplete constructor.
	 *
	 * @author TopDev <jovanni.llewellyn@codefutures.com>
	 * @since  1.0.0
	 *
	 * @param Algolia_Settings            $settings            The Algolia_Settings object.
	 * @param Algolia_Autocomplete_Config $autocomplete_config The Algolia_Autocomplete_Config object.
	 */
	public function __construct( Algolia_Settings $settings, Algolia_Autocomplete_Config $autocomplete_config ) {
		$this->settings            = $settings;
		$this->autocomplete_config = $autocomplete_config;

		add_action( 'admin_menu', array( $this, 'add_page' ) );
		add_action( 'admin_init', array( $this, 'add_settings' ) );
		add_action( 'admin_notices', array( $this, 'display_errors' ) );

		// @todo: Listen for de-index to remove from autocomplete.
	}

	/**
	 * Add menu pages.
	 *
	 * @author TopDev <jovanni.llewellyn@codefutures.com>
	 * @since  1.0.0
	 */
	public function add_page() {
		add_menu_page(
			'Algolia',
			esc_html__( 'Algolia Search', 'wp-search-with-algolia' ),
			'manage_options',
			'algolia',
			array( $this, 'display_page' ),
			''
		);
		add_submenu_page(
			'algolia',
			esc_html__( 'Indices', 'wp-search-with-algolia' ),
			esc_html__( 'Indices', 'wp-search-with-algolia' ),
			$this->capability,
			$this->slug,
			array( $this, 'display_page' )
		);
	}

	/**
	 * Add and register settings.
	 *
	 * @author TopDev <jovanni.llewellyn@codefutures.com>
	 * @since  1.0.0
	 */
	public function add_settings() {
		add_settings_section(
			$this->section,
			null,
			array( $this, 'print_section_settings' ),
			$this->slug
		);

		add_settings_section(
			'algolia_autocomplete_config',
			esc_html__( '', 'wp-search-with-algoliaz' ),
			array( $this, 'autocomplete_config_callback' ),
			$this->slug,
			$this->section
		);

		register_setting( $this->option_group, 'algolia_autocomplete_config', array( $this, 'sanitize_autocomplete_config' ) );
	}	

	/**
	 * Autocomplete Config Callback.
	 *
	 * @author TopDev <jovanni.llewellyn@codefutures.com>
	 * @since  1.0.0
	 */
	public function autocomplete_config_callback() {
		$indices = $this->autocomplete_config->get_form_data();

		require_once dirname( __FILE__ ) . '/partials/page-autocomplete-config.php';
	}

	/**
	 * Sanitize Autocomplete Config.
	 *
	 * @author TopDev <jovanni.llewellyn@codefutures.com>
	 * @since  1.0.0
	 *
	 * @param array $values Array of autocomplete config values.
	 *
	 * @return array|mixed
	 */
	public function sanitize_autocomplete_config( $values ) {
		return $this->autocomplete_config->sanitize_form_data( $values );
	}

	/**
	 * Display the page.
	 *
	 * @author TopDev <jovanni.llewellyn@codefutures.com>
	 * @since  1.0.0
	 */
	public function display_page() {
		require_once dirname( __FILE__ ) . '/partials/page-autocomplete.php';
	}

	/**
	 * Display the errors.
	 *
	 * @author TopDev <jovanni.llewellyn@codefutures.com>
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function display_errors() {
		settings_errors( $this->option_group );

		if ( defined( 'ALGOLIA_HIDE_HELP_NOTICES' ) && ALGOLIA_HIDE_HELP_NOTICES ) {
			return;
		}

		$is_enabled = 'yes' === $this->settings->get_autocomplete_enabled();
		$indices    = $this->autocomplete_config->get_config();

		if ( true === $is_enabled && empty( $indices ) ) {
			/* translators: placeholder contains the URL to the autocomplete configuration page. */
			$message = sprintf( __( 'Please select one or multiple indices on the <a href="%s">Algolia: Autocomplete configuration page</a>.', 'wp-search-with-algolia' ), esc_url( admin_url( 'admin.php?page=' . $this->slug ) ) );
			echo '<div class="error notice">
					  <p>' . esc_html__( 'You have enabled the Algolia Autocomplete feature but did not choose any index to search in.', 'wp-search-with-algolia' ) . '</p>
					  <p>' . wp_kses_post( $message ) . '</p>
				  </div>';
		}
	}

	/**
	 * Prints the section text.
	 *
	 * @author TopDev <jovanni.llewellyn@codefutures.com>
	 * @since  1.0.0
	 */
	public function print_section_settings() {
		// echo '<p>' . esc_html__( 'The autocomplete feature adds a find-as-you-type dropdown menu to your search bar(s).', 'wp-search-with-algolia' ) . '</p>';
	}
}
