<?php
/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://www.nicolasmahler.fr
 * @since      1.0.0
 *
 * @package    Fh_Download_Pdf
 * @subpackage Fh_Download_Pdf/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @todo Justify why we need this or remove it. AFAIK nothing can be done with textdomains else than loading it.
 *       This, if true, makes this class a total waste of code.
 *
 * @since      1.0.0
 * @package    Fh_Download_Pdf
 * @subpackage Fh_Download_Pdf/includes
 * @author     Your Name <contact@nicolasmahler.fr>
 */
class Fh_Download_Pdf_I18n {

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'fh-download-pdf',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
